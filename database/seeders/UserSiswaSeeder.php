<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Aisyah Almas Nur Salsabila',
            'Nada Celia Sinka Audy Ines',
            'Fauziah Putri Ramadhani',
            'Nanda Ayu Putri Ashari',
            'Luluk Triyani',
            'Andini Diska Anggraini',
            'Putri Nur Sakinah',
            'Eliya Fitri Nur Azizah',
            'Azril Praya Prasetyo',
            'Juniardanu Widi Murdianto',
            'Zeiniyatul Fitriyah',
            'Erna Ainul Khasanah',
            'M. Sofi Ulinuha Adian',
            'Egi Brenka Ginting',
            'Indana Zulfa',
            'Moch Yusril Irsya Nur Rohim',
            'Aura Presty Bintari',
            'Mohammad Ageng Prasetyo'
        ];

        foreach ($names as $name) {
            $username = Str::slug($name, '_');
            DB::table('users')->insert([
                'name' => $name,
                'username' => $username,
                'email' => $username . '@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'siswa',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
