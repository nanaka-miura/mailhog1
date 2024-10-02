<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;


class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => 'Product ' . ($i + 1),
                'content' => 'Description for product ' . ($i + 1),
                'condition' => 'new',
                'price' => rand(1000, 10000), // 1000 から 10000 のランダムな価格
                'image' => 'path/to/image.jpg', // 画像のパス
                'sold_out' => false,
                'brand_id' => Brand::inRandomOrder()->first()->id, // ランダムなブランドIDを取得
                'category_id' => Category::inRandomOrder()->first()->id, // ランダムなカテゴリIDを取得
            ]);
        }
    }
}
