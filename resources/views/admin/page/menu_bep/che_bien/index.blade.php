@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="card border-primary border-bottom border-3 border-0">
            <div class="card-header">
                <h3 class="fw-bold text-primary text-center">Menu Bếp - Chế Biến</h3>
            </div>
            <div class="card-body">
                <div class="table-responseve">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-primary">
                                <th class="text-center text-nowrap align-middle">
                                    <button class="btn btn-success" v-on:click="multiCheBien()">
                                        <i class="fa-solid fa-forward-fast"></i>
                                    </button>
                                </th>
                                <th class="text-center text-nowrap align-middle">Tên Món Ăn</th>
                                <th class="text-center text-nowrap align-middle">Số Lượng</th>
                                <th class="text-center text-nowrap align-middle">Tên Bàn</th>
                                <th class="text-center text-nowrap align-middle">Ghi Chú</th>
                                <th class="text-center text-nowrap align-middle">Thời Gian</th>
                                <th class="text-center text-nowrap align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, key) in list">
                                <tr>
                                    <th class="text-center text-nowrap align-middle">
                                        <input type="checkbox" v-model="value.check">
                                    </th>
                                    <td class="text-center text-nowrap align-middle">@{{ value.ten_mon_an }}</td>
                                    <td class="text-center text-nowrap align-middle">@{{ value.so_luong_ban }}</td>
                                    <td class="text-center text-nowrap align-middle">@{{ value.ten_ban }}</td>
                                    <td class="text-center text-nowrap align-middle">@{{ value.ghi_chu }}</td>
                                    <td class="text-center text-nowrap align-middle">@{{ date_format(value.created_at) }}</td>
                                    <td class="text-center text-nowrap align-middle">
                                        <template v-if="value.is_che_bien == 0">
                                            <button v-on:click="finishCheBien(value)" class="btn btn-primary">Đang chế
                                                biến</button>
                                        </template>
                                        <template v-else="value.is_che_bien == 1">
                                            <button class="btn btn-success" disabled>Chế biến xong</button>
                                        </template>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
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
                },
                created() {
                    setInterval(() => {
                        this.loadData();
                    }, 3000);
                },
                methods: {
                    multiCheBien() {
                        var payload = {
                            'list' : this.list
                        };
                        axios
                            .post('{{ Route("multi-che-bien") }}', payload)
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

                    finishCheBien(payload) {
                        console.log(payload);
                        axios
                            .post('/admin/menu-bep/che-bien/finish', payload)
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

                    loadData() {
                        axios
                            .get('/admin/menu-bep/che-bien/data')
                            .then((res) => {
                                if (res.data.status) {
                                    this.list = res.data.data;
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                            });
                    },
                    date_format(now) {
                        return moment(now).format('HH:mm:ss');
                    },
                },
            });
        });
    </script>
@endsection
