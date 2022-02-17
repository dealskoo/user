<?php

namespace Dealskoo\User\Tests\Feature\Auth;

use Dealskoo\User\Models\User;
use Dealskoo\User\Notifications\ResetUserPassword;
use Dealskoo\Country\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Dealskoo\User\Tests\TestCase;
use Illuminate\Support\Facades\URL;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Country::factory(['alpha2' => config('country.default_alpha2')])->create();
        URL::defaults([config('country.prefix') => request()->country()->alpha2]);
    }

    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get(route('user.password.request'));

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('user.password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetUserPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('user.password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetUserPassword::class, function ($notification) {
            $response = $this->get(route('user.password.reset', ['token' => $notification->token]));

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('user.password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, ResetUserPassword::class, function ($notification) use ($user) {
            $response = $this->post(route('user.password.update'), [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
