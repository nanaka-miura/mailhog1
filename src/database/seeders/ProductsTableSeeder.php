<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Faker\Factory as Faker;


class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            // 画像を生成して保存
            $imageUrl = 'https://via.placeholder.com/150'; // プレースホルダー画像
            $imagePath = 'products/' . uniqid() . '.jpg';

            // 画像をダウンロードして保存する場合
            file_put_contents(public_path('storage/' . $imagePath), file_get_contents($imageUrl));

            Product::create([
                'user_id' => rand(1,2),
                'category_id' => rand(1, 5),
                'name' => $faker->word,
                'content' => $faker->sentence,
                'condition' => $faker->word,
                'price' => $faker->numberBetween(1000, 10000),
                'image' => $imagePath,
                'sold_out' => $faker->boolean,
            ]);
    }
}
}