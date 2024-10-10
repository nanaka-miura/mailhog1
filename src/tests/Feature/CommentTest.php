<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /** @test */
    public function user_can_comment_a_product_and_increment_comment_count()
    {
        $user = User::first();
        $product = Product::first();

        $initialCommentCount = $product->comments()->count();

        $this->actingAs($user);

        $response = $this->post(route('comments.store', ['id' => $product->id]),  [
            'content' => 'これはテストコメントです。',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => 'これはテストコメントです。',

        ]);

        $this->assertEquals($initialCommentCount + 1, $product->comments()->count());

        $response->assertRedirect(route('products.show', ['id' => $product->id]));
    }

    /** @test */
    public function guest_user_cannot_comment_on_a_product()
    {
        $product = Product::first();

        $response = $this->post(route('comments.store', ['id' => $product->id]),  [
            'content' => 'これはゲストユーザーのコメントです。',
        ]);

        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'content' => 'これはゲストユーザーのコメントです。'
        ]);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_must_enter_a_comment()
    {
        $user = User::first();
        $product = Product::first();

        $this->actingAs($user);

        $response = $this->post(route('comments.store', ['id' => $product->id]),  [
            'content' => '',
        ]);

        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'content' => ''
        ]);

        $response->assertSessionHasErrors('content');
    }

    /** @test */
    public function user_must_not_exceed_comment_length()
    {
        $user = User::first();
        $product = Product::first();

        $this->actingAs($user);

        $longComment = str_repeat('a', 256);

        $response = $this->post(route('comments.store', ['id' => $product->id]),  [
            'content' => $longComment,
        ]);

        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'content' => $longComment,
        ]);

        $response->assertSessionHasErrors('content');
    }
}
