<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountPageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccountPageSettingController extends Controller
{
    public function index()
    {
        $setting = AccountPageSetting::getSettings();
        return view('admin.account-page-settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_background_image' => 'nullable|image|max:2048',
            'overlay_type' => 'required|in:none,darken,lighten',
            'overlay_opacity' => 'required|integer|min:0|max:100',
            'background_position' => 'required|string',
            'background_size' => 'required|string',
        ]);

        $setting = AccountPageSetting::getSettings();
        
        // Обработка фонового изображения
        if ($request->hasFile('hero_background_image')) {
            $file = $request->file('hero_background_image');
            $path = $file->store('account-page', 'public');
            
            // Удаляем старое изображение если есть
            if ($setting->hero_background_image && Storage::disk('public')->exists($setting->hero_background_image)) {
                Storage::disk('public')->delete($setting->hero_background_image);
            }
            
            $setting->hero_background_image = $path;
        }

        $setting->overlay_type = $request->overlay_type;
        $setting->overlay_opacity = $request->overlay_opacity;
        $setting->background_position = $request->background_position;
        $setting->background_size = $request->background_size;
        $setting->save();

        return redirect()->route('admin.account-page-settings.index')
            ->with('success', 'Настройки личного кабинета обновлены!');
    }

    public function deleteImage()
    {
        $setting = AccountPageSetting::getSettings();
        
        if ($setting->hero_background_image) {
            if (Storage::disk('public')->exists($setting->hero_background_image)) {
                Storage::disk('public')->delete($setting->hero_background_image);
            }
            $setting->hero_background_image = null;
            $setting->save();
        }

        return redirect()->route('admin.account-page-settings.index')
            ->with('success', 'Изображение удалено!');
    }
}

