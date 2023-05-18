<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quyen\CreateQuyenRequest;
use App\Http\Requests\Quyen\UpdateQuyenRequest;
use App\Models\DanhSachChucNang;
use App\Models\Quyen;
use Illuminate\Http\Request;

class QuyenController extends Controller
{

    public function index()
    {
        $check = $this->checkRule(7);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }
        return view('admin.page.roles.index');
    }


    public function store(CreateQuyenRequest $request)
    {
        $check = $this->checkRule(9);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $data = $request->all();
        if($data) {
            Quyen::create($data);
            return response()->json([
                'status'    => true,
                'message'   => 'Đã thêm mới thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Có lỗi không mong muốn xẩy ra!',
            ]);
        }
    }


    public function getData() {
        $check = $this->checkRule(8);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }

        $list = Quyen::get();
        return response()->json([
            'list' => $list
        ]);
    }

    public function update(UpdateQuyenRequest $request)
    {
        $check = $this->checkRule(11);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $data = $request->all();
        $quyen = Quyen::find($request->id);
        $quyen->update($data);
        return response()->json([
            'status'    => true,
            'message'   => 'Đã cập nhật thành công!',
        ]);
    }

    public function destroy(Request $request)
    {
        $check = $this->checkRule(10);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $quyen = Quyen::find($request->id);
        if($quyen) {
            $quyen->delete();
            return response()->json([
                'status'    => true,
                'message'   => 'Đã xóa thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Có lỗi không mong muốn xảy ra!',
            ]);
        }
    }

    public function search(Request $request)
    {
        $list = Quyen::where('ten_quyen', 'LIKE', '%' . $request->key_search . '%')->get();
        if($list) {
            return response()->json([
                'status'    => true,
                'roles'     => $list
            ]);

        } else{
            return response()->json([
                'status'    => false,
                'message'   => 'Tên quyền không có trên hệ thống!',
            ]);
        }
    }

    public function getDataChucNang()
    {
        $chucNang = DanhSachChucNang::get();

        return response()->json([
            'data' => $chucNang
        ]);
    }
    public function phanQuyen(Request $request)
    {
        $quyen      =  Quyen::find($request->id_quyen);
        $list_id_quyen =  implode(",", $request->list_phan_quyen);
        $quyen->update([
            'list_id_quyen' => $list_id_quyen
        ]);

        return response()->json([
            'status'  => true,
            'message' => "Cập nhập phân quyền cho Quyền " . $quyen->ten_quyen . " thành công!",
        ]);
    }
}
