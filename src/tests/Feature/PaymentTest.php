<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use App\Models\Product;
use App\Models\User;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /** @test */
    public function payment_method_is_reflected_immediately_on_subtotal_screen()
    {
        $user = User::first();
        $product = Product::where('user_id', '!=', $user->id)->where('sold_out', false)->first();

        $this->actingAs($user);

        $response = $this->get(route('purchase', ['id' => $product->id]));
        $response->assertStatus(200);

        $selectedPayment = 'カード支払い';

        session(['selected_payment' => $selectedPayment]);

        $response = $this->get(route('purchase', ['id' => $product->id]));

        $response->assertSee($selectedPayment);

    }
}
