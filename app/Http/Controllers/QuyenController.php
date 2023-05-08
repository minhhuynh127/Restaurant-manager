<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quyen\CreateQuyenRequest;
use App\Http\Requests\Quyen\UpdateQuyenRequest;
use App\Models\Quyen;
use Illuminate\Http\Request;

class QuyenController extends Controller
{

    public function index()
    {
        return view('admin.page.roles.index');
    }


    public function store(CreateQuyenRequest $request)
    {
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
        $list = Quyen::get();
        return response()->json([
            'list' => $list
        ]);
    }

    public function update(UpdateQuyenRequest $request)
    {
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
}
