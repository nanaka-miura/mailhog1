<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use App\Models\Product;
use App\Models\User;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /** @test */
    public function test_partial_match_search()
    {
        $productName = Product::inRandomOrder()->first()->name;

        $response = $this->get('/?keyword=' . urlencode($productName));

        $response->assertStatus(200);
        $response->assertSee($productName);
    }

    public function test_search_keyword_is_retained_when_navigating_to_mylist()
    {
        $user = User::first();
        $product = Product::first();

        $user->likeProducts()->attach($product->id);

        $this->actingAs($user);

        $searchKeyword = $product->name;

        $response = $this->get('/?tab=mylist&keyword=' . urlencode($searchKeyword));

        $response->assertStatus(200);

        $response->assertSee($searchKeyword);

        $response->assertSee($product->name);
    }
}
