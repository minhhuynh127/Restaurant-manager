@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="text-primary text-center fw-bold">Thêm nhà cung cấp</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Mã Số Thuê</label>
                        <input type="text" class="form-control" v-model="add_nha_cung_cap.ma_so_thue"
                            v-on:blur="checkAddMST()">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Tên Công Ty</label>
                        <input type="text" class="form-control" v-model="add_nha_cung_cap.ten_cong_ty">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Tên Người Đại Diện</label>
                        <input type="text" class="form-control" v-model="add_nha_cung_cap.ten_nguoi_dai_dien">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Số Điện Thoại</label>
                        <input type="text" class="form-control" v-model="add_nha_cung_cap.so_dien_thoai">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Email</label>
                        <input type="text" class="form-control" v-model="add_nha_cung_cap.email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Địa Chỉ</label>
                        <input type="text" class="form-control" v-model="add_nha_cung_cap.dia_chi">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Tên Gợi Nhớ</label>
                        <input type="text" class="form-control" v-model="add_nha_cung_cap.ten_goi_nho">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Tình Trạng</label>
                        <select class="form-control" v-model="add_nha_cung_cap.tinh_trang">
                            <option value="-1">Vui lòng chọn tình trạng</option>
                            <option value="1">Hiển thị</option>
                            <option value="0">Tạm tắt</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary add" v-on:click="addNhaCungCap()">Thêm mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="text-primary text-center fw-bold">Danh Sách Nhà Cung Cấp</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-primary">
                                    <th class="text-center">
                                        <button class="btn btn-danger" v-on:click="multiDel()">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </th>
                                    <th class="text-center">Thông Tin Công Ty</th>
                                    <th class="text-center">Thông Tin Liên Hệ</th>
                                    <th class="text-center">Tình Trạng</th>
                                    <th class="text-center">Action</th>
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
                                                    <th class="text-nowrap text-center">Mã số thuế</th>
                                                    <td class="text-nowrap text-center">@{{ value.ma_so_thue }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap text-center">Địa chỉ</th>
                                                    <td class="text-nowrap text-center">@{{ value.dia_chi }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap text-center">Tên công ty</th>
                                                    <td class="text-nowrap text-center">@{{ value.ten_cong_ty }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="align-middle">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th class="text-nowrap text-center">Tên liên hệ</th>
                                                    <td class="text-nowrap text-center">@{{ value.ten_nguoi_dai_dien }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap text-center">Số điện thoại</th>
                                                    <td class="text-nowrap text-center">@{{ value.so_dien_thoai }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap text-center">Email</th>
                                                    <td class="text-nowrap text-center">@{{ value.email }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-nowrap text-center">Tên gợi nhớ</th>
                                                    <td class="text-nowrap text-center">@{{ value.ten_goi_nho }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button v-on:click="changeStatus(value)" v-if="value.tinh_trang == 1"
                                                class="btn btn-success">Hiển thị</button>

                                            <button v-on:click="changeStatus(value)" v-else class="btn btn-warning">Tạm
                                                Tắt</button>
                                        </td>
                                        <td class="text-center align-middle text-wrap">
                                            <button class="btn btn-outline-primary mb-3" data-bs-toggle="modal"
                                                data-bs-target="#updateModal"
                                                v-on:click="edit_nha_cung_cap = Object.assign({}, value)">Cập
                                                nhật</button>
                                            <button class="btn btn-outline-danger mb-3" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" v-on:click="del_nha_cung_cap = value">Xóa
                                                Bỏ</button>
                                            <button v-on:click="taoHoaDonNhapHang(value.id); getIdHoaDonNhap(value.id)" class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#chitietModal">Nhập Hàng
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
                                    <h1 class="modal-title fs-5 text-danger fw-bold" id="exampleModalLabel">Xác nhận xóa
                                        dữ liệu
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" class="form-control" id="id_delete">
                                    <div class="alert alert-primary" role="alert">
                                        Bạn chắc chắn muốn xóa nhà cung cấp <b
                                            class="text-danger text-uppercase fw-bold">@{{ del_nha_cung_cap.ten_cong_ty }}</b>. Việc này
                                        không thể thay đổi, hãy cẩn
                                        thận!.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="accpect_delete" class="btn btn-danger"
                                        data-bs-dismiss="modal" aria-label="Close" v-on:click="accpectDel()">Xác nhận
                                        xóa</button>
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
                                    <h1 class="modal-title fw-bold text-primary" id="exampleModalLabel">Cập nhật dữ
                                        liệu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Mã Số Thuê</label>
                                        <input type="text" class="form-control" v-model="edit_nha_cung_cap.ma_so_thue"
                                            v-on:blur="checkEditMST()">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Tên Công Ty</label>
                                        <input type="text" class="form-control"
                                            v-model="edit_nha_cung_cap.ten_cong_ty">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Tên Người Đại Diện</label>
                                        <input type="text" class="form-control"
                                            v-model="edit_nha_cung_cap.ten_nguoi_dai_dien">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Số Điện Thoại</label>
                                        <input type="text" class="form-control"
                                            v-model="edit_nha_cung_cap.so_dien_thoai">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Email</label>
                                        <input type="text" class="form-control" v-model="edit_nha_cung_cap.email">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Địa Chỉ</label>
                                        <input type="text" class="form-control" v-model="edit_nha_cung_cap.dia_chi">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Tên Gợi Nhớ</label>
                                        <input type="text" class="form-control"
                                            v-model="edit_nha_cung_cap.ten_goi_nho">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Tình Trạng</label>
                                        <select class="form-control" v-model="edit_nha_cung_cap.tinh_trang">Tình trạng
                                            <option value="-1">Vui lòng chọn tình trạng</option>
                                            <option value="1">Hiển thị</option>
                                            <option value="0">Tạm tắt</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary edit" v-on:click="accpectUpdate()">Cập
                                        nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Modal chi tiet --}}
                    <div class="modal fade" id="chitietModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 100%;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 text-center text-primary fw-bold" id="exampleModalLabel">
                                        Hóa Đơn Nhập
                                        Hàng</h1>
                                    <button stype="button" class="btn-close"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
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
                                                                    <td colspan="2">
                                                                        <input v-model="key_search"
                                                                            v-on:keyup.enter="search()" type="text"
                                                                            class="form-control">
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-outline-primary"
                                                                            v-on:click="search()">Tìm Kiếm</button>
                                                                    </td>
                                                                </tr>
                                                                <tr class="table-primary">
                                                                    <th class="text-center align-middle">
                                                                        <button class="btn btn-primary"
                                                                            v-on:click="multiAdd()">
                                                                            <i class="fa-solid fa-forward"></i>
                                                                        </button>
                                                                    </th>
                                                                    <th class="text-center align-middle">Tên Món</th>
                                                                    <th class="text-center align-middle"
                                                                        v-on:click="sort()">Đơn giá
                                                                        <i v-if="order_by == 1"
                                                                            class="fa-solid fa-caret-up"></i>
                                                                        <i v-else-if="order_by == 2"
                                                                            class="fa-solid fa-caret-down"></i>
                                                                        <i v-else class="fa-solid fa-sort"></i>
                                                                    </th>

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
                                                                            @{{ number_format(value.gia_ban) }}
                                                                        </td>

                                                                        <td class="text-center align-middle">
                                                                            <button class="btn btn-primary"
                                                                                v-on:click="nhapHangtoBill(value.id)">
                                                                                Nhập Hàng </button>
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
                                                                        <select class="form-control">
                                                                            <option value="0">Chọn nhà cung cấp
                                                                            </option>
                                                                            <template v-for="(value, key) in list">
                                                                                <option v-bind:value="value.id">
                                                                                    @{{ value.ten_cong_ty }}
                                                                                </option>
                                                                            </template>
                                                                        </select>
                                                                        {{-- <select v-else class="form-control"
                                                                            v-model="hoa_don.id_khach_hang" disabled>
                                                                            <option value="0">Chọn nhà cung cấp
                                                                            </option>
                                                                            <template v-for="(value, key) in list_khach">
                                                                                <option v-bind:value="value.id">
                                                                                    @{{ value.ten_cong_ty }}
                                                                                </option>
                                                                            </template>
                                                                        </select> --}}
                                                                    </th>
                                                                    <th class="align-middle">
                                                                        <button class="btn btn-primary">Xác Nhận</button>
                                                                    </th>
                                                                    <th class="text-center align-middle">Tổng Tiền</th>
                                                                    <td class="text-start align-middle" colspan="2">
                                                                        <p><b>@{{ number_format(tong_tien) }}</b></p>
                                                                        <p><i
                                                                                class="text-capitalize">@{{ tien_chu }}</i>
                                                                        </p>
                                                                    </td>

                                                                </tr>
                                                                <tr class="table-primary">
                                                                    <th class="text-center">
                                                                        <button class="btn btn-danger"
                                                                            v-on:click="multiDelBill()">
                                                                            <i class="fa-solid fa-trash-can"></i>
                                                                        </button>
                                                                    </th>
                                                                    <th class="text-center">Tên Món</th>
                                                                    <th class="text-center" style="width: 15%;">Số Lượng Nhập
                                                                    </th>
                                                                    <th class="text-center">Đơn Giá Nhập</th>
                                                                    <th class="text-center">Thành Tiền</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(value, key) in list_detail">
                                                                    <th class="align-middle text-center">
                                                                        <input type="checkbox" v-model="value.check">

                                                                    </th>
                                                                    <td class="align-middle text-center">
                                                                        @{{ value.ten_mon_an }}</td>
                                                                    <td class="align-middle text-center">
                                                                        <input v-on:change="updateBill(value)"
                                                                            v-model="value.so_luong_nhap"
                                                                            type="number"
                                                                            class="form-control text-center"
                                                                            step="0.1" min="0.1">
                                                                    </td>
                                                                    <td class="align-middle text-center">
                                                                        <input v-on:change="updateBill(value)"
                                                                            v-model="value.don_gia_nhap" type="number"
                                                                            class="form-control text-center"
                                                                            min="0">
                                                                    </td>
                                                                    <td class="align-middle text-center">
                                                                        @{{ number_format(value.thanh_tien) }}</td>
                                                                    <td>
                                                                        <button v-on:click="destroy(value)" class="btn btn-outline-danger">Xóa Bỏ</button>
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
                                    <button type="button" class="btn btn-success">Nhập Hàng</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
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
                    list                : [],
                    list_mon            : [],
                    del_nha_cung_cap    : {},
                    add_nha_cung_cap    : {
                        'ma_so_thue': '',
                        'ten_cong_ty': '',
                        'ten_nguoi_dai_dien': '',
                        'so_dien_thoai': '',
                        'email': '',
                        'dia_chi': '',
                        'ten_goi_nho': '',
                        'tinh_trang': -1
                    },
                    edit_nha_cung_cap   : {
                        'ma_so_thue': '',
                        'ten_cong_ty': '',
                        'ten_nguoi_dai_dien': '',
                        'so_dien_thoai': '',
                        'email': '',
                        'dia_chi': '',
                        'ten_goi_nho': ''
                    },
                    key_search          : '',
                    order_by            : '',
                    id_hd_nhap          : 0,
                    list_detail         : [],
                    tong_tien           : 0,
                    tien_chu            : '',
                },
                created() {
                    this.loadData();
                    this.loadDanhSachMon();
                },
                methods: {
                    multiAdd() {
                        var payload = {
                            'list_mon'              : this.list_mon,
                            'id_hoa_don_nhap_hang'  : this.id_hd_nhap
                        }
                        axios
                            .post('{{ Route("multi-add-bill") }}', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                                this.loadDanhSachMonTheoHoaDonNhap(this.id_hd_nhap);
                                this.loadDanhSachMon();
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    multiDelBill() {
                        var payload = {
                            'list_detail'           :   this.list_detail,
                            'id_hoa_don_nhap_hang'  :   this.id_hd_nhap
                        }
                        axios
                            .post('{{ Route("multi-delete-bill") }}', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                                this.loadDanhSachMonTheoHoaDonNhap(this.id_hd_nhap);
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    destroy(payload) {
                        axios
                            .post('{{ Route("xoa-hang") }}', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadDanhSachMonTheoHoaDonNhap(payload.id_hoa_don_nhap_hang);
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
                    updateBill(payload) {
                        axios
                            .post('/admin/nhap-hang/update', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadDanhSachMonTheoHoaDonNhap(payload.id_hoa_don_nhap_hang);
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
                    getIdHoaDonNhap(id_nha_cc) {
                        var payload = {
                            'id_nha_cc'    : id_nha_cc
                        }
                        axios
                            .post('/admin/nhap-hang/find-id-hoa_don_nhap', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    this.id_hd_nhap = res.data.id_hoa_don_nhap;
                                    this.loadDanhSachMonTheoHoaDonNhap(this.id_hd_nhap);
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
                    loadDanhSachMonTheoHoaDonNhap(id_hd_nhap) {
                        var payload = {
                            'id_hoa_don_nhap_hang' : id_hd_nhap
                        }
                        axios
                            .post('{{ Route("load-mon-theo-hoa-don-nhap") }}', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    this.list_detail = res.data.data;
                                    this.tong_tien   = res.data.tong_tien;
                                    this.tien_chu    = res.data.tien_chu;
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
                    nhapHangtoBill(id_mon) {
                        var payload = {
                            'id_mon'        : id_mon,
                            'id_hd_nhap'    : this.id_hd_nhap
                        }
                        axios
                            .post('{{ Route("nhap-hang") }}', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                                this.loadDanhSachMonTheoHoaDonNhap(this.id_hd_nhap);
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },
                    taoHoaDonNhapHang(id_nha_cc) {
                        var payload = {
                            'id_nha_cc' : id_nha_cc
                        }
                        axios
                            .post('{{ Route("tao-hoa-don") }}', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.id_hd_nhap = res.data.id_hd_nhap;
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
                    multiDel() {
                        var payload = {
                            'list': this.list
                        }
                        axios
                            .post('/admin/nha-cung-cap/multi-delete', payload)
                            .then((res) => {
                                if (res.data.status) {
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
                    addNhaCungCap() {
                        $('.add').prop('disabled', true);
                        axios
                            .post('/admin/nha-cung-cap/create', this.add_nha_cung_cap)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                    this.add_nha_cung_cap = {
                                        'ma_so_thue': '',
                                        'ten_cong_ty': '',
                                        'ten_nguoi_dai_dien': '',
                                        'so_dien_thoai': '',
                                        'email': '',
                                        'dia_chi': '',
                                        'ten_goi_nho': '',
                                        'tinh_trang': 1
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
                                    toastr.error(value[0]);
                                });
                                $('.add').removeAttr('disabled');
                            });
                    },
                    checkAddMST() {
                        axios
                            .post('/admin/nha-cung-cap/check-ma-so-thue', this.add_nha_cung_cap)
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
                            .post('/admin/nha-cung-cap/update', this.edit_nha_cung_cap)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                    $('#updateModal').modal('hide');
                                } else if (res.data.status == 0) {
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
                    checkEditMST() {
                        axios
                            .post('/admin/nha-cung-cap/check-ma-so-thue', this.edit_nha_cung_cap)
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
                            .post('/admin/nha-cung-cap/delete', this.del_nha_cung_cap)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, 'Error');
                                }
                            });
                    },
                    loadData() {
                        axios
                            .get('/admin/nha-cung-cap/data')
                            .then((res) => {
                                this.list = res.data.nhaCungCap;
                            });
                    },
                    changeStatus(nhaCungCap) {
                        axios
                            .post('/admin/nha-cung-cap/doi-trang-thai', nhaCungCap)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, 'Error');
                                }
                            })
                    },
                    number_format(number) {
                        return new Intl.NumberFormat('vi-VI', {
                            style: 'currency',
                            currency: 'VND'
                        }).format(number);
                    },
                },
            });
        });
    </script>
@endsection
