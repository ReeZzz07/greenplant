<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductHeroSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductHeroSettingController extends Controller
{
    /**
     * Update the hero settings for product detail page.
     */
    public function update(Request $request)
    {
        $setting = ProductHeroSetting::getSettings();

        $validated = $request->validate([
            'background_position' => 'nullable|string|max:255',
            'background_size' => 'nullable|string|max:255',
            'overlay_type' => 'required|in:darken,lighten,none',
            'overlay_opacity' => 'required|integer|min:0|max:100',
            'background_color' => 'nullable|string|max:50',
            'is_active' => 'required|boolean',
            'background_image' => 'nullable|image|max:4096',
            'remove_background_image' => 'nullable|boolean',
        ]);

        $validated['background_position'] = $validated['background_position'] ?? 'center center';
        $validated['background_size'] = $validated['background_size'] ?? 'cover';
        $validated['background_color'] = $validated['background_color'] ?: '#82ae46';

        if ($request->boolean('remove_background_image') && $setting->background_image) {
            Storage::disk('public')->delete($setting->background_image);
            $validated['background_image'] = null;
        }

        if ($request->hasFile('background_image')) {
            if ($setting->background_image) {
                Storage::disk('public')->delete($setting->background_image);
            }
            $validated['background_image'] = $request->file('background_image')->store('product-hero', 'public');
        }

        $setting->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Настройки hero для страницы товара обновлены.');
    }
}


