@extends('admin.share.master')
@section('noi_dung')
    <div class="row">
        <div class="col-5">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="card-title text-primary fw-bold">Thêm danh mục mới</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Tên danh mục</label>
                        <input id="add_ten_danh_muc" type="text" class="form-control">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Slug danh mục</label>
                        <input id="add_slug_danh_muc" type="text" class="form-control">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Tình trạng</label>
                        <select id="add_tinh_trang" class="form-control">
                            <option value="-1">Vui lòng chọn tên danh mục</option>
                            <option value="1">Hiển thị</option>
                            <option value="0">Không hiển thị</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary add">Thêm mới</button>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="card-title text-primary fw-bold">Danh sách danh mục</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="listDanhMuc">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tên Danh Mục</th>
                                <th class="text-center">Slug Danh Mục</th>
                                <th class="text-center">Tình trạng</th>
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
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận xóa dữ liệu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" class="form-control" id="id_delete">
                                    <div class="alert alert-primary" role="alert">
                                        Bạn chắc chắn sẽ xóa dữ liệu khu vực này!. Việc này không thể thay đổi, hãy cẩn
                                        thận.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="accpect_delete" class="btn btn-danger"
                                        data-bs-dismiss="modal" aria-label="Close">Xác nhận xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal update-->
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cập nhật danh mục</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="id_edit" class="form-control">
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Tên danh mục</label>
                                        <input type="text" class="form-control" id="edit_ten_danh_muc">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Tên danh mục</label>
                                        <input type="text" class="form-control" id="edit_slug_danh_muc">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Tình trạng</label>
                                        <select class="form-control" id="edit_tinh_trang">
                                            <option value="1">Hiển thị</option>
                                            <option value="0">Tạm tắt</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="accpect_update">Cập nhật</button>
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

            //Hàm xử lí chuỗi
            function toSlug(str) {
                // Chuyển hết sang chữ thường
                str = str.toLowerCase();

                // xóa dấu
                str = str
                    .normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
                    .replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp

                // Thay ký tự đĐ
                str = str.replace(/[đĐ]/g, 'd');

                // Xóa ký tự đặc biệt
                str = str.replace(/([^0-9a-z-\s])/g, '');

                // Xóa khoảng trắng thay bằng ký tự -
                str = str.replace(/(\s+)/g, '-');

                // Xóa ký tự - liên tiếp
                str = str.replace(/-+/g, '-');

                // xóa phần dư - ở đầu & cuối
                str = str.replace(/^-+|-+$/g, '');

                // return
                return str;
            }

            loadData();

            function loadData() {
                axios
                    .get('/admin/danh-muc/data')
                    .then((res) => {
                        $danhMucs = res.data.danhMucs;
                        var code = '';
                        $.each($danhMucs, function(key, value) {
                            code += '<tr>';
                            code += '<th class="text-center align-middle">' + (key + 1) + '</th>';
                            code += '<td class="text-center align-middle">' + (value.ten_danh_muc) +
                                '</td>';
                            code += '<td class="text-center align-middle">' + (value.slug_danh_muc) +
                                '</td>';
                            code += '<td class="text-center align-middle">';
                            if (value.tinh_trang) {
                                code += '<button data-iddm="' + value.id +
                                    '" class="doi-trang-thai btn btn-success">Hiển thị</button>'
                            } else {
                                code += '<button data-iddm="' + value.id +
                                    '" class="doi-trang-thai btn btn-warning">Tạm tắt</button>'
                            }
                            code += '</td>';
                            code += '<td class="text-center align-middle">';
                            code += '<button data-iddm="' + value.id +
                                '" class="edit btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Cập nhật</button>';
                            code += '<button data-iddm="' + value.id +
                                '" class="delete btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa bỏ</button>';
                            code += '</td>';
                            code += '</tr>';
                        });
                        $('#listDanhMuc tbody').html(code);
                    });
            }

            //Đổi trạng thái
            $("body").on('click', '.doi-trang-thai', function() {
                var id = $(this).data('iddm');
                console.log(id);
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/danh-muc/doi-trang-thai', payload)
                    .then((res) => {
                        // console.log(res.data);
                        if (res.data.status) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                        }
                    });
            });

            // Thêm mới
            $('.add').prop('disabled', true);
            $('body').on('click', '.add', function() {
                $('.add').prop('disabled', true);
                var ten_danh_muc = $('#add_ten_danh_muc').val();
                var slug_danh_muc = $('#add_slug_danh_muc').val();
                var tinh_trang = $('#add_tinh_trang').val();
                var payload = {
                    'ten_danh_muc': ten_danh_muc,
                    'slug_danh_muc': slug_danh_muc,
                    'tinh_trang': tinh_trang
                };
                axios
                    .post('/admin/danh-muc/create', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, 'Warning');
                        }
                        $('#add_ten_danh_muc').val('');
                        $('#add_slug_danh_muc').val('');
                        $('#add_tinh_trang').val(-1);
                        $('.add').removeAttr('disabled');
                    });
            });

            // Tự động thêm slug
            $('body').on('keyup', '#add_ten_danh_muc', function() {
                var slug = toSlug($(this).val());
                $('#add_slug_danh_muc').val(slug);
            });

            // Check slug
            $('body').on('blur', '#add_ten_danh_muc', function() {
                var slug = toSlug($(this).val());
                var payload = {
                    'slug_danh_muc': slug
                };
                axios
                    .post('/admin/danh-muc/check-slug', payload)
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
            });

            //  Lấy dữ liệu xóa
            $("body").on('click', '.delete', function() {
                var id = $(this).data('iddm');
                $('#id_delete').val(id);
            });
            // Xóa dữ liệu
            $("body").on('click', '#accpect_delete', function() {
                var id = $('#id_delete').val();
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/danh-muc/delete', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, 'Warning');
                        }
                    });
            });

            // Lấy dữ liệu edit
            $("body").on('click', '.edit', function() {
                var id = $(this).data('iddm');
                $('#id_edit').val(id);
                var payload = {
                    'id': id
                }
                axios
                    .post('/admin/danh-muc/edit', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.warning(res.data.message, 'Success');
                            $('#id_edit').val(res.data.danhMuc.id);
                            $('#edit_ten_danh_muc').val(res.data.danhMuc.ten_danh_muc);
                            $('#edit_slug_danh_muc').val(res.data.danhMuc.slug_danh_muc);
                            $('#edit_tinh_trang').val(res.data.danhMuc.tinh_trang);
                        } else {
                            toastr.error(res.data.message, 'Error');
                        }
                    });
            });

            // Edit dữ liệu
            $('body').on('click', '#accpect_update', function() {
                var id = $('#id_edit').val();
                var ten_danh_muc = $('#edit_ten_danh_muc').val();
                var slug_danh_muc = $('#edit_slug_danh_muc').val();
                var tinh_trang = $('#edit_tinh_trang').val();
                var payload = {
                    'id': id,
                    'ten_danh_muc': ten_danh_muc,
                    'slug_danh_muc': slug_danh_muc,
                    'tinh_trang': tinh_trang
                };
                axios
                    .post('/admin/danh-muc/update', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                            $('#updateModal').modal('hide');
                        } else {
                            toastr.error(res.data.message, 'Error');
                        }
                    });
            });

            // Thêm slug khi edit
            $('body').on('keyup', '#edit_ten_danh_muc', function() {
                $('#accpect_update').prop('disabled', true);
                var slug = toSlug($(this).val());
                $('#edit_slug_danh_muc').val(slug);
            });

            // Check slug khi edit
            $('body').on('blur', '#edit_ten_danh_muc', function() {
                var slug = toSlug($(this).val());
                var payload = {
                    'slug_danh_muc': slug,
                    'id': $('#id_edit').val()
                };
                axios
                    .post('/admin/danh-muc/check-slug', payload)
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
        })
    </script>
@endsection
