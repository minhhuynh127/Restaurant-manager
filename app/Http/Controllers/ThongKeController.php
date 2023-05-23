<?php

namespace App\Http\Controllers;

use App\Models\ChiTietBanHang;
use App\Models\ChiTietHoaDon;
use App\Models\DanhMuc;
use App\Models\HoaDonBanHang;
use App\Models\KhachHang;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    public function viewThongKeBanHang()
    {
        return view('admin.page.thong_ke.ban_hang');
    }

    public function actionThongKeBanHang(Request $request)
    {
        $data = HoaDonBanHang::where('trang_thai', 1)
                            ->where('ngay_thanh_toan', '>=', $request->begin)
                            ->where('ngay_thanh_toan', '<=', $request->end)
                            ->get();
        return response()->json([
            'status'    =>  1,
            'message'   =>  'Đã lấy được dữ liệu!!',
            'data'      =>  $data
        ]);
    }

    public function viewThongKeMonAn() {
        return view('admin.page.thong_ke.mon_an');
    }

    public function actionThongKeMonAn(Request $request)
    {
        $data = ChiTietBanHang::join('hoa_don_ban_hangs', 'hoa_don_ban_hangs.id', 'chi_tiet_ban_hangs.id_hoa_don_ban_hang')
                              ->whereDate('hoa_don_ban_hangs.ngay_thanh_toan', '>=', $request->begin)
                              ->whereDate('hoa_don_ban_hangs.ngay_thanh_toan', '<=', $request->end)
                              ->where('hoa_don_ban_hangs.trang_thai', 1)
                              ->select('chi_tiet_ban_hangs.ten_mon_an',
                                       'chi_tiet_ban_hangs.id_mon_an',
                                        DB::raw('SUM(chi_tiet_ban_hangs.so_luong_ban) as tong_so_luong_ban'),
                                        DB::raw('SUM(chi_tiet_ban_hangs.thanh_tien) as tong_tien_thanh_toan')
                                    )
                              ->groupBy('chi_tiet_ban_hangs.ten_mon_an',
                                            'chi_tiet_ban_hangs.id_mon_an')
                              ->get();
        return response()->json([
            'status'    => 1,
            'message'   => 'Đã lấy dữ liệu',
            'data'      => $data,
        ]);
    }

    public function actionChiTietMonAn(Request $request)
    {
        $data = ChiTietBanHang::where('id_mon_an', $request->id_mon_an)
                              ->join('hoa_don_ban_hangs', 'hoa_don_ban_hangs.id', 'chi_tiet_ban_hangs.id_hoa_don_ban_hang')
                              ->where('hoa_don_ban_hangs.trang_thai', 1)
                              ->whereDate('hoa_don_ban_hangs.ngay_thanh_toan', '>=', $request->begin)
                              ->whereDate('hoa_don_ban_hangs.ngay_thanh_toan', '<=', $request->end)
                              ->join('bans', 'bans.id', 'hoa_don_ban_hangs.id_ban')
                              ->join('khu_vucs', 'khu_vucs.id', 'bans.id_khu_vuc')
                              ->select('bans.ten_ban', 'khu_vucs.ten_khu',
                                        DB::raw('SUM(chi_tiet_ban_hangs.so_luong_ban) as tong_so_luong'),
                                        DB::raw('SUM(chi_tiet_ban_hangs.thanh_tien) as tong_tien_thanh_toan'),
                                    )
                              ->groupBy('bans.ten_ban', 'khu_vucs.ten_khu')
                              ->get();
        return response()->json([
            'status'    => 1,
            'message'   => 'Đã lấy dữ liệu',
            'data'      => $data,
        ]);
    }

    public function indexThongKeKhachHang()
    {

        return view('admin.page.thong_ke.khach_hang');
    }

    public function thongKeKhachHang(Request $request)
    {
        $data = KhachHang::join('hoa_don_ban_hangs', 'khach_hangs.id', 'hoa_don_ban_hangs.id_khach_hang')
                        ->whereDate('hoa_don_ban_hangs.ngay_thanh_toan', '>=', $request->begin)
                        ->whereDate('hoa_don_ban_hangs.ngay_thanh_toan', '<=', $request->end)
                        ->select('khach_hangs.ma_khach', 'khach_hangs.ho_va_ten', DB::raw('SUM(hoa_don_ban_hangs.tong_tien) as tong_tien'))
                        ->groupBy('khach_hangs.ma_khach', 'khach_hangs.ho_va_ten')
                        ->orderByDESC('tong_tien')
                        ->take(10)
                        ->get();
                        // dd($data->toArray());

        $list_ten = [];
        $list_tien = [];
        foreach ($data as $key => $value) {
            array_push($list_ten, $value->ho_va_ten);
            array_push($list_tien, $value->tong_tien);
        }
        return response()->json([
            'list_ten'    => $list_ten,
            'list_tien'   => $list_tien,
        ]);
    }

    public function indexThongKeNhaCungCap()
    {
        return view('admin.page.thong_ke.nha_cung_cap');
    }
    public function thongKeNhaCungCap(Request $request)
    {
        $data = NhaCungCap::join('hoa_don_nhap_hangs', 'nha_cung_caps.id', 'hoa_don_nhap_hangs.id_nha_cung_cap')
                        ->whereDate('hoa_don_nhap_hangs.ngay_nhap_hang', '>=', $request->begin)
                        ->whereDate('hoa_don_nhap_hangs.ngay_nhap_hang', '<=', $request->end)
                        ->select('nha_cung_caps.ten_cong_ty', DB::raw('COUNT(hoa_don_nhap_hangs.id) AS so_lan_nhap_hang'), DB::raw('SUM(hoa_don_nhap_hangs.tong_tien_nhap) AS tong_tien_nhap'))
                        ->groupBy('nha_cung_caps.ten_cong_ty')
                        ->take(5)
                        ->get();
                        // dd($data->toArray());
        $list_ten_nha_cc = [];
        $list_so_lan_nhap = [];
        foreach ($data as $key => $value) {
            array_push($list_ten_nha_cc, $value->ten_cong_ty);
            array_push($list_so_lan_nhap, $value->so_lan_nhap_hang);
        }
        return response()->json([
            'list_ten_nha_cc'    => $list_ten_nha_cc,
            'list_so_lan_nhap'   => $list_so_lan_nhap,
        ]);
    }


}
