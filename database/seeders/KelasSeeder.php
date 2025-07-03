<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        foreach (range('A', 'G') as $huruf) {
            $data[] = [
                'nama_kelas' => "TRPL 4$huruf",
                'angkatan' => '2021',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('kelas')->insert($data);
    }
}
