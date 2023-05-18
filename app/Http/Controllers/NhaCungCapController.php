<?php

namespace App\Http\Controllers;

use App\Http\Requests\NhaCungCap\CreateNhaCungCapRequest;
use App\Http\Requests\NhaCungCap\UpdateNhaCungCapRequest;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;

class NhaCungCapController extends Controller
{

    public function index()
    {
        return view('admin.page.nha_cung_cap.index');
    }

    public function indexVue()
    {
        $check = $this->checkRule(12);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }
        return view('admin.page.nha_cung_cap.index_vue');
    }

    public function getData(Request $request)
    {
        $check = $this->checkRule(14);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }

        $nhaCungCap = NhaCungCap::get();
        return response()->json([
            'nhaCungCap' => $nhaCungCap
        ]);
    }

    public function changeStatus(Request $request)
    {
        $check = $this->checkRule(17);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $nhaCungCap = NhaCungCap::find($request->id);
        if($nhaCungCap) {
            $nhaCungCap->tinh_trang = !$nhaCungCap->tinh_trang;
            $nhaCungCap->save();
            return  response()->json([
                'status' => true,
                'message' => 'Đổi trạng thái thành công'
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Bàn không tồn tại'
            ]);
        }
    }

    public function store(CreateNhaCungCapRequest $request)
    {
        $check = $this->checkRule(13);
        if($check) {

            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $data = $request->all();
        NhaCungCap::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công'
        ]);
    }


    public function checkMaSoThue(Request $request)
    {
        if(isset($request->id)) {
            $check = NhaCungCap::where('ma_so_thue', $request->ma_so_thue)
                                ->where('id', '<>', $request->id)
                                ->first();
        } else {
            $check = NhaCungCap::where('ma_so_thue', $request->ma_so_thue)->first();
        }
        if($check) {
            return  response()->json([
                'status' => false,
                'message' => 'Mã số thuế đã tồn tại'
            ]);
        } else {
            return  response()->json([
                'status' => true,
                'message' => 'Mã số thuế được phép sử dụng'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $check = $this->checkRule(16);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $nhaCungCap = NhaCungCap::find($request->id);
        if($nhaCungCap) {
            return response()->json([
                'status'    => true,
                'message'   => 'Đã lấy được dữ liệu cần sửa',
                'nhaCungCap'       => $nhaCungCap
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   =>  'Bàn không tồn tại'
            ]);
        }
    }

    public function update(UpdateNhaCungCapRequest $request)
    {
        $nhaCungCap = NhaCungCap::where('id', $request->id)->first();
        if($nhaCungCap) {
           $data = $request->all();
           $nhaCungCap->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật được thông tin'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Cập nhật lỗi'
            ]);
        }
    }


    public function destroy(Request $request)
    {
        $check = $this->checkRule(15);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $nhaCungCap = NhaCungCap::find($request->id);
        if($nhaCungCap) {
            $nhaCungCap->delete();
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

    public function multiDel(Request $request)
    {
        $check = $this->checkRule(15);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }
        $str = "";
        foreach ($request->list as $key => $value) {
            if(isset($value['check'])) {
                $str = $str . $value['id'] . ',';
            }
        }
        $str = rtrim($str, ',');
        $str = explode(',', $str);
        $nhaCungCaps = NhaCungCap::whereIn('id', $str)->get();
        if($nhaCungCaps) {
            foreach ($nhaCungCaps as $k => $v) {
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
