<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class CollectionPromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productIds = Product::pluck('id')->toArray();
        if (empty($productIds)) {
            return;
        }
        $collections = [
            'top-picks',
            'weekly-deals',
            'new-arrivals',
        ];
        foreach ($collections as $key) {
            foreach (array_slice($productIds, 0, 3) as $productId) {
                DB::table ('product_collections')->insert([
                    'collection_key' => $key,
                    'product_id' => $productId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        $promos = [
            'diskon-awal-bulan',
            'flash-sale-weekend',
        ];
        foreach ($promos as $slug) {
            foreach (array_slice($productIds, 1, 3) as $productId) {
                DB::table('product_promos')-> insert([
                    'promo_slug' => $slug,
                    'product_id' => $productId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
