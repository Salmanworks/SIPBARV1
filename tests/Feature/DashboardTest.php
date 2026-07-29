<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_dashboard_redirects_to_admin_panel(): void
    {
        $user = User::create([
            'name'     => 'Admin Test',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password'),
            'role'     => UserRole::Admin,
        ]);
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_guru_dashboard_redirects_to_guru_panel(): void
    {
        $user = User::create([
            'name'     => 'Guru Test',
            'email'    => 'guru@test.com',
            'password' => Hash::make('password'),
            'role'     => UserRole::Guru,
        ]);
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('guru.verifikasi.dashboard'));
    }

    public function test_siswa_dashboard_redirects_to_peminjam_panel(): void
    {
        $user = User::create([
            'name'     => 'Siswa Test',
            'email'    => 'siswa@test.com',
            'password' => Hash::make('password'),
            'role'     => UserRole::Siswa,
        ]);
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('peminjam.dashboard'));
    }
}
