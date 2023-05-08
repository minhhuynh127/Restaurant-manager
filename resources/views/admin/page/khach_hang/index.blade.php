@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h3 class="text-primary text-center fw-bold">Thêm Mới Khách Hàng</h3>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Họ Lót</label>
                        <input type="text" class="form-control" v-model="add_khach_hang.ho_lot">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên Khách Hàng</label>
                        <input type="text" class="form-control" v-model="add_khach_hang.ten_khach">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Số Diện Thoại</label>
                        <input type="text" class="form-control" v-model="add_khach_hang.so_dien_thoai">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="text" class="form-control" v-model="add_khach_hang.email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ghi Chú</label>
                        <input type="text" class="form-control" v-model="add_khach_hang.ghi_chu">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ngày Sinh</label>
                        <input type="date" class="form-control" v-model="add_khach_hang.ngay_sinh">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Loại Khách Hàng</label>
                        <select class="form-control" v-model="add_khach_hang.id_loai_khach">
                            <option value="0">Chọn loại khách hàng</option>
                            @foreach ($loaiKhachHangs as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->ten_loai_khach }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mã Số Thuế</label>
                        <input type="text" class="form-control" v-model="add_khach_hang.ma_so_thue">
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary add" v-on:click="addKhachHang()">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h3 class="text-center text-primary fw-bold">
                        Danh Sách Khách Hàng
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="align-middle">Tìm Kiếm</th>
                                    <td colspan="1">
                                        <input v-model="key_search" v-on:keyup.enter="search()" type="text" class="form-control">
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary" v-on:click="search()">Tìm Kiếm</button>
                                    </td>
                                </tr>
                                <tr class="table-primary">
                                    <th class="text-center align-middle">
                                        <button class="btn btn-danger" v-on:click="multiDel()">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </th>
                                    <th class="text-center align-middle">Thông Tin Khách Hàng</th>
                                    <th class="text-center align-middle">Thông Tin Liên Hệ</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list">
                                    <tr>
                                        <th class="text-center align-middle">
                                            <input type="checkbox" v-model="value.check">
                                        </th>
                                        <td class="align-middle">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th class="text-nowrap text-start">Mã Khách Hàng</th>
                                                    <td class="text-nowrap text-center">@{{ value.ma_khach }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap text-start">Họ Và Tên</th>
                                                    <td class="text-nowrap text-center">@{{ value.ho_va_ten }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap text-start">Ngày Sinh</th>
                                                    <td class="text-nowrap text-center">@{{ value.ngay_sinh }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap text-start">Loại Khách Hàng</th>
                                                    <td class="text-nowrap text-center">@{{ value.ten_loai_khach }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="align-middle">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th class="text-nowrap text-start">Email</th>
                                                    <td class="text-nowrap text-center">@{{ value.email }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap text-start">Số Điện Thoại</th>
                                                    <td class="text-nowrap text-center">@{{ value.so_dien_thoai }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap text-start">Mã Số Thuế</th>
                                                    <td class="text-nowrap text-center">@{{ value.ma_so_thue }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap text-start">Ghi Chú</th>
                                                    <td class="text-nowrap text-center">@{{ value.ghi_chu }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#updateModal"
                                                v-on:click="edit_khach_hang = Object.assign({}, value)">Cập
                                                nhật</button>
                                            <button class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" v-on:click="del_khach_hang = value">Xóa
                                                Bỏ</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <!-- Modal delete-->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 fw-bold text-danger" id="exampleModalLabel">Xác
                                            nhận xóa dữ liệu</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" class="form-control" id="id_delete">
                                        <div class="alert alert-primary" role="alert">
                                            <p class="text-wrap">Bạn chắc chắn muốn xóa khách hàng: <b
                                                    class="text-danger text-uppercase">@{{ del_khach_hang.ho_va_ten }}</b> có mã <b
                                                    class="text-danger text-uppercase">@{{ del_khach_hang.ma_khach }}</b>, việc
                                                này không thể thay đổ., Hãy cẩn thận!!!.</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button v-on:click="accpectDel()" type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal" aria-label="Close">Xác nhận xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Update -->
                        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fw-bolde text-primary" id="exampleModalLabel">Cập nhật
                                            dữ
                                            liệu</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Họ Lót</label>
                                            <input type="text" class="form-control" v-model="edit_khach_hang.ho_lot">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tên Khách Hàng</label>
                                            <input type="text" class="form-control" v-model="edit_khach_hang.ten_khach">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Số Diện Thoại</label>
                                            <input type="text" class="form-control" v-model="edit_khach_hang.so_dien_thoai">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Email</label>
                                            <input type="text" class="form-control" v-model="edit_khach_hang.email">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ghi Chú</label>
                                            <input type="text" class="form-control" v-model="edit_khach_hang.ghi_chu">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ngày Sinh</label>
                                            <input type="date" class="form-control" v-model="edit_khach_hang.ngay_sinh">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Loại Khách Hàng</label>
                                            <select class="form-control" v-model="edit_khach_hang.id_loai_khach">
                                                <option value="0">Chọn loại khách hàng</option>
                                                @foreach ($loaiKhachHangs as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->ten_loai_khach }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary edit"
                                            v-on:click="accpectUpdate()">Cập nhật</button>
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
                el: '#app',
                data: {
                    list: [],
                    add_khach_hang: {

                        'ho_lot': '',
                        'ten_khach': '',
                        'so_dien_thoai': '',
                        'email': '',
                        'ghi_chu': '',
                        'ngay_sinh': '',
                        'id_loai_khach': 0,
                        'ma_so_thue': ''
                    },
                    del_khach_hang: {},
                    edit_khach_hang: {

                        'ho_lot': '',
                        'ten_khach': '',
                        'so_dien_thoai': '',
                        'email': '',
                        'ghi_chu': '',
                        'ngay_sinh': '',
                        'id_loai_khach': 0,
                        'ma_so_thue': ''
                    }

                },
                created() {
                    this.loadData();
                },
                methods: {
                    multiDel() {
                        var payload = {
                            'list' : this.list
                        };
                        axios
                            .post('/admin/khach-hang/multi-delete', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                } else {
                                    toastr.error(res.data.message, 'Error');
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
                            .get('/admin/khach-hang/data')
                            .then((res) => {
                                this.list = res.data.khachHangs;
                            })
                    },
                    addKhachHang() {
                        $('.add').prop('disabled', true);
                        axios
                            .post('/admin/khach-hang/create', this.add_khach_hang)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                    this.add_khach_hang = {
                                        'ho_lot': '',
                                        'ten_khach': '',
                                        'so_dien_thoai': '',
                                        'email': '',
                                        'ghi_chu': '',
                                        'ngay_sinh': '',
                                        'id_loai_khach': 0,
                                        'ma_so_thue': ''
                                    };
                                    $('.add').removeAttr('disabled');
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, 'Error');
                                } else if (res.data.status == 2) {
                                    toastr.warning(res.data.message, 'Warning');
                                }

                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(key, value) {
                                    toastr.error(value[0])
                                });
                                $('.add').removeAttr('disabled');
                            });
                    },

                    accpectDel() {
                        axios
                            .post('/admin/khach-hang/delete', this.del_khach_hang)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, 'Error');
                                } else if (res.data.status == 2) {
                                    toastr.warning(res.data.message, 'Warning');
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(key, value) {
                                    toastr.error(value[0])
                                });
                                $('.add').removeAttr('disabled');
                            });
                    },
                    accpectUpdate() {
                        // $('.edit').prop('disabled', true);
                        axios
                            .post('/admin/khach-hang/update', this.edit_khach_hang)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                    $('#updateModal').modal('hide');
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, 'Error');
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function( key, value) {
                                    toastr.error(value[0])
                                });
                                $('.edit').removeAttr('disabled');
                            });
                    },

                    search() {
                        var payload = {
                            'key_search' : this.key_search
                        }
                        axios
                            .post('/admin/khach-hang/search', payload)
                            .then((res) => {
                                this.list = res.data.khachHangs;
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    }
                },
            });
        });
    </script>
@endsection
