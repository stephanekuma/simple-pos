<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@bokitgrill.online'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole('super_admin');

        $stephane = User::query()->firstOrCreate(
            ['email' => 'kumastephane@gmail.com'],
            [
                'name' => 'Stéphane Kuma',
                'password' => bcrypt('super'),
            ]
        );
        $stephane->assignRole('super_admin');
    }
}
