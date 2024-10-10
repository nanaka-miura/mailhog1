<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_validation_error_when_name_is_empty()
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertContains('お名前を入力してください' , session()->get('errors')->get('name'));
    }

    /**@test */
    public function it_shows_validation_error_when_email_is_empty()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password_123',
            'email' => '',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertContains('メールアドレスを入力してください',
        $response->session()->get('errors')->get('email'));
    }

    /** @test */
    public function it_shows_validation_error_when_password_is_empty()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertContains('パスワードを入力してください', session('errors')->get('password'));
    }

    /**@test */
    public function it_shows_validation_error_when_password_is_too_short()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertContains('パスワードは8文字以上で入力してください', $response->session()->get('errors')->get('password'));
    }

    /** @test */
    public function it_shows_validation_error_when_passwords_do_not_match()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertContains('パスワードと一致しません', session('errors')->get('password'));
    }

    /** @test */
    public function it_registers_user_and_redirects_to_login_when_all_fields_are_valid()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect('/register');
    }
}