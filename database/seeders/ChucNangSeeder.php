<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucNangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('danh_sach_chuc_nangs')->delete();
        DB::table('danh_sach_chuc_nangs')->truncate();

        DB::table('danh_sach_chuc_nangs')->insert([
            [
                'id'                =>  1,
                'ten_chuc_nang'     => 'Tạo mới tài khoản'
            ],
            [
                'id'                =>  2,
                'ten_chuc_nang'     => 'Xem Danh Sách Tài Khoản'
            ],
            [
                'id'                =>  3,
                'ten_chuc_nang'     => 'Đổi Mật Khẩu Tài Khoản'
            ],
            [
                'id'                =>  4,
                'ten_chuc_nang'     => 'Cập Nhật Thông Tin Tài Khoản'
            ],
            [
                'id'                =>  5,
                'ten_chuc_nang'     => 'Xóa Tài Khoản'
            ],
        ]);
    }
}
