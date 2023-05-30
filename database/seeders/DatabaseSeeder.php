<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        $this->call(DanhMucSeeder::class);
        $this->call(BanSeeder::class);
        $this->call(KhuVucSeeder::class);
        $this->call(MonAnSeeder::class);
        $this->call(LoaiKhachHangSeeder::class);
        $this->call(KhachHangSeeder::class);
        $this->call(ChucNangSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(QuyenSeeder::class);

    }
}
