<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ban\CreateBanRequest;
use App\Http\Requests\Ban\UpdateBanRequest;
use App\Models\Ban;
use App\Models\HoaDonBanHang;
use App\Models\KhuVuc;
use Illuminate\Http\Request;

class BanController extends Controller
{

    public function index()
    {
        $khuVuc = KhuVuc::all();
        return view('admin.page.ban.index', compact('khuVuc'));
    }

    public function indexVue()
    {
        $check = $this->checkRule(56);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }

        $khuVuc = KhuVuc::all();

        return view('admin.page.ban.index_vue', compact('khuVuc'));
    }

    public function getData()
    {
        $check = $this->checkRule(57);
        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }
        $danhSachBan = Ban::join('khu_vucs', 'bans.id_khu_vuc', 'khu_vucs.id')
                            ->select('khu_vucs.ten_khu', 'bans.*')
                            ->orderBy('bans.id')
                            ->get();
        return response()->json([
            'danhSachBan' => $danhSachBan
        ]);

    }

    public function changeStatus(Request $request)
    {
        $check = $this->checkRule(58);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $ban = Ban::find($request->id);
        $hoaDon = HoaDonBanHang::where('id_ban', $ban->id)->first();

        if($ban && $ban->trang_thai == 1 && $hoaDon->trang_thai == 0) {
            return response()->json([
                'status'    => false,
                'message'   => 'Bàn đang hoạt đọng và có hóa đơn'
            ]);
        } else {
            $ban->tinh_trang = !$ban->tinh_trang;
            $ban->save();
            return  response()->json([
                'status' => true,
                'message' => 'Đổi trạng thái thành công'
            ]);
        }
    }

    public function checkSlug(Request $request)
    {
        if(isset($request->id)) {
            $check = Ban::where('slug_ban', $request->slug_ban)
                            ->where('id', '<>', $request->id)
                            ->first();
        } else {
            $check = Ban::where('slug_ban', $request->slug_ban)->first();
        }
        if($check) {
            return  response()->json([
                'status' => false,
                'message' => 'Tên bàn đã tồn tại'
            ]);
        } else {
            return  response()->json([
                'status' => true,
                'message' => 'Tên bàn được phép sử dụng'
            ]);
        }
    }

    public function store(CreateBanRequest $request)
    {
        $check = $this->checkRule(60);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $data = $request->all();
        Ban::create($data);
        return  response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công thành công'
        ]);

    }


    public function edit(Request $request)
    {
        $check = $this->checkRule(61);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $ban = Ban::find($request->id);
        if($ban) {
            return response()->json([
                'status'    => true,
                'message'   => 'Đã lấy được dữ liệu cần sửa',
                'ban'       => $ban
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   =>  'Bàn không tồn tại'
            ]);
        }
    }


    public function update(UpdateBanRequest $request)
    {
        $ban = Ban::where('id', $request->id)->first();
        if($ban) {
           $data = $request->all();
           $ban->update($data);
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
        $check = $this->checkRule(159);
        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $ban = Ban::find($request->id);
        $hoaDon = HoaDonBanHang::where('id_ban', $ban->id)->first();
        if($hoaDon && $hoaDon->trang_thai == 0) {
            return response()->json([
                'status'    => false,
                'message'   => 'Bàn đang có hóa đơn!!'
            ]);
        }else {
            $ban->delete();
            return response()->json([
                'status'    => true,
                'message'   => 'Đã xóa bàn thành công'
            ]);
        }
    }

    public function search(Request $request)
    {
        $danhSachBan = Ban::join('khu_vucs', 'bans.id_khu_vuc', 'khu_vucs.id')
                            ->select('khu_vucs.ten_khu', 'bans.*')
                            ->where('ten_ban', 'like', '%' . $request->key_search . '%')
                            ->orWhere('khu_vucs.ten_khu', 'like', '%' . $request->key_search . '%')
                            ->orderBy('bans.id')
                            ->get();
        return response()->json([
            'danhSachBan' => $danhSachBan
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
        $bans = Ban::whereIn('id', $str)->get();
        if($bans) {
            foreach ($bans as $key => $value) {
                $hoaDon = HoaDonBanHang::where('id_ban', $value->id)->first();
                if($hoaDon && $hoaDon->trang_thai == 0) {
                    return response()->json([
                        'status'    => 0,
                        'message'   => 'Bàn đang có hóa đơn!',
                    ]);
                } else {
                    $value->delete();
                    return response()->json([
                        'status'    => 1,
                        'message'   => 'Đã xóa thành công!',
                    ]);
                }
            }
        }

    }
}
