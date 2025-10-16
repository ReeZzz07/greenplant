<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = 'Туя ' . fake()->words(2, true);
        $price = fake()->numberBetween(1500, 8000);
        
        return [
            'category_id' => Category::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 1000),
            'short_description' => fake()->sentence(10),
            'description' => fake()->paragraphs(3, true),
            'price' => $price,
            'old_price' => $price + fake()->numberBetween(500, 2000),
            'stock' => fake()->numberBetween(5, 50),
            'sku' => 'TUI-' . fake()->unique()->numberBetween(1000, 9999),
            'image' => 'products/default.jpg',
            'is_active' => true,
            'is_featured' => fake()->boolean(30), // 30% шанс быть featured
            'meta_title' => ucfirst($name),
            'meta_description' => fake()->sentence(15),
            'meta_keywords' => 'туя, саженцы, купить тую',
        ];
    }

    /**
     * Indicate that the product is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the product is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }

    /**
     * Indicate that the product is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}

