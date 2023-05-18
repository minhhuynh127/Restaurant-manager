<?php

namespace App\Http\Controllers;

use App\Models\ChiTietBanHang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class MenuBepController extends Controller
{
    public function indexCheBien()
    {
        $check = $this->checkRule(22);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }

        return view('admin.page.menu_bep.che_bien.index');
    }

    public function indexTiepThuc()
    {
        $check = $this->checkRule(18);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }

        return view('admin.page.menu_bep.tiep_thuc.index');
    }

    public function getDataCheBien()
    {
        $check = $this->checkRule(23);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }
        $data = ChiTietBanHang::where('is_in_bep', 1)
                                ->where('is_che_bien', 0)
                                ->join('hoa_don_ban_hangs', 'chi_tiet_hoa_dons.id_hoa_don_ban_hang', 'hoa_don_ban_hangs.id')
                                ->join('bans', 'hoa_don_ban_hangs.id_ban', 'bans.id')
                                ->select('chi_tiet_hoa_dons.*', 'bans.ten_ban')
                                ->get();

        if($data) {
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã lấy được dữ liệu!',
                'data'      => $data
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có lỗi không mong muốn xảy ra!',
            ]);
        }

    }

    public function getDataTiepThuc()
    {
        $check = $this->checkRule(19);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }

        $data = ChiTietBanHang::where('is_in_bep', 1)
                                ->where('is_che_bien', 1)
                                ->where('is_tiep_thuc', 0)
                                ->join('hoa_don_ban_hangs', 'chi_tiet_hoa_dons.id_hoa_don_ban_hang', 'hoa_don_ban_hangs.id')
                                ->join('bans', 'hoa_don_ban_hangs.id_ban', 'bans.id')
                                ->select('chi_tiet_hoa_dons.*', 'bans.ten_ban')
                                ->get();
        if($data) {
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã lấy được dữ liệu!',
                'data'      => $data
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có lỗi không mong muốn xảy ra!',
            ]);
        }

    }

    public function finishCheBien(Request $request)
    {
        $check = ChiTietBanHang::find($request->id);
        if($check && $check->is_che_bien == 0) {
            $check->is_che_bien = 1;
            $check->thoi_gian_che_bien = strtotime(Carbon::now()) - strtotime($check->created_at);
            $check->save();
            return response()->json([
                'status'    => 1,
                'message'   => 'Món ' . $check->ten_mon_an . ' đã chế biến xong',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có lỗi không mong muốn xảy ra!',
            ]);
        }
    }

    public function finishTiepThuc(Request $request)
    {
        $check = ChiTietBanHang::find($request->id);
        if($check && $check->is_che_bien == 1 && $check->is_tiep_thuc == 0) {
            $check->is_tiep_thuc = 1;
            $check->thoi_gian_che_bien = strtotime(Carbon::now()) - strtotime($check->updated_at);
            $check->save();
            return response()->json([
                'status'    => 1,
                'message'   => 'Món ' . $check->ten_mon_an . ' đã tiếp thực xong',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có lỗi không mong muốn xảy ra!',
            ]);
        }
    }

    public function multiCheBien(Request $request)
    {
        $str = '';
        foreach ($request->list as $key => $value) {
            if(isset($value['check'])) {
                $str = $str . $value['id'] . ',';
            }
        }
        $str = rtrim($str, ',');
        $str = explode(',', $str);
        $data  = ChiTietBanHang::whereIn('id', $str)->get();
        // dd($data->toArray());
        if($data) {
            foreach ($data as $k => $v) {
                if($v->is_che_bien == 0 && $v->is_tiep_thuc == 0) {
                    $v->is_che_bien = 1;
                    $v->save();
                }
            }
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã chế biến xong!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có lỗi xảy ra!',
            ]);
        }

    }

    public function multiTiepThuc(Request $request)
    {
        $str = '';
        foreach ($request->list as $key => $value) {
            if(isset($value['check'])) {
                $str = $str . $value['id'] . ',';
            }
        }
        $str = rtrim($str, ',');
        $str = explode(',', $str);
        $data  = ChiTietBanHang::whereIn('id', $str)->get();
        // dd($data->toArray());
        if($data) {
            foreach ($data as $k => $v) {
                if($v->is_che_bien == 1 && $v->is_tiep_thuc == 0) {
                    $v->is_tiep_thuc = 1;
                    $v->save();
                }
            }
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã tiếp thực xong!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có lỗi xảy ra!',
            ]);
        }

    }
}
