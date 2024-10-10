<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use App\Models\Product;
use App\Models\User;
use Mockery;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        Mockery::mock('alias:Stripe\Checkout\Session')
            ->shouldReceive('create')
            ->once()
            ->andReturn((object) ['url' => 'http://localhost/mypage']);
    }

    /** @test */
    public function payment_method_is_reflected_immediately_on_subtotal_screen()
    {
        $user = User::first();
        $product = Product::where('user_id', '!=', $user->id)->where('sold_out', false)->first();

        $this->actingAs($user);

        $response = $this->get(route('purchase', ['id' => $product->id]));
        $response->assertStatus(200);

        $paymentMethod = 'カード支払い';

        $response = $this->post(route('purchase.complete', $product->id), [
            'payment' => $paymentMethod,
            'postal_code' => '111-1111',
            'address' => '東京都品川区',
            'building' => null,
        ]);

        $response = $this->get(route('purchase', ['id' => $product->id]));

        $response->assertSeeText($paymentMethod);

    }
}
