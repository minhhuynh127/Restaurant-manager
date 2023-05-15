@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-5">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 500px;">
                        <table class="table table-bordered">
                            <thead>
                                {{-- <tr>
                                    <th class="align-middle">
                                        Tìm kiếm
                                    </th>
                                    <td colspan="1">
                                        <input v-model="key_search" v-on:keyup.enter="search()" type="text"
                                            class="form-control">
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary" v-on:click="search()">Tìm Kiếm</button>
                                    </td>
                                </tr> --}}
                                <tr class="table-primary">
                                    <th class="text-center align-middle">
                                        <button class="btn btn-primary" v-on:click="multiAdd()">
                                            <i class="fa-solid fa-forward"></i>
                                        </button>
                                    </th>
                                    <th class="text-center align-middle">Tên Món</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list_mon">
                                    <tr>
                                        <th class="text-center align-middle">
                                            <input type="checkbox" v-model="value.check">
                                        </th>
                                        <td class="text-center align-middle">
                                            @{{ value.ten_mon }}
                                        </td>
                                        <td class="text-center align-middle">
                                            <button class="btn btn-primary" v-on:click="addSanPham(value)">
                                                Thêm Sản Phẩm </button>
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
                                    <th class="align-middle" colspan="2">
                                        <select class="form-control" v-model="id_nha_cung_cap">
                                            <option value="0">Chọn nhà cung cấp</option>
                                            <template v-for="(value, key) in list_ncc">
                                                <option v-bind:value="value.id">
                                                    @{{ value.ten_cong_ty }}
                                                </option>
                                            </template>
                                        </select>
                                    </th>
                                    <th class="align-middle">
                                        <button class="btn btn-primary">Xác Nhận</button>
                                    </th>
                                    <th class="text-center align-middle">Tổng Tiền</th>
                                    <td class="text-start align-middle" colspan="2">
                                        <p><b>@{{ number_format(tong_tien) }}</b></p>
                                        <p><i class="text-capitalize">@{{ tien_chu }}</i>
                                        </p>
                                    </td>

                                </tr>
                                <tr class="table-primary">
                                    <th class="text-center">
                                        <button class="btn btn-danger" v-on:click="multiDelBill()">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </th>
                                    <th class="text-center">Tên Sản Phẩm</th>
                                    <th class="text-center">Số Lượng</th>
                                    <th class="text-center">Đơn Giá Nhập</th>
                                    <th class="text-center">Thành Tiền</th>
                                    <th class="text-center">Ghi Chú</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in data_nhap_hang">
                                    <tr>
                                        <th class="text-center align-middle">@{{ key + 1}}</th>
                                        <td class="align-middle text-nowrap">@{{ value.ten_mon_an }}</td>
                                        <td class="align-middle text-center">
                                            <input class="form-control" type="number" v-model="value.so_luong_nhap" v-on:change="updateChiTietHoaDonNhap(value)">
                                        </td>
                                        <td class="align-middle text-center text-nowrap">
                                            <input class="form-control" type="number" v-model="value.don_gia_nhap" v-on:change="updateChiTietHoaDonNhap(value)">
                                        </td>
                                        <td class="align-middle">@{{ number_format(value.thanh_tien) }}</td>
                                        <td class="align-middle text-center text-nowrap">
                                            <input class="form-control" type="text" v-model="value.ghi_chu" v-on:change="updateChiTietHoaDonNhap(value)">
                                        </td>
                                        <td class="align-middle text-center text-nowrap">
                                            <button class="btn btn-danger ml-1" data-bs-toggle="modal" data-bs-target="#deleteModal" v-on:click="mon_an = value">Xóa Bỏ</button>
                                        </td>
                                    </tr>
                                </template>
                                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa Loại Khách Hàng</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert alert-primary" role="alert">
                                                <p>Bạn có chắc chắn muốn xóa sản phẩm: <b class="text-danger text-uppercase">@{{ mon_an.ten_mon_an }}</b></p><p> này không?</p><p><b>Lưu ý:</b> Thao tác này sẽ không thể hoàn tác</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            <button type="button" class="btn btn-danger" v-on:click="accpectDel()" data-bs-dismiss="modal">Xác Nhận</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary w-100" v-on:click="nhapHang()">Nhập Hàng</button>
                        </div>
                    </div>
                    <div class="row mt-3" id="mail">
                        <div class="col-md-5">
                            <p v-if="check == false">Sẽ đóng trong : <b>@{{ time }}s</b></p>
                            <p v-else>Đang xử lý gửi mail...</b></p>
                        </div>
                        <div class="col-md-7">
                            <button class="btn btn-success w-100" v-on:click="guiMailNhapHang()">Gửi Mail</button>
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
            $("#mail").hide();
            new Vue({
                el: '#app',
                data: {
                    list_mon: [],
                    list_ncc: [],
                    mon_an: {},
                    data_nhap_hang  : [],
                    tong_tien       : 0,
                    tien_chu        : '',
                    id_nha_cung_cap : 0,
                    id_hoa_don_nhap : 0,
                    time            : 20,
                    check           : false
                },
                created() {
                    this.loadDanhSachSP();
                    this.loadDanhSachNCC();
                    this.loadDataNhapHang();
                },
                methods: {
                    guiMailNhapHang() {
                        var payload = {
                            'id_hoa_don_nhap': this.id_hoa_don_nhap,
                        }
                        this.time = 0;
                        this.check = true;
                        clearInterval(window.myTime);
                        axios
                            .post('/admin/nhap-hang/gui-mail', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message);
                                    this.loadDataNhapHang();
                                    $("#mail").hide();
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
                    nhapHang(){
                        var payload = {
                            'id_nha_cung_cap' : this.id_nha_cung_cap,
                            'tong_tien_nhap'  : this.tong_tien,
                        }
                        axios
                            .post('/admin/nhap-hang/nhap-hang/action', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message);
                                    if(res.data.nhapHang.id_nha_cung_cap) {
                                        this.id_hoa_don_nhap = res.data.nhapHang.id;
                                        $("#mail").show();
                                        myTime = setInterval(() => {
                                            if(this.time == 0) {
                                                clearInterval(myTime);
                                                this.loadDataNhapHang();
                                                $("#mail").hide();
                                            }
                                            this.time = this.time - 1;
                                        }, 1000);

                                    } else {
                                        this.loadDataNhapHang();
                                    }
                                } else {
                                    toastr.error(res.data.message);
                                    this.loadDataNhapHang();

                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    updateChiTietHoaDonNhap(value) {
                        axios
                            .post('/admin/nhap-hang/update-chi-tiet-hoa-don-nhap', value)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message);
                                    this.loadDataNhapHang();
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
                    accpectDel() {
                        axios
                        .post('/admin/nhap-hang/delete-mon-an', this.mon_an)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(res.data.message);
                                this.loadDataNhapHang();
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
                    addSanPham(value) {
                        axios
                            .post('/admin/nhap-hang/add-san-pham-nhap-hang', value)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadDataNhapHang();
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
                    loadDataNhapHang() {
                        this.time = 20;
                        axios
                            .get('/admin/nhap-hang/data')
                            .then((res) => {
                                this.data_nhap_hang = res.data.data;
                                this.tong_tien       = res.data.tong_tien;
                                this.tien_chu        = res.data.tien_chu;
                            });
                    },
                    loadDanhSachNCC() {
                        axios
                            .get('/admin/nha-cung-cap/data')
                            .then((res) => {
                                this.list_ncc  =  res.data.nhaCungCap;
                            });
                    },
                    loadDanhSachSP() {
                        axios
                            .get('/admin/mon-an/data')
                            .then((res) => {
                                this.list_mon = res.data.monAns;
                            });
                    },
                    number_format(number) {
                        return new Intl.NumberFormat('vi-VI', {
                            style: 'currency',
                            currency: 'VND'
                        }).format(number);
                    },
                },
            });
        })
    </script>
@endsection
