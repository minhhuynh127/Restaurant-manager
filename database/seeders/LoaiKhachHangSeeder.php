<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LoaiKhachHangSeeder extends Seeder
{
    public function run()
    {
        DB::table('loai_khach_hangs')->delete();
        DB::table('loai_khach_hangs')->truncate();

        // $faker = Faker::create();
        DB::table('loai_khach_hangs')->insert([
            [
                'ten_loai_khach'       =>  'Khách Nợ',
                'phan_tram_giam'      =>  random_int(1, 100),
                'list_mon_tang'       =>  'Không tặng',
            ],
            [
                'ten_loai_khach'       =>  'Khách Giàu',
                'phan_tram_giam'      =>  random_int(1, 100),
                'list_mon_tang'       =>  'Phần lẩu',
            ],
            [
                'ten_loai_khach'       =>  'Khách Bình Dân',
                'phan_tram_giam'      =>  random_int(1, 100),
                'list_mon_tang'       =>  'Tráng miệng',
            ],
            [
                'ten_loai_khach'       =>  'Khách Vip',
                'phan_tram_giam'      =>  random_int(1, 100),
                'list_mon_tang'       =>  'Con gà',
            ],
        ]);
    }
}
