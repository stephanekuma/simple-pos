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
        User::query()->create(attributes: [
            'name' => 'Admin',
            'email' => 'admin@bokitgrill.online',
            'password' => bcrypt('password'),
        ]);
    }
}
