<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonAn\CreateMonAnRequest;
use App\Http\Requests\MonAn\UpdateMonAnRequest;
use App\Models\DanhMuc;
use App\Models\MonAn;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MonAnController extends Controller
{

    public function index()
    {
        $danhMuc = DanhMuc::get();
        return view('admin.page.mon_an.index', compact('danhMuc'));
    }

    public function indexVue()
    {
        $check = $this->checkRule(41);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }

        $danhMuc = DanhMuc::get();

        return view('admin.page.mon_an.index_vue', compact('danhMuc'));
    }

    public function getData()
    {
        $check = $this->checkRule(42);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }

        $monAns = MonAn::join('danh_mucs', 'mon_ans.id_danh_muc', 'danh_mucs.id')
                        ->select('danh_mucs.ten_danh_muc', 'mon_ans.*')
                        ->get();
        return response()->json([
            'monAns' => $monAns
        ]);
    }

    public function changeStatus(Request $request)
    {
        $check = $this->checkRule(43);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $monAn = MonAn::find($request->id);
        if($monAn) {
            $monAn->tinh_trang = !$monAn->tinh_trang;
            $monAn->save();
            return response()->json([
                'status' => true,
                'message' => 'Đã đổi trạng thái'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Món ăn không tồn tại'
            ]);
        }
    }

    public function store(CreateMonAnRequest $request)
    {
        $check = $this->checkRule(46);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $data = $request->all();
        $file = $request->file('hinh_anh');
        $name_image = Str::uuid() . '-' . $request->slug_mon . '.' . $file->getClientOriginalExtension();
        // 1236345234234-slug_mon.png(jpg)
        $data['hinh_anh'] = $name_image;
        $file->move('image-mon-an', $name_image);

        MonAn::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Thêm món ăn thành công'
        ]);
    }

    public function checkSlug(Request $request)
    {

        if(isset($request->id)) {
            $check = MonAn::where('slug_mon', $request->slug_mon)
                            ->where('id', '<>', $request->id)
                            ->first();
        } else {
            $check = MonAn::where('slug_mon', $request->slug_mon)->first();
        }
        if($check) {
            return response()->json([
                'status' => false,
                'message' => 'Món ăn này đã có'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Món ăn có thể thêm'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $check = $this->checkRule(44);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }
        $monAn = MonAn::find($request->id);
        if($monAn) {
            $monAn->delete();
            return response()->json([
                'status'    => true,
                'message'   => 'Đã xóa món ắn thành công'
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Món ăn không tồn tại'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $check = $this->checkRule(45);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $monAn = MonAn::find($request->id);
        if($monAn) {
            return response()->json([
                'status'    => true,
                'message'   => 'Đã lấy được dữ liệu',
                'monAn'   => $monAn
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Danh mục không tồn tại'
            ]);
        }
    }

    public function update(UpdateMonAnRequest $request)
    {
        $check = $this->checkRule(46);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $monAn = MonAn::where('id', $request->id)->first();

            $data = $request->all();
            $monAn->update($data);
            return response()->json([
                'status'    => true,
                'message'   => 'Đã cập nhật dữu liệu'
            ]);
    }

    public function search(Request $request)
    {
        $monAns = MonAn::join('danh_mucs', 'mon_ans.id_danh_muc', 'danh_mucs.id')
                        ->select('danh_mucs.ten_danh_muc', 'mon_ans.*')
                        ->where('ten_mon', 'like', '%' . $request->key_search . '%')
                        ->orWhere('danh_mucs.ten_danh_muc', 'like', '%' . $request->key_search . '%')
                        ->get();
        return response()->json([
            'monAns' => $monAns
        ]);
    }

    public function multiDel(Request $request)
    {
        $check = $this->checkRule(48);
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
        $monAns = MonAn::whereIn('id', $str)->get();
        if($monAns) {
            foreach ($monAns as $k => $v) {
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
