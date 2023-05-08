@extends('admin.share.master')
@section('noi_dung')
    <div class="row">
        <div class="col-5">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="card-title text-primary fw-bold">Thêm khu vực mới</h5>
                </div>
                <div class="card-body">
                        <div class="mb-3 form-group">
                            <label class="form-label fw-bold">Tên khu vực</label>
                            <input type="text" class="form-control" id="add_ten_khu">
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label fw-bold">Slug khu vực</label>
                            <input type="text" class="form-control" id="add_slug_khu">
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label fw-bold">Tình trạng</label>
                            <select class="form-control" id="add_tinh_trang">
                                <option value="-1">Vui lòng chọn tình trạng</option>
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
                    <h5 class="card-title text-primary fw-bold">Danh sách khu vực</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="listKhuVuc">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tên khu vực</th>
                                <th class="text-center">Slug khu vực</th>
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
                                    <button type="button" id="accpect_delete" class="btn btn-danger" data-bs-dismiss="modal"
                                    aria-label="Close">Xác nhận xóa</button>
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
                                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel ">Cập nhật dữ liệu</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="id_edit" class="form-control">
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Tên khu vực</label>
                                        <input type="text" class="form-control" id="edit_ten_khu">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Slug khu vực</label>
                                        <input type="text" class="form-control" id="edit_slug_khu">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Tình trạng</label>
                                        <select class="form-control" id="edit_tinh_trang">
                                            <option value="1">Hiển thị</option>
                                            <option value="0">Không hiển thị</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

            // Check slug cso tồn tại
            $('body').on('blur', '#add_ten_khu', function() {
                var slug = toSlug($(this).val());
                var payload = {
                    'slug_khu' : slug
                }
                axios
                    .post('/admin/khu-vuc/check-slug', payload)
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

            // Tự dộng thêm slug bàn khi nhập tên bàn
            $('body').on('keyup', '#add_ten_khu', function() {
                var slug = toSlug($(this).val());
                $('#add_slug_khu').val(slug);
            });

            loadData();
            function loadData() {
                axios
                    .get('/admin/khu-vuc/data')
                    .then((res) => {
                        var list = res.data.list;
                        var code = '';
                        $.each(list, function(key, value) {
                            code += '<tr>'
                            code += '<th class="text-center align-middle">' + (key + 1) + '</th>';
                            code += '<td class="align-middle text-center">' + (value.ten_khu) + '</td>';
                            code += '<td class="align-middle text-center">' + (value.slug_khu) + '</td>';
                            code += '<td class="align-middle text-center">';
                            if (value.tinh_trang) {
                                code += '<button data-idkv="' + value.id +
                                    '" class="doi-trang-thai btn btn-success">Hiển thị</button>';
                            } else {
                                code += '<button data-idkv="' + value.id +
                                    '" class="doi-trang-thai btn btn-warning">Tạm tắt</button>';
                            }
                            code += '</td>';
                            code += '<td class="align-middle text-center">';
                            code += '<button data-idkv="' + value.id +
                                '" class="edit btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Cập nhật</button>';
                            code +=
                                '<button data-idkv="' + value.id +
                                '" class="delete btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa bỏ</button>';
                            code += '</td>';
                            code += '</tr>';
                        });
                        $('#listKhuVuc tbody').html(code);
                    });

            }

            // Đổi trạng thái
            $("body").on('click', '.doi-trang-thai', function() {
                var id = $(this).data('idkv');
                console.log(id);
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/khu-vuc/doi-trang-thai', payload)
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

             // Add
            $('.add').prop('disabled', true);
            $('body').on('click', '.add', function() {
                $('.add').prop('disabled', true);
                var ten_khu = $('#add_ten_khu').val();
                var slug_khu = $('#add_slug_khu').val();
                var tinh_trang = $('#add_tinh_trang').val();
                var payload = {
                    'ten_khu' : ten_khu,
                    'slug_khu' : slug_khu,
                    'tinh_trang' : tinh_trang,
                };
                axios
                    .post('/admin/khu-vuc/create', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, 'Warning');
                        }
                        $('#add_ten_khu').val('');
                        $('#add_slug_khu').val('');
                        $('#add_tinh_trang').val(-1);
                        $('.add').removeAttr('disabled');
                    });
            });

            // Xóa
            $("body").on('click', '.delete', function() {
                var id = $(this).data('idkv');
                $('#id_delete').val(id);
            });

            $("body").on('click', '#accpect_delete', function() {
                var id = $('#id_delete').val();
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/khu-vuc/delete', payload)
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
                var id = $(this).data('idkv');
                var payload = {
                    'id': id
                }
                axios
                    .post('/admin/khu-vuc/edit', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.warning(res.data.message, 'Success');
                            $('#id_edit').val(res.data.khuVuc.id);
                            $('#edit_ten_khu').val(res.data.khuVuc.ten_khu);
                            $('#edit_slug_khu').val(res.data.khuVuc.slug_khu);
                            $('#edit_tinh_trang').val(res.data.khuVuc.tinh_trang);
                        } else {
                            toastr.error(res.data.message, 'Error');
                        }
                    });
            });

            // Update dữ liệu
            $('body').on('click', '#accpect_update', function() {
                var id = $('#id_edit').val();
                var ten_khu = $('#edit_ten_khu').val();
                var slug_khu = $('#edit_slug_khu').val();
                var tinh_trang = $('#edit_tinh_trang').val();
                var payload = {
                    'id' : id,
                    'ten_khu' : ten_khu,
                    'slug_khu' : slug_khu,
                    'tinh_trang' : tinh_trang
                };
                axios
                    .post('/admin/khu-vuc/update', payload)
                    .then((res) => {
                        if(res.data.status) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                            $('#updateModal').modal('hide');
                        } else {
                            toastr.error(res.data.message, 'Error');
                        }
                    });
            });

            // Tự động thêm slug khi edit
            $('body').on('keyup', '#edit_ten_khu', function() {
                $('#accpect_update').prop('disabled', true);
                var slug = toSlug($(this).val());
                $('#edit_slug_khu').val(slug);
            });

            // Check slug khi edit
            $('body').on('blur', '#edit_ten_khu', function() {
                var slug = toSlug($(this).val());
                var payload = {
                    'slug_khu'  : slug,
                    'id'        : $('#id_edit').val()
                }
                axios
                    .post('/admin/khu-vuc/check-slug', payload)
                    .then((res) => {
                        if(res.data.status == 1) {
                            toastr.success(res.data.message, 'Success');
                            $('#accpect_update').removeAttr('disabled');
                        } else if(res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                            $('#accpect_update').prop('disabled', true);
                        } else if(res.data.status == 2) {
                            toastr.warning(res.data.message, 'Warning')
                        }
                    });
            });
        });
    </script>
@endsection
