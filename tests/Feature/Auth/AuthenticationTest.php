<?php

namespace Dealskoo\User\Tests\Feature\Auth;

use Dealskoo\User\Models\User;
use Dealskoo\Country\Models\Country;
use Dealskoo\User\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Country::factory(['alpha2' => config('country.default_alpha2')])->create();
    }


    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get(route('user.login', [config('country.prefix') => request()->country()->alpha2]));

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->post(route('user.login', [config('country.prefix') => request()->country()->alpha2]), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('user');
        $response->assertRedirect(route('user.dashboard', [config('country.prefix') => request()->country()->alpha2]));
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post(route('user.login', [config('country.prefix') => request()->country()->alpha2]), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_user_not_authenticate_inactive()
    {
        $response = $this->get(route('user.banned', [config('country.prefix') => request()->country()->alpha2]));
        $response->assertStatus(200);

    }

    public function test_user_authenticate_inactive()
    {
        $user = User::factory()->inactive()->create();
        $response = $this->actingAs($user, 'user')->get(route('user.dashboard', [config('country.prefix') => request()->country()->alpha2]));
        $response->assertRedirect(route('user.banned', [config('country.prefix') => request()->country()->alpha2]));
    }

    public function test_user_logout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->post(route('user.logout', [config('country.prefix') => request()->country()->alpha2]));
        $response->assertRedirect(route('user.login', [config('country.prefix') => request()->country()->alpha2]));
    }
}
