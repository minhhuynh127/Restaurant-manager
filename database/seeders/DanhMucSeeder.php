<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhMucSeeder extends Seeder
{
    public function run()
    {
        DB::table('danh_mucs')->delete();
        DB::table('danh_mucs')->truncate();

        DB::table('danh_mucs')->insert([
            [
                'ten_danh_muc'  => 'Khai Vị',
                'slug_danh_muc' => 'khai-vi',
                'tinh_trang'    => random_int(0, 1),
            ],
            [
                'ten_danh_muc'  => 'Gỏi/Salad',
                'slug_danh_muc' => 'goi-salad',
                'tinh_trang'    => random_int(0, 1),
            ],
            [
                'ten_danh_muc'  => 'Món Ăn Kèm',
                'slug_danh_muc' => 'mon-an-kem',
                'tinh_trang'    => random_int(0, 1),
            ],
            [
                'ten_danh_muc'  => 'Hải Sản',
                'slug_danh_muc' => 'hai-san',
                'tinh_trang'    => random_int(0, 1),
            ],
            [
                'ten_danh_muc'  => 'Chiên, xào, om',
                'slug_danh_muc' => 'chien-xao-om',
                'tinh_trang'    => random_int(0, 1),
            ],
            [
                'ten_danh_muc'  => 'Lẩu các loại',
                'slug_danh_muc' => 'lau-cac-loai',
                'tinh_trang'    => random_int(0, 1),
            ],
            [
                'ten_danh_muc'  => 'Đồ Nhúng',
                'slug_danh_muc' => 'do-nhung',
                'tinh_trang'    => random_int(0, 1),
            ],
            [
                'ten_danh_muc'  => 'Đồ Uống',
                'slug_danh_muc' => 'do-uong',
                'tinh_trang'    => random_int(0, 1),
            ],
            [
                'ten_danh_muc'  => 'Đồ Gọi Thêm',
                'slug_danh_muc' => 'do-goi-them',
                'tinh_trang'    => random_int(0, 1),
            ],
        ]);
    }
}
