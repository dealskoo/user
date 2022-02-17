<?php

namespace Dealskoo\User\Tests\Feature;

use Dealskoo\Country\Models\Country;
use Dealskoo\User\Models\User;
use Dealskoo\User\Tests\Notifications\UserNotificationDemo;
use Dealskoo\User\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Country::factory(['alpha2' => config('country.default_alpha2')])->create();
        URL::defaults([config('country.prefix') => request()->country()->alpha2]);
    }

    public function test_list()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->get(route('user.notification.list'));
        $response->assertStatus(200);
    }

    public function test_unread()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->get(route('user.notification.unread'));
        $response->assertStatus(200);
    }

    public function test_all_read()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->get(route('user.notification.all_read'));
        $response->assertStatus(302);
    }

    public function test_show()
    {
        $user = User::factory()->create();
        $user->notify(new UserNotificationDemo());
        $notification = $user->notifications->last();
        $response = $this->actingAs($user, 'user')->get(route('user.notification.show', $notification));
        $response->assertStatus(200);
    }
}
