<?php

namespace App\Http\Controllers;

use App\Http\Requests\HoaDon\ChuyenMonRequest;
use App\Http\Requests\HoaDon\UpdateBillRequest;
use App\Models\ChiTietBanHang;
use App\Models\HoaDonBanHang;
use App\Models\MonAn;
use Illuminate\Http\Request;

class ChiTietBanHangController extends Controller
{
    public function updateChietKhau(UpdateBillRequest $request)
    {
        $chiTietBanHang = ChiTietBanHang::find($request->id);
        $hoaDonBanHang = HoaDonBanHang::find($request->id_hoa_don_ban_hang);

        // Có id, bàn chưa tính tiền
        if($hoaDonBanHang && $hoaDonBanHang->trang_thai == 0) {
            $thanh_tien = $chiTietBanHang->so_luong_ban * $chiTietBanHang->don_gia_ban;
            $chiTietBanHang->tien_chiet_khau = $request->tien_chiet_khau;


            if($request->tien_chiet_khau > $thanh_tien) {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Tiền chiếc khẩu chỉ được tối đa: ' . number_format($thanh_tien, 0 , '.' , '.') . 'đ',
                ]);
            } else {
                $chiTietBanHang->thanh_tien = $thanh_tien - $request->tien_chiet_khau;
                $chiTietBanHang->save();
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã cập nhật thành công',
                ]);
            }

        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có lỗi không mong muốn xảy ra!!!',
            ]);
        }
    }

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
        $hoaDonBanHang = HoaDonBanHang::find($request->id_hoa_don_ban_hang);
        $chiTietBanHang = ChiTietBanHang::whereIn('id', $str)->get();
        if($chiTietBanHang && $hoaDonBanHang && $hoaDonBanHang->trang_thai == 0) {
            foreach ($chiTietBanHang as $k => $v) {
                if($v->is_in_bep == 0) {
                    $v->delete();
                }
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
        $monAns = MonAn::whereIn('id', $str)->get();
        $hoaDon = HoaDonBanHang::find($request->id_hoa_don_ban_hang);
        if($hoaDon->trang_thai) { // Trạng thái = 1 đã tính tiền
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền',
            ]);
        } else {
            foreach ($monAns as $k => $v) {
                $check = ChiTietBanHang::where('id_hoa_don_ban_hang', $request->id_hoa_don_ban_hang)
                                    ->where('id_mon_an', $v->id)
                                    ->first();
                if($check && $check->is_in_bep == 0) {
                    $check->so_luong_ban = $check->so_luong_ban + 1;
                    $check->thanh_tien = $check->so_luong_ban * $check->don_gia_ban - $check->tien_chiet_khau;
                    $check->save();
                } else {
                    ChiTietBanHang::create([
                        'id_hoa_don_ban_hang'   =>  $request->id_hoa_don_ban_hang,
                        'id_mon_an'             =>  $v->id,
                        'ten_mon_an'            =>  $v->ten_mon,
                        'so_luong_ban'          =>  1,
                        'don_gia_ban'           =>  $v->gia_ban,
                        'tien_chiet_khau'       =>  0,
                        'thanh_tien'            =>  $v->gia_ban,

                    ]);
                }
            }
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã thêm món thành công!',
            ]);
        }

    }

    public function loadDanhSachMonTheoBan(Request $request)
    {
        // Tìm hóa đơn có id_ban và đang hoạt động
        $hoaDon = HoaDonBanHang::where('id_ban', $request->id_ban)
                                ->where('trang_thai', 0)
                                ->first();
        if($hoaDon) {
            $data = ChiTietBanHang::where('id_hoa_don_ban_hang', $hoaDon->id)->get();
            return response()->json([
                'status'    => 1,
                'data'      => $data,
                'id_hd'     => $hoaDon->id
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền',
            ]);
        }
    }

    public function chuyenMon(ChuyenMonRequest $request)
    {
        $so_luong_chuyen    =   $request->so_luong_chuyen;
        $id_hoa_don_nhan    =   $request->id_hoa_don_nhan;

        $hoaDon = HoaDonBanHang::find($request->id_hoa_don_ban_hang);

        if($hoaDon && $hoaDon->trang_thai == 0) {

            // Trường hợp chuyển hết số lượng
            if($so_luong_chuyen > 0 && $so_luong_chuyen == $request->so_luong_ban) {
                $chiTietBanHang                      = ChiTietBanHang::find($request->id);
                $chiTietBanHang->id_hoa_don_ban_hang = $id_hoa_don_nhan;
                $space                               = $chiTietBanHang->ghi_chu ? ":" : ' ';
                $chiTietBanHang->ghi_chu             = 'Chuyển từ hóa đơn '. $chiTietBanHang->id_hoa_don_ban_hang. ' sang: ' . $space . $chiTietBanHang->ghi_chu;
                $chiTietBanHang->save();
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã chuyển món thành công!',
                ]);
            } else if($so_luong_chuyen > 0 && $so_luong_chuyen < $request->so_luong_ban) {
                $chiTietBanHang                  = ChiTietBanHang::find($request->id);
                // Tính tiền giảm giá của 1 phần
                $tien_chiet_khau_1_phan           = $chiTietBanHang->tien_chiet_khau / $chiTietBanHang->so_luong_ban;
                // Só lượng còn lại sau khi chuyển
                $chiTietBanHang->so_luong_ban    -= $so_luong_chuyen;
                // Tiền chiết khấu còn lại sau khi chuyển
                $tien_chiet_khau                = $tien_chiet_khau_1_phan * $chiTietBanHang->so_luong_ban;
                // thành tiền sau khi chuyển
                $chiTietBanHang->thanh_tien      = ($chiTietBanHang->so_luong_ban * $chiTietBanHang->don_gia_ban) - $tien_chiet_khau;
                $chiTietBanHang->tien_chiet_khau   =  $tien_chiet_khau;
                $chiTietBanHang->save();
                $space                              = $chiTietBanHang->ghi_chu ? ":" : ' ';
                ChiTietBanHang::create([
                    'id_hoa_don_ban_hang'  =>  $id_hoa_don_nhan,
                    'id_mon_an'            =>  $chiTietBanHang->id_mon_an,
                    'ten_mon_an'           =>  $chiTietBanHang->ten_mon_an,
                    'so_luong_ban'         =>  $so_luong_chuyen,
                    'don_gia_ban'          =>  $chiTietBanHang->don_gia_ban,
                    'tien_chiet_khau'      =>  $tien_chiet_khau_1_phan * $so_luong_chuyen,
                    'thanh_tien'           =>  $so_luong_chuyen * $chiTietBanHang->don_gia_ban - $tien_chiet_khau_1_phan * $so_luong_chuyen,
                    'ghi_chu'              =>  'Chuyển từ hóa đơn '. $chiTietBanHang->id_hoa_don_ban_hang. ' sang: ' . $space . $chiTietBanHang->ghi_chu,
                    'is_che_bien'          =>  $chiTietBanHang->is_che_bien,
                    'is_tiep_thuc'         =>  $chiTietBanHang->is_tiep_thuc,
                    'is_in_bep'            =>  $chiTietBanHang->is_in_bep
                ]);

                return response()->json([
                    'status'    => 1,
                    'message'   => 'Đã chuyển món thành công!',
                ]);

            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Dữ liệu không chính xác!',
                ]);
            }

        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Hóa đơn này đã tính tiền',
            ]);
        }
    }
}
