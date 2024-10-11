<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;


class ProductListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    /** @test */
    public function test_can_fetch_all_products()
    {
        $response = $this->get('/');

        $response ->assertStatus(200);
        $response->assertViewHas('products', Product::all());
    }

    /** @test */
    public function test_sold_items_display_sold_label()
    {
        $product = Product::first();
        $product->sold_out = true;
        $product->save();

        $response = $this->get('/');

        $response->assertSee('Sold', false);
    }

    /** @test */
    public function test_user_cannot_see_own_listed_products()
    {
        $user = User::all()->random();
        $ownProduct = $user->products()->inRandomOrder()->first();

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertDontSee($ownProduct->name);
    }
}