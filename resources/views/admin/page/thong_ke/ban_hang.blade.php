@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-3 mt-4">
                            <h6>Thống Kê</h6>
                        </div>
                        <div class="col-3">

                        </div>
                        <div class="col">
                            <h6>Từ Ngày</h6>
                            <input v-model="thong_ke.begin" type="date" class="form-control">
                        </div>
                        <div class="col">
                            <h6>Đến Ngày</h6>
                            <input v-model="thong_ke.end" type="date" class="form-control">
                        </div>
                        <div class="col mt-4">
                            <button v-on:click="thongKeBanHang()" class="btn btn-success">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h6 class="text-primary text-center fw-bold mb-0">Hóa Đơn Bán Hàng</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 300px">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-primary">
                                    <th class="text-center align-middle">#</th>
                                    <th class="text-center align-middle">Ngày Háo Đơn</th>
                                    <th class="text-center align-middle">Giảm Giá</th>
                                    <th class="text-center align-middle">Tổng Tiển</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, key) in list_hoa_don">
                                    <th class="text-center align-middle">@{{ key + 1 }}</th>
                                    <td class="text-center align-middle">@{{ date_format(value.ngay_thanh_toan) }}</td>
                                    <td class="text-center align-middle">@{{ number_format(value.giam_gia) }}</td>
                                    <td class="text-center align-middle">@{{ number_format(value.tong_tien) }}</td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-primary" v-on:click="chiTietHoaDon(value)">Xem Chi Tiết</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h6 class="text-center text-primary fw-bold mb-0">Chi Tiết Hóa Đơn</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-primary">
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tên Món</th>
                                    <th class="text-center">Số Lượng Bán</th>
                                    <th class="text-center">Đơn Giá Bán</th>
                                    <th class="text-center">Chiết Khẩu</th>
                                    <th class="text-center">Thành Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, key) in list_chi_tiet">
                                    <th>@{{ key + 1 }}</th>
                                    <td>@{{ value.ten_mon_an }}</td>
                                    <td class="text-center">@{{ value.so_luong_ban }}</td>
                                    <td class="text-end">@{{ number_format(value.don_gia_ban) }}</td>
                                    <td class="text-end">@{{ number_format(value.tien_chiet_khau) }}</td>
                                    <td class="text-end">@{{ number_format(value.thanh_tien) }}</td>
                                </tr>
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
                el      :   '#app',
                data    :   {
                    thong_ke        :   {},
                    list_hoa_don    :   [],
                    list_chi_tiet   :   [],
                },
                created()   {

                },
                methods :   {
                    thongKeBanHang() {
                        axios
                            .post('{{ Route("thong-ke-ban-hang") }}', this.thong_ke)
                            .then((res) => {
                                if(res.data.status) {
                                    console.log(res.data.data);
                                    toastr.success(res.data.message, 'Success');
                                    this.list_hoa_don = res.data.data;
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
                    chiTietHoaDon(payload) {
                        axios
                            .post('{{ Route("danh-sach-mon-thong-ke") }}', payload)
                            .then((res) => {
                                this.list_chi_tiet = res.data.data;
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
                    date_format(now) {
                        return moment(now).format('HH:mm:ss DD/MM/yyyy');
                    },

                },
            });
        });
    </script>
@endsection
