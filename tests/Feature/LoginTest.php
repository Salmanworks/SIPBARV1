<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\AdminProfile;
use App\Models\GuruProfile;
use App\Models\SiswaProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = User::create([
            'name'     => 'Administrator SIPBAR',
            'email'    => 'admin@sipbar.sch.id',
            'password' => Hash::make('password'),
            'role'     => UserRole::Admin,
        ]);
        AdminProfile::create([
            'user_id'  => $admin->id,
            'id_admin' => 'ADM001',
        ]);

        $guru = User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'guru@sipbar.sch.id',
            'password' => Hash::make('password'),
            'role'     => UserRole::Guru,
        ]);
        GuruProfile::create([
            'user_id' => $guru->id,
            'nip'     => 'GRU001',
        ]);

        $siswa = User::create([
            'name'     => 'Ahmad Fauzi',
            'email'    => 'siswa@sipbar.sch.id',
            'password' => Hash::make('password'),
            'role'     => UserRole::Siswa,
        ]);
        SiswaProfile::create([
            'user_id' => $siswa->id,
            'nis'     => 'SIS001',
        ]);
    }

    #[DataProvider('roleProvider')]
    public function test_login_success_for_each_role(
        string $role,
        string $identifier,
        string $expectedRouteName
    ): void {
        $response = $this->post(route('login'), [
            'role'       => $role,
            'identifier' => $identifier,
            'password'   => 'password',
        ]);

        // After successful login LoginController redirects to the expected route
        $response->assertRedirect(route($expectedRouteName));
        $this->assertAuthenticated();
        $this->assertEquals($role, auth()->user()->role->value);

        // logout before the next data set
        $this->post(route('logout'));
    }

    public static function roleProvider(): array
    {
        return [
            'admin' => ['admin', 'admin@sipbar.sch.id', 'admin.dashboard'],
            'guru'  => ['guru',  'GRU001',              'dashboard'],
            'siswa' => ['siswa', 'SIS001',               'dashboard'],
        ];
    }
}
