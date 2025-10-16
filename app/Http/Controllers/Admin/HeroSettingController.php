<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heroSettings = HeroSetting::orderBy('created_at', 'desc')->get();
        return view('admin.hero-settings.index', compact('heroSettings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero-settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'background_position' => 'nullable|string|max:100',
            'background_size' => 'nullable|string|max:100',
            'overlay_type' => 'required|in:darken,lighten,none',
            'overlay_opacity' => 'required|integer|min:0|max:100',
            'background_color' => 'nullable|string|max:7',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Загрузка фонового изображения
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')->store('hero-backgrounds', 'public');
        }

        // Если это активная настройка, деактивируем остальные
        if ($request->has('is_active') && $request->is_active) {
            HeroSetting::where('is_active', true)->update(['is_active' => false]);
        }

        HeroSetting::create($data);

        return redirect()->route('admin.hero-settings.index')
            ->with('success', 'Настройки hero-секции успешно созданы!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $heroSetting = HeroSetting::findOrFail($id);
        return view('admin.hero-settings.edit', compact('heroSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'background_position' => 'nullable|string|max:100',
            'background_size' => 'nullable|string|max:100',
            'overlay_type' => 'required|in:darken,lighten,none',
            'overlay_opacity' => 'required|integer|min:0|max:100',
            'background_color' => 'nullable|string|max:7',
            'is_active' => 'nullable|boolean',
        ]);

        $heroSetting = HeroSetting::findOrFail($id);
        $data = $request->all();

        // Загрузка нового фонового изображения
        if ($request->hasFile('background_image')) {
            // Удаляем старое изображение
            if ($heroSetting->background_image) {
                Storage::disk('public')->delete($heroSetting->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('hero-backgrounds', 'public');
        }

        // Если это активная настройка, деактивируем остальные
        if ($request->has('is_active') && $request->is_active) {
            HeroSetting::where('id', '!=', $id)->where('is_active', true)->update(['is_active' => false]);
        }

        $heroSetting->update($data);

        return redirect()->route('admin.hero-settings.index')
            ->with('success', 'Настройки hero-секции успешно обновлены!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $heroSetting = HeroSetting::findOrFail($id);
        
        // Удаляем фоновое изображение
        if ($heroSetting->background_image) {
            Storage::disk('public')->delete($heroSetting->background_image);
        }
        
        $heroSetting->delete();

        return redirect()->route('admin.hero-settings.index')
            ->with('success', 'Настройки hero-секции успешно удалены!');
    }
}
