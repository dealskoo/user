<?php

namespace Dealskoo\User\Tests\Feature\Admin;

use Dealskoo\Country\Models\Country;
use Dealskoo\User\Models\User;
use Dealskoo\Admin\Models\Admin;
use Dealskoo\User\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.users.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.users.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_show()
    {
        $admin = Admin::factory()->isOwner()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.users.show', $user));
        $response->assertStatus(200);
    }

    public function test_edit()
    {
        $admin = Admin::factory()->isOwner()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.users.show', $user));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $admin = Admin::factory()->isOwner()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($admin, 'admin')->put(route('admin.users.update', $user), [
            'status' => false
        ]);
        $response->assertStatus(302);
        $user->refresh();
        $this->assertEquals(false, $user->status);
    }

    public function test_login()
    {
        Country::factory(['alpha2' => config('country.default_alpha2')])->create();
        URL::defaults([config('country.prefix') => request()->country()->alpha2]);
        $admin = Admin::factory()->isOwner()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.users.login', $user));
        $this->assertAuthenticated('user');
        $response->assertRedirect(route('user.dashboard'));
    }
}
