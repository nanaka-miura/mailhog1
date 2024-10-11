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

class AddressChangeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /** @test */
    public function test_address_is_updated_and_reflected_in_purchase_screen()
    {
        $user = User::first();
        $this->actingAs($user);

        $product = Product::where('sold_out', false)->first();
        $response = $this->get(route('purchase', $product->id));
        $response->assertStatus(200);

        $response = $this->get(route('purchase.address', $product->id));
        $response->assertStatus(200);

        $response = $this->post(route('purchase.updateAddress', $product->id), [
            'postal_code' => '123-4567',
            'address' => '新しい住所',
            'building' => '新しい建物名'
        ]);

        $response->assertRedirect(route('purchase', ['id' => $product->id]));

        $response = $this->get(route('purchase', ['id' => $product->id]));
        $response->assertSee('123-4567');
        $response->assertSee('新しい住所');
        $response->assertSee('新しい建物名');
    }

    public function test_shipping_address_is_correctly_associated_with_purchased_product()
    {
        $user = User::first();
        $this->actingAs($user);

        $product = Product::where('sold_out', false)->first();

        $response = $this->get(route('purchase', $product->id));
        $response->assertStatus(200);

        $response = $this->get(route('purchase.address', $product->id));
        $response->assertStatus(200);

        $response = $this->post(route('purchase.updateAddress', $product->id), [
            'postal_code' => '123-4567',
            'address' => '新しい住所',
            'building' => '新しい建物名'
        ]);

        $response->assertRedirect(route('purchase', ['id' => $product->id]));

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        Mockery::mock('alias:Stripe\Checkout\Session')
            ->shouldReceive('create')
            ->once()
            ->andReturn((object) ['url' => 'http://localhost/mypage']);

        $response = $this->post(route('purchase.complete', $product->id), [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'payment' => 'カード支払い',
            'postal_code' => '123-4567',
            'address' => '新しい住所',
            'building' => '新しい建物名',
        ]);

        $response->assertRedirect('http://localhost/mypage');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'postal_code' => '123-4567',
            'shipping_address' => '新しい住所',
            'shipping_building' => '新しい建物名',
        ]);
    }
}