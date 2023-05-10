<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loai_khach_hangs')->delete();
        DB::table('loai_khach_hangs')->truncate();

        // $faker = Faker::create();
        DB::table('loai_khach_hangs')->insert([
            [
                'ho_va_ten' => 'Huỳnh Công Minh',
                'email' => 'admin@gmail.com',
                'so_dien_thoai' => '0909999888',
                'ngay_sinh' => '2001-01-01',
                'password'  => bcrypt('123456'),
                'hash_reset'    => null,
                'id_quyen'  => null
            ],

        ]);
    }
}
