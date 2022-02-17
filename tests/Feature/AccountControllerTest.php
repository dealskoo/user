<?php

namespace Dealskoo\User\Tests\Feature;

use Dealskoo\Country\Models\Country;
use Dealskoo\User\Models\User;
use Dealskoo\User\Notifications\EmailChangeNotification;
use Dealskoo\User\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Country::factory(['alpha2' => config('country.default_alpha2')])->create();
    }

    public function test_profile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->get(route('user.account.profile', [config('country.prefix') => request()->country()->alpha2]));
        $response->assertStatus(200);
    }

    public function test_update_profile()
    {
        $user = User::factory()->create();
        $user1 = User::factory()->make();
        $response = $this->actingAs($user, 'user')->post(route('user.account.profile', [config('country.prefix') => request()->country()->alpha2]), $user1->only([
            'name',
            'bio',
            'company_name',
            'website'
        ]));
        $response->assertStatus(302);
        $user->refresh();
        $this->assertEquals($user1->name, $user->name);
    }

    public function test_avatar()
    {
        Storage::fake();
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->post(route('user.account.avatar', [config('country.prefix') => request()->country()->alpha2]), [
            'file' => UploadedFile::fake()->image('file.jpg')
        ]);
        $response->assertStatus(200);
        Storage::assertExists('user/avatars/' . $user->id . '.jpg');
    }

    public function test_email()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->get(route('user.account.email', [config('country.prefix') => request()->country()->alpha2]));
        $response->assertStatus(200);
    }

    public function test_update_email()
    {
        Notification::fake();
        $user = User::factory()->create();
        $user1 = User::factory()->make();
        $response = $this->actingAs($user, 'user')->post(route('user.account.email', [config('country.prefix') => request()->country()->alpha2]), $user1->only([
            'email'
        ]));
        $response->assertStatus(302);
        Notification::assertSentTo(Notification::route('mail', $user1->email), EmailChangeNotification::class);
    }

    public function test_email_verify()
    {
        Notification::fake();
        $user = User::factory()->create();
        $user1 = User::factory()->make();
        $response = $this->actingAs($user, 'user')->post(route('user.account.email', [config('country.prefix') => request()->country()->alpha2]), $user1->only([
            'email'
        ]));
        $response->assertStatus(302);
        Notification::assertSentTo(Notification::route('mail', $user1->email), EmailChangeNotification::class, function ($notification) use ($user) {
            $response = $this->actingAs($user, 'user')->get($notification->url);
            $response->assertSessionHasNoErrors();
            return true;
        });
    }

    public function test_password()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->get(route('user.account.password', [config('country.prefix') => request()->country()->alpha2]));
        $response->assertStatus(200);
    }

    public function test_update_password()
    {
        $password = '12345678';
        $new_password = '23456789';
        $user = User::factory()->create();
        $user->password = Hash::make($password);
        $user->save();
        $response = $this->actingAs($user, 'user')->post(route('user.account.password', [config('country.prefix') => request()->country()->alpha2]), [
            'password' => $password,
            'new_password' => $new_password,
            'new_password_confirmation' => $new_password
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
    }
}
