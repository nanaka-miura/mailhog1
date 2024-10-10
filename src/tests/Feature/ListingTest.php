<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class ListingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(UsersTableSeeder::class);

    }

    /** @test */
    public function test_product_listing_information_is_save_correctly()
    {
        $user = User::first();
        $this->actingAs($user);

        Storage::fake('public');

        $image = UploadedFile::fake()->create('test_image.jpg', 150);

        $category = Category::first();

        $data = [
            'categories' => [$category->id],
            'condition' => '良好',
            'name' => 'テスト商品',
            'content' => 'テスト商品の説明です。',
            'price' => 5000,
            'image' => $image,
            'sold_out' => false
        ];

        $response = $this->get('/sell');
        $response->assertStatus(200);

        $response = $this->post('/sell', $data);

        $this->assertDatabaseHas('products', [
            'category_id' => $category->id,
            'condition' => '良好',
            'name' => 'テスト商品',
            'content' => 'テスト商品の説明です。',
            'price' => 5000,
            'sold_out' => false

        ]);

        Storage::disk('public')->assertExists('products/' . $image->hashName());

    }
}