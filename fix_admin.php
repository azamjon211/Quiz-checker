<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$updated = Illuminate\Support\Facades\DB::table('users')
    ->where('email', 'admin@quiz.uz')
    ->update(['role' => 'admin']);

echo $updated ? "Admin roli 'admin' ga o'zgartirildi.\n" : "Foydalanuvchi topilmadi!\n";

$user = App\Models\User::where('email', 'admin@quiz.uz')->first();
echo "Email: {$user->email}, Role: {$user->role}\n";
