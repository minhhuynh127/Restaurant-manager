@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-5">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h3 class="card-title text-primary fw-bold text-center">Thêm danh mục mới</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Tên danh mục</label>
                        <input v-model="add_danh_muc.ten_danh_muc" v-on:keyup="createSlug()" type="text"
                            class="form-control" v-on:blur="checkSlugAdd()">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Slug danh mục</label>
                        <input v-model="add_danh_muc.slug_danh_muc" type="text" class="form-control">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Tình trạng</label>
                        <select class="form-control" v-model="add_danh_muc.tinh_trang">
                            <option value="-1">Vui lòng chọn tình trạng</option>
                            <option value="1">Hiển thị</option>
                            <option value="0">Không hiển thị</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary add" v-on:click="addDanhMuc()">Thêm mới</button>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h3 class="card-title text-primary fw-bold text-center">Danh sách danh mục</h3>
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
                                    <th class="text-center text-nowrap">
                                        <button class="btn btn-danger" v-on:click="multiDel()">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </th>
                                    <th class="text-center text-nowrap">
                                        Tên Danh Mục

                                    </th>
                                    <th class="text-center text-nowrap">Slug Danh Mục</th>
                                    <th class="text-center text-nowrap">Tình trạng</th>
                                    <th class="text-center text-nowrap">Ngày cập nhật</th>
                                    <th class="text-center text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list">
                                    <tr>
                                        <th class="text-center align-middle text-nowrap">
                                            <input type="checkbox" v-model="value.check">
                                        </th>
                                        <td class="text-center align-middle text-nowrap">@{{ value.ten_danh_muc }}</td>
                                        <td class="text-center align-middle text-nowrap">@{{ value.slug_danh_muc }}</td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button v-on:click="changeStatus(value)" v-if="(value.tinh_trang == 1)"
                                                class=" btn btn-success">Hiển thị</button>
                                            <button v-on:click="changeStatus(value)" v-else class=" btn btn-warning">Tạm
                                                tắt</button>
                                        </td>
                                        <td class="text-center align-middle text-nowrap">@{{ date_format(value.updated_at) }}</td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button v-on:click="edit_danh_muc = Object.assign({}, value)"
                                                class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#updateModal">Cập nhật</button>
                                            <button class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" v-on:click="del_danh_muc = value">Xóa
                                                bỏ</button>
                                        </td>
                                    </tr>
                                </template>
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
                                                    <p class="text-wrap">Bạn chắc chắn muốn xóa dữ liệu của danh mục: <b class="text-danger text-uppercase">@{{ del_danh_muc.ten_danh_muc }}</b>, việc này không thể thay đổ., Hãy cẩn thận!!!.</p>
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
                                <!-- Modal update-->
                                <div class="modal fade" id="updateModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5 fw-bold text-primary" id="exampleModalLabel">
                                                    Cập nhật danh mục</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="mb-3 form-group">
                                                    <label class="form-label fw-bold">Tên danh mục</label>
                                                    <input type="text" class="form-control"
                                                        v-model="edit_danh_muc.ten_danh_muc" v-on:keyup="updateSlug()"
                                                        v-on:blur="checkSlugEdit">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label fw-bold">Slug danh mục</label>
                                                    <input type="text" class="form-control"
                                                        v-model="edit_danh_muc.slug_danh_muc">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label fw-bold">Tình trạng</label>
                                                    <select class="form-control" v-model="edit_danh_muc.tinh_trang">
                                                        <option value="-1">Vui lòng chọn tình trạng</option>
                                                        <option value="1">Hiển thị</option>
                                                        <option value="0">Tạm tắt</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button v-on:click="accpectUpdate()" type="button"
                                                    class="btn btn-primary edit">Cập
                                                    nhật</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tbody>
                        </table>
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
                    ten_danh_muc: '',
                    slug_danh_muc: '',
                    add_danh_muc: {
                        'ten_danh_muc': '',
                        'slug_danh_muc': '',
                        'tinh_trang': -1
                    },
                    del_danh_muc: {},
                    edit_danh_muc: {
                        'ten_danh_muc': '',
                        'slug_danh_muc': '',
                        'tinh_trang': -1
                    },
                    key_search: ''
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
                            .post('/admin/danh-muc/multi-delete', payload)
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
                        }
                        axios
                            .post('/admin/danh-muc/search', payload)
                            .then((res) => {
                                this.list = res.data.danhMucs;
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },

                    addDanhMuc() {
                        $('.add').prop('disabled', true);
                        axios
                            .post('/admin/danh-muc/create', this.add_danh_muc)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, 'Success');
                                    this.add_danh_muc = {
                                        'ten_danh_muc': '',
                                        'slug_danh_muc': '',
                                        'tinh_trang': -1
                                    };
                                    this.loadData();
                                    $('.add').removeAttr('disabled');
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, 'Error');
                                } else if (res.data.status == 2) {
                                    toastr.warning(res.data.message, 'Warning');
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(key, value) {
                                    toastr.error(value[0]);
                                });
                                $('.add').removeAttr('disabled');
                            });
                    },
                    checkSlugAdd() {
                        axios
                            .post('/admin/danh-muc/check-slug', this.add_danh_muc)
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
                    accpectUpdate() {
                        $('.edit').prop('disabled', true);
                        axios
                            .post('/admin/danh-muc/update', this.edit_danh_muc)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                    $('#updateModal').modal('hide');
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(key, value) {
                                    toastr.error(value[0]);
                                });
                                $('.edit').removeAttr('disabled');
                            });
                    },
                    checkSlugEdit() {
                        axios
                            .post('/admin/danh-muc/check-slug', this.edit_danh_muc)
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
                    accpectDel() {
                        axios
                            .post('/admin/danh-muc/delete', this.del_danh_muc)
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
                            .get('/admin/danh-muc/data')
                            .then((res) => {
                                this.list = res.data.danhMucs;
                            });
                    },
                    updateSlug() {
                        $('.edit').prop('disabled', true);
                        var slug = this.toSlug(this.edit_danh_muc.ten_danh_muc);
                        this.edit_danh_muc.slug_danh_muc = slug;
                    },
                    createSlug() {
                        $('.add').prop('disabled', true);
                        var slug = this.toSlug(this.add_danh_muc.ten_danh_muc);
                        this.add_danh_muc.slug_danh_muc = slug;
                    },
                    changeStatus(danhMuc) {
                        axios
                            .post('/admin/danh-muc/doi-trang-thai', danhMuc)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, ' Error');
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
