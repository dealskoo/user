<?php

namespace Dealskoo\User\Tests\Feature;

use Dealskoo\Country\Models\Country;
use Dealskoo\User\Models\User;
use Dealskoo\User\Tests\Notifications\UserNotificationDemo;
use Dealskoo\User\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Country::factory(['alpha2' => config('country.default_alpha2')])->create();
    }

    public function test_list()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->get(route('user.notification.list', [config('country.prefix') => request()->country()->alpha2]));
        $response->assertStatus(200);
    }

    public function test_unread()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->get(route('user.notification.unread', [config('country.prefix') => request()->country()->alpha2]));
        $response->assertStatus(200);
    }

    public function test_all_read()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->get(route('user.notification.all_read', [config('country.prefix') => request()->country()->alpha2]));
        $response->assertStatus(302);
    }

    public function test_show()
    {
        $user = User::factory()->create();
        $user->notify(new UserNotificationDemo());
        $notification = $user->notifications->last();
        $response = $this->actingAs($user, 'user')->get(route('user.notification.show', [config('country.prefix') => request()->country()->alpha2, 'id' => $notification->id]));
        $response->assertStatus(200);
    }
}
