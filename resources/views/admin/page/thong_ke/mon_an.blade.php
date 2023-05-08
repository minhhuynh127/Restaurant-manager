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
                            <button v-on:click="thongKeMonAn()" class="btn btn-success">
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
                                    <th class="text-center align-middle">Tên Món Ăn</th>
                                    <th class="text-center align-middle">Số Lượng</th>
                                    <th class="text-center align-middle">Tổng Tiền</th>
                                    <th class="text-center align-middle">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, key) in list_mon_an">
                                    <th class="align-middle">@{{ key + 1 }}</th>
                                    <td class="align-middle">@{{ value.ten_mon_an }}</td>
                                    <td class="text-center align-middle">@{{ value.tong_so_luong_ban }}</td>
                                    <td class="align-middle">@{{ number_format(value.tong_tien_thanh_toan) }}</td>
                                    <td class="text-center align-middle">
                                        <button v-on:click="chiTietMonAn(value)" class="btn btn-primary">Xem Chi Tiết</button>
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
                    <h6 class="text-primary text-center fw-bold mb-0">Chi Tiết Hóa Đơn</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 300px">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-primary">
                                    <th class="text-center align-middle">#</th>
                                    <th class="text-center align-middle">Bàn Đã Bán</th>
                                    <th class="text-center align-middle">Khu Vực</th>
                                    <th class="text-center align-middle">Số Luọng</th>
                                    <th class="text-center align-middle">Tổng Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, key) in list_chi_tiet">
                                    <th class="text-center">@{{ key + 1 }}</th>
                                    <td class="text-center">@{{ value.ten_ban }}</td>
                                    <td class="text-center">@{{ value.ten_khu }}</td>
                                    <td class="text-center">@{{ value.tong_so_luong }}</td>
                                    <td class="text-center">@{{ number_format(value.tong_tien_thanh_toan) }}</td>
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
                    thong_ke    :   {},
                    list_mon_an :   [],
                    list_chi_tiet:  []
                },
                created()   {

                },
                methods :   {
                    thongKeMonAn() {
                        axios
                            .post('{{ Route("thong-ke-mon-an") }}', this.thong_ke)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.list_mon_an = res.data.data;
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
                    chiTietMonAn(payload) {
                        payload.begin = this.thong_ke.begin;
                        payload.end = this.thong_ke.end;
                        axios
                            .post('{{ Route("chi-tiet-mon-an") }}', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    this.list_chi_tiet = res.data.data;
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
