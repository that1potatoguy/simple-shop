<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        
        
            
            
            
            $jsonPath = database_path('seeders/products.json');
            $products = [];
            if (file_exists($jsonPath)) {
                $contents = json_decode(file_get_contents($jsonPath), true);
                if (is_array($contents) && !empty($contents)) {
                    $products = $contents;
                }
            }

            
            if (empty($products)) {
                $products = [
                    ['name' => 'Sample Product', 'slug' => 'sample-product', 'description' => 'Example product', 'price' => 9.99, 'image' => null],
                ];
            }

            foreach ($products as $p) {
                
                if (empty($p['name']) || empty($p['slug'])) {
                    if ($this->command) $this->command->warn('Skipping product with missing name or slug: ' . json_encode($p));
                    continue;
                }

                
                $slug = trim((string) ($p['slug'] ?? ''));
                if ($slug === '') {
                    $slug = Str::slug($p['name']);
                }

                
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
