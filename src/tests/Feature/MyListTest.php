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
        $user = User::all()->random();
        $otherUser = User::where('id', '!=', $user->id)->inRandomOrder()->first();
        $product = $otherUser->products()->inRandomOrder()->get()->random();

        $user->likeProducts()->attach($product->id);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /** @test */
    public function test_sold_items_display_sold_label()
    {
        $user = User::all()->random();
        $otherUser = User::where('id', '!=', $user->id)->inRandomOrder()->first();
        $product = $otherUser->products()->inRandomOrder()->get()->random();

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
        $user = User::all()->random();
        $ownProduct = $user->products()->inRandomOrder()->first();

        $user->likeProducts()->attach($ownProduct->id);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertDontSee($ownProduct->name);
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