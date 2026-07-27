<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email','admin@sipbar.sch.id')->first();
if ($user) {
    echo "FOUND:{$user->id}:{$user->email}\n";
} else {
    echo "NOT_FOUND\n";
}
