<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutPageSettingController extends Controller
{
    public function index()
    {
        $settings = AboutPageSetting::orderBy('created_at', 'desc')->get();
        return view('admin.about-page-settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.about-page-settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'overlay_type' => 'nullable|in:none,darken,lighten',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
            'background_position' => 'nullable|string|max:255',
            'background_size' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'main_content' => 'nullable|string',
            'welcome_title' => 'nullable|string|max:255',
            'welcome_text' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Загружаем фоновое изображение
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')->store('about-page', 'public');
    }

        // Загружаем изображение "О компании"
        if ($request->hasFile('about_image')) {
            $data['about_image'] = $request->file('about_image')->store('about-page', 'public');
        }

        // Если это активная настройка, деактивируем остальные
        if ($request->has('is_active') && $request->is_active) {
            AboutPageSetting::where('is_active', true)->update(['is_active' => false]);
        }

        AboutPageSetting::create($data);

        return redirect()->route('admin.about-page-settings.index')
            ->with('success', 'Настройки страницы "О компании" успешно созданы!');
    }

    public function edit($id)
    {
        $setting = AboutPageSetting::findOrFail($id);
        return view('admin.about-page-settings.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'overlay_type' => 'nullable|in:none,darken,lighten',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
            'background_position' => 'nullable|string|max:255',
            'background_size' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'main_content' => 'nullable|string',
            'welcome_title' => 'nullable|string|max:255',
            'welcome_text' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $setting = AboutPageSetting::findOrFail($id);
        $data = $request->except('_token', '_method');

        // Удаляем старое фоновое изображение, если загружено новое
        if ($request->hasFile('background_image')) {
            if ($setting->background_image) {
                Storage::disk('public')->delete($setting->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('about-page', 'public');
    }

        // Удаляем старое изображение "О компании", если загружено новое
        if ($request->hasFile('about_image')) {
            if ($setting->about_image) {
                Storage::disk('public')->delete($setting->about_image);
            }
            $data['about_image'] = $request->file('about_image')->store('about-page', 'public');
        }

        // Если это активная настройка, деактивируем остальные
        if ($request->has('is_active') && $request->is_active) {
            AboutPageSetting::where('is_active', true)->where('id', '!=', $id)->update(['is_active' => false]);
        }

        $setting->update($data);

        return redirect()->route('admin.about-page-settings.index')
            ->with('success', 'Настройки страницы "О компании" успешно обновлены!');
    }

    public function destroy($id)
    {
        $setting = AboutPageSetting::findOrFail($id);
        
        // Удаляем изображения
        if ($setting->background_image) {
            Storage::disk('public')->delete($setting->background_image);
        }
        if ($setting->about_image) {
            Storage::disk('public')->delete($setting->about_image);
        }
        
        $setting->delete();

        return redirect()->route('admin.about-page-settings.index')
            ->with('success', 'Настройки страницы "О компании" успешно удалены!');
    }
}
