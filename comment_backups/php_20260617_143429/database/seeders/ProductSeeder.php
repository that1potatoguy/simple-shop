<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Edit this array to add, remove, or change seeded products.
        // Rerun `php artisan db:seed` (or `php artisan migrate:fresh --seed`) to apply changes.
            // The seeder will prefer `database/seeders/products.json` if present.
            // Edit that JSON file to add/remove/change products without touching PHP.
            // After editing, run `php artisan db:seed` to apply changes.
            $jsonPath = database_path('seeders/products.json');
            $products = [];
            if (file_exists($jsonPath)) {
                $contents = json_decode(file_get_contents($jsonPath), true);
                if (is_array($contents) && !empty($contents)) {
                    $products = $contents;
                }
            }

            // Fallback in case JSON is missing or empty
            if (empty($products)) {
                $products = [
                    ['name' => 'Sample Product', 'slug' => 'sample-product', 'description' => 'Example product', 'price' => 9.99, 'image' => null],
                ];
            }

            foreach ($products as $p) {
                // Basic validation and normalization
                if (empty($p['name']) || empty($p['slug'])) {
                    if ($this->command) $this->command->warn('Skipping product with missing name or slug: ' . json_encode($p));
                    continue;
                }

                // ensure slug is a string and safe
                $slug = trim((string) ($p['slug'] ?? ''));
                if ($slug === '') {
                    $slug = Str::slug($p['name']);
                }

                // price normalization
                $price = $p['price'] ?? null;
                if (!is_numeric($price)) {
                    if ($this->command) $this->command->warn("Skipping product {$slug}: invalid price");
                    continue;
                }
                $p['price'] = (float) $price;

                Product::updateOrCreate(['slug' => $slug], [
                    'name' => $p['name'],
                    'slug' => $slug,
                    'description' => $p['description'] ?? null,
                    'price' => $p['price'],
                    'image' => $p['image'] ?? null,
                ]);
            }
    }
}
