@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-5">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="text-center text-primary fw-bold">Thêm mới quyền</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                      <label class="form-label fw-bold">Tên Quyền</label>
                      <input v-model="add.ten_quyen" type="text" class="form-control" placeholder="Nhập vào tên quyên..." >
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" v-on:click="createQuyen()">Thêm mới</button>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="text-center text-primary fw-bold">Danh sách quyền</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="align-middle">Tìm Kiếm</th>
                                    <td colspan="1">
                                        <input type="text" class="form-control" v-model="key_search" v-on:keyup.enter="search()">
                                    </td>
                                    <td class="text-start">
                                        <button class="btn btn-outline-primary" v-on:click="search()">Tìm Kiếm</button>
                                    </td>
                                </tr>
                                <tr class="table-primary">
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tên Quyền</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list">
                                    <tr>
                                        <th class="text-center align-middle">@{{ key + 1 }}</th>
                                        <td class="text-center align-middle">@{{ value.ten_quyen }}</td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button class="btn btn-inverse-success fw-bold" data-bs-toggle="modal"data-bs-target="#roleModal" v-on:click="edit = Object.assign({}, value), getPhanQuyenDetail(value.list_id_quyen)">Cấp quyền</button>
                                            <button class="btn btn-outline-primary" v-on:click="edit = value" data-bs-toggle="modal"data-bs-target="#updateModal">Cập nhật</button>
                                            <button class="btn btn-outline-danger" v-on:click="del = value" data-bs-toggle="modal"data-bs-target="#deleteModal">Xóa bỏ</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        {{-- Modal Delete --}}
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel">Xác nhận xóa</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-primary" role="alert">
                                            <p>Bạn có chắc chắn muốn xoá quyền <b class="text-danger">@{{del.ten_quyen}}</b> này không?</p>
                                            <p><b>Lưu ý:</b> Thao tác này sẽ không thể hoàn tác</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn btn-danger" v-on:click="delQuyen()">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Modal Update --}}
                        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">Cập Nhật Quyền</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tên Quyền</label>
                                            <input v-model="edit.ten_quyen" type="text" class="form-control">
                                          </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" v-on:click="updateQuyen()" class="btn btn-primary">Cập Nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Role Delete --}}
                        <div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card border-primary border-bottom border-3 border-0">
                                            <div class="card-header">
                                                <h1 class="modal-title fs-5 text-primary text-center" id="exampleModalLabel">Cấp quyền cho <b class="text-danger">@{{ edit.ten_quyen }}</b></h1>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <template v-for="(value, key) in list_chuc_nang">
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" v-model="array_quyen" type="checkbox" v-bind:value="value.id" v-bind:id="'quyen_' + value.id">
                                                                <span>@{{ value.id }}</span>
                                                                <label class="form-check-label" v-bind:for="'quyen_' +  value.id">@{{ value.ten_chuc_nang }}</label>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="text-center">
                                                    <button class="btn btn-primary" v-on:click="phanQuyen()" style="width: 95%">Cấp Quyền</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                el      :   '#app',
                data    :   {
                    add:    {},
                    list:   [],
                    del:    {},
                    edit:   {},
                    key_search: '',
                    list_chuc_nang: [],
                    array_quyen: []

                },
                created()   {
                    this.loadData();
                    this.loadDataQuyen();
                },
                methods :   {
                    phanQuyen() {
                        var payload = {
                            'id_quyen'          : this.edit.id,
                            'list_phan_quyen'   : this.array_quyen,
                        };
                        axios
                            .post('/admin/quyen/phan-quyen', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message);
                                    this.loadData();
                                    $('#roleModal').modal('hide');

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
                    getPhanQuyenDetail(list_rule) {
                        if (list_rule) {
                            if (list_rule.indexOf(","))
                                this.array_quyen = list_rule.split(",");
                            else {
                                this.array_quyen.push(list_rule);
                            }
                        } else {
                            this.array_quyen = [];
                        }
                    },
                    loadDataQuyen() {
                        axios
                            .get('/admin/quyen/data-chuc-nang')
                            .then((res) => {
                                this.list_chuc_nang  =  res.data.data;
                            });
                    },
                    search() {
                        var payload = {
                            'key_search' : this.key_search
                        };
                        axios
                            .post('/admin/quyen/search', payload)
                            .then((res) => {
                                if(res.data.status) {
                                    this.list = res.data.list;
                                } else {
                                    toastr.error(res.data.message, 'Error');
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(key, value) {
                                    toastr.error(value[0]);
                                });
                            });
                    },
                    updateQuyen() {
                        axios
                            .post('/admin/quyen/update', this.edit)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.loadData();
                                    $('#updateModal').modal('hide');
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

                    delQuyen() {
                        axios
                            .post('/admin/quyen/delete', this.del)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    $('#deleteModal').modal('hide');
                                    this.loadData();
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
                    loadData() {
                        axios
                            .get('/admin/quyen/data')
                            .then((res) => {
                                this.list = res.data.list;
                            });
                    },
                    createQuyen() {
                        axios
                            .post('/admin/quyen/create', this.add)
                            .then((res) => {
                                if(res.data.status) {
                                    toastr.success(res.data.message, 'Success');
                                    this.add = {};
                                } else {
                                    toastr.error(res.data.message);
                                }
                                this.loadData();
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    },

                },
            });
        });
    </script>
@endsection
