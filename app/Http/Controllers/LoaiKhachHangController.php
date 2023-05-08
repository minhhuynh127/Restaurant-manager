<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Models\LoaiKhachHang;
use App\Models\MonAn;
use Illuminate\Http\Request;

class LoaiKhachHangController extends Controller
{

    public function index()
    {
        return view('admin.page.loai_khach_hang.index');
    }

    public function getData()
    {
        $loaiKhachHangs = LoaiKhachHang::get();
        foreach ($loaiKhachHangs as $key => $value) {
            // String to Array
            $value->list_mon_tang = explode(',', $value->list_mon_tang);
            $danhSachMons = MonAn::whereIn('id', $value->list_mon_tang)->select('ten_mon')->get();
            $ten_mon = '';
            foreach ($danhSachMons as $k => $v) {
                $ten_mon = $ten_mon . $v->ten_mon . ', ';
            }
            $ten_mon = rtrim($ten_mon, ', ');
            $value->ten_mon_tang = $ten_mon;

        }
        // dd($loaiKhachHangs->toArray());
        return response()->json([
            'loaiKhachHangs' => $loaiKhachHangs
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $str = "";
        foreach ($request->list_mon as $key => $value) {
            if(isset($value['check'])) {
                $str = $str . $value['id'] . ',';
            }
        }
        $str = rtrim($str, ","); // Xóa , cuối cùng
        $data['list_mon_tang'] = $str;
        LoaiKhachHang::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành thành công'
        ]);
    }

    public function check(Request $request)
    {
        if(isset($request->id)) {
            $check = LoaiKhachHang::where('ten_loai_khach', $request->ten_loai_khach)
                            ->where('id', '<>', $request->id)
                            ->first();
        } else {
            $check = LoaiKhachHang::where('ten_loai_khach', $request->ten_loai_khach)->first();
        }

        if($check) {
            return response()->json([
                'status' => false,
                'message' => 'Tên loại khách hàng này đã tồn tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Tên loại khách hàng có thể sử dụng'
            ]);
        }
    }
    public function edit(LoaiKhachHang $loaiKhachHang)
    {

    }


    public function update(Request $request)
    {
        $loaiKhachHang = LoaiKhachHang::where('id', $request->id)->first();

            $data = $request->all();

            $loaiKhachHang->update($data);
            return response()->json([
                'status'    => true,
                'message'   => 'Đã cập nhật dữu liệu'
            ]);
    }


    public function destroy(Request $request)
    {
        $loaiKhachHang = LoaiKhachHang::find($request->id);

        if($loaiKhachHang) {
            $khachHang = KhachHang::where('id_loai_khach', $request->id)->first();
            if($khachHang) {
                return response()->json([
                    'status'    => 2,
                    'message'   =>  'Loại khách hàng này đang còn khách không thể xóa'
                ]);
            } else {
                $loaiKhachHang->delete();
                return response()->json([
                    'status'    => true,
                    'message'   => 'Đã xóa loại khách thành công'
                ]);
            }
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Loại khách không tồn tại'
            ]);
        }
    }

    public function search(Request $request)
    {
        $loaiKhachHangs = LoaiKhachHang::where('ten_loai_khach', 'like', '%' . $request->key_search . '%')
                            ->get();
        return response()->json([
            'loaiKhachHangs' => $loaiKhachHangs
        ]);
    }

    public function multiDel(Request $request)
    {
        $str = "";
        foreach ($request->list as $key => $value) {
            if(isset($value['check'])) {
                $str = $str . $value['id'] . ', ';
            }
        }
        $str = rtrim($str, ", "); // Xóa , cuối cùng
        $str = explode(',', $str);
        $loaiKhachHangs = LoaiKhachHang::whereIn('id', $str)->get();
        if($loaiKhachHangs) {
            foreach ($loaiKhachHangs as $k => $v) {
                $v->delete();
            }
            return response()->json([
                'status'    => true,
                'message'   => 'Đã xóa thành công'
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Có lỗi không mong muốn xảy ra!!'
            ]);
        }
    }
}
