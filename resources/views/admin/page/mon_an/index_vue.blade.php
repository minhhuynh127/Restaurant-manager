@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h3 class="text-center text-primary fw-bold">
                        Thêm Mới Món Ăn
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên Món Ăn</label>
                        <input type="text" class="form-control" v-model="add_mon_an.ten_mon" v-on:keyup="createSlug()" v-on:blur="checkAddSlug">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Slug Món Ăn</label>
                        <input type="text" class="form-control" v-model="add_mon_an.slug_mon">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Giá Bán</label>
                        <input type="text" class="form-control" v-model="add_mon_an.gia_ban">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Danh mục</label>
                        <select class="form-control" v-model="add_mon_an.id_danh_muc">
                            <option value="0">Vui lòng chọn tên danh mục</option>
                            @foreach ($danhMuc as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tình trạng</label>
                        <select class="form-control">
                            <option value="1">Hiển thị</option>
                            <option value="0">Tạm tắt</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button v-on:click="addMonAn()" class="btn btn-primary add">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h3 class="text-center text-primary fw-bold text-center">
                        Danh Sách Món Ăn
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="align-middle">Tìm Kiếm</th>
                                    <td colspan="4">
                                        <input v-model="key_search" v-on:keyup.enter="search()" type="text" class="form-control">
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
                                    <th class="text-center text-nowrap align-middle">Tên Món Ăn</th>
                                    <th class="text-center text-nowrap align-middle">Slug Món Ăn</th>
                                    <th class="text-center text-nowrap align-middle" v-on:click="sort()">
                                        Giá bán
                                        <i v-if="order_by == 1" class="fa-solid fa-caret-up"></i>
                                        <i v-else-if="order_by == 2" class="fa-solid fa-caret-down"></i>
                                        <i v-else class="fa-solid fa-sort"></i>
                                    </th>
                                    <th class="text-center text-nowrap align-middle">Tên danh mục</th>
                                    <th class="text-center text-nowrap align-middle">Tình Trạng</th>
                                    <th class="text-center text-nowrap align-middle">Ngày Cập Nhật</th>
                                    <th class="text-center text-nowrap align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list">
                                    <tr>
                                        <th class="text-center align-middle text-nowrap">
                                            <input type="checkbox" v-model="value.check">
                                        </th>
                                        <td class="text-center align-middle text-nowrap">@{{ value.ten_mon }}</td>
                                        <td class="text-center align-middle text-nowrap">@{{ value.slug_mon }}</td>
                                        <td class="text-center align-middle text-nowrap">@{{ number_format(value.gia_ban) }}</td>
                                        <td class="text-center align-middle text-nowrap">@{{ value.ten_danh_muc }}</td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button v-on:click="changeStatus(value)" class="btn btn-warning"
                                                v-if="value.tinh_trang == 0">Dừng bán</button>
                                            <button v-on:click="changeStatus(value)" class="btn btn-success" v-else>Đang
                                                bán</button>
                                        </td>
                                        <td class="text-center align-middle text-nowrap">@{{ date_format(value.updated_at) }}</td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button v-on:click="edit_mon_an = Object.assign({}, value)" class="btn btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#updateModal">Cập Nhật</button>
                                            <button v-on:click="del_mon_an = value" class="btn btn-outline-danger ml-1"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa Bỏ</button>
                                        </td>
                                    </tr>
                                </template>
                                <!-- Modal delete-->
                                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5 fw-bold text-danger" id="exampleModalLabel">Xác nhận xóa món ăn
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-primary" role="alert">
                                                    <p class="text-wrap">
                                                        Bạn  có chắc chắn muốn xóa món ăn: <b class="tex-danger text-uppercase text-danger">@{{ del_mon_an.ten_mon }}</b> thuộc danh mục <b class="tex-danger text-uppercase text-danger">@{{ del_mon_an.ten_danh_muc }}</b> này không. Việc này không thể thay đổi, hãy cẩn thận!.
                                                    </p>
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
                                <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Cập
                                                    nhật món ăn</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3 form-group">
                                                    <label class="form-label fw-bold">Tên món ăn</label>
                                                    <input v-on:keyup="updateSlug()" v-model="edit_mon_an.ten_mon" type="text" class="form-control" v-on:blur="checkEditSlug()">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label fw-bold">Slug món ăn</label>
                                                    <input v-model="edit_mon_an.slug_mon" type="text" class="form-control">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label fw-bold">Giá bán</label>
                                                    <input v-model="edit_mon_an.gia_ban" type="text" class="form-control">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label fw-bold">Danh Mục</label>
                                                    <select class="form-control" v-model="edit_mon_an.id_danh_muc">
                                                        <option value="0">Vui lòng chọn danh mục</option>
                                                        @foreach ($danhMuc as $key => $value)
                                                            <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label fw-bold">Tình trạng</label>
                                                    <select class="form-control" v-model="edit_mon_an.tinh_trang">
                                                        <option value="1">Hiển thị</option>
                                                        <option value="0">Tạm tắt</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button v-on:click="accpectUpdate()" type="button" class="btn btn-primary edit">Cập
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
                    add_mon_an: {
                        'ten_mon': '',
                        'slug_mon': '',
                        'gia_ban': '',
                        'id_danh_muc': 0,
                        'tinh_trang': 1
                    },
                    del_mon_an: {},
                    edit_mon_an: {
                        'ten_mon': '',
                        'slug_mon': '',
                        'id_danh_muc': 0,
                    },
                    key_search: '',
                    order_by: 0

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
                            .post('/admin/mon-an/multi-delete', payload)
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
                    sort() {
                        this.order_by = this.order_by + 1;
                        if(this.order_by > 2) {
                            this.order_by = 0;
                        }
                        //Quy ước: 1 tăng dần , 2 giảm dần , 0 tăng dần theo id
                        if(this.order_by == 1) {
                            this.list = this.list.sort(function(a,b) {
                                return a.gia_ban - b.gia_ban;
                            })
                        } else if(this.order_by == 2) {
                            this.list = this.list.sort(function(a,b) {
                                return b.gia_ban - a.gia_ban;
                            })
                        } else {
                            this.list = this.list.sort(function(a,b) {
                                return a.id - b.id;
                            })
                        }
                    },
                    search() {
                        var payload = {
                            'key_search' : this.key_search
                        }
                        axios
                            .post('/admin/mon-an/search', payload)
                            .then((res) => {
                                this.list = res.data.monAns;
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    checkAddSlug() {
                        var payload = {
                            'slug_mon' : this.add_mon_an.slug_mon,
                        };
                        axios
                            .post('/admin/mon-an/check-slug', payload)
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
                    checkEditSlug() {
                        var payload = {
                            'slug_mon' : this.edit_mon_an.slug_mon,
                            'id'       : this.edit_mon_an.id
                        };
                        axios
                            .post('/admin/mon-an/check-slug', payload)
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
                    addMonAn() {
                        $('.add').prop('disabled', true);
                        axios
                            .post('/admin/mon-an/create', this.add_mon_an)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                    this.add_mon_an = {
                                        'ten_mon': '',
                                        'slug_mon': '',
                                        'gia_ban': '',
                                        'id_danh_muc': 0,
                                        'tinh_trang': 1
                                    }
                                    $('.add').removeAttr('disabled');
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, 'Error');
                                } else if (res.data.status == 2) {
                                    toastr.warning(res.data.message, 'Warning');
                                }
                            })
                            .catch((res) => {
                                console.log(res.response.data.errors);
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                                $('.add').removeAttr('disabled');
                            });
                    },
                    accpectDel() {
                        axios
                            .post('/admin/mon-an/delete', this.del_mon_an)
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
                    accpectUpdate() {
                        axios
                            .post('/admin/mon-an/update', this.edit_mon_an)
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
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                                $('.edit').removeAttr('disabled');
                            });
                    },
                    updateSlug() {
                        $('.edit').prop('đisabled', true);
                        var slug = this.toSlug(this.edit_mon_an.ten_mon);
                        this.edit_mon_an.slug_mon = slug;
                    },
                    createSlug() {
                        $('.add').prop('đisabled', true);
                        var slug = this.toSlug(this.add_mon_an.ten_mon);
                        this.add_mon_an.slug_mon = slug;
                    },
                    loadData() {
                        axios
                            .get('/admin/mon-an/data')
                            .then((res) => {
                                this.list = res.data.monAns;
                            })
                    },
                    changeStatus(monAn) {
                        axios
                            .post('/admin/mon-an/doi-trang-thai', monAn)
                            .then((res) => {
                                // console.log(res.data);
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, 'Error');
                                }
                            });
                    },
                    number_format(number) {
                        return new Intl.NumberFormat('vi-VI', {
                            style: 'currency',
                            currency: 'VND'
                        }).format(number);

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
                    }
                },
            });
        });
    </script>
@endsection
