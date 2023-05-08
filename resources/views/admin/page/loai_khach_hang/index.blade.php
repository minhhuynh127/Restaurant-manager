@extends('admin.share.master')
@section('noi_dung')
<div class="row" id="app">
    <div class="col-5">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header">
                <h4 class="card-title text-primary fw-bold text-center">Thêm mới loại khách hàng</h4>
            </div>
            <div class="card-body">
                <div class="mb-2 form-group">
                    <label class="form-label fw-bold">Tên Loại Khách Hàng</label>
                    <input type="text"
                        class="form-control" v-model="add_loai_khach_hang.ten_loai_khach" v-on:blur="checkTenLoaiKhachAdd()">
                </div>
                <div class="mb-2 form-group">
                    <label class="form-label fw-bold">Phần Trăm Giảm</label>
                    <input  type="number" class="form-control" min="0" max="100" v-model="add_loai_khach_hang.phan_tram_giam">
                </div>
                <div class="mb-2 form-group">
                    <div class="table-responsive" style="max-height: 250px;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="align-middle">
                                        Tìm kiếm
                                    </th>
                                    <td colspan="2">
                                        <input v-model="search_mon" v-on:keyup.enter="searchMon()" type="text" class="form-control">
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary" v-on:click="searchMon()">Tìm Kiếm</button>
                                    </td>
                                </tr>
                                <tr class="table-primary">
                                    <th class="text-center align-middle">#</th>
                                    <th class="text-center align-middle">Tên Món</th>
                                    <th class="text-center align-middle">Đơn giá
                                        {{-- <i v-if="order_by == 1" class="fa-solid fa-caret-up"></i>
                                        <i v-else-if="order_by == 2" class="fa-solid fa-caret-down"></i>
                                        <i v-else class="fa-solid fa-sort"></i> --}}
                                    </th>
                                    <th class="text-center align-middle">ĐTV</th>

                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list_mon">
                                    <tr>
                                        <th class="text-center align-middle">
                                            <input type="checkbox" v-model="value.check">
                                        </th>
                                        <td class="text-center align-middle">@{{ value.ten_mon }}</td>
                                        <td class="text-center align-middle">@{{ number_format(value.gia_ban) }}</td>
                                        <td class="text-center align-middle">Kg</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary add" v-on:click="addLoaiKhachHang()">Thêm Món</button>
            </div>
        </div>
    </div>
    <div class="col-7">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header">
                <h4 class="card-title text-primary fw-bold text-center">Danh sách loại khách hàng</h4>
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
                                    Tên Loại Khách Hàng

                                </th>
                                <th class="text-center text-nowrap" v-on:click="sort()">
                                    Phần Trăm Giảm
                                    <i v-if="order_by == 1" class="fa-solid fa-caret-up"></i>
                                    <i v-else-if="order_by == 2" class="fa-solid fa-caret-down"></i>
                                    <i v-else class="fa-solid fa-sort"></i>
                                </th>
                                <th class="text-center text-nowrap">List Món Tặng</th>
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
                                    <td class="text-center align-middle text-nowrap">@{{ value.ten_loai_khach }}</td>
                                    <td class="text-center align-middle text-nowrap">@{{ value.phan_tram_giam }}</td>
                                    <td class="text-center align-middle">@{{ value.ten_mon_tang }}</td>

                                    <td class="text-center align-middle text-nowrap">@{{ date_format(value.updated_at) }}</td>
                                    <td class="text-center align-middle text-nowrap">
                                        <button v-on:click="edit_loai_khach_hang = Object.assign({}, value)"
                                            class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#updateModal">Cập nhật</button>
                                        <button class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" v-on:click="del_loai_khach_hang = value">Xóa
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
                                                <p class="text-wrap">Bạn chắc chắn muốn xóa dữ liệu của: <b class="text-danger text-uppercase">@{{ del_loai_khach_hang.ten_loai_khach }}</b>, việc này không thể thay đổ., Hãy cẩn thận!!!.</p>
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
                                                Cập nhật lọa khách hàng</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="mb-3 form-group">
                                                <label class="form-label fw-bold">Tên loại khách hàng</label>
                                                <input type="text" class="form-control"
                                                    v-model="edit_loai_khach_hang.ten_loai_khach"
                                                    v-on:blur="checkTenLoaiKhachEdit()">
                                            </div>
                                            <div class="mb-3 form-group">
                                                <label class="form-label fw-bold">Phần Trăm Giam</label>
                                                <input type="text" class="form-control"
                                                    v-model="edit_loai_khach_hang.phan_tram_giam">
                                            </div>
                                            <div class="mb-3 form-group">
                                                <label class="form-label fw-bold">List Món Tặng</label>
                                                <input type="text" class="form-control"
                                                    v-model="edit_loai_khach_hang.list_mon_tang">
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
                    list                    : [],
                    add_loai_khach_hang     : {'ten_loai_khach' : '', 'phan_tram_giam' : 0, 'list_mon_tang' : ''},
                    del_loai_khach_hang     : {},
                    edit_loai_khach_hang    : {
                        'ten_loai_khach': '',
                        'phan_tram_giam': 0,
                        'list_mon_tang': ''
                    },
                    key_search: '',
                    order_by                : 0,
                    list_mon                : [],
                    search_mon              : '',

                },
                created() {
                    this.loadData();
                    this.loadDanhSachMon();
                },
                methods: {
                    multiDel() {
                        var payload = {
                            'list' : this.list
                        };
                        axios
                            .post('/admin/loai-khach-hang/multi-delete', payload)
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
                    loadDanhSachMon() {
                        axios
                            .get('/admin/mon-an/data')
                            .then((res) => {
                                this.list_mon = res.data.monAns;
                            })
                    },
                    searchMon() {
                        var payload = {
                            'key_search' : this.search_mon
                        }
                        axios
                            .post('/admin/mon-an/search', payload)
                            .then((res) => {
                                this.list_mon = res.data.monAns;
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
                                return a.phan_tram_giam - b.phan_tram_giam;
                            })
                        } else if(this.order_by == 2) {
                            this.list = this.list.sort(function(a,b) {
                                return b.phan_tram_giam - a.phan_tram_giam;
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
                            .post('/admin/loai-khach-hang/search', payload)
                            .then((res) => {
                                this.list = res.data.loaiKhachHangs;
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    loadData() {
                        axios
                            .get('/admin/loai-khach-hang/data')
                            .then((res) => {
                                this.list = res.data.loaiKhachHangs;
                            });
                    },
                    addLoaiKhachHang() {
                        $('.add').prop('disabled', true);
                        var payload = {
                            'ten_loai_khach' : this.add_loai_khach_hang.ten_loai_khach,
                            'phan_tram_giam' : this.add_loai_khach_hang.phan_tram_giam,
                            'list_mon'       : this.list_mon,
                        }
                        axios
                            .post('/admin/loai-khach-hang/create', payload)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, 'Success');
                                    this.add_loai_khach_hang = {
                                        'ten_loai_khach': '',
                                        'phan_tram_giam': 0,
                                        'list_mon_tang': ''

                                    };
                                    this.loadData();
                                    this.loadDanhSachMon();
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
                    checkTenLoaiKhachAdd() {
                        axios
                            .post('/admin/loai-khach-hang/check', this.add_loai_khach_hang)
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
                    accpectDel() {
                        axios
                            .post('/admin/loai-khach-hang/delete', this.del_loai_khach_hang)
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
                    checkTenLoaiKhachEdit() {
                        axios
                            .post('/admin/loai-khach-hang/check', this.edit_loai_khach_hang)
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
                            .post('/admin/loai-khach-hang/update', this.edit_loai_khach_hang)
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
                    date_format(now) {
                        return moment(now).format('HH:mm:ss DD/MM/yyyy');
                    },
                    number_format(number) {
                        return new Intl.NumberFormat('vi-VI', { style: 'currency', currency: 'VND' }).format(number);
                    },
                },

            });
        });
    </script>
@endsection