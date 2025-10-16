<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomePageGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = HomePageGallery::orderBy('order')->get();
        return view('admin.home-page-galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.home-page-galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('home-page/gallery', 'public');
        }

        HomePageGallery::create($data);

        return redirect()->route('admin.home-page-galleries.index')
            ->with('success', 'Изображение галереи успешно добавлено!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gallery = HomePageGallery::findOrFail($id);
        return view('admin.home-page-galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $gallery = HomePageGallery::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $data['image'] = $request->file('image')->store('home-page/gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.home-page-galleries.index')
            ->with('success', 'Изображение галереи успешно обновлено!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gallery = HomePageGallery::findOrFail($id);
        
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }
        
        $gallery->delete();

        return redirect()->route('admin.home-page-galleries.index')
            ->with('success', 'Изображение галереи успешно удалено!');
    }
}
