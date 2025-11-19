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

        $productHeroSetting = \App\Models\ProductHeroSetting::getSettings();

        return view('admin.products.index', compact('products', 'productHeroSetting'));
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
            'stock' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'characteristics' => 'nullable|array',
            'characteristics.*.title' => 'nullable|string|max:255',
            'characteristics.*.value' => 'nullable|string|max:2000',
            'delivery_description' => 'nullable|string',
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

        unset($validated['gallery_images']);

        $validated['characteristics'] = $this->formatCharacteristics($request->input('characteristics', []));

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
            'stock' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'characteristics' => 'nullable|array',
            'characteristics.*.title' => 'nullable|string|max:255',
            'characteristics.*.value' => 'nullable|string|max:2000',
            'delivery_description' => 'nullable|string',
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

        unset($validated['gallery_images'], $validated['remove_images']);

        $validated['characteristics'] = $this->formatCharacteristics($request->input('characteristics', []));

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Товар успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    protected function formatCharacteristics(?array $items): array
    {
        return collect($items ?? [])
            ->map(function ($item) {
                return [
                    'title' => trim($item['title'] ?? ''),
                    'value' => trim($item['value'] ?? ''),
                ];
            })
            ->filter(function ($item) {
                return $item['title'] !== '' || $item['value'] !== '';
            })
            ->values()
            ->all();
    }

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
}

