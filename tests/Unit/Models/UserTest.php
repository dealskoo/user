<?php

namespace Dealskoo\User\Tests\Unit\Models;

use Dealskoo\User\Models\User;
use Dealskoo\User\Notifications\ResetUserPassword;
use Dealskoo\User\Notifications\VerifyUserEmail;
use Dealskoo\User\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_avatar_url()
    {
        $user = User::factory()->create();
        $user->avatar = 'avatar.png';
        $this->assertEquals($user->avatar_url, Storage::url($user->avatar));
    }

    public function test_send_password_reset_notification()
    {
        Notification::fake();
        $user = User::factory()->create();
        $user->sendPasswordResetNotification('aaa');
        Notification::assertSentTo($user, ResetUserPassword::class);
    }

    public function test_send_email_verification_notification()
    {
        Notification::fake();
        $user = User::factory()->create();
        $user->sendEmailVerificationNotification();
        Notification::assertSentTo($user, VerifyUserEmail::class);
    }

    public function test_country()
    {
        $user = User::factory()->create();
        $this->assertNotNull($user->country);
    }

    public function test_slug()
    {
        $slug = 'Hello';
        $user = User::factory()->create();
        $user->slug = $slug;
        $user->save();
        $user->refresh();
        $this->assertEquals($user->slug, Str::lower($slug));
    }
}
