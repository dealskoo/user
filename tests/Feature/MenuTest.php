<?php

namespace Dealskoo\User\Tests\Feature;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\User\Facades\UserMenu;
use Dealskoo\User\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu()
    {
        $this->assertNotNull(AdminMenu::findBy('title', 'user::user.users'));
        $this->assertNotNull(UserMenu::findBy('title', 'user::user.dashboard'));
    }
}
