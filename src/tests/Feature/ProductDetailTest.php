<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /** @test */
    public function test_product_detail_page_displays_required_information()
    {
        $product = Product::first();
        $categories = Category::all();

        $user = User::first();
        $commentContent = 'This is a test comment.';
        $product->comments()->create([
            'user_id' => $user->id,
            'content' => $commentContent,
        ]);

        $response = $this->get('/item/' . $product->id);

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee($product->image);
        $response->assertSee('¥' . number_format($product->price) . ' (税込)');
        $response->assertSee($product->like_count);
        $response->assertSee($product->comment_count);
        $response->assertSee($product->content);
        $response->assertSee($product->category->name);
        $response->assertSee($product->detail);
        $response->assertSee($product->comment_count);
        $response->assertSee($product->comment_user);
        $response->assertSee($product->comment_content);

        foreach ($product->categories as $category) {
            $response->assertSee($category->name);
        }
        $response->assertSee($commentContent);
        $response->assertSee($user->name);
    }

    public function it_displays_selected_categories_on_product_detail_page()
    {
        $response = $this->get(route('products.show', $product->id));

        foreach ($categories as $category) {
            $response->assertSee($category['name']);
        }

        $response->assertStatus(200);
    }
}