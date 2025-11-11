<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array|max:10',
            'gallery_images.*' => 'image|max:5120',
            'hero_background_image' => 'nullable|image|max:4096',
            'hero_background_position' => 'nullable|string|max:191',
            'hero_background_size' => 'nullable|string|max:191',
            'hero_background_color' => 'nullable|string|max:20',
            'hero_overlay_type' => 'nullable|string|in:none,darken,lighten',
            'hero_overlay_opacity' => 'nullable|integer|min:0|max:100',
            'stock' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Генерация slug если не указан
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Загрузка изображения
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file) {
                    $galleryImages[] = $file->store('products/gallery', 'public');
                }
            }
        }

        if (!empty($galleryImages)) {
            $validated['images'] = $galleryImages;
            if (empty($validated['image'])) {
                $validated['image'] = $galleryImages[0];
            }
        }

        if ($request->hasFile('hero_background_image')) {
            $validated['hero_background_image'] = $request->file('hero_background_image')->store('products/hero', 'public');
        } else {
            unset($validated['hero_background_image']);
        }

        $position = trim($validated['hero_background_position'] ?? '');
        $size = trim($validated['hero_background_size'] ?? '');
        $overlayType = $validated['hero_overlay_type'] ?? 'darken';
        $overlayOpacity = isset($validated['hero_overlay_opacity'])
            ? (int)$validated['hero_overlay_opacity']
            : 40;

        $validated['hero_background_position'] = $position !== '' ? $position : 'center center';
        $validated['hero_background_size'] = $size !== '' ? $size : 'cover';
        $validated['hero_overlay_type'] = $overlayType;
        $validated['hero_overlay_opacity'] = max(0, min(100, $overlayOpacity));
        $validated['hero_background_color'] = $this->normalizeHexColor($validated['hero_background_color'] ?? null);

        unset($validated['gallery_images']);

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно создан');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array|max:10',
            'gallery_images.*' => 'image|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'string',
            'hero_background_image' => 'nullable|image|max:4096',
            'hero_background_position' => 'nullable|string|max:191',
            'hero_background_size' => 'nullable|string|max:191',
            'hero_background_color' => 'nullable|string|max:20',
            'hero_overlay_type' => 'nullable|string|in:none,darken,lighten',
            'hero_overlay_opacity' => 'nullable|integer|min:0|max:100',
            'remove_hero_background' => 'nullable|boolean',
            'stock' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Генерация slug если не указан
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Загрузка нового изображения
        if ($request->hasFile('image')) {
            // Удаление старого изображения
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $existingImages = collect($product->images ?? []);

        $removeImages = collect($request->input('remove_images', []));
        if ($removeImages->isNotEmpty()) {
            $existingImages = $existingImages->reject(function ($path) use ($removeImages, $product) {
                if ($removeImages->contains($path)) {
                    Storage::disk('public')->delete($path);
                    return true;
                }
                return false;
            })->values();

            if ($product->image && $removeImages->contains($product->image)) {
                Storage::disk('public')->delete($product->image);
                $validated['image'] = null;
            }
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file) {
                    $existingImages->push($file->store('products/gallery', 'public'));
                }
            }
        }

        if ($existingImages->isNotEmpty()) {
            $validated['images'] = $existingImages->unique()->values()->all();
            if (empty($validated['image'])) {
                $validated['image'] = $product->image ?? $existingImages->first();
            }
        } else {
            $validated['images'] = null;
            if (empty($validated['image']) && $product->image && (!isset($validated['image']) || $validated['image'] === null) && !$request->hasFile('image')) {
                $validated['image'] = $product->image;
            }
        }

        // Если после удаления галереи и основного изображения ничего не осталось, очистим поле image
        if (array_key_exists('image', $validated) && !$validated['image']) {
            $validated['image'] = $existingImages->first() ?? null;
        }

        if ($request->boolean('remove_hero_background')) {
            if ($product->hero_background_image) {
                Storage::disk('public')->delete($product->hero_background_image);
            }
            $validated['hero_background_image'] = null;
        } elseif ($request->hasFile('hero_background_image')) {
            if ($product->hero_background_image) {
                Storage::disk('public')->delete($product->hero_background_image);
            }
            $validated['hero_background_image'] = $request->file('hero_background_image')->store('products/hero', 'public');
        } else {
            unset($validated['hero_background_image']);
        }

        $position = trim($validated['hero_background_position'] ?? ($product->hero_background_position ?? ''));
        $size = trim($validated['hero_background_size'] ?? ($product->hero_background_size ?? ''));
        $overlayType = $validated['hero_overlay_type'] ?? $product->hero_overlay_type ?? 'darken';
        $overlayOpacityInput = $validated['hero_overlay_opacity'] ?? $product->hero_overlay_opacity ?? 40;

        $validated['hero_background_position'] = $position !== '' ? $position : 'center center';
        $validated['hero_background_size'] = $size !== '' ? $size : 'cover';
        $validated['hero_overlay_type'] = $overlayType;
        $validated['hero_overlay_opacity'] = max(0, min(100, (int) $overlayOpacityInput));
        $validated['hero_background_color'] = $this->normalizeHexColor($validated['hero_background_color'] ?? $product->hero_background_color);

        unset($validated['gallery_images'], $validated['remove_images'], $validated['remove_hero_background']);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Удаление изображения
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->images) {
            foreach ($product->images as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        if ($product->hero_background_image) {
            Storage::disk('public')->delete($product->hero_background_image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно удален');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $product->is_active
        ]);
    }

    protected function normalizeHexColor(?string $color): ?string
    {
        if ($color === null) {
            return null;
        }

        $color = trim($color);

        if ($color === '') {
            return null;
        }

        return '#' . ltrim($color, '#');
    }
}

