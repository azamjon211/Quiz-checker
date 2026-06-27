<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'abdulhamidovazamjon211@gmail.com'],
            [
                'name'     => 'azamjon',
                'password' => Hash::make('tyler21106'),
                'role'     => 'superadmin',
            ]
        );
    }
}
