<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BanController;
use App\Http\Controllers\ChiTietBanHangController;
use App\Http\Controllers\ChiTietHoaDonNhapHangController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\HoaDonBanHangController;
use App\Http\Controllers\HoaDonNhapHangController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\KhuVucController;
use App\Http\Controllers\LoaiKhachHangController;
use App\Http\Controllers\MenuBepController;
use App\Http\Controllers\MonAnController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\QuyenController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ThongKeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [TestController::class, 'index']);
// Route::get('/test', [HoaDonBanHangController::class, 'test']);
// Code Login Admin
Route::get('/', [AdminController::class, 'viewLogin']);
Route::get('/admin/login', [AdminController::class, 'viewLogin']);
Route::post('/admin/login', [AdminController::class, 'actionLogin']);

Route::get('/admin/lost-password', [AdminController::class, 'viewLostPass']);
Route::post('/admin/lost-password', [AdminController::class, 'actionLostPass']);

Route::get('/admin/update-password/{hash_reset}', [AdminController::class, 'viewUpdatePass']);
Route::post('/admin/update-password', [AdminController::class, 'actionUpdatePass']);


Route::group(['prefix' => '/admin', 'middleware' => 'checkAdminLogin'], function() {

    Route::get('/logout', [AdminController::class, 'actionLogout']);

    // Code TAi Khoan
    Route::group(['prefix' => '/tai-khoan'],function(){
        Route::get('/',[AdminController::class,'index']);
        Route::post('/create',[AdminController::class,'store']);
        Route::get('/data', [AdminController::class, 'getData']);
        Route::post('/delete', [AdminController::class, 'destroy']);
        Route::post('/update', [AdminController::class, 'update']);
        Route::post('/change-password', [AdminController::class, 'changePassword']);
        Route::post('/search', [AdminController::class, 'search']);

    });
    // Code khu vực
    Route::group(['prefix' => '/khu-vuc'], function() {
        Route::get('/', [KhuVucController::class, 'index']);
        Route::get('/vue', [KhuVucController::class, 'indexVue']);
        Route::get('/data', [KhuVucController::class, 'getData']);
        Route::post('/doi-trang-thai', [KhuVucController::class, 'doiTrangThai']);
        Route::post('/delete', [KhuVucController::class, 'destroy']);
        Route::post('/edit', [KhuVucController::class, 'edit']);
        Route::post('/create', [KhuVucController::class, 'store']);
        Route::post('/check-slug', [KhuVucController::class, 'checkSlug']);
        Route::post('/update', [KhuVucController::class, 'update']);
        Route::post('/search', [KhuVucController::class, 'search']);
        Route::post('/multi-delete', [KhuVucController::class, 'multiDel']);


    });

    // Code bàn
    Route::group(['prefix' => '/ban'], function() {
        Route::get('/', [BanController::class, 'index']);
        Route::get('/vue', [BanController::class, 'indexVue']);
        Route::get('/data', [BanController::class, 'getData']);
        Route::post('/doi-trang-thai', [BanController::class, 'changeStatus']);
        Route::post('/delete', [BanController::class, 'destroy']);
        Route::post('/edit', [BanController::class, 'edit']);
        Route::post('/create', [BanController::class, 'store']);
        Route::post('/check-slug', [BanController::class, 'checkSlug']);
        Route::post('/update', [BanController::class, 'update']);
        Route::post('/search', [BanController::class, 'search']);
        Route::post('/multi-delete', [BanController::class, 'multiDel']);

    });

    // Code danh mục
    Route::group(['prefix' => '/danh-muc'], function() {
        Route::get('/', [DanhMucController::class, 'index']);
        Route::get('/vue', [DanhMucController::class, 'indexVue']);
        Route::get('/data', [DanhMucController::class, 'getData']);
        Route::post('/doi-trang-thai', [DanhMucController::class, 'changeStatus']);
        Route::post('/delete', [DanhMucController::class, 'destroy']);
        Route::post('/edit', [DanhMucController::class, 'edit']);
        Route::post('/create', [DanhMucController::class, 'store']);
        Route::post('/check-slug', [DanhMucController::class, 'checkSlug']);
        Route::post('/update', [DanhMucController::class, 'update']);
        Route::post('/search', [DanhMucController::class, 'search']);
        Route::post('/multi-delete', [DanhMucController::class, 'multiDel']);


    });

    // Code món ăn
    Route::group(['prefix' => '/mon-an'], function() {
        Route::get('/', [MonAnController::class, 'index']);
        Route::get('/vue', [MonAnController::class, 'indexVue']);
        Route::get('/data', [MonAnController::class, 'getData']);
        Route::post('/doi-trang-thai', [MonAnController::class, 'changeStatus']);
        Route::post('/delete', [MonAnController::class, 'destroy']);
        Route::post('/edit', [MonAnController::class, 'edit']);
        Route::post('/create', [MonAnController::class, 'store']);
        Route::post('/check-slug', [MonAnController::class, 'checkSlug']);
        Route::post('/update', [MonAnController::class, 'update']);
        Route::post('/search', [MonAnController::class, 'search']);
        Route::post('/multi-delete', [MonAnController::class, 'multiDel']);


    });

    // Code nhà cung cấp
    Route::group(['prefix' => '/nha-cung-cap'], function() {
        Route::get('/', [NhaCungCapController::class, 'index']);
        Route::get('/vue', [NhaCungCapController::class, 'indexVue']);
        Route::get('/data', [NhaCungCapController::class, 'getData']);
        Route::post('/create', [NhaCungCapController::class, 'store']);
        Route::post('/doi-trang-thai', [NhaCungCapController::class, 'changeStatus']);
        Route::post('/delete', [NhaCungCapController::class, 'destroy']);
        Route::post('/check-ma-so-thue', [NhaCungCapController::class, 'checkMaSoThue']);
        Route::post('/edit', [NhaCungCapController::class, 'edit']);
        Route::post('/update', [NhaCungCapController::class, 'update']);
        Route::post('/multi-delete', [NhaCungCapController::class, 'multiDel']);

    });

    // Code Hóa Đơn Bán Hàng
    Route::group(['prefix' => '/ban-hang'], function()   {
        Route::get('/', [HoaDonBanHangController::class, 'index']);
        Route::post('/tao-hoa-don', [HoaDonBanHangController::class, 'store']);
        Route::post('/find-id-by-idban', [HoaDonBanHangController::class, 'findIdByIdBan']);
        Route::post('/them-mon-an', [HoaDonBanHangController::class, 'addToBill']);
        Route::post('/danh-sach-mon-theo-hoa-don', [HoaDonBanHangController::class, 'getDanhSachMonTheoHoaDon']);
        Route::post('/update', [HoaDonBanHangController::class, 'updateChiTiet']);
        Route::post('/in-bep', [HoaDonBanHangController::class, 'inBep']);
        Route::post('/xoa-chi-tiet', [HoaDonBanHangController::class, 'xoaChiTietHoaDon']);
        Route::post('/xac-nhan', [HoaDonBanHangController::class, 'xacNhanKhach'])->name('xac-nhan-khach');
        Route::post('/thanh-toan', [HoaDonBanHangController::class, 'thanhToan'])->name('thanh-toan');
        Route::get('/in-bill/{id}', [HoaDonBanHangController::class, 'inBill']);
        Route::post('/update-hoa-don', [HoaDonBanHangController::class, 'updateHoaDon'])->name('update-hoa-don');

    });

    // Code Chi Tiết Bán Hàng
    Route::group(['prefix' => '/chi-tiet'], function()   {
        Route::post('/update', [ChiTietBanHangController::class, 'updateChietKhau'])->name('update-chiet-khau');
        Route::post('/multi-delete', [ChiTietBanHangController::class, 'multiDel']);
        Route::post('/multi-add', [ChiTietBanHangController::class, 'multiAdd']);
        Route::post('/danh-sach-mon-theo-ban', [ChiTietBanHangController::class, 'loadDanhSachMonTheoBan'])->name('list-mon-of-ban');
        Route::post('/chuyen-mon', [ChiTietBanHangController::class, 'chuyenMon'])->name('chuyen-mon');


    });


    // Code Khách Hàng
    Route::group(['prefix' => '/khach-hang'], function()   {
        Route::get('/', [KhachHangController::class, 'index']);
        Route::get('/data', [KhachHangController::class, 'getData'])->name('data-khach-hang');
        Route::post('/create', [KhachHangController::class, 'store']);
        Route::post('/check', [KhachHangController::class, 'check']);
        Route::post('/delete', [KhachHangController::class, 'destroy']);
        Route::post('/update', [KhachHangController::class, 'update']);
        Route::post('/search', [KhachHangController::class, 'search']);
        Route::post('/multi-delete', [KhachHangController::class, 'multiDel']);

    });

    // Code Loại Khác Hàng
    Route::group(['prefix' => '/loai-khach-hang'], function()   {
        Route::get('/', [LoaiKhachHangController::class, 'index']);
        Route::get('/data', [LoaiKhachHangController::class, 'getData']);
        Route::post('/create', [LoaiKhachHangController::class, 'store']);
        Route::post('/check', [LoaiKhachHangController::class, 'check']);
        Route::post('/delete', [LoaiKhachHangController::class, 'destroy']);
        Route::post('/update', [LoaiKhachHangController::class, 'update']);
        Route::post('/search', [LoaiKhachHangController::class, 'search']);
        Route::post('/multi-delete', [LoaiKhachHangController::class, 'multiDel']);

    });

    // Code Menu Bếp
    Route::group(['prefix' => '/menu-bep'], function()   {
        Route::get('/che-bien', [MenuBepController::class, 'indexCheBien']);
        Route::get('/tiep-thuc', [MenuBepController::class, 'indexTiepThuc']);
        Route::get('/che-bien/data', [MenuBepController::class, 'getDataCheBien']);
        Route::get('/tiep-thuc/data', [MenuBepController::class, 'getDataTiepThuc']);

        Route::post('/che-bien/finish', [MenuBepController::class, 'finishCheBien']);
        Route::post('/tiep-thuc/finish', [MenuBepController::class, 'finishTiepThuc']);
        Route::post('/che-bien/multi-che-bien', [MenuBepController::class, 'multiCheBien'])->name('multi-che-bien');
        Route::post('/che-bien/multi-tiep-thuc', [MenuBepController::class, 'multiTiepThuc'])->name('multi-tiep-thuc');

    });

    // Code Hóa Đơn Nhập Hàng
    Route::group(['prefix' => '/nhap-hang'], function()   {
        Route::get('/', [HoaDonNhapHangController::class, 'index']);
        Route::get('/data',[HoaDonNhapHangController::class,'getData']);
        Route::post('/add-san-pham-nhap-hang', [HoaDonNhapHangController::class, 'addSanPhamNhapHang']);
        Route::post('/delete-mon-an', [HoaDonNhapHangController::class, 'deleteMonAnNhapHang']);
        Route::post('/update-chi-tiet-hoa-don-nhap', [HoaDonNhapHangController::class, 'updateChiTietHoaDonNhap']);
        Route::post('/nhap-hang/action', [HoaDonNhapHangController::class, 'nhapHangAction']);
        Route::post('/gui-mail', [HoaDonNhapHangController::class, 'guiMail']);

        Route::post('/multi-delete', [ChiTietHoaDonNhapHangController::class, 'multiDel'])->name('multi-delete-bill');
        Route::post('/multi-add', [ChiTietHoaDonNhapHangController::class, 'multiAdd'])->name('multi-add-bill');


    });

    // Code Thống Kê
    Route::group(['prefix' => '/thong-ke'], function()   {
        Route::get('/ban-hang', [ThongKeController::class, 'viewThongKeBanHang']);
        Route::post('/ban-hang', [ThongKeController::class, 'actionThongKeBanHang'])->name('thong-ke-ban-hang');
        Route::post('/danh-sach-mon-theo-hoa-don-da-thanh-toan', [HoaDonBanHangController::class, 'getChiTietHoaDonDaThanhToan'])->name('danh-sach-mon-thong-ke');

        Route::get('/mon-an', [ThongKeController::class, 'viewThongKeMonAn']);
        Route::post('/mon-an', [ThongKeController::class, 'actionThongKeMonAn'])->name('thong-ke-mon-an');
        Route::post('/chi-tiet-mon-an-da-thanh-toan', [ThongKeController::class, 'actionChiTietMonAn'])->name('chi-tiet-mon-an');

        Route::get('/khach-hang', [ThongKeController::class, 'indexThongKeKhachHang']);
        Route::post('/khach-hang', [ThongKeController::class, 'thongKeKhachHang']);

        Route::get('/nha-cung-cap', [ThongKeController::class, 'indexThongKeNhaCungCap']);
        Route::post('/nha-cung-cap', [ThongKeController::class, 'thongKeNhaCungCap']);
    });

    // Code Roles
    Route::group(['prefix' => '/quyen'], function() {
        Route::get('/', [QuyenController::class, 'index']);
        Route::get('/data', [QuyenController::class, 'getData']);
        Route::post('/create', [QuyenController::class, 'store']);
        Route::post('/delete', [QuyenController::class, 'destroy']);
        Route::post('/update', [QuyenController::class, 'update']);
        Route::post('/search', [QuyenController::class, 'search']);
        Route::get('/data-chuc-nang', [QuyenController::class, 'getDataChucNang']);
        Route::post('/phan-quyen', [QuyenController::class, 'phanQuyen']);

    });
});


