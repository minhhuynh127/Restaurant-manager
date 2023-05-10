<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ChangePassWordAdminRequest;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\DeleteAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Requests\Ban\UpdateBanRequest;
use App\Mail\QuenMatKhau;
use App\Models\Admin;
use App\Models\Quyen;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function viewUpdatePass($hash_reset)
    {
        $account = Admin::where('hash_reset', $hash_reset)->first();
        if($account) {
            return view('admin.page.update_pass', compact('hash_reset'));
        } else {
            toastr()->error("Dữ liệu không tồn tại!");
            return redirect('/admin/login');
        }
    }

    public function actionUpdatePass(Request $request)
    {
        if($request->password != $request->re_password) {
            toastr()->error("Mật khẩu không trùng nhau");
            return redirect()->back();
        }
        $account = Admin::where('hash_reset', $request->hash_reset)->first();
        if(!$account) {
            toastr()->error("Dữ liệu không tồn tại!");
            return redirect()->back();
        } else {
            $account->password = bcrypt($request->password);
            $account->hash_reset = NULL;
            $account->save();
            toastr()->success("Đã đổi mật khẩu thành công!");
            return redirect('/admin/login');
        }
    }

    public function viewLostPass()
    {
        return view('admin.page.lost_password');
    }

    public function actionLostPass(Request $request)
    {
        $account = Admin::where('email', $request->email)->first();
        if($account) {
            $now = Carbon::now();
            $time = $now->diffInMinutes($account->updated_at);
            if(!$account->hash_reset || $time > 10) {
                $account->hash_reset = Str::uuid();
                $account->save();
                $link = env('APP_URL') . '/admin/update-password/' . $account->hash_reset;
                Mail::to($account->email)->send(new QuenMatKhau($link));
            }
            toastr()->success("Vui lòng kiểm tra Email!");
            return redirect('/admin/login');
        } else {
            toastr()->error("Tài khoản không tồn tại!");
            return redirect('/admin/lost-password');
        }
    }

    public function actionLogout()
    {
        Auth::guard('admin')->logout();
        toastr()->error("Tài khoản đã đăng xuất!");
        return redirect('/admin/login');
    }

    public function viewLogin()
    {
        $check = Auth::guard('admin')->check();
        if($check) {
            return redirect('/');
        } else {
            return view('admin.page.login');
        }
    }
    public function actionLogin(Request $request)
    {
        $check = Auth::guard('admin')->attempt([
                                        'email'     => $request->email,
                                        'password'  => $request->password
                                    ]);
        if($check) {
            toastr()->success("Đã đăng nhập thành công!");
            return redirect('/');
        } else {
            toastr()->error("Tài khoản hoặc mật khẩu không chính xác!");
            return redirect('/admin/login');
        }
    }

    public function index()
    {
        $roles = Quyen::get();
        return view('admin.page.tai_khoan.index', compact('roles'));
    }
    public function store(CreateAdminRequest $request )
    {
        $check = $this->checkRule(1);
        if($check) {
            // toastr()->error("Bạn không đủ quyên truy cập!");
            // return redirect('/');

            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }


        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        Admin::create($data);
        return response()->json([
            'status'    => true,
            'message'   => 'Đã tạo tài khoản thành công!',
        ]);
    }

    public function getData()
    {
        $check = $this->checkRule(2);

        if($check) {
            toastr()->error("Bạn không đủ quyên truy cập!");
            return redirect('/');
        }

        $list = Admin::join('quyens', 'admins.id_quyen', 'quyens.id')
                    ->select('admins.*', 'quyens.ten_quyen')
                    ->get();
        return response()->json([
            'list'  => $list
        ]);
    }

    public function destroy(DeleteAdminRequest $request)
    {
        $check = $this->checkRule(5);

        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $admin = Admin::where('id', $request->id)->first();
        $admin->delete();
        return response()->json([
            'status'    => true,
            'message'   => 'Đã xóa thành công!',
        ]);
    }

    public function update(UpdateAdminRequest $request)
    {
        $check = $this->checkRule(4);

        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $data    = $request->all();
        $admin = Admin::find($request->id);
        $admin->update($data);
        return response()->json([
            'status'    => true,
            'message'   => 'Đã cập nhật thành công!',
        ]);
    }

    public function changePassword(ChangePassWordAdminRequest $request)
    {
        $check = $this->checkRule(3);

        if($check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn không đủ quyên!',
            ]);
        }

        $data = $request->all();
        if(isset($request->password)){
            $admin = Admin::find($request->id);
            // pas hiện tại = pass mới
            $data['password'] = bcrypt($data['password_new']);
            // Lưu pass mới
            $admin->password = $data['password'];
            $admin->save();
        }
        return response()->json([
            'status'    => 1,
            'message'   => 'Đã cập nhật mật khẩu thành công!',
        ]);
    }

    public function search(Request $request)
    {
        $list = Admin::join('quyens', 'admins.id_quyen', 'quyens.id')
                        ->where('ho_va_ten', 'LIKE', '%' . $request->key_search . '%')
                        ->where('email', 'LIKE', '%' . $request->key_search . '%')
                        ->orWhere('quyens.ten_quyen', 'LIKE', '%' . $request->key_search . '%')
                        ->orderBy('admins.id')
                        ->get();
        dd($list);
        return response()->json([
            'list'     => $list
        ]);
    }
}
