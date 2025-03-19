<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminData = [
          'name' => 'Admin Sekolah',
          'username' => 'adminsekolah',
          'email' => 'admin@gmail.com',
          'password' => Hash::make('admin123'),
          'role' => 'admin',
        ];

        User::create($adminData);
    }
}
