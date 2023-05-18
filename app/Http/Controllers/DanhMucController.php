<?php

namespace App\Http\Controllers;

use App\Http\Requests\DanhMuc\CreateDanhMucRequest;
use App\Http\Requests\DanhMuc\UpdateDanhMucRequest;
use App\Models\DanhMuc;
use App\Models\MonAn;
use Illuminate\Http\Request;

class DanhMucController extends Controller
{

    public function index()
    {
        return view('admin.page.danh_muc.index');
    }
    public function indexVue()
    {
        $check = $this->checkRule(49);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }

        return view('admin.page.danh_muc.indexx_vue');
    }

    public function getData()
    {
        $check = $this->checkRule(50);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }

        $danhMucs = DanhMuc::get();
        return response()->json([
            'danhMucs' => $danhMucs
        ]);
    }

    public function changeStatus(Request $request)
    {
        $check = $this->checkRule(51);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $danhMuc = DanhMuc::find($request->id);
        if($danhMuc) {
            $danhMuc->tinh_trang = !$danhMuc->tinh_trang;
            $danhMuc->save();
            return response()->json([
                'status' => true,
                'message' => 'Đã đổi trạng thái'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Danh mục không tồn tại'
            ]);
        }
    }

    public function store(CreateDanhMucRequest $request)
    {
        $check = $this->checkRule(54);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $data = $request->all();
        DanhMuc::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Thêm danh mục thành công'
        ]);
    }

    public function checkSlug(Request $request)
    {
        if(isset($request->id)) {
            $check = DanhMuc::where('slug_danh_muc', $request->slug_danh_muc)
                            ->where('id', '<>', $request->id)
                            ->first();
        } else {
            $check = DanhMuc::where('slug_danh_muc', $request->slug_danh_muc)->first();
        }

        if($check) {
            return response()->json([
                'status' => false,
                'message' => 'Danh mục này đã tồn tại'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Tên danh mục có thể sử dụng'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $check = $this->checkRule(52);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $danhMuc = DanhMuc::find($request->id);

        if($danhMuc) {
            $monAn = MonAn::where('id_danh_muc', $request->id)->first();
            if($monAn) {
                return response()->json([
                    'status'    => 2,
                    'message'   =>  'Danh mục này đang có món ăn bạn không thể xóa'
                ]);
            } else {
                $danhMuc->delete();
                return response()->json([
                    'status'    => true,
                    'message'   => 'Đã xóa danh mục thành công'
                ]);
            }
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Danh mục không tồn tại'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $check = $this->checkRule(53);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $danhMuc = DanhMuc::find($request->id);
        if($danhMuc) {
            return response()->json([
                'status'    => true,
                'message'   => 'Đã lấy được dữ liệu',
                'danhMuc'   => $danhMuc
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Danh mục không tồn tại'
            ]);
        }
    }


    public function update(UpdateDanhMucRequest $request) {
        $danhMuc = DanhMuc::where('id', $request->id)->first();
        if($danhMuc) {
            $data = $request->all();
            $danhMuc->update($data);
            return response()->json([
                'status'    => true,
                'message'   => 'Đã cập nhật dữ liệu'
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Cập nhật lỗi'
            ]);
        }
    }

    public function search(Request $request)
    {
        $danhMucs = DanhMuc::where('ten_danh_muc', 'like', '%' . $request->key_search . '%')
                            ->get();
        return response()->json([
            'danhMucs' => $danhMucs
        ]);
    }

    public function multiDel(Request $request)
    {
        $check = $this->checkRule(55);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $str = '';
        foreach ($request->list as $key => $value) {
            if(isset($value['check'])) {
                $str = $str . $value['id'] . ',';
            }
        }
        $str = rtrim($str, ',');
        $str = explode(',', $str);
        $danhMucs = DanhMuc::whereIn('id', $str)->get();
        if($danhMucs) {
            foreach ($danhMucs as $k => $v) {
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
