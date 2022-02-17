<?php

namespace Dealskoo\User\Tests\Feature;

use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\User\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permissions()
    {
        $this->assertNotNull(PermissionManager::getPermission('users.index'));
        $this->assertNotNull(PermissionManager::getPermission('users.show'));
        $this->assertNotNull(PermissionManager::getPermission('users.edit'));
    }
}
