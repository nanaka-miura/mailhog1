<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;


class LikeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    /** @test */
    public function user_can_like_a_product_and_increment_like_count()
    {
        $user = User::first();
        $product = Product::first();

        $initialLikeCount = $product->likeCount();

        $this->actingAs($user);

        $response = $this->post(route('products.like', $product->id));

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->assertEquals($initialLikeCount + 1, $product->likeCount());

        $response->assertRedirect(route('products.show', ['id' => $product->id]));

    }

    /** @test */
    public function user_can_see_like_icon_after_liking_product()
    {
        $user = User::first();
        $product = Product::first();

        $this->actingAs($user);

        $response = $this->post(route('products.like', $product->id));

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response->assertRedirect(route('products.show', ['id' => $product->id]));

        $this->get(route('products.show', ['id' => $product->id]))->assertSee('class="fas fa-star"', false);
    }

    /** @test */
    public function user_can_see_unlike_a_product_and_decrement_like_count()
    {
        $user = User::first();
        $product = Product::first();

        $user->likeProducts()->attach($product->id);

        $initialLikeCount = $product->likeCount();

        $this->actingAs($user);

        $response = $this->post(route('products.like', $product->id));

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->assertEquals($initialLikeCount - 1, $product->likeCount());

        $response->assertRedirect(route('products.show', ['id' => $product->id]));

    }
}
