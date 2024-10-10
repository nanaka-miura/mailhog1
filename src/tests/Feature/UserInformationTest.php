<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use App\Models\User;
use App\Models\Product;

class UserInformationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /** @test */
    public function user_information_is_displayed_correctly_on_profile_page()
    {
        $user = User::first();
        $userProducts = Product::where('user_id', $user->id)->get();
        $productToPurchase = Product::where('user_id', '!=', $user->id)->where('sold_out', false)->first();

        $this->actingAs($user);

        $this->post(route('purchase.complete', $productToPurchase->id), [
            'payment' => 'カード支払い',
            'postal_code' => '111-1111',
            'address' => '東京都品川区',
            'building' => null,
        ]);

        $response = $this->get('/mypage');

        $response->assertStatus(200);

        $response->assertSee($user->name); // ユーザー名の確認
        
        if ($user->image) {
        $response->assertSee('<img src="' . asset('storage/' . $user->image) . '"', false);
    }

         foreach ($userProducts as $product) {
            $response->assertSee($product->name, false);
        }

        // 購入した商品が正しく表示されていることを確認
        $response->assertSee($productToPurchase->name, false);
}
}
