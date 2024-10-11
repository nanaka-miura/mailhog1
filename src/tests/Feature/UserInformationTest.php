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
        ]);

        $response = $this->get('/mypage');


        $response->assertStatus(200);

        $response->assertSee($user->name);
        if ($user->image) {
            $response->assertSee('<img src="' . asset('storage/' . $user->image) . '"', false);
        }

        $response = $this->get('/mypage?tab=sell');
        $response->assertStatus(200);

        foreach ($userProducts as $product) {
            $imagePath = asset('storage/' . $product->image);
        $response->assertSee($product->name);
        $response->assertSee($imagePath, false);
        $response->assertSee(route('products.show', $product->id));
        }

        $response = $this->get('/mypage?tab=buy');
        $response->assertStatus(200);

        $response->assertSee($productToPurchase->name);
        $response->assertSeeInOrder([
            '<img','src="' . asset('storage/' . $productToPurchase->image) . '"'
        ], false);

        $response->assertSee(route('products.show', $productToPurchase->id));
    }

    /** @test */
    public function profile_page_displays_default_values_correctly()
    {
        $user = User::first();
        $this->actingAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);

        $response->assertSee('value="' . e($user->name) . '"', false);

        $response->assertSee('value="' . e($user->postal_code) . '"', false);

        $response->assertSee('value="' . e($user->address) . '"', false);

        if ($user->image) {
            $response->assertSee('<img src="' . asset('storage/' . $user->image) . '"', false);
        } else {
            $response->assertSee('class="profile__item--default-img"', false);
        }
    }
}
