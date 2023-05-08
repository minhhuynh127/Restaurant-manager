@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="text-primary text-center fw-bold">Tạo Tài Khoản</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Họ Và Tên</label>
                        <input v-model="add.ho_va_ten" type="text" class="form-control" placeholder="Nhập vào họ và tên *">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input v-model="add.email" type="email" class="form-control" placeholder="Nhập vào email *">
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Số Điện Thoại</label>
                                <input v-model="add.so_dien_thoai" type="tel" class="form-control" placeholder="Nhập vào số điện thoại *">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ngày Sinh</label>
                                <input v-model="add.ngay_sinh" type="date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mật Khẩu</label>
                        <input v-model="add.password" type="password" class="form-control" placeholder="Nhập vào mật khẩu *">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Xác Nhận Mật Khẩu</label>
                        <input v-model="add.re_password" type="password" class="form-control" placeholder="Nhập lại mật khẩu *">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Quyền Tài Khoản</label>
                        <select class="form-control" v-model="add.id_quyen">
                            <option value="0">Vui lòng chọn quyền cho tài khoản</option>
                            @foreach ($roles as $key => $value )
                                <option value="{{ $value->id }}">{{ $value->ten_quyen }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="button" v-on:click="CreateTaiKhoan()">Tạo Mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="text-primary text-center fw-bold">Danh Sách Tài Khoản</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="align-middle">Tìm Kiếm</th>
                                    <td colspan="4">
                                        <input type="text" class="form-control" v-model="key_search" v-on:keyup.enter="search()">
                                    </td>
                                    <td class="text-start">
                                        <button class="btn btn-outline-primary" v-on:click="search()">Tìm Kiếm</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-center align-middle">#</th>
                                    <th class="text-center align-middle">Họ Và Tên</th>
                                    <th class="text-center align-middle">Email</th>
                                    <th class="text-center align-middle">Quyền Tài Khoản</th>
                                    <th class="text-center align-middle">Ngày Sinh</th>
                                    <th class="text-center align-middle">Số Điện Thoại</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list">
                                    <tr>
                                        <th class="text-center align-middle">@{{key + 1}}</th>
                                        <td class="align-middle text-center">@{{ value.ho_va_ten}}</td>
                                        <td class="align-middle text-center">@{{ value.email}}</td>
                                        <td class="align-middle text-center">@{{ value.ten_quyen}}</td>
                                        <td class="text-center align-middle">@{{ date_format(value.ngay_sinh)}}</td>
                                        <td class="text-center align-middle">@{{ value.so_dien_thoai}}</td>
                                        <td class="text-center align-middle text-nwrap">
                                            <button class="btn btn-success" v-on:click="password_new = value" data-bs-toggle="modal"data-bs-target="#changePasswordModal">Đổi Mật Khẩu</button>
                                            <button class="btn btn-outline-primary" v-on:click="edit = value" data-bs-toggle="modal" data-bs-target="#updateModal">Cập Nhật</button>
                                            <button class="btn btn-outline-danger" v-on:click="del = value" data-bs-toggle="modal"data-bs-target="#deleteModal">Xoá</button>
                                        </td>
                                     </tr>
                                </template>
                            </tbody>
                        </table>
                        {{-- Modal Delete --}}
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel">Xoá Tài Khoản</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-primary" role="alert">
                                            <p>Bạn có chắc chắn muốn xoá tài khoản của <b class="text-danger">@{{del.ho_va_ten}}.</b></p>
                                            <p>Đang có quyền <b class="text-danger">@{{del.ten_quyen}}</b> ?</p>
                                            <p><b>Lưu ý:</b> Thao tác này sẽ không thể hoàn tác</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn btn-danger" v-on:click="DelAdmin()">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Modal Update --}}
                        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">Cập Nhật Tài Khoản</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Họ Và Tên</label>
                                            <input v-model="edit.ho_va_ten" type="text" class="form-control" placeholder="Nhập vào họ và tên *">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Email</label>
                                            <input v-model="edit.email" type="email" class="form-control" placeholder="Nhập vào email *">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Số Điện Thoại</label>
                                            <input v-model="edit.so_dien_thoai" type="tel" class="form-control" placeholder="Nhập vào số điện thoại *">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ngày Sinh</label>
                                            <input v-model="edit.ngay_sinh" type="date" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Quyền Tài Khoản</label>
                                            <select class="form-control" v-model="edit.id_quyen">
                                                <option value="0">Vui lòng chọn quyền cho tài khoản</option>
                                                @foreach ($roles as $key => $value )
                                                    <option value="{{ $value->id }}">{{ $value->ten_quyen }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" v-on:click="updateAdmin()" class="btn btn-primary">Cập Nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Modal change password --}}
                        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">Đổi Mật Khẩu</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" v-model="password_new.id">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mật Khẩu</label>
                                            <input type="password" class="form-control" v-model="password_new.password_new" placeholder="Nhập vào mật khẩu mới *">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Xác Nhận Mật Khẩu</label>
                                            <input type="password" class="form-control" v-model="password_new.re_password"  placeholder="Nhập lại mật khẩu mới *">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn btn-primary" v-on:click="changePassWord()">Cập Nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            new Vue({
                el      :   '#app',
                data    :   {
                    add:            {'id_quyen' : 0},
                    list:           [],
                    del:            {},
                    edit:           {},
                    password_new:   {},
                    key_search:     '',
                },
                created()   {
                    this.loadData();
                },
                methods :   {
                    search() {
                        var payload = {
                            'key_search' : this.key_search
                        };
                        axios
                            .post('/admin/tai-khoan/search', payload)
                            .then((res) => {
                                this.list = res.data.list;
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(key, value) {
                                    toastr.error(value[0]);
                                });
                            });
                    },
                    CreateTaiKhoan() {
                        axios
                            .post('/admin/tai-khoan/create', this.add)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                    this.add = {'id_quyen' : 0};
                                } else {
                                    toastr.error(res.data.message);
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    loadData() {
                        axios
                            .get('/admin/tai-khoan/data')
                            .then((res) => {
                                this.list  =  res.data.list;
                            });
                    },
                    DelAdmin() {
                        axios
                            .post('/admin/tai-khoan/delete', this.del)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                    this.loadData();
                                    $('#deleteModal').modal('hide');
                                } else {
                                    toastr.error(res.data.message);
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    updateAdmin() {
                        axios
                            .post('/admin/tai-khoan/update', this.edit)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Successs');
                                    this.loadData();
                                    $('#updateModal').modal('hide');
                                } else {
                                    toastr.error(res.data.message);
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    changePassWord() {
                        axios
                            .post('/admin/tai-khoan/change-password', this.password_new)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message);
                                    this.loadData();
                                    $('#changePasswordModal').modal('hide');
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },

                    date_format(now) {
                        return moment(now).format('DD/MM/yyyy');
                    },

                },
            });
        });
    </script>
@endsection
