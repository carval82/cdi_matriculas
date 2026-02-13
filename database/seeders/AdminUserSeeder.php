<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'pcapacho24@gmail.com'],
            [
                'name' => 'Pedro Capacho',
                'password' => Hash::make('anaval33'),
                'role' => 'admin',
                'activo' => true,
            ]
        );
    }
}
