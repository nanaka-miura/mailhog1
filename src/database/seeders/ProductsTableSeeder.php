<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
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
        $userIds = DB::table('users')->pluck('id');

        $products = [
            [
                'user_id' => $userIds->random(),
                'category_id' => ['1', '12', '5'],
                'name' => '腕時計',
                'brand' => 'テストブランド',
                'content' => 'スタイリッシュなデザインのメンズ腕時計',
                'condition' => '良好',
                'price' => '15000',
                'image' => 'products/gegjru0dt7CyUrcYipJ1mqOYlcOw2MB6fMcO4ihH.jpg',
                'sold_out' => false,
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => '2',
                'name' => 'HDD',
                'brand' => 'テストブランド',
                'content' => '高速で信頼性の高いハードデ ィスク',
                'condition' => '目立った傷や汚れなし',
                'price' => '5000',
                'image' => 'products/NpHZby7LSxTg4vmOg8pv6qywGHNshdAlxfprLBtU.jpg',
                'sold_out' => false,
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => '10',
                'name' => '玉ねぎ3束',
                'brand' => 'テストブランド',
                'content' => '新鮮な玉ねぎ3束のセット',
                'condition' => 'やや傷や汚れあり',
                'price' => '300',
                'image' => 'products/5KdnRuj1jSqBaSTEifqFRHB5GCk1001zaqZQAHRE.jpg',
                'sold_out' => false,
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => ['1', '5'],
                'name' => '革靴',
                'brand' => 'テストブランド',
                'content' => 'クラシックなデザインの革靴',
                'condition' => '状態が悪い',
                'price' => '4000',
                'image' => 'products/mQSDXK8a5yMC1GNmPLp4mBUSbx2kmF9iu5puylHf.jpg',
                'sold_out' => false,
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => '2',
                'name' => 'ノートPC',
                'brand' => 'テストブランド',
                'content' => '高性能なノートパソコン',
                'condition' => '良好',
                'price' => '45000',
                'image' => 'products/jPtK3RPiXbU14MAq9vy3I9b4Rg0ojV35xCnVNM2I.jpg',
                'sold_out' => false,
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => '13',
                'name' => 'マイク',
                'brand' => 'テストブランド',
                'content' => '高音質のレコーディング用マイク',
                'condition' => '目立った傷や汚れなし',
                'price' => '8000',
                'image' => 'products/C8C7KSAhaCZGtBqvlimuwMdkNZ366MUhUqM3Pbdf.jpg',
                'sold_out' => false,
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => ['1', '4'],
                'name' => 'ショルダーバッグ',
                'brand' => 'テストブランド',
                'content' => 'おしゃれなショルダーバッグ',
                'condition' => 'やや傷や汚れあり',
                'price' => '3500',
                'image' => 'products/iknEVLgOLzL8sgEddHC85K9NdbqNdfgVrDBCTggI.jpg',
                'sold_out' => false,
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => '10',
                'name' => 'タンブラー',
                'brand' => 'テストブランド',
                'content' => '使いやすいタンブラー',
                'condition' => '状態が悪い',
                'price' => '500',
                'image' => 'products/JVIGUeZwwNghTE7wHfxsdxHEU6JRutaLF6FyhoSu.jpg',
                'sold_out' => false,
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => '10',
                'name' => 'コーヒーミル',
                'brand' => 'テストブランド',
                'content' => '手動のコーヒーミル',
                'condition' => '良好',
                'price' => '4000',
                'image' => 'products/5nt3KJGI1zeJRkZ8njQL64ow8gSnVeDYYipKMtLh.jpg',
                'sold_out' => false,
            ],
            [
                'user_id' => $userIds->random(),
                'category_id' => '6',
                'name' => 'メイクセット',
                'brand' => 'テストブランド',
                'content' => '便利なメイクアップセット',
                'condition' => '目立った傷や汚れなし',
                'price' => '2500',
                'image' => 'products/dZFHFBJuC1KAIQtsRskpyTZAWry5UqGUelMhcGGe.jpg',
                'sold_out' => false,
            ],
        ];

        foreach ($products as $productData) {
            $productId = DB::table('products')->insertGetId([
                'user_id' => $productData['user_id'],
                'category_id' => is_array($productData['category_id']) ? $productData['category_id'][0] : $productData['category_id'],
                'name' => $productData['name'],
                'brand' => $productData['brand'],
                'content' => $productData['content'],
                'condition' => $productData['condition'],
                'price' => $productData['price'],
                'image' => $productData['image'],
                'sold_out' => $productData['sold_out'],
            ]);

            $categoryIds = (array) $productData['category_id'];
            foreach ($categoryIds as $categoryId) {
                DB::table('category_product')->insert([
                    'product_id' => $productId,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}