<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Models\LoaiKhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KhachHangController extends Controller
{

    public function index()
    {
        $loaiKhachHangs = LoaiKhachHang::get();
        return view('admin.page.khach_hang.index', compact('loaiKhachHangs'));
    }


    public function getData()
    {
        $khachHangs = KhachHang::join('loai_khach_hangs', 'khach_hangs.id_loai_khach', 'loai_khach_hangs.id')
                        ->select('khach_hangs.*', 'loai_khach_hangs.ten_loai_khach')
                        ->orderBy('khach_hangs.id')
                        ->get();
        return response()->json([
            'status'    => true,
            'khachHangs' => $khachHangs
        ]);
    }

    public function check(Request $request)
    {
        if(isset($request->id)) {
            $check = KhachHang::where('ma_khach', $request->ma_khach)
                            ->where('id', '<>', $request->id)
                            ->first();
        } else {
            $check = KhachHang::where('ma_khach', $request->ma_khach)->first();
        }

        if($check) {
            return response()->json([
                'status' => false,
                'message' => 'Mã khách hàng này đã tồn tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Mã khách hàng có thể sử dụng'
            ]);
        }
    }


    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        if(isset($data['ho_lot'])){
            $data['ho_va_ten'] = $data['ho_lot'] . " " . $data['ten_khach'];
        }else{
            $data['ho_va_ten'] = $data['ten_khach'];
        }
        $data['ma_khach']  = Str::uuid();
        KhachHang::create($data);

        return response()->json([
            'status'    => true,
            'message'   => 'Đã tạo mới thành công!',
        ]);
    }


    public function update(Request $request)
    {
        $khachHang = KhachHang::where('id', $request->id)->first();
        $khachHang = KhachHang::find($request->id);
        if($khachHang){
            $data = $request->all();
            if(isset($data['ho_lot'])){
                $data['ho_va_ten'] = $data['ho_lot'] . " " . $data['ten_khach'];
            }else{
                $data['ho_va_ten'] = $data['ten_khach'];
            }
            $khachHang->update($data);
            return response()->json([
                'status'        => 1,
                'message'       => 'Đã cập nhật khách hàng thành công',
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $khachHang = KhachHang::find($request->id);
        if($khachHang) {
            $khachHang->delete();
            return response()->json([
                'status'    => true,
                'message'   => 'Đã xóa bàn thành công'
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Bàn không tồn tại'
            ]);
        }
    }

    public function search(Request $request)
    {
        $khachHangs = KhachHang::join('loai_khach_hangs', 'loai_khach_hangs.id', 'khach_hangs.id_loai_khach')
                        ->select('khach_hangs.*', 'loai_khach_hangs.ten_loai_khach')
                        ->where('khach_hangs.ten_khach', 'like', '%' . $request->key_search . '%')
                        ->orWhere('khach_hangs.ho_lot', 'like', '%' . $request->key_search . '%')
                        ->orWhere('khach_hangs.so_dien_thoai', 'like', '%' . $request->key_search . '%')
                        ->orWhere('khach_hangs.email', 'like', '%' . $request->key_search . '%')
                        ->get();
        return response()->json([
            'khachHangs' => $khachHangs
        ]);
    }

    public function multiDel(Request $request)
    {
        $str = "";
        foreach ($request->list as $key => $value) {
            if(isset($value['check'])) {
                $str = $str . $value['id'] . ',';
            }
        }
        $str = rtrim($str, ',');
        $str = explode(',', $str);
        $khachHangs = KhachHang::whereIn('id', $str)->get();
        if($khachHangs) {
            foreach ($khachHangs as $k => $v) {
                $v->delete();
            }
            return response()->json([
                'status'    => 1,
                'message'   => 'Đã xóa thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Có lỗi xảy ra!',
            ]);
        }
    }
}
