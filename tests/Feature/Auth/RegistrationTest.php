<?php

namespace Dealskoo\User\Tests\Feature\Auth;

use Dealskoo\Country\Models\Country;
use Dealskoo\User\Events\UserRegistered;
use Dealskoo\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\User\Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Country::factory(['alpha2' => config('country.default_alpha2')])->create();
    }

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get(route('user.register', [config('country.prefix') => request()->country()->alpha2]));

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        Event::fake();
        $country = Country::factory()->create();
        $response = $this->post(route('user.register', [config('country.prefix') => request()->country()->alpha2]), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'country_id' => $country->id,
        ]);

        $this->assertAuthenticated('user');
        $response->assertRedirect(route('user.dashboard', [config('country.prefix') => request()->country()->alpha2]));
        Event::assertDispatched(UserRegistered::class);
        $user = User::get()->first();
    }
}
