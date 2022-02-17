<?php

namespace Dealskoo\User\Tests\Feature;

use Dealskoo\Country\Models\Country;
use Dealskoo\User\Models\User;
use Dealskoo\User\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Country::factory(['alpha2' => config('country.default_alpha2')])->create();
        URL::defaults([config('country.prefix') => request()->country()->alpha2]);
    }

    public function test_search()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'user')->get(route('user.search'));
        $response->assertStatus(200);
    }
}
