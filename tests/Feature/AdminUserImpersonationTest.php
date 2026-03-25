<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminUserImpersonationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'user', 'guard_name' => 'web']);
    }

    public function test_admin_can_impersonate_a_regular_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($admin)->post(route('admin.users.impersonate', $user));

        $response->assertRedirect(route('user.dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->assertSame($admin->id, session('impersonator_id'));
    }

    public function test_non_admin_cannot_impersonate_another_user(): void
    {
        $actor = User::factory()->create();
        $actor->assignRole('user');

        $target = User::factory()->create();
        $target->assignRole('user');

        $this->actingAs($actor)
            ->post(route('admin.users.impersonate', $target))
            ->assertForbidden();

        $this->assertAuthenticatedAs($actor);
    }

    public function test_admin_can_leave_impersonation_and_return_to_admin_account(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($admin)->post(route('admin.users.impersonate', $user));

        $response = $this->delete(route('impersonation.destroy'));

        $response->assertRedirect(route('admin.users.show', $user));
        $this->assertAuthenticatedAs($admin);
        $this->assertNull(session('impersonator_id'));
    }
}
