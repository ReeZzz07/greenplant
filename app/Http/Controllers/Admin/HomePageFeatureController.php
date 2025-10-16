<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomePageFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features = HomePageFeature::orderBy('order')->get();
        return view('admin.home-page-features.index', compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.home-page-features.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'nullable|string|max:255',
            'icon_image' => 'nullable|image|mimes:png,svg,jpg,jpeg|max:2048',
            'icon_type' => 'required|in:flaticon,image,custom',
            'icon_size' => 'nullable|string|max:50',
            'icon_color' => 'nullable|string|max:7',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Загрузка изображения иконки
        if ($request->hasFile('icon_image')) {
            $data['icon_image'] = $request->file('icon_image')->store('feature-icons', 'public');
        }

        HomePageFeature::create($data);

        return redirect()->route('admin.home-page-features.index')
            ->with('success', 'Преимущество успешно создано!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $feature = HomePageFeature::findOrFail($id);
        return view('admin.home-page-features.edit', compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'icon' => 'nullable|string|max:255',
            'icon_image' => 'nullable|image|mimes:png,svg,jpg,jpeg|max:2048',
            'icon_type' => 'required|in:flaticon,image,custom',
            'icon_size' => 'nullable|string|max:50',
            'icon_color' => 'nullable|string|max:7',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $feature = HomePageFeature::findOrFail($id);
        $data = $request->all();

        // Загрузка нового изображения иконки
        if ($request->hasFile('icon_image')) {
            // Удаляем старое изображение
            if ($feature->icon_image) {
                Storage::disk('public')->delete($feature->icon_image);
            }
            $data['icon_image'] = $request->file('icon_image')->store('feature-icons', 'public');
        }

        $feature->update($data);

        return redirect()->route('admin.home-page-features.index')
            ->with('success', 'Преимущество успешно обновлено!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $feature = HomePageFeature::findOrFail($id);
        
        // Удаляем изображение иконки
        if ($feature->icon_image) {
            Storage::disk('public')->delete($feature->icon_image);
        }
        
        $feature->delete();

        return redirect()->route('admin.home-page-features.index')
            ->with('success', 'Преимущество успешно удалено!');
    }
}
