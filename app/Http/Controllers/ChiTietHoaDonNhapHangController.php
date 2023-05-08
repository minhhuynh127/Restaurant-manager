<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHoaDonNhapHang;
use App\Models\HoaDonNhapHang;
use App\Models\MonAn;
use Illuminate\Http\Request;

class ChiTietHoaDonNhapHangController extends Controller
{

    public function multiDel(Request $request)
    {
        $str = "";
        foreach($request->list_detail as $key => $value) {
            if(isset($value['check'])) {
                $str = $str . $value['id'] . ',';
            }
        }
        $str = rtrim($str, ',');
        $str = explode(',', $str);
        $hoaDonNhapHang = HoaDonNhapHang::find($request->id_hoa_don_nhap_hang);
        $chiTietHoaDons = ChiTietHoaDonNhapHang::whereIn('id', $str)->get();
        if($chiTietHoaDons && $hoaDonNhapHang) {
            foreach ($chiTietHoaDons as $k => $v) {
                $v->delete();
            }
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã xóa thành công!',
            ]);
        }
        else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có lỗi không mong muốn xảy ra!!!',
            ]);
        }
    }

    public function multiAdd(Request $request)
    {
        $str = "";
        foreach ($request->list_mon as $key => $value) {
            if(isset($value['check'])) {
                $str = $str . $value['id'] . ',';
            }
        }
        $str = rtrim($str, ',');
        $str = explode(',', $str);
        $monAn = MonAn::whereIn('id', $str)->get();
        $hoaDon = HoaDonNhapHang::find($request->id_hoa_don_nhap_hang);
        if($hoaDon) {
            foreach ($monAn as $k => $v) {
                $check = ChiTietHoaDonNhapHang::where('id_hoa_don_nhap_hang', $request->id_hoa_don_nhap_hang)
                ->where('id_mon_an', $v->id)
                ->first();
                if($check) {
                    $check->so_luong_nhap = $check->so_luong_nhap + 1;
                    $check->thanh_tien = $check->so_luong_nhap * $check->don_gia_nhap;
                    $check->save();
                } else {
                    $tong_tien_nhap = 0;
                    $tong_tien_nhap += $v->gia_ban;
                    ChiTietHoaDonNhapHang::create([
                        'id_mon_an'             =>  $v->id,
                        'ten_mon_an'            =>  $v->ten_mon,
                        'so_luong_nhap'         =>  1,
                        'don_gia_nhap'          =>  $v->gia_ban,
                        'thanh_tien'            =>  $tong_tien_nhap,
                        'id_hoa_don_nhap_hang'  =>  $request->id_hoa_don_nhap_hang,
                    ]);
                }
            }
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã thêm thành công!',
            ]);
        }
    }


}
