<?php

namespace Dealskoo\User\Tests\Feature\Auth;

use Dealskoo\User\Models\User;
use Dealskoo\Country\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\User\Tests\TestCase;
use Illuminate\Support\Facades\URL;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Country::factory(['alpha2' => config('country.default_alpha2')])->create();
        URL::defaults([config('country.prefix') => request()->country()->alpha2]);
    }

    public function test_confirm_password_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'user')->get(route('user.password.confirm'));

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'user')->post(route('user.password.confirm'), [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'user')->post(route('user.password.confirm'), [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
