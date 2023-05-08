@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <template v-for="(value, key) in list_ban" v-if="value.tinh_trang == 1">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body text-center">
                        <p v-if="value.trang_thai == 0" class="text-uppercase fw-bold">Bàn: @{{ value.ten_ban }}</p>
                        <p v-else-if="value.trang_thai == 1" class="text-uppercase fw-bold text-primary">Bàn:
                            @{{ value.ten_ban }}</p>
                        <p v-else-if="value.trang_thai == 2" class="text-uppercase fw-bold text-warning">Bàn:
                            @{{ value.ten_ban }}</p>
                        <i v-on:click="openTable(value.id); getIdHoaDon(value.id)" v-if="value.trang_thai == 0"
                            class="fa-solid fa-square-xmark fa-5x" data-bs-toggle="modal"
                            data-bs-target="#chitietModal"></i>
                        <i v-on:click="openTable(value.id); getIdHoaDon(value.id)" v-else-if="value.trang_thai == 1"
                            class="fa-solid fa-bowl-food fa-5x text-primary" data-bs-toggle="modal"
                            data-bs-target="#chitietModal"></i>
                        <i v-on:click="openTable(value.id); getIdHoaDon(value.id)" v-else-if="value.trang_thai == 2"
                            class="fa-solid fa-money-bill-wheat fa-5x text-warning" data-bs-toggle="modal"
                            data-bs-target="#chitietModal"></i>
                    </div>
                    <div class="card-footer text-center">
                        <div v-if="value.trang_thai > 0" class="btn-group">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#chitietModal">Action</button>
                            <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-expanded="false"> <span class="visually-hidden">Toggle
                                    Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a>
                                </li>
                                <li><a class="dropdown-item" href="#">Another action</a>
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Separated link</a>
                                </li>
                            </ul>
                        </div>
                        <div v-else class="btn-group">
                            <button v-on:click="openTable(value.id)" type="button" class="btn btn-outline-secondary"
                                data-bs-toggle="modal" data-bs-target="#chitietModal">Open
                                !!!</button>
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-expanded="false"> <span class="visually-hidden">Toggle
                                    Dropdown</span>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </template>
        {{-- Modal chi tiet --}}
        <div class="modal fade" id="chitietModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 100%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-center text-primary fw-bold" id="exampleModalLabel">Hóa Đơn Bán
                            Hàng</h1>
                        <button v-on:click="trang_thai = 0" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" v-if="trang_thai == 0">
                            <div class="col-5">
                                <div class="card border-primary border-bottom border-3 border-0">
                                    <div class="card-body">
                                        <div class="table-responsive" style="max-height: 500px;">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">
                                                            Tìm kiếm
                                                        </th>
                                                        <td colspan="3">
                                                            <input v-model="key_search" v-on:keyup.enter="search()"
                                                                type="text" class="form-control">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-outline-primary"
                                                                v-on:click="search()">Tìm Kiếm</button>
                                                        </td>
                                                    </tr>
                                                    <tr class="table-primary">
                                                        <th class="text-center align-middle">
                                                            <button class="btn btn-primary" v-on:click="multiAddMon()">
                                                                <i class="fa-solid fa-forward"></i>
                                                            </button>
                                                        </th>
                                                        <th class="text-center align-middle">Tên Món</th>
                                                        <th class="text-center align-middle" v-on:click="sort()">Đơn giá
                                                            <i v-if="order_by == 1" class="fa-solid fa-caret-up"></i>
                                                            <i v-else-if="order_by == 2"
                                                                class="fa-solid fa-caret-down"></i>
                                                            <i v-else class="fa-solid fa-sort"></i>
                                                        </th>
                                                        <th class="text-center align-middle">ĐTV</th>
                                                        <th class="text-center align-middle">Tên Danh Mục</th>
                                                        <th class="text-center align-middle">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <template v-for="(value, key) in list_mon">
                                                        <tr>
                                                            <th class="text-center align-middle">
                                                                <input type="checkbox" v-model="value.check">
                                                            </th>
                                                            <td class="text-center align-middle">@{{ value.ten_mon }}
                                                            </td>
                                                            <td class="text-center align-middle">@{{ number_format(value.gia_ban) }}
                                                            </td>
                                                            <td class="text-center align-middle">Kg</td>
                                                            <td class="text-center align-middle">@{{ value.ten_danh_muc }}
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <button class="btn btn-primary"
                                                                    v-on:click="chiTietHoaDon(value.id)">Thêm Món </button>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="card card border-primary border-bottom border-3 border-0">
                                    <div class="card-body">
                                        <div class="table-responsive" style="max-height: 500px">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle" colspan="3">
                                                            <select v-if="hoa_don.is_xac_nhan == 0" class="form-control"
                                                                v-model="hoa_don.id_khach_hang">
                                                                <option value="0">Chọn tên khách hàng</option>
                                                                <template v-for="(value, key) in list_khach">
                                                                    <option v-bind:value="value.id">@{{ value.ho_va_ten }}
                                                                    </option>
                                                                </template>
                                                            </select>
                                                            <select v-else class="form-control"
                                                                v-model="hoa_don.id_khach_hang" disabled>
                                                                <option value="0">Chọn tên khách hàng</option>
                                                                <template v-for="(value, key) in list_khach">
                                                                    <option v-bind:value="value.id">@{{ value.ho_va_ten }}
                                                                    </option>
                                                                </template>
                                                            </select>
                                                        </th>
                                                        <th class="align-middle">
                                                            <button v-if="hoa_don.is_xac_nhan == 1" disabled
                                                                class="btn btn-primary">Xác Nhận</button>
                                                            <button v-on:click="xacNhan()" v-else
                                                                class="btn btn-primary">Xác Nhận</button>
                                                        </th>
                                                        <th class="text-center align-middle">Tổng Tiền</th>
                                                        <td class="text-start align-middle" colspan="2">
                                                            <p><b>@{{ number_format(tong_tien) }}</b></p>
                                                            <p><i class="text-capitalize">@{{ tien_chu }}</i></p>
                                                        </td>

                                                    </tr>
                                                    <tr class="table-primary">
                                                        <th class="text-center">
                                                            <button class="btn btn-danger" v-on:click="multiDel()">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </th>
                                                        <th class="text-center">Tên Món</th>
                                                        <th class="text-center" style="width: 15%;">Số Lượng</th>
                                                        <th class="text-center">Đơn Giá</th>
                                                        <th class="text-center" style="width: 15%;">Chiết Khấu</th>
                                                        <th class="text-center">Thành Tiền</th>
                                                        <th class="text-center" style="width: 20%;">Ghi Chú</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(value, key) in list_detail">
                                                        <th class="align-middle text-center">
                                                            <template v-if="value.is_in_bep">
                                                                @{{ key + 1 }}
                                                            </template>
                                                            <template v-else>
                                                                <input type="checkbox" v-model="value.check">
                                                                <i v-on:click="destroy(value)"
                                                                    class="fa-solid fa-trash-can text-danger"></i>
                                                            </template>
                                                        </th>
                                                        <td class="align-middle text-center">@{{ value.ten_mon_an }}</td>
                                                        <template v-if="value.is_in_bep">
                                                            <td class="align-middle text-center">@{{ value.so_luong_ban }}
                                                            </td>
                                                        </template>
                                                        <template v-else>
                                                            <td class="align-middle text-center">
                                                                <input v-on:change="updateChiTiet(value)"
                                                                    v-model="value.so_luong_ban" type="number"
                                                                    class="form-control text-center" step="0.1"
                                                                    min="0.1">
                                                            </td>
                                                        </template>
                                                        <td class="align-middle text-center">@{{ number_format(value.don_gia_ban) }}</td>
                                                        <td class="align-middle text-center">
                                                            <input v-on:change="updateChietKhau(value)"
                                                                v-model="value.tien_chiet_khau" type="number"
                                                                class="form-control text-center" min="0">
                                                        </td>
                                                        <td class="align-middle text-center">@{{ number_format(value.thanh_tien) }}</td>
                                                        <td class="align-middle text-center">
                                                            <input v-on:change="updateChiTiet(value)" type="text"
                                                                class="form-control" v-model="value.ghi_chu">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2" class="text-center">Giảm giá</th>

                                                        <td colspan="2">
                                                            <input v-on:change="updateHoaDon()" v-model="giam_gia" type="text" class="form-control">
                                                        </td>
                                                        <th class="text-center">Thực trả</th>
                                                        <th class="text-danger">@{{ number_format(thanh_tien) }}</th>
                                                        <td>
                                                            <i>@{{ thanh_tien_chu }}</i>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="trang_thai == 1">
                            <div class="col-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center align-middle">Chọn Bàn</th>
                                            <th class="text-center">
                                                <select class="form-control"
                                                    v-on:change="loadDanhSachMonTheoBan(id_ban_nhan_mon)"
                                                    v-model="id_ban_nhan_mon">
                                                    <option value="0">Chọn bàn cần chuyển món</option>
                                                    <template v-for="(value, key) in list_ban"
                                                        v-if="value.tinh_trang == 1 && value.trang_thai != 0">
                                                        <option v-if="value.id != add_mon.id_ban" v-bind:value="value.id">
                                                            @{{ value.ten_ban }}</option>
                                                    </template>
                                                </select>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="table-primary">
                                                <th class="text-center">#</th>
                                                <th class="text-center">Tên Món</th>
                                                <th class="text-center">Số Luọng</th>
                                                <th class="text-center">Ghi Chú</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(value, key) in list_mon_of_ban">
                                                <th class="text-center">@{{ key + 1 }}</th>
                                                <td>@{{ value.ten_mon_an }}</td>
                                                <td class="text-center">@{{ value.so_luong_ban }}</td>
                                                <td>@{{ value.ghi_chu }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="card card border-primary border-bottom border-3 border-0">
                                    <div class="card-body">
                                        <div class="table-responsive" style="max-height: 500px">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="table-primary">
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Tên Món</th>
                                                        <th class="text-center" style="width: 15%;">Số Lượng</th>
                                                        <th class="text-center" style="width: 20%">Số Lượng Chuyển</th>
                                                        <th class="text-center">Chuyển</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(value, key) in list_detail">
                                                        <th class="align-middle text-center">
                                                            @{{ key + 1 }}
                                                        </th>
                                                        <td class="align-middle text-center">@{{ value.ten_mon_an }}</td>

                                                        <td class="align-middle text-center">@{{ value.so_luong_ban }}</td>

                                                        <td class="align-middle text-center">
                                                            <input v-model="value.so_luong_chuyen" type="number"
                                                                class="form-control">
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <button v-on:click="chuyenMon(value)" class="btn btn-primary">
                                                                Chuyển
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-if="trang_thai == 0" v-on:click="trang_thai = 1" type="button" class="btn btn-danger">Chuyển bàn</button>
                        <button v-if="trang_thai == 1" v-on:click="trang_thai = 0" type="button"
                        class="btn btn-warning">Xong chuyển bàn</button>
                        <button v-on:click="inBep(add_mon.id_hoa_don_ban_hang)" type="button" class="btn btn-primary">In Bếp</button>
                        <button v-on:click="thanhToan()" type="button" class="btn btn-success">Thanh Toán</button>
                        <a target="_blank" v-bind:href="'/admin/ban-hang/in-bill/' + add_mon.id_hoa_don_ban_hang" class="btn btn-warning">In Bill</a>
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
                    list_ban            : [],
                    list_mon            : [],
                    list_detail         : [],
                    list_mon_of_ban     : [],
                    key_search          : '',
                    order_by            : 0,
                    add_mon             : {
                                            'id_hoa_don_ban_hang': 0,
                                            'id_ban': 0
                                        },
                    trang_thai          : 0,
                    id_ban_nhan_mon     : 0,
                    id_hd_nhan          : 0,
                    list_khach          : [],
                    hoa_don             : {},
                    tong_tien           : 0,
                    tien_chu            : '',
                    giam_gia            : 0,
                    thanh_tien          : 0,
                    thanh_tien_chu      : '',

                },
                created() {
                    this.loadDanhSachBan();
                    this.loadDanhSachMon();
                    this.loadDanhSachKhach();
                },
                methods: {

                    updateHoaDon() {
                        var payload = {
                            'id_hoa_don_ban_hang'   : this.add_mon.id_hoa_don_ban_hang,
                            'giam_gia'              : this.giam_gia
                        }
                        axios
                            .post('{{ Route("update-hoa-don") }}', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    this.loadDanhSachMonTheoHoaDon(this.add_mon.id_hoa_don_ban_hang);
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

                    thanhToan() {
                        axios
                            .post('{{ Route("thanh-toan") }}', this.add_mon)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message);
                                    $('#chitietModal').modal('toggle');
                                    this.loadDanhSachBan();
                                    var link = '/admin/ban-hang/in-bill/' + this.add_mon.id_hoa_don_ban_hang;
                                    window.open(link,'_blank');
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
                    xacNhan() {
                        axios
                            .post('{{ Route("xac-nhan-khach") }}', this.hoa_don)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.hoa_don = res.data.data;
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
                    loadDanhSachKhach() {
                        axios
                            .get('{{ Route('data-khach-hang') }}')
                            .then((res) => {
                                if (res.data.status) {
                                    this.list_khach = res.data.khachHangs;
                                } else {
                                    toastr.error(res.data.message);
                                }
                            });
                    },

                    // Chuyển món sang bàn khác
                    chuyenMon(payload) {
                        payload['id_hoa_don_nhan'] = this.id_hd_nhan;
                        axios
                            .post('{{ Route('chuyen-mon') }}', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                } else {
                                    toastr.error(res.data.message);
                                }
                                this.loadDanhSachMonTheoHoaDon(this.add_mon.id_hoa_don_ban_hang);
                                this.loadDanhSachMonTheoBan(this.id_ban_nhan_mon);
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },

                    // Load danh sách món của bàn cần chuyển
                    loadDanhSachMonTheoBan(id_ban_nhan_mon) {
                        var payload = {
                            'id_ban': id_ban_nhan_mon
                        };
                        axios
                            .post('{{ Route('list-mon-of-ban') }}', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    this.list_mon_of_ban = res.data.data;
                                    this.id_hd_nhan = res.data.id_hd;
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

                    // Add nhiều món
                    multiAddMon() {
                        var payload = {
                            'id_hoa_don_ban_hang': this.add_mon.id_hoa_don_ban_hang,
                            'list_mon': this.list_mon
                        }
                        axios
                            .post('/admin/chi-tiet/multi-add', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadDanhSachMonTheoHoaDon(this.add_mon.id_hoa_don_ban_hang);
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                                this.loadDanhSachMon();
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },

                    // Xóa nhiều món
                    multiDel() {
                        var payload = {
                            'list_detail': this.list_detail,
                            'id_hoa_don_ban_hang': this.add_mon.id_hoa_don_ban_hang
                        };
                        axios
                            .post('/admin/chi-tiet/multi-delete', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                                this.loadDanhSachMonTheoHoaDon(this.add_mon.id_hoa_don_ban_hang);
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    // Update chiết khấu
                    updateChietKhau(payload) {
                        axios
                            .post('{{ Route("update-chiet-khau") }}', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                } else {
                                    toastr.error(res.data.message);
                                }
                                this.loadDanhSachMonTheoHoaDon(payload.id_hoa_don_ban_hang);
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },

                    // Xóa món ăn chưa in bếp trong hóa đơn
                    destroy(payload) {
                        axios
                            .post('/admin/ban-hang/xoa-chi-tiet', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                } else {
                                    toastr.error(res.data.message);
                                }
                                this.loadDanhSachMonTheoHoaDon(payload.id_hoa_don_ban_hang);
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },

                    // In bếp
                    inBep(id_hoa_don_ban_hang) {
                        // console.log(id_hoa_don_ban_hang);
                        var payload = {
                            'id_hoa_don_ban_hang': id_hoa_don_ban_hang
                        }
                        axios
                            .post('/admin/ban-hang/in-bep', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadDanhSachMonTheoHoaDon(id_hoa_don_ban_hang);

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

                    // Update chi tiểt
                    updateChiTiet(v) {
                        axios
                            .post('/admin/ban-hang/update', v)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                                this.loadDanhSachMonTheoHoaDon(v.id_hoa_don_ban_hang);
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },

                    // Load danh sách món ăn của hóa đơn
                    loadDanhSachMonTheoHoaDon(id_hoa_don) {
                        var payload = {
                            'id_hoa_don_ban_hang': id_hoa_don
                        };
                        axios
                            .post('/admin/ban-hang/danh-sach-mon-theo-hoa-don', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    this.list_detail    = res.data.data;
                                    this.tong_tien      = res.data.tong_tien;
                                    this.tien_chu       = res.data.tien_chu;
                                    this.thanh_tien     = res.data.thanh_tien;
                                    this.thanh_tien_chu = res.data.thanh_tien_chu;
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

                    // Thêm món vào chi tiết hóa đơn
                    chiTietHoaDon(id_mon) {
                        var payload = {
                            'id_mon': id_mon,
                            'id_hoa_don_ban_hang': this.add_mon.id_hoa_don_ban_hang
                        }
                        axios
                            .post('/admin/ban-hang/them-mon-an', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                    // Load theo id hóa đơn
                                    this.loadDanhSachMonTheoHoaDon(this.add_mon.id_hoa_don_ban_hang);
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

                    // Lấy id hóa đơn theo id bàn
                    getIdHoaDon(id_ban) {
                        var payload = {
                            'id_ban': id_ban
                        }
                        axios
                            .post('/admin/ban-hang/find-id-by-idban', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    this.add_mon.id_hoa_don_ban_hang = res.data.id_hoa_don;
                                    this.add_mon.id_ban = id_ban;
                                    this.hoa_don = res.data.hoa_don;
                                    // Load theo id hóa đơn
                                    this.loadDanhSachMonTheoHoaDon(this.add_mon.id_hoa_don_ban_hang);
                                } else {
                                    toastr.error('Hệ thống đang có sự cố!');
                                    this.loadDanhSachBan();
                                    $('#chitietModal').modal('toggle');
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
                        if (this.order_by > 2) {
                            this.order_by = 0;
                        }
                        //Quy ước: 1 tăng dần theo giá, 2 giảm dần theo giá, 0 tăng dần theo id
                        if (this.order_by == 1) {
                            this.list_mon = this.list_mon.sort(function(a, b) {
                                return a.gia_ban - b.gia_ban;
                            })
                        } else if (this.order_by == 2) {
                            this.list_mon = this.list_mon.sort(function(a, b) {
                                return b.gia_ban - a.gia_ban;
                            })
                        } else {
                            this.list_mon = this.list_mon.sort(function(a, b) {
                                return a.id - b.id;
                            })
                        }
                    },
                    search() {
                        var payload = {
                            'key_search': this.key_search
                        }
                        axios
                            .post('/admin/mon-an/search', payload)
                            .then((res) => {
                                this.list_mon = res.data.monAns
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
                    loadDanhSachBan() {
                        axios
                            .get('/admin/ban/data')
                            .then((res) => {
                                this.list_ban = res.data.danhSachBan;
                            });
                    },
                    openTable(id_ban) {
                        var payload = {
                            'id_ban': id_ban
                        }
                        axios
                            .post('/admin/ban-hang/tao-hoa-don', payload)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadDanhSachBan();
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                    this.loadDanhSachBan();
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    number_format(number) {
                        return new Intl.NumberFormat('vi-VI', {
                            style: 'currency',
                            currency: 'VND'
                        }).format(number);
                    },
                }
            });
        });
    </script>
@endsection
