@extends('admin.share.master')
@section('noi_dung')
    <div class="row">
        <div class="col-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="card-title text-primary fw-bold">Thêm bàn mới</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Tên Bàn</label>
                        <input type="text" class="form-control" id="add_ten_ban">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Slug Bàn</label>
                        <input type="text" class="form-control" id="add_slug_ban">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Khu Vực</label>
                        <select name=""class="form-control" id="add_id_khu_vuc">
                            <option value="0">Vui lòng chọn khu vực</option>
                            @foreach ($khuVuc as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->ten_khu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Gia Mở Bán</label>
                        <input type="text" class="form-control" id="add_gia_mo_ban">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Tiền Giờ</label>
                        <input type="text" class="form-control" id="add_tien_gio">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label fw-bold">Tình Trạng</label>
                        <select class="form-control" id="add_tinh_trang">
                            <option value="-1">Vui lòng chọn tình trạng</option>
                            <option value="1">Hiển thị</option>
                            <option value="0">Không hiển thị</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" id="add">Thêm mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="card-title text-primary fw-bold">Danh sách bàn</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="danh-sach-ban">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tên bàn</th>
                                <th class="text-center">Slug bàn</th>
                                <th class="text-center">Khu vực</th>
                                <th class="text-center">Giá mở bàn</th>
                                <th class="text-center">Tiền giờ</th>
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
                                    <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel">Xác nhận xóa dữ liệu
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" class="form-control" id="id_delete">
                                    <div class="alert alert-danger" role="alert">
                                        Bạn chắc chắn muốn xóa dữ liệu bàn này!. Việc này không thể thay đổi, hãy cẩn
                                        thận!.
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
                                    <input type="hidden" class="form-control" id="id_edit">
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Tên Bàn</label>
                                        <input type="text" class="form-control" id="edit_ten_ban">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Slug Bàn</label>
                                        <input type="text" class="form-control" id="edit_slug_ban">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Khu Vực</label>
                                        <select name=""class="form-control" id="edit_id_khu_vuc">
                                            <option value="0">Vui lòng chọn khu vực</option>
                                            @foreach ($khuVuc as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->ten_khu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3 form-group">
                                                <label class="form-label fw-bold">Gia Mở Bán</label>
                                                <input type="text" class="form-control" id="edit_gia_mo_ban">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3 form-group">
                                                <label class="form-label fw-bold">Tiền Giờ</label>
                                                <input type="text" class="form-control" id="edit_tien_gio">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Tình Trạng</label>
                                        <select class="form-control" id="edit_tinh_trang">
                                            <option value="1">Hiển thị</option>
                                            <option value="0">Không hiển thị</option>
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
            // Hàm xử lí số
            function convert(number) {
                return new Intl.NumberFormat('vi-VI', { style: 'currency', currency: 'VND' }).format(number);
            }

            // Disabled nút Thêm mới
            $('#add').prop('disabled', true);

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

            // Check slug khi blur
            $('body').on('blur', '#add_ten_ban', function() {
                var slug = toSlug($(this).val());
                var payload = {
                    'slug_ban' : slug
                }
                axios
                    .post('/admin/ban/check-slug', payload)
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
            });

            // Tự dộng thêm slug bàn khi nhập tên bàn
            $('body').on('keyup', '#add_ten_ban', function() {
                var slug = toSlug($(this).val());
                $('#add_slug_ban').val(slug);
            });

            loadData();
            function loadData() {
                axios
                    .get('/admin/ban/data')
                    .then((res) => {
                        var danhSachBan = res.data.danhSachBan;
                        var code = '';
                        $.each(danhSachBan, function(key, value) {
                            code += '<tr>'
                            code += '<th class="text-center align-middle">' + (key + 1) + '</th>'
                            code += '<td class="text-center align-middle">' + value.ten_ban + '</td>'
                            code += '<td class="text-center align-middle">' + value.slug_ban + '</td>'
                            code += '<td class="text-center align-middle">' + value.ten_khu + '</td>'
                            code += '<td class="text-center align-middle">' + convert(value.gia_mo_ban) + '</td>'
                            code += '<td class="text-center align-middle">' + convert(value.tien_gio) + '</td>'
                            code += '<td class="text-center align-middle">'
                            if (value.tinh_trang) {
                                code += '<button data-idban="' + value.id +
                                    '" class="change-status btn btn-success fw-bold">Hiển thị</button>'
                            } else {
                                code += '<button data-idban="' + value.id +
                                    '" class="change-status btn btn-outline-warning fw-bold">Tạm tắt</button>'
                            }
                            code += '</td>'
                            code += '<td class="text-center align-middle">'
                            code += '<button data-idban="' + value.id +
                                '" class="edit btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Sửa</button>'
                            code += '<button data-idban="' + value.id +
                                '" class="delete btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa</button>'
                            code += '</td>'
                            code += '</tr>'
                        });
                        $('#danh-sach-ban tbody').html(code);
                    });
            }

            //Thay đổi trạng thái
            $('body').on('click', '.change-status', function() {
                var id = $(this).data('idban');
                var payload = {
                    'id': id
                }
                axios
                    .post('/admin/ban/doi-trang-thai', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success(res.data.message, 'Success')
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error')
                        }
                    });
            });

             // Add
             $('body').on('click', '#add', function() {
                $('#add').prop('disabled', true);
                var ten_ban = $('#add_ten_ban').val();
                var slug_ban = $('#add_slug_ban').val();
                var id_khu_vuc = $('#add_id_khu_vuc').val();
                var gia_mo_ban = $('#add_gia_mo_ban').val();
                var tien_gio = $('#add_tien_gio').val();
                var tinh_trang = $('#add_tinh_trang').val();
                var payload = {
                    'ten_ban': ten_ban,
                    'slug_ban': slug_ban,
                    'id_khu_vuc': id_khu_vuc,
                    'gia_mo_ban': gia_mo_ban,
                    'tien_gio': tien_gio,
                    'tinh_trang': tinh_trang
                };

                axios
                    .post('/admin/ban/create', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, 'Warning');
                        }
                        $('#add_ten_ban').val('');
                        $('#add_slug_ban').val('');
                        $('#add_id_khu_vuc').val(0);
                        $('#add_gia_mo_ban').val('');
                        $('#add_tien_gio').val('');
                        $('#add_tinh_trang').val(-1);
                        $('#add').removeAttr('disabled');
                    });
            });

            //Xóa
            $('body').on('click', '.delete', function() {
                var id = $(this).data('idban');
                $('#id_delete').val(id);
            });

            $('body').on('click', '#accpect_delete', function() {
                var id = $('#id_delete').val();
                // console.log(id);
                var payload = {
                    'id': id
                }
                axios
                    .post('/admin/ban/delete', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                        }
                    });
            })

            // Lấy dữ liệu edit
            $('body').on('click', '.edit', function() {
                var id = $(this).data('idban');
                var payload = {
                    'id': id
                }
                axios
                    .post('/admin/ban/edit', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.warning(res.data.message, 'Warning');
                            $('#id_edit').val(res.data.ban.id)
                            $('#edit_ten_ban').val(res.data.ban.ten_ban);
                            $('#edit_slug_ban').val(res.data.ban.slug_ban);
                            $('#edit_id_khu_vuc').val(res.data.ban.id_khu_vuc);
                            $('#edit_gia_mo_ban').val(res.data.ban.gia_mo_ban);
                            $('#edit_tien_gio').val(res.data.ban.tien_gio);
                            $('#edit_tinh_trang').val(res.data.ban.tinh_trang);
                        } else {
                            toastr.error(res.data.message, 'Error');
                        }
                    });
            });

            // Update dữ liệu
            $('body').on('click', '#accpect_update', function() {
                var id          = $('#id_edit').val();
                var ten_ban     = $('#edit_ten_ban').val();
                var slug_ban    = $('#edit_slug_ban').val();
                var id_khu_vuc  = $('#edit_id_khu_vuc').val();
                var gia_mo_ban  = $('#edit_gia_mo_ban').val();
                var tien_gio    = $('#edit_tien_gio').val();
                var tinh_trang  = $('#edit_tinh_trang').val();
                var payload = {
                    'id'            : id,
                    'ten_ban'       : ten_ban,
                    'slug_ban'      : slug_ban,
                    'id_khu_vuc'    : id_khu_vuc,
                    'gia_mo_ban'    : gia_mo_ban,
                    'tien_gio'      : tien_gio,
                    'tinh_trang'    : tinh_trang,
                };
                axios
                    .post('/admin/ban/update', payload)
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
            $('body').on('blur', '#edit_ten_ban', function() {
                var slug = toSlug($(this).val());
                var payload = {
                    'slug_ban'  : slug,
                    'id'        : $('#id_edit').val()
                }
                axios
                    .post('/admin/ban/check-slug', payload)
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

            // Tự dộng thêm slug bàn khi nhập tên bàn
            $('body').on('keyup', '#edit_ten_ban', function() {
                $('#accpect_update').prop('disabled', true);
                var slug = toSlug($(this).val());
                $('#edit_slug_ban').val(slug);
            });

        });
    </script>
@endsection
