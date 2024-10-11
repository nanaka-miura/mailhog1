<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use App\Models\Product;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Mockery;


class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        Mockery::globalHelpers();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function test_user_can_purchase_product()
    {
        $user = User::first();
        $product = Product::where('user_id', '!=', $user->id)->where('sold_out', false)->first();

        $this->actingAs($user);

        $response = $this->get(route('purchase', $product->id));
        $response->assertStatus(200);

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        Mockery::mock('alias:Stripe\Checkout\Session')
            ->shouldReceive('create')
            ->once()
            ->andReturn((object) ['url' => 'http://localhost/mypage']);

        $response = $this->post(route('purchase.complete', $product->id), [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'payment' => 'カード支払い',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
        ]);

        $response->assertRedirect('http://localhost/mypage');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment' => 'カード支払い',
            'postal_code' => $user->postal_code,
            'shipping_address' => $user->address,
        ]);

        $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'sold_out' => true,
    ]);
    }

    /** @test */
    public function test_sold_product_is_displayed_in_product_list()
    {
        $user = User::first();
        $product = Product::where('user_id', '!=', $user->id)->where('sold_out', false)->first();

        $this->actingAs($user);

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        Mockery::mock('alias:Stripe\Checkout\Session')
            ->shouldReceive('create')
            ->once()
            ->andReturn((object) ['url' => 'http://localhost/mypage']);

        $response = $this->post(route('purchase.complete', $product->id), [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'payment' => 'カード支払い',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
        ]);

        $response = $this->get(url('/'));

        $response->assertStatus(200);

        $response->assertSee($product->name);
        $response->assertSee('Sold');
    }

    /** @test */
    public function test_purchased_product_is_displayed_in_profile_purchase_list()
    {
        $user = User::first();
        $product = Product::where('user_id', '!=', $user->id)->where('sold_out', false)->first();

        $this->actingAs($user);

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        Mockery::mock('alias:Stripe\Checkout\Session')
            ->shouldReceive('create')
            ->once()
            ->andReturn((object) ['url' => 'http://localhost/mypage']);

        $response = $this->post(route('purchase.complete', $product->id), [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'payment' => 'カード支払い',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
        ]);

        $response = $this->get('/mypage?tab=buy');

        $response->assertStatus(200);

        $response->assertSee('購入した商品');
        $response->assertSee($product->name);
        $response->assertSee(route('products.show', $product->id));
    }
}
