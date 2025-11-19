<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WholesaleSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WholesaleSettingController extends Controller
{
    public function index()
    {
        $settings = WholesaleSetting::orderBy('created_at', 'desc')->get();
        return view('admin.wholesale-settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.wholesale-settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'overlay_type' => 'nullable|in:none,darken,lighten',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
            'background_position' => 'nullable|string|max:255',
            'background_size' => 'nullable|string|max:255',
            'background_color' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'purchase_price' => 'nullable|numeric|min:0',
            'default_sale_price' => 'nullable|numeric|min:0',
            'min_quantity' => 'nullable|integer|min:1',
            'planting_distance' => 'nullable|numeric|min:0.1',
            'seedling_price' => 'nullable|numeric|min:0',
            'mature_tree_price' => 'nullable|numeric|min:0',
            'additional_costs_per_seedling' => 'nullable|numeric|min:0',
            'maturity_years' => 'nullable|integer|min:1',
            'profit_multiplier_min' => 'nullable|numeric|min:0',
            'profit_multiplier_max' => 'nullable|numeric|min:0',
            'calculator_description' => 'nullable|string',
            'advantages' => 'nullable|string',
            'how_it_works' => 'nullable|string',
            'how_it_works_text' => 'nullable|string',
            'testimonials' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();

        // Загружаем фоновое изображение
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')->store('wholesale-page', 'public');
    }

        // Преобразуем JSON строки в массивы
        if ($request->has('advantages') && !empty($request->advantages)) {
            $data['advantages'] = json_decode($request->advantages, true);
        }
        if ($request->has('how_it_works') && !empty($request->how_it_works)) {
            $data['how_it_works'] = json_decode($request->how_it_works, true);
        }
        if ($request->has('testimonials') && !empty($request->testimonials)) {
            $data['testimonials'] = json_decode($request->testimonials, true);
        }

        // Если это активная настройка, деактивируем остальные
        if ($request->has('is_active') && $request->is_active) {
            WholesaleSetting::where('is_active', true)->update(['is_active' => false]);
        }

        WholesaleSetting::create($data);

        return redirect()->route('admin.wholesale-settings.index')
            ->with('success', 'Настройки страницы "Оптовым покупателям" успешно созданы!');
    }

    public function edit($id)
    {
        $setting = WholesaleSetting::findOrFail($id);
        return view('admin.wholesale-settings.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'overlay_type' => 'nullable|in:none,darken,lighten',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
            'background_position' => 'nullable|string|max:255',
            'background_size' => 'nullable|string|max:255',
            'background_color' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'purchase_price' => 'nullable|numeric|min:0',
            'default_sale_price' => 'nullable|numeric|min:0',
            'min_quantity' => 'nullable|integer|min:1',
            'planting_distance' => 'nullable|numeric|min:0.1',
            'seedling_price' => 'nullable|numeric|min:0',
            'mature_tree_price' => 'nullable|numeric|min:0',
            'additional_costs_per_seedling' => 'nullable|numeric|min:0',
            'maturity_years' => 'nullable|integer|min:1',
            'profit_multiplier_min' => 'nullable|numeric|min:0',
            'profit_multiplier_max' => 'nullable|numeric|min:0',
            'calculator_description' => 'nullable|string',
            'advantages' => 'nullable|string',
            'how_it_works' => 'nullable|string',
            'how_it_works_text' => 'nullable|string',
            'testimonials' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $setting = WholesaleSetting::findOrFail($id);
        $data = $request->except('_token', '_method');

        // Удаляем старое фоновое изображение, если загружено новое
        if ($request->hasFile('background_image')) {
            if ($setting->background_image) {
                Storage::disk('public')->delete($setting->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('wholesale-page', 'public');
    }

        // Преобразуем JSON строки в массивы
        if ($request->has('advantages') && !empty($request->advantages)) {
            $data['advantages'] = json_decode($request->advantages, true);
        }
        if ($request->has('how_it_works') && !empty($request->how_it_works)) {
            $data['how_it_works'] = json_decode($request->how_it_works, true);
        }
        if ($request->has('testimonials') && !empty($request->testimonials)) {
            $data['testimonials'] = json_decode($request->testimonials, true);
        }

        // Если это активная настройка, деактивируем остальные
        if ($request->has('is_active') && $request->is_active) {
            WholesaleSetting::where('is_active', true)->where('id', '!=', $id)->update(['is_active' => false]);
        }

        $setting->update($data);

        return redirect()->route('admin.wholesale-settings.index')
            ->with('success', 'Настройки страницы "Оптовым покупателям" успешно обновлены!');
    }

    public function destroy($id)
    {
        $setting = WholesaleSetting::findOrFail($id);
        
        // Удаляем изображения
        if ($setting->background_image) {
            Storage::disk('public')->delete($setting->background_image);
        }
        
        $setting->delete();

        return redirect()->route('admin.wholesale-settings.index')
            ->with('success', 'Настройки страницы "Оптовым покупателям" успешно удалены!');
    }
}
