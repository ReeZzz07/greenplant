<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactPageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactPageSettingController extends Controller
{
    public function index()
    {
        $settings = ContactPageSetting::orderBy('created_at', 'desc')->get();
        return view('admin.contact-page-settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.contact-page-settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'overlay_type' => 'nullable|in:none,darken,lighten',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
            'background_position' => 'nullable|string|max:255',
            'background_size' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'map_latitude' => 'nullable|string|max:50',
            'map_longitude' => 'nullable|string|max:50',
            'map_zoom' => 'nullable|integer|min:1|max:20',
            'map_description' => 'nullable|string',
            'map_embed_code' => 'nullable|string',
            'contact_section_title' => 'nullable|string|max:255',
            'contact_section_content' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Загружаем фоновое изображение
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')->store('contact-page', 'public');
        }

        // Если это активная настройка, деактивируем остальные
        if ($request->has('is_active') && $request->is_active) {
            ContactPageSetting::where('is_active', true)->update(['is_active' => false]);
        }

        ContactPageSetting::create($data);

        return redirect()->route('admin.contact-page-settings.index')
            ->with('success', 'Настройки страницы "Контакты" успешно созданы!');
    }

    public function edit($id)
    {
        $setting = ContactPageSetting::findOrFail($id);
        return view('admin.contact-page-settings.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'overlay_type' => 'nullable|in:none,darken,lighten',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
            'background_position' => 'nullable|string|max:255',
            'background_size' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'map_latitude' => 'nullable|string|max:50',
            'map_longitude' => 'nullable|string|max:50',
            'map_zoom' => 'nullable|integer|min:1|max:20',
            'map_description' => 'nullable|string',
            'map_embed_code' => 'nullable|string',
            'contact_section_title' => 'nullable|string|max:255',
            'contact_section_content' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $setting = ContactPageSetting::findOrFail($id);
        $data = $request->except('_token', '_method');

        // Удаляем старое фоновое изображение, если загружено новое
        if ($request->hasFile('background_image')) {
            if ($setting->background_image) {
                Storage::disk('public')->delete($setting->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('contact-page', 'public');
    }

        // Если это активная настройка, деактивируем остальные
        if ($request->has('is_active') && $request->is_active) {
            ContactPageSetting::where('is_active', true)->where('id', '!=', $id)->update(['is_active' => false]);
        }

        $setting->update($data);

        return redirect()->route('admin.contact-page-settings.index')
            ->with('success', 'Настройки страницы "Контакты" успешно обновлены!');
    }

    public function destroy($id)
    {
        $setting = ContactPageSetting::findOrFail($id);
        
        // Удаляем изображения
        if ($setting->background_image) {
            Storage::disk('public')->delete($setting->background_image);
        }
        
        $setting->delete();

        return redirect()->route('admin.contact-page-settings.index')
            ->with('success', 'Настройки страницы "Контакты" успешно удалены!');
    }
}
