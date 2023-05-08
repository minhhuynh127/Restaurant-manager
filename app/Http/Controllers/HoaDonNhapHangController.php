<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHoaDonNhapHang;
use App\Models\HoaDonNhapHang;
use App\Models\MonAn;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use PHPViet\NumberToWords\Transformer;



class HoaDonNhapHangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.page.nha_cung_cap.index');
    }

    public function store(Request $request)
    {
        $nhaCungCap = NhaCungCap::find($request->id_nha_cc);
        if($nhaCungCap && $nhaCungCap->tinh_trang == 1) {

            $hoaDon = HoaDonNhapHang::create([
                'ma_hoa_don_nhap_hang'  => Str::uuid(),
                'id_nha_cung_cap'       => $request->id_nha_cc,
                'tong_tien_nhap'        => 0,
                'ngay_nhap_hang'        => Carbon::now(),
            ]);
            return response()->json([
                'status'        => 1,
                'message'       => 'Tạo hóa đơn nhập hàng thành công!',
                'id_hd_nhap'    =>  $hoaDon->id
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có lỗi không móng muốn xảy ra!',
            ]);
        }
    }

    public function nhapHangtoBill(Request $request)
    {
        $monAn = MonAn::find($request->id_mon);
        $check = ChiTietHoaDonNhapHang::where('id_hoa_don_nhap_hang', $request->id_hd_nhap)
                                        ->where('id_mon_an', $request->id_mon)
                                        ->first();
        if($check) {
            $check->so_luong_nhap = $check->so_luong_nhap + 1;
                $check->thanh_tien = $check->so_luong_nhap * $check->don_gia_nhap;
                $check->save();
        } else {
            ChiTietHoaDonNhapHang::create([
                'id_mon_an'             => $monAn->id,
                'ten_mon_an'            => $monAn->ten_mon,
                'so_luong_nhap'         => 1,
                'don_gia_nhap'          =>  $monAn->gia_ban,
                'thanh_tien'            =>  $monAn->gia_ban,
                'id_hoa_don_nhap_hang'  => $request->id_hd_nhap,
            ]);
        }
        return response()->json([
            'status'    => 1,
            'message'   => 'Đã nhập hàng thành công!',
        ]);
    }

    public function findIdByIdNhaCc(Request $request)
    {
        $hoaDon = HoaDonNhapHang::where('id_nha_cung_cap', $request->id_nha_cc)->first();
        if($hoaDon) {
            return response()->json([
                'status'            => true,
                'id_hoa_don_nhap'   => $hoaDon->id,
                'hoa_don'           => $hoaDon
            ]);
        } else {
            return response()->json([
                'status'        => false,
                'id_hoa_don'    => 0
            ]);
        }
    }

    public function getDanhSachMonTheoHoaDonNhap(Request $request)
    {
        $hoaDon = HoaDonNhapHang::find($request->id_hoa_don_nhap_hang);
        if($hoaDon) {
            $data = ChiTietHoaDonNhapHang::where('id_hoa_don_nhap_hang', $request->id_hoa_don_nhap_hang)->get();
            $tong_tien = 0;
            foreach ($data as $key => $value) {
                $tong_tien += $value->thanh_tien;
            }
            $transformer = new Transformer();
            $tien_chu = $transformer->toCurrency($tong_tien);
            $hoaDon->tong_tien_nhap = $tong_tien;
            $hoaDon->save();
            return response()->json([
                'status'    => 1,
                'data'      => $data,
                'tong_tien' => $tong_tien,
                'tien_chu'  => $tien_chu
            ]);
        }
    }

    public function updateBill(Request $request)
    {
        $hoaDon = HoaDonNhapHang::find($request->id_hoa_don_nhap_hang);
        $chiTietHoaDon = ChiTietHoaDonNhapHang::find($request->id);
        if($hoaDon) {
            $chiTietHoaDon->so_luong_nhap    = $request->so_luong_nhap;
            $chiTietHoaDon->don_gia_nhap    = $request->don_gia_nhap;
            $chiTietHoaDon->thanh_tien      = $chiTietHoaDon->so_luong_nhap * $request->don_gia_nhap;
            $chiTietHoaDon->save();
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã cập nhật thành công!',
            ]);

        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có lỗi không mong muốn xảy ra!!!',
            ]);
        }

    }

    public function xoaChiTietHoaDon(Request $request)
    {
        $hoaDon = HoaDonNhapHang::find($request->id_hoa_don_nhap_hang);
        $chiTietHoaDon = ChiTietHoaDonNhapHang::find($request->id);
        if($hoaDon) {
            $chiTietHoaDon->delete();
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã xóa thành công!',
                ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có lỗi không mong muốn xảy ra!!!',
            ]);
        }
    }

}
