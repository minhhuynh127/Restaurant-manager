@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-5">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h3 class="card-title text-primary fw-bold text-center">Thêm khu vực mới</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Tên khu vực</label>
                        <input type="text" class="form-control" v-model="add_khu_vuc.ten_khu" v-on:keyup="createSlug()" v-on:blur="checkSlugAdd()">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Slug khu vực</label>
                        <input type="text" class="form-control" v-model="add_khu_vuc.slug_khu">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Tình trạng</label>
                        <select class="form-control" v-model="add_khu_vuc.tinh_trang">
                            <option value="-1">Vui lòng chọn tình trạng</option>
                            <option value="1">Hiển thị</option>
                            <option value="0">Tạm tắt</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary add" v-on:click="addKhuVuc()">Thêm mới</button>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h3 class="card-title text-primary fw-bold text-center">Danh sách khu vực</h3>
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
                                    <td>
                                        <button class="btn btn-outline-primary" v-on:click="search()">Tìm Kiếm</button>
                                    </td>
                                </tr>
                                <tr class="table-primary">
                                    <th class="text-center">
                                        <button class="btn btn-danger" v-on:click="multiDel()">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </th>
                                    <th class="text-center text-nowrap">Tên khu vực</th>
                                    <th class="text-center text-nowrap">Slug khu vực</th>
                                    <th class="text-center text-nowrap">Tình trạng</th>
                                    <th class="text-center text-nowrap">Ngày cập nhật</th>

                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list">
                                    <tr>
                                        <th class="text-center align-middle">
                                            <input type="checkbox" v-model="value.check">
                                        </th>
                                        <td class="align-middle text-center text-nowrap">@{{ value.ten_khu }}</td>
                                        <td class="align-middle text-center text-nowrap">@{{ value.slug_khu }}</td>
                                        <td class="align-middle text-center text-nowrap">
                                            <button v-on:click="changeStatus(value)" v-if="value.tinh_trang == 1"
                                                class=" btn btn-success">Hiển thị</button>
                                            <button v-on:click="changeStatus(value)" v-else class=" btn btn-warning">Tạm
                                                tắt</button>
                                        </td>
                                        <td class="align-middle text-center text-nowrap">@{{ date_format(value.updated_at) }}</td>
                                        <td class="align-middle text-center text-nowrap">
                                            <button v-on:click="edit_khu_vuc = Object.assign({}, value)" class=" btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#updateModal">Cập nhật
                                            </button>
                                            <button v-on:click="del_khu_vuc = value" class="btn btn-outline-danger"         data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">Xóa bỏ
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <!-- Modal delete-->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 fw-bold text danger" id="exampleModalLabel">Xác nhận xóa dữ liệu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-primary" role="alert">
                                        Bạn chắc chắn muốn xóa dữ liệu của: <b class="text-danger text-uppercase">@{{ del_khu_vuc.ten_khu }}</b>, việc này không thể thay đổ., Hãy cẩn thận!!!.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="accpectDel()" type="button" id="accpect_delete" class="btn btn-danger"
                                        data-bs-dismiss="modal" aria-label="Close">Xác nhận xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal update-->
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel ">Cập nhật dữ
                                        liệu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Tên khu vực</label>
                                        <input v-on:keyup="updateSlug()" type="text" class="form-control" v-model="edit_khu_vuc.ten_khu" v-on:blur="checkSlugEdit()">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Slug khu vực</label>
                                        <input type="text" class="form-control" v-model="edit_khu_vuc.slug_khu">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Tình trạng</label>
                                        <select class="form-control" v-model="edit_khu_vuc.tinh_trang">
                                            <option value="-1">Vui lòng chọn tình trạng</option>
                                            <option value="1">Hiển thị</option>
                                            <option value="0">Tạm tắt</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="accpectUpdate()" type="button" class="btn btn-primary edit">Cập nhật</button>
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
                    list            : [],
                    add_khu_vuc     : {'ten_khu': '', 'slug_khu': '', 'tinh_trang': -1},
                    del_khu_vuc     : {},
                    edit_khu_vuc    : {'ten_khu': '', 'slug_khu': ''},
                    key_search      : '',

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
                            .post('/admin/khu-vuc/multi-delete', payload)
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
                    search() {
                        var payload = {
                            'key_search' : this.key_search
                        };
                        axios
                            .post('/admin/khu-vuc/search', payload)
                            .then((res) => {
                                this.list = res.data.list;
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(key, value) {
                                    toastr.error(value[0]);
                                });
                            });
                    },
                    addKhuVuc() {
                        $('.add').prop('disabled', true);
                        axios
                            .post('/admin/khu-vuc/create', this.add_khu_vuc)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                    this.add_khu_vuc = {'ten_khu': '', 'slug_khu': ''};
                                    $('.add').removeAttr('disabled');
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, 'Error');
                                } else if (res.data.status == 2) {
                                    toastr.warning(res.data.message, 'Warning');
                                }
                            })
                            .catch((res) => {
                                // console.log(res.response.data.errors);
                                $.each(res.response.data.errors, function(key, value) {
                                    toastr.error(value[0]);
                                });
                                $('.add').removeAttr('disabled');
                            });
                    },
                    checkSlugAdd() {
                        axios
                        .post('/admin/khu-vuc/check-slug', this.add_khu_vuc)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, 'Success');
                                $('.add').removeAttr('disabled');
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, 'Error');
                                $('.add').prop('disabled', true);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, 'Warning');
                            }
                        });
                    },
                    checkSlugEdit() {
                        axios
                        .post('/admin/khu-vuc/check-slug', this.edit_khu_vuc)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, 'Success');
                                $('.edit').removeAttr('disabled');
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, 'Error');
                                $('.edit').prop('disabled', true);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, 'Warning');
                            }
                        });
                    },
                    accpectUpdate() {
                        $('.edit').prop('disabled', true);
                        axios
                            .post('/admin/khu-vuc/update', this.edit_khu_vuc)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                    $('#updateModal').modal('hide');
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                            })
                            .catch((res) => {
                                // console.log(res.response.data.errors);
                                $.each(res.response.data.errors, function(key, value) {
                                    toastr.error(value[0]);
                                });
                                $('.edit').removeAttr('disabled');
                            });
                    },
                    accpectDel() {
                        axios
                            .post('/admin/khu-vuc/delete', this.del_khu_vuc)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, 'Error');
                                } else if (res.data.status == 2) {
                                    toastr.warning(res.data.message, 'Warning');
                                }
                            });
                    },
                    loadData() {
                        axios
                            .get('/admin/khu-vuc/data')
                            .then((res) => {
                                this.list = res.data.list;
                            });
                    },
                    updateSlug() {
                        $('.edit').prop('disabled', true);
                        var slug = this.toSlug(this.edit_khu_vuc.ten_khu);
                        this.edit_khu_vuc.slug_khu = slug;
                    },
                    createSlug() {
                        $('.add').prop('disabled', true);
                        var slug = this.toSlug(this.add_khu_vuc.ten_khu);
                        this.add_khu_vuc.slug_khu = slug;
                    },
                    changeStatus(khuVuc) {
                        axios
                            .post('/admin/khu-vuc/doi-trang-thai', khuVuc)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, 'Error');
                                }
                            });
                    },
                    date_format(now) {
                        return moment(now).format('HH:mm:ss DD/MM/yyyy');
                    },
                    toSlug(str) {
                        // Chuyển hết sang chữ thường
                        str = str.toLowerCase();

                        // xóa dấu
                        str = str
                            .normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
                            .replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp

                        // Thay ký tự đĐ
                        str = str.replace(/[đĐ]/g, 'd');

                        // Xóa ký tự đặc biệt
                        str = str.replace(/([^0-9a-z-\s])/g, '');

                        // Xóa khoảng trắng thay bằng ký tự -
                        str = str.replace(/(\s+)/g, '-');

                        // Xóa ký tự - liên tiếp
                        str = str.replace(/-+/g, '-');

                        // xóa phần dư - ở đầu & cuối
                        str = str.replace(/^-+|-+$/g, '');

                        // return
                        return str;
                    },
                },
            });
        });
    </script>
@endsection
