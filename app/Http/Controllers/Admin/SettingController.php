<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable|string',
            'site_favicon' => 'nullable|file|mimes:png,jpg,jpeg,svg,ico|max:2048',
            'site_logo' => 'nullable|file|mimes:png,jpg,jpeg,svg|max:4096',
            'remove_site_favicon' => 'nullable|boolean',
            'remove_site_logo' => 'nullable|boolean',
        ]);

        foreach ($validated['settings'] as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'] ?? '']
            );
        }

        $currentFavicon = Setting::get('site_favicon');
        if ($request->hasFile('site_favicon')) {
            if ($currentFavicon) {
                Storage::disk('public')->delete($currentFavicon);
            }
            $path = $request->file('site_favicon')->store('settings', 'public');
            Setting::set('site_favicon', $path, 'file', 'general');
        } elseif ($request->boolean('remove_site_favicon')) {
            if ($currentFavicon) {
                Storage::disk('public')->delete($currentFavicon);
            }
            Setting::set('site_favicon', null, 'file', 'general');
        }

        $currentLogo = Setting::get('site_logo');
        if ($request->hasFile('site_logo')) {
            if ($currentLogo) {
                Storage::disk('public')->delete($currentLogo);
            }
            $path = $request->file('site_logo')->store('settings', 'public');
            Setting::set('site_logo', $path, 'file', 'general');
        } elseif ($request->boolean('remove_site_logo')) {
            if ($currentLogo) {
                Storage::disk('public')->delete($currentLogo);
            }
            Setting::set('site_logo', null, 'file', 'general');
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Настройки успешно обновлены');
    }
}

