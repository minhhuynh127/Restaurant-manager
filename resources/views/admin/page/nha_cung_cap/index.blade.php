@extends('admin.share.master')
@section('noi_dung')
    <div class="row">
        <div class="col-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h3 class="text-primary">Thêm nhà cung cấp</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Mã số thuê</label>
                        <input type="text" class="form-control" id="add_ma_so_thue">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Tên công ty</label>
                        <input type="text" class="form-control" id="add_ten_cong_ty">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Tên người đại diện</label>
                        <input type="text" class="form-control" id="adđ_ten_nguoi_dai_dien">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Số điện thoại</label>
                        <input type="text" class="form-control" id="add_so_dien_thoai">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Email</label>
                        <input type="text" class="form-control" id="add_email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Địa chỉ</label>
                        <input type="text" class="form-control" id="add_dia_chi">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label fw-bold">Tên gợi nhớ</label>
                        <input type="text" class="form-control" id="add_ten_goi_nho">
                    </div>
                    <div class="form-group mb-3">
                        <select class="form-control" id="add_tinh_trang">Tình trạng
                            <option value="-1">Vui lòng chọn tình trạng</option>
                            <option value="1">Hiển thị</option>
                            <option value="0">Tạm tắt</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" id="add">Thêm mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header text-primary fw-bold">
                    Danh Sách Nhà Cung Cấp
                </div>
                <div class="card-body overflow-scroll">
                    <table class="table table-bordered" id="listNhaCungCap">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Thông Tin Công Ty</th>
                                <th class="text-center">Thông Tin Liên Hệ</th>
                                <th class="text-center">Tình Trạng</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <!-- Modal delete-->
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel">Xác nhận xóa dữ liệu
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" class="form-control" id="id_delete">
                                    <div class="alert alert-danger" role="alert">
                                        Bạn chắc chắn muốn xóa dữ liệu bàn này!. Việc này không thể thay đổi, hãy cẩn
                                        thận!.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="accpect_delete" class="btn btn-danger"
                                        data-bs-dismiss="modal" aria-label="Close">Xác nhận xóa</button>
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
                                    <h1 class="modal-title fw-bolde text-primary" id="exampleModalLabel">Cập nhật dữ
                                        liệu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" class="form-control" id="id_edit">
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Mã số thuê</label>
                                        <input type="text" class="form-control" id="edit_ma_so_thue">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Tên công ty</label>
                                        <input type="text" class="form-control" id="edit_ten_cong_ty">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Tên người đại diện</label>
                                        <input type="text" class="form-control" id="edit_ten_nguoi_dai_dien">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Số điện thoại</label>
                                        <input type="text" class="form-control" id="edit_so_dien_thoai">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Email</label>
                                        <input type="text" class="form-control" id="edit_email">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Địa chỉ</label>
                                        <input type="text" class="form-control" id="edit_dia_chi">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="form-label fw-bold">Tên gợi nhớ</label>
                                        <input type="text" class="form-control" id="edit_ten_goi_nho">
                                    </div>
                                    <div class="form-group mb-3">
                                        <select class="form-control" id="edit_tinh_trang">Tình trạng
                                            <option value="-1">Vui lòng chọn tình trạng</option>
                                            <option value="1">Hiển thị</option>
                                            <option value="0">Tạm tắt</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary"
                                        id="accpect_update">Cập nhật</button>
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
            //loadData
            loadData();

            function loadData() {
                axios
                    .get('/admin/nha-cung-cap/data')
                    .then((res) => {
                        var nhaCungCap = res.data.nhaCungCap;
                        var code = '';
                        $.each(nhaCungCap, function(key, value) {
                            code += '<tr>';
                            code += '<th class="text-center align-middle">' + (key + 1) + '</th>';
                            code += '<td class="align-middle">';
                            code += '<table class="table table-bordered">';
                            code += '<tr>';
                            code += '<th class="text-nowrap text-center">Mã số thuế</th>';
                            code += '<td class="text-nowrap text-center">' + value.ma_so_thue + '</td>';
                            code += '</tr>';
                            code += '<tr>';
                            code += '<th class="text-nowrap text-center">Địa chỉ</th>';
                            code += '<td class="text-nowrap text-center">' + value.dia_chi + '</td>';
                            code += '</tr>';
                            code += '<tr>';
                            code += '<th class="text-nowrap text-center">Tên công ty</th>';
                            code += '<td class="text-nowrap text-center">' + value.ten_cong_ty + '</td>';
                            code += '</tr>';
                            code += '</table>';
                            code += '</td>';
                            code += '<td class="align-middle">';
                            code += '<table class="table table-bordered">';
                            code += '<tr>';
                            code += '<th class="text-nowrap text-center">Tên liên hệ</th>';
                            code += '<td class="text-nowrap text-center">' + value.ten_nguoi_dai_dien + '</td>';
                            code += '</tr>';
                            code += '<tr>';
                            code += '<th class="text-nowrap text-center">Số điện thoại</th>';
                            code += '<td class="text-nowrap text-center">' + value.so_dien_thoai + '</td>';
                            code += '</tr>';
                            code += '<tr>';
                            code += '<th class="text-nowrap text-center">Email</th>';
                            code += '<td class="text-nowrap text-center">' + value.email + '</td>';
                            code += '</tr>';
                            code += '<tr>';
                            code += '<th class="text-nowrap text-center">Tên gợi nhớ</th>';
                            code += '<td class="text-nowrap text-center">' + value.ten_goi_nho + '</td>';
                            code += '</tr>';
                            code += ' </table>';
                            code += '</td>';
                            code += '<td class="text-center align-middle text-nowrap">';
                            if (value.tinh_trang) {
                                code += '<button data-id ="' + value.id +
                                    '" class="btn btn-success doi-trang-thai">Hiển thị</button>';
                            } else {
                                code += '<button data-id ="' + value.id +
                                    '" class="btn btn-warning doi-trang-thai">Tạm Tắt</button>';
                            }
                            code += '</td>';
                            code += '<td class="text-center align-middle text-nowrap">';
                                code += '<button data-id="' + value.id +
                                '" class="edit btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Cập nhật</button>'
                            code += '<button data-id="' + value.id +
                                '" class="delete btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa Bỏ</button>'
                            code += '</td>';
                            code += '</tr>';
                        });
                        $('#listNhaCungCap tbody').html(code);
                    });
            }
            // Add
            $('body').on('click', '#add', function() {
                $('#add').prop('disabled', true);
                var ma_so_thue = $('#add_ma_so_thue').val();
                var ten_cong_ty = $('#add_ten_cong_ty').val();
                var ten_nguoi_dai_dien = $('#adđ_ten_nguoi_dai_dien').val();
                var so_dien_thoai = $('#add_so_dien_thoai').val();
                var email = $('#add_email').val();
                var dia_chi = $('#add_dia_chi').val();
                var ten_goi_nho = $('#add_ten_goi_nho').val();
                var tinh_trang = $('#add_tinh_trang').val();
                var payload = {
                    'ma_so_thue': ma_so_thue,
                    'ten_cong_ty': ten_cong_ty,
                    'ten_nguoi_dai_dien': ten_nguoi_dai_dien,
                    'so_dien_thoai': so_dien_thoai,
                    'email': email,
                    'dia_chi': dia_chi,
                    'ten_goi_nho': ten_goi_nho,
                    'tinh_trang': tinh_trang
                };
                axios
                    .post('/admin/nha-cung-cap/create', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, 'Warning');
                        }
                        $('#add_ma_so_thue').val('');
                        $('#add_ten_cong_ty').val('');
                        $('#add_ten_nguoi_dai_dien').val(0);
                        $('#add_so_dien_thoai').val('');
                        $('#add_email').val('');
                        $('#add_dia_chi').val('');
                        $('#add_email').val('');
                        $('#add_ten_goi_nho').val('');
                        $('#add_tinh_trang').val(-1);
                        $('#add').removeAttr('disabled');
                    });
            });

            // Đổi trạng thái
            $('body').on('click', '.doi-trang-thai', function() {
                var id = $(this).data('id');
                var payload = {
                    'id': id
                }
                axios
                    .post('/admin/nha-cung-cap/doi-trang-thai', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                        }
                    });
            });

            $('#add').prop('disabled', true);
            // Check mã số thuê
            $('body').on('blur', '#add_ma_so_thue', function() {
                var ma_so_thue = $('#add_ma_so_thue').val();
                var payload = {
                    'ma_so_thue': ma_so_thue
                }
                axios
                    .post('/admin/nha-cung-cap/check-ma-so-thue', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, 'Success');
                            $('#add').removeAttr('disabled');
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                            $('#add').prop('disabled', true);
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, 'Warning');
                        }
                    });
            })

            // Xóa
            $('body').on('click', '.delete', function() {
                var id = $(this).data('id');
                $('#id_delete').val(id);
            });
            // Accpect delete
            $('body').on('click', '#accpect_delete', function() {
                var id = $('#id_delete').val();
                var payload = {
                    'id': id
                }
                axios
                    .post('/admin/nha-cung-cap/delete', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                        }
                    });
            });

            // Lấy dữ liệu edit
            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');
                $('#id_edit').val(id);
                var payload = {
                    'id': id
                }
                axios
                    .post('/admin/nha-cung-cap/edit', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.warning(res.data.message, 'Warning');
                            $('#id_edit').val(res.data.nhaCungCap.id)
                            $('#edit_ma_so_thue').val(res.data.nhaCungCap.ma_so_thue);
                            $('#edit_ten_cong_ty').val(res.data.nhaCungCap.ten_cong_ty);
                            $('#edit_ten_nguoi_dai_dien').val(res.data.nhaCungCap.ten_nguoi_dai_dien);
                            $('#edit_so_dien_thoai').val(res.data.nhaCungCap.so_dien_thoai);
                            $('#edit_email').val(res.data.nhaCungCap.email);
                            $('#edit_dia_chi').val(res.data.nhaCungCap.dia_chi);
                            $('#edit_ten_goi_nho').val(res.data.nhaCungCap.ten_goi_nho);
                            $('#edit_tinh_trang').val(res.data.nhaCungCap.tinh_trang);
                        } else {
                            toastr.error(res.data.message, 'Error');
                        }
                    });
            });

            // Update dữ liệu
            $('body').on('click', '#accpect_update', function() {
                var id          = $('#id_edit').val();
                var ma_so_thue     = $('#edit_ma_so_thue').val();
                var ten_cong_ty    = $('#edit_ten_cong_ty').val();
                var ten_nguoi_dai_dien  = $('#edit_ten_nguoi_dai_dien').val();
                var so_dien_thoai  = $('#edit_so_dien_thoai').val();
                var email    = $('#edit_email').val();
                var dia_chi    = $('#edit_dia_chi').val();
                var ten_goi_nho    = $('#edit_ten_goi_nho').val();
                var tinh_trang  = $('#edit_tinh_trang').val();
                var payload = {
                    'id'                    : id,
                    'ma_so_thue'            : ma_so_thue,
                    'ten_cong_ty'           : ten_cong_ty,
                    'ten_nguoi_dai_dien'    : ten_nguoi_dai_dien,
                    'so_dien_thoai'         : so_dien_thoai,
                    'email'                 : email,
                    'dia_chi'               : dia_chi,
                    'ten_goi_nho'           : ten_goi_nho,
                    'tinh_trang'            : tinh_trang,
                };
                axios
                    .post('/admin/nha-cung-cap/update', payload)
                    .then((res) => {
                        if(res.data.status) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                            $('#updateModal').modal('hide');
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                        }
                    });
            });

            // Check slug khi blur
             $('body').on('blur', '#edit_ma_so_thue', function() {
                var ma_so_thue = $('#edit_ma_so_thue').val();
                var payload = {
                    'ma_so_thue'  : ma_so_thue,
                    'id'        : $('#id_edit').val()
                }
                axios
                    .post('/admin/nha-cung-cap/check-ma-so-thue', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, 'Success');
                            $('#accpect_update').removeAttr('disabled');
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                            $('#accpect_update').prop('disabled', true);
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, 'Warning');
                        }
                    });
            });

            // Disabled nút edit
            $('body').on('keyup', '#edit_ma_so_thue', function() {
                $('#accpect_update').prop('disabled', true);
            });

        });
    </script>
@endsection
