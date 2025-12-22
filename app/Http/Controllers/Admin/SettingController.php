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
            'site_og_image' => 'nullable|file|mimes:png,jpg,jpeg|max:5120',
            'remove_site_favicon' => 'nullable|boolean',
            'remove_site_logo' => 'nullable|boolean',
            'remove_site_og_image' => 'nullable|boolean',
        ]);

        foreach ($validated['settings'] as $setting) {
            $group = $this->determineSettingGroup($setting['key']);
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'] ?? '',
                    'type' => $group === 'legal' ? 'textarea' : 'string',
                    'group' => $group
                ]
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

        $currentOgImage = Setting::get('site_og_image');
        if ($request->hasFile('site_og_image')) {
            if ($currentOgImage) {
                Storage::disk('public')->delete($currentOgImage);
            }
            $path = $request->file('site_og_image')->store('settings', 'public');
            Setting::set('site_og_image', $path, 'file', 'general');
        } elseif ($request->boolean('remove_site_og_image')) {
            if ($currentOgImage) {
                Storage::disk('public')->delete($currentOgImage);
            }
            Setting::set('site_og_image', null, 'file', 'general');
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Настройки успешно обновлены');
    }

    /**
     * Определяет группу настройки по ключу
     */
    private function determineSettingGroup($key)
    {
        if (in_array($key, ['privacy_policy_content', 'terms_of_service_content'])) {
            return 'legal';
        }
        
        if (strpos($key, 'privacy') !== false || strpos($key, 'terms') !== false || strpos($key, 'policy') !== false) {
            return 'policies';
        }
        
        if (strpos($key, 'company_') !== false) {
            return 'legal';
        }
        
        if (strpos($key, 'turnstile') !== false) {
            return 'integrations';
        }
        
        if (strpos($key, 'payment_method') !== false || strpos($key, 'delivery') !== false || strpos($key, 'free_delivery') !== false) {
            return 'delivery';
        }
        
        // Определяем группу по существующей настройке
        $existing = Setting::where('key', $key)->first();
        if ($existing && $existing->group) {
            return $existing->group;
        }
        
        return 'general';
    }
}

