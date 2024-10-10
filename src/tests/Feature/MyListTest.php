<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /** @test */
    public function test_can_fetch_like_products()
    {
        $user = User::first();
        $product = Product::first();
        $user->likeProducts()->attach($product->id);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /** @test */
    public function test_sold_items_display_sold_label()
    {
        $user = User::first();
        $product = Product::first();
        $product->sold_out = true;
        $product->save();
        $user->likeProducts()->attach($product->id);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('Sold');

        $response->assertSee($product->name);
    }

    /** @test */
    public function test_user_cannot_see_own_listed_products_after_login()
    {
        $user = User::first();

        $ownProduct = Product::first();
        $ownProduct->user_id = $user->id;
        $ownProduct->save();

        $otherProduct = Product::where('id', '!=', $ownProduct->id)->first();

        $user->likeProducts()->attach($otherProduct->id);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertDontSee($ownProduct->name);

        $response->assertSee($otherProduct->name);
    }

    /** @test */
    public function test_no_products_displayed_for_guests()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertDontSee('腕時計');
        $response->assertDontSee('HDD');
        $response->assertDontSee('玉ねぎ3束');
        $response->assertDontSee('革靴');
        $response->assertDontSee('ノートPC');
        $response->assertDontSee('マイク');
        $response->assertDontSee('ショルダーバッグ');
        $response->assertDontSee('タンブラー');
        $response->assertDontSee('コーヒーミル');
        $response->assertDontSee('メイクセット');
    }
}