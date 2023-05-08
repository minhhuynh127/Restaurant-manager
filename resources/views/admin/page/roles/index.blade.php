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
                    <div class="mb-3">
                        <label class="form-label fw-bold">List ID Quyền</label>
                        <input v-model="add.list_id_quyen" type="text" class="form-control" placeholder="Nhập vào list id quyên..." >
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
                    <div class="table-response">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="align-middle">Tìm Kiếm</th>
                                    <td colspan="2">
                                        <input type="text" class="form-control" v-model="key_search" v-on:keyup.enter="search()">
                                    </td>
                                    <td class="text-start">
                                        <button class="btn btn-outline-primary" v-on:click="search()">Tìm Kiếm</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tên Quyền</th>
                                    <th class="text-center">List ID Quyền</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, key) in list">
                                    <th class="text-center align-middle">@{{ key + 1 }}</th>
                                    <td class="text-center align-middle">@{{ value.ten_quyen }}</td>
                                    <td class="text-center align-middle">@{{ value.list_id_quyen }}</td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-outline-primary" v-on:click="edit = value" data-bs-toggle="modal"data-bs-target="#updateModal">Cập nhật</button>
                                        <button class="btn btn-outline-danger" v-on:click="del = value" data-bs-toggle="modal"data-bs-target="#deleteModal">Xóa bỏ</button>
                                    </td>
                                </tr>
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
                                          <div class="mb-3">
                                              <label class="form-label fw-bold">List ID Quyền</label>
                                              <input v-model="edit.list_id_quyen" type="text" class="form-control">
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

                },
                created()   {
                    this.loadData();
                },
                methods :   {
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
