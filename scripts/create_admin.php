<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Enums\UserRole;

$email = 'admin@sipbar.sch.id';
$password = 'Secret123!';

$user = User::where('email', $email)->first();
if (! $user) {
    $user = User::create([
        'name' => 'Admin SIPBAR',
        'email' => $email,
        'password' => bcrypt($password),
        'role' => UserRole::Admin,
    ]);
    echo "CREATED:{$user->id}:{$user->email}\n";
} else {
    $user->password = bcrypt($password);
    $user->role = UserRole::Admin;
    $user->save();
    echo "UPDATED:{$user->id}:{$user->email}\n";
}

echo "Password for {$email} set to: {$password}\n";
