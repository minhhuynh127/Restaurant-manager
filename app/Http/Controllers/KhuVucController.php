<?php

namespace App\Http\Controllers;

use App\Http\Requests\KhuVuc\CreateKhuVucRequest;
use App\Http\Requests\KhuVuc\UpdateKhuVucRequest;
use App\Models\KhuVuc;
use App\Models\Ban;

use Illuminate\Http\Request;

class KhuVucController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.page.khu_vuc.index');
    }

    public function indexVue()
    {
        $check = $this->checkRule(63);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        return view('admin.page.khu_vuc.index_vue');
    }

    public function getData() {
        $check = $this->checkRule(64);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }

        $list = KhuVuc::get();
        return response()->json([
            'list' => $list
        ]);
    }

    public function doiTrangThai(Request $request) {
        $check = $this->checkRule(65);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $khuVuc = KhuVuc::find($request->id);
        if($khuVuc) {
            $khuVuc->tinh_trang = !$khuVuc->tinh_trang;
            $khuVuc->save();
            return response()->json([
                'status' => true,
                'message' => 'Đổi trạng thái thành công'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Khu vực không tồn tại'
            ]);
        }
    }

    public function store(CreateKhuVucRequest $request)
    {
        $check = $this->checkRule(68);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $data = $request->all();
        KhuVuc::create($data);
        return response()->json([
            'status'    => true,
            'message'   => 'Thêm khu vực thành công'
        ]);
    }

    public function checkSlug(Request $request)
    {
        if(isset($request->id)) {
            $check = KhuVuc::where('slug_khu', $request->slug_khu)
                            ->where('id', '<>', $request->id)
                            ->first();
        } else {
            $check = KhuVuc::where('slug_khu', $request->slug_khu)->first();
        }
        if($check) {
            return response()->json([
                'status' => false,
                'message' => 'Tên khu vực đã tồn tại'
            ]);
        }
        else {
            return response()->json([
                'status' => true,
                'message' => 'Tên khu vực được phép sử dụng'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $check = $this->checkRule(69);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $khuVuc = KhuVuc::find($request->id);
        if($khuVuc) {
            return response()->json([
                'status'    => true,
                'message'   => 'Đã lấy được dữ liệu',
                'khuVuc'    => $khuVuc
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Khu vực không tồn tại'
            ]);
        }
    }

    public function update(UpdateKhuVucRequest $request)
    {
        $khuVuc = KhuVuc::where('id', $request->id)->first();
        if($khuVuc) {
            $data = $request->all();
            $khuVuc->update($data);
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
        $check = $this->checkRule(66);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $khuVuc = KhuVuc::find($request->id);

        if($khuVuc) {
            $ban = Ban::where('id_khu_vuc', $request->id)->first();
            if($ban) {
                return response()->json([
                    'status'    => 2,
                    'message'   =>  'Khu vực này đang có bàn bạn không thể xóa'
                ]);
            } else {
                $khuVuc->delete();
                return response()->json([
                    'status'    => true,
                    'message'   => 'Đã xóa khu vực thành công'
                ]);
            }
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Khu vực không tồn tại'
            ]);
        }
    }
    public function search(Request $request)
    {
        $list = KhuVuc::where('ten_khu', 'like', '%' . $request->key_search . '%' )->get();
        return response()->json([
            'list' => $list
        ]);
    }

    public function multiDel(Request $request)
    {
        $check = $this->checkRule(67);
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
        $khuVucs = KhuVuc::whereIn('id', $str)->get();
        if($khuVucs) {
            foreach ($khuVucs as $k => $v) {
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
