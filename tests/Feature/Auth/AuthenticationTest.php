<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_dashboard_requires_authentication(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));

        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertViewIs('pages.dashboard');
    }

    public function test_regular_users_cannot_access_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard')->assertForbidden();
    }

    public function test_writers_are_sent_to_news_dashboard(): void
    {
        $writer = User::factory()->create();
        $writer->forceFill(['role' => 'penulis'])->save();

        $this->actingAs($writer)
            ->get('/dashboard')
            ->assertRedirect(route('konten.berita', absolute: false));
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('beranda', absolute: false));
    }

    public function test_regular_users_are_sent_to_beranda_even_after_visiting_dashboard(): void
    {
        $user = User::factory()->create();

        $this->get('/dashboard')->assertRedirect(route('login'));

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('beranda', absolute: false));
    }

    public function test_authenticated_regular_users_are_not_sent_to_dashboard_from_login(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/login')->assertRedirect(route('beranda'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHas('errors', function ($errors): bool {
            if ($errors instanceof \Illuminate\Support\ViewErrorBag) {
                return $errors->getBag('default')->get('password') === ['Email atau password salah.'];
            }

            return ($errors['password'] ?? null) === ['Email atau password salah.'];
        });
    }

    public function test_users_can_not_authenticate_with_unknown_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'unknown@akademik.test',
            'password' => 'password',
        ]);

        $this->assertGuest();
        $this->assertSame(302, $response->status());
    }

    public function test_users_see_the_failed_login_message_for_an_invalid_email_format(): void
    {
        $response = $this->post('/login', [
            'email' => 'rqwqwrqe',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
