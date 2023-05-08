@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h3 class="card-title text-primary fw-bold text-center">Thêm bàn mới</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Tên Bàn</label>
                        <input type="text" class="form-control" v-model="add_ban.ten_ban" v-on:keyup="createSlug()" v-on:blur="checkSlugAdd()">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Slug Bàn</label>
                        <input type="text" class="form-control" v-model="add_ban.slug_ban">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Khu Vực</label>
                        <select name=""class="form-control" v-model="add_ban.id_khu_vuc">
                            <option value="0">Vui lòng chọn khu vực</option>
                            @foreach ($khuVuc as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->ten_khu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Gia Mở Bán</label>
                        <input type="text" class="form-control" v-model="add_ban.gia_mo_ban">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Tiền Giờ</label>
                        <input type="text" class="form-control" v-model="add_ban.tien_gio">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Tình Trạng</label>
                        <select class="form-control" v-model="add_ban.tinh_trang">
                            <option value="-1">Vui lòng chọn tình trạng</option>
                            <option value="1">Hiển thị</option>
                            <option value="0">Tạm tắt</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary add" v-on:click="addBan()">Thêm mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card border-primary border-bottom border-3 border-0 ">
                <div class="card-header">
                    <h3 class="card-title text-primary fw-bold text-center">Danh sách bàn</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="align-middle">Tìm Kiếm</th>
                                    <td colspan="6">
                                        <input v-model="key_search" v-on:keyup.enter="search()" type="text" class="form-control">
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
                                    <th class="text-center text-nowrap">Tên bàn</th>
                                    <th class="text-center text-nowrap">Slug bàn</th>
                                    <th class="text-center text-nowrap">Khu vực</th>
                                    <th class="text-center text-nowrap" v-on:click="sortGiaMoBan()">
                                        Giá mở bàn
                                        <i v-if="order_by == 1" class="fa-solid fa-caret-up"></i>
                                        <i v-else-if="order_by == 2" class="fa-solid fa-caret-down"></i>
                                        <i v-else class="fa-solid fa-sort"></i>
                                    </th>
                                    <th class="text-center text-nowrap" v-on:click="sortTienGio()">
                                        Tiền giờ
                                        <i v-if="order_by == 1" class="fa-solid fa-caret-up"></i>
                                        <i v-else-if="order_by == 2" class="fa-solid fa-caret-down"></i>
                                        <i v-else class="fa-solid fa-sort"></i>
                                    </th>
                                    <th class="text-center text-nowrap">Tình trạng</th>
                                    <th class="text-center text-nowrap">Ngày cập nhật</th>
                                    <th class="text-center text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list">
                                    <tr class="">
                                        <th class="text-center align-middle">
                                            <input type="checkbox" v-model="value.check">
                                        </th>
                                        <td class="text-nowrap text-center align-middle">@{{ value.ten_ban }}</td>
                                        <td class="text-nowrap text-center align-middle">@{{ value.slug_ban }}</td>
                                        <td class="text-nowrap text-center align-middle">@{{ value.ten_khu }}</td>
                                        <td class="text-nowrap text-center align-middle">@{{ number_format(value.gia_mo_ban) }}</td>
                                        <td class="text-nowrap text-center align-middle">@{{ number_format(value.tien_gio) }}</td>
                                        <td class="text-nowrap text-center align-middle">
                                            <button v-on:click="changeStatus(value)" v-if="(value.tinh_trang == 1)"
                                                class=" btn btn-success">Hiển thị</button>
                                            <button v-on:click="changeStatus(value)" v-else class=" btn btn-warning">Tạm
                                                tắt</button>
                                        </td>
                                        <td class="text-nowrap text-center align-middle">@{{ date_format(value.updated_at) }}</td>
                                        <td class="text-nowrap text-center align-middle text-nowrap">'
                                            <button class=" btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#updateModal" v-on:click="edit_ban = Object.assign({}, value)">Cập nhật</button>
                                            <button class=" btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" v-on:click="del_ban = value">Xóa bỏ</button>
                                        </td>
                                    </tr>
                                </template>
                                <!-- Modal delete-->
                                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5 text-danger fw-bold" id="exampleModalLabel">Xác nhận xóa dữ liệu
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-primary" role="alert">
                                                    <p class="text-wrap">
                                                        Bạn chắc chắn muốn xóa <b class="text-danger text uppercase">@{{ del_ban.ten_ban }}</b> thuộc <b class="text-danger text uppercase">@{{ del_ban.ten_khu }}</b>. Việc này không thể thay đổi, hãy cẩn thận!.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal" aria-label="Close" v-on:click="accpectDel()">Xác nhận xóa</button>
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

                                                <div class="mb-3 form-group">
                                                    <label class="form-label fw-bold">Tên Bàn</label>
                                                    <input type="text" class="form-control" v-model="edit_ban.ten_ban" v-on:keyup="updateSlug()" v-on:blur="checkSlugEdit()">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label fw-bold">Slug Bàn</label>
                                                    <input type="text" class="form-control" v-model="edit_ban.slug_ban">
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label fw-bold">Khu Vực</label>
                                                    <select name=""class="form-control" v-model="edit_ban.id_khu_vuc">
                                                        <option value="0">Vui lòng chọn khu vực</option>
                                                        @foreach ($khuVuc as $key => $value)
                                                            <option value="{{ $value->id }}">{{ $value->ten_khu }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3 form-group">
                                                            <label class="form-label fw-bold">Gia Mở Bán</label>
                                                            <input type="text" class="form-control" v-model="edit_ban.gia_mo_ban">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-3 form-group">
                                                            <label class="form-label fw-bold">Tiền Giờ</label>
                                                            <input type="text" class="form-control" v-model="edit_ban.tien_gio">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 form-group">
                                                    <label class="form-label fw-bold">Tình Trạng</label>
                                                    <select class="form-control" v-model="edit_ban.tinh_trang">
                                                        <option value="1">Hiển thị</option>
                                                        <option value="0">Tạm tắt</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary edit" v-on:click="accpectUpdate()">Cập nhật</button>
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
                    list        : [],
                    ten_ban     : '',
                    slug_ban    : '',
                    add_ban     : {'ten_ban' : '', 'slug_ban' : '', 'id_khu_vuc' : 0, 'gia_mo_ban' : '', 'tien_gio': '', 'tinh_trang' : -1},
                    del_ban     : {},
                    edit_ban    : {'ten_ban' : '', 'slug_ban' : '', 'id_khu_vuc' : 0, 'gia_mo_ban' : '', 'tien_gio': ''},
                    key_search  : '',
                    order_by    : 0
                },
                created() {
                    this.loadData();
                },
                methods: {
                    multiDel() {
                        var payload = {
                            'list' : this.list
                        }
                        axios
                            .post('/admin/ban/multi-delete', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                                this.loadData();
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    sortGiaMoBan() {
                        this.order_by = this.order_by + 1;
                        if(this.order_by > 2) {
                            this.order_by = 0;
                        }
                        //Quy ước: 1 tăng dần , 2 giảm dần , 0 tăng dần theo id
                        if(this.order_by == 1) {
                            this.list = this.list.sort(function(a,b) {
                                return a.gia_mo_ban - b.gia_mo_ban;
                            })
                        } else if(this.order_by == 2) {
                            this.list = this.list.sort(function(a,b) {
                                return b.gia_mo_ban - a.gia_mo_ban;
                            })
                        } else {
                            this.list = this.list.sort(function(a,b) {
                                return a.id - b.id;
                            })
                        }
                    },
                    sortTienGio() {
                        this.order_by = this.order_by + 1;
                        if(this.order_by > 2) {
                            this.order_by = 0;
                        }
                        //Quy ước: 1 tăng dần theo giá, 2 giảm dần theo giá, 0 tăng dần theo id
                        if(this.order_by == 1) {
                            this.list = this.list.sort(function(a,b) {
                                return a.tien_gio - b.tien_gio;
                            })
                        } else if(this.order_by == 2) {
                            this.list = this.list.sort(function(a,b) {
                                return b.tien_gio - a.tien_gio;
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
                            .post('/admin/ban/search', payload)
                            .then((res) => {
                                this.list = res.data.danhSachBan;
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },

                    addBan() {
                        $('.add').prop('disabled', true);
                        axios
                            .post('/admin/ban/create', this.add_ban)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                    this.add_ban = {'ten_ban' : '', 'slug_ban' : '', 'id_khu_vuc' : 0, 'gia_mo_ban' : '', 'tien_gio': '', 'tinh_trang' : 1};
                                    $('.add').removeAttr('disabled');
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, 'Error');
                                } else if (res.data.status == 2) {
                                    toastr.warning(res.data.message, 'Warning');
                                }

                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function( key, value) {
                                    toastr.error(value[0])
                                });
                                $('.add').removeAttr('disabled');
                            });
                    },
                    accpectUpdate() {
                        $('.edit').prop('disabled', true);
                        axios
                            .post('/admin/ban/update', this.edit_ban)
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
                    accpectDel() {
                        axios
                        .post('/admin/ban/delete', this.del_ban)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, 'Success');
                                this.loadData();
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, 'Error');
                            }
                        });
                    },
                    checkSlugEdit() {
                        axios
                            .post('/admin/ban/check-slug', this.edit_ban)
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
                    checkSlugAdd() {
                        axios
                            .post('/admin/ban/check-slug', this.add_ban)
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
                    updateSlug() {
                        $('.edit').prop('disabled', true);
                        var slug = this.toSlug(this.edit_ban.ten_ban);
                        this.edit_ban.slug_ban = slug;
                    },
                    createSlug() {
                        $('.add').prop('disabled', true);
                        var slug = this.toSlug(this.add_ban.ten_ban);
                        this.add_ban.slug_ban = slug;
                    },
                    loadData() {
                        axios
                            .get('/admin/ban/data')
                            .then((res) => {
                                this.list = res.data.danhSachBan;
                            });
                    },
                    changeStatus(ban) {
                        axios
                            .post('/admin/ban/doi-trang-thai', ban)
                            .then((res) => {
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
                    },
                },
            });
        });
    </script>
@endsection
