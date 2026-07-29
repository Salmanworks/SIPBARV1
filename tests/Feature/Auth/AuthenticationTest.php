<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::create([
            'name'     => 'Admin Test',
            'email'    => 'admin@sipbar.sch.id',
            'password' => Hash::make('password'),
            'role'     => UserRole::Admin,
        ]);
        AdminProfile::create([
            'user_id'  => $user->id,
            'id_admin' => 'ADM001',
        ]);

        $response = $this->post(route('login.store'), [
            'role'       => 'admin',
            'identifier' => 'admin@sipbar.sch.id',
            'password'   => 'password',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::create([
            'name'     => 'Admin Test',
            'email'    => 'admin@sipbar.sch.id',
            'password' => Hash::make('password'),
            'role'     => UserRole::Admin,
        ]);
        AdminProfile::create([
            'user_id'  => $user->id,
            'id_admin' => 'ADM001',
        ]);

        $response = $this->post(route('login.store'), [
            'role'       => 'admin',
            'identifier' => 'admin@sipbar.sch.id',
            'password'   => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('identifier');

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::create([
            'name'     => 'Admin Test',
            'email'    => 'admin@sipbar.sch.id',
            'password' => Hash::make('password'),
            'role'     => UserRole::Admin,
        ]);

        $response = $this->actingAs($user)->post(route('logout'));

        // After logout, redirects to home landing page (not login)
        $response->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
