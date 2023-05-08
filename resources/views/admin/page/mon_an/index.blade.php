@extends('admin.share.master')
@section('noi_dung')
    <div class="row">
        <div class="col-4">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="card-title text-primary fw-bold">Thêm món ăn mới</h5>
                </div>
                <div class="card-body">
                        <div class="mb-3 form-group">
                            <label class="form-label fw-bold">Tên Món Ăn</label>
                            <input id="add_ten_mon_an" type="text" class="form-control">
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label fw-bold">SLug Món Ăn</label>
                            <input id="add_slug_mon" type="text" class="form-control">
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label fw-bold">Giá Bán</label>
                            <input id="add_gia_ban" type="text" class="form-control">
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label fw-bold">Tình Trạng</label>
                            <select id="add_tinh_trang" class="form-control">
                                <option value="-1">Vui lòng chọn tình trạng</option>
                                <option value="1">Hiển thị</option>
                                <option value="0">Không hiển thị</option>
                            </select>
                        </div>
                        <div class="mb-3 form-group">
                            <label class="form-label fw-bold">Danh Mục</label>
                            <select id="add_id_danh_muc" class="form-control">
                                <option value="0">Vui lòng chọn danh mục</option>
                                @foreach ($danhMuc as $key => $value )
                                    <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary add">Thêm mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card border-primary border-bottom border-3 border-0">
                <div class="card-header">
                    <h5 class="card-title text-primary fw-bold">Danh sách món ăn</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="listMonAn">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tên Món Ăn</th>
                                <th class="text-center">Slug Món Ăn</th>
                                <th class="text-center">Giá Bán</th>
                                <th class="text-center">Tình Trạng</th>
                                <th class="text-center">Danh Mục</th>
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
                                    <input type="text" class="form-control" id="id_delete">
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
                                    <h1 class="modal-title fs-5 text-primary fw-bold" id="exampleModalLabel">Cập nhật món ăn</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="id_edit" class="form-control">
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Tên món ăn</label>
                                        <input type="text" class="form-control" id="edit_ten_mon_an">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Slug món ăn</label>
                                        <input type="text" class="form-control" id="edit_slug_mon_an">
                                    </div><div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Giá bán</label>
                                        <input type="text" class="form-control" id="edit_gia_ban">
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Tình trạng</label>
                                        <select class="form-control" id="edit_tinh_trang">
                                            <option value="1">Hiển thị</option>
                                            <option value="0">Tạm tắt</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label fw-bold">Danh Mục</label>
                                        <select id="edit_id_danh_muc" class="form-control">
                                            <option value="0">Vui lòng chọn danh mục</option>
                                            @foreach ($danhMuc as $key => $value )
                                                <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}</option>
                                            @endforeach
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

            // Hàm xử lí số
            function convert(number) {
                return new Intl.NumberFormat('vi-VI', { style: 'currency', currency: 'VND' }).format(number);
            }

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

            // Ẩn nút thêm mới
            $('.add').prop('disabled', true);

            // Load dữ liệu
            loadData();
            function loadData() {
                axios
                    .get('/admin/mon-an/data')
                    .then((res) => {
                        $monAns = res.data.monAns;
                        var code = ''
                        $.each($monAns, function(key, value) {
                            code+= '<tr>';
                                code+= '<th class="text-center align-middle">'+ (key + 1) +'</th>';
                                code+= '<td class="text-center align-middle">'+ value.ten_mon_an +'</td>';
                                code+= '<td class="text-center align-middle">'+ value.slug_mon +'</td>';
                                code+= '<td class="text-center align-middle">'+ convert(value.gia_ban) +'</td>';
                                code+= '<td class="text-center align-middle">'
                                    if(value.tinh_trang) {
                                        code+= '<button data-idma="'+ value.id +'" class="doi-trang-thai btn btn-success">Hiển thị</button>';
                                    } else {
                                        code+= '<button data-idma="'+ value.id +'" class="doi-trang-thai btn btn-warning">Tạm tắt</button>';
                                    }
                                code+= '</td>';
                                code+= '<td class="text-center align-middle">'+ value.ten_danh_muc +'</td>';
                                code+= '<td class="text-center align-middle text-nowrap">'
                                    code+= '<button data-idma="'+ value.id +'" class="edit btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Cập nhật</button>';
                                    code+= '<button data-idma="'+ value.id +'" class="delete btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Xóa bỏ</button>';
                                code+= '</td>';
                            code+= '</tr>';
                        });
                        $('#listMonAn tbody').html(code);
                    });
            }

            //Đổi trạng thái
            $("body").on('click', '.doi-trang-thai', function() {
                var id = $(this).data('idma');
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/mon-an/doi-trang-thai', payload)
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
             $('body').on('click', '.add', function() {
                $('.add').prop('disabled', true);
                console.log(111111111);
                var ten_mon_an = $('#add_ten_mon_an').val();
                var slug_mon = $('#add_slug_mon').val();
                var gia_ban = $('#add_gia_ban').val();
                var tinh_trang = $('#add_tinh_trang').val();
                var id_danh_muc = $('#add_id_danh_muc').val();
                var payload = {
                    'ten_mon_an'    : ten_mon_an,
                    'slug_mon'      : slug_mon,
                    'gia_ban'       : gia_ban,
                    'tinh_trang'    : tinh_trang,
                    'id_danh_muc'   : id_danh_muc,
                };
                axios
                    .post('/admin/mon-an/create', payload)
                    .then((res) => {
                        if (res.data.status == 1) {
                            toastr.success(res.data.message, 'Success');
                            loadData();
                        } else if (res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                        } else if (res.data.status == 2) {
                            toastr.warning(res.data.message, 'Warning');
                        }
                        $('#add_ten_mon_an').val('');
                        $('#add_slug_mon').val('');
                        $('#add_gia_ban').val('');
                        $('#add_tinh_trang').val(-1);
                        $('#add_id_danh_muc').val(0);
                        $('.add').removeAttr('disabled');
                    });
            });

            // Tự thêm slug
            $('body').on('keyup', '#add_ten_mon_an', function() {
                var slug = toSlug($(this).val());
                $('#add_slug_mon').val(slug);
            });

            // Check slug
            $('body').on('blur', '#add_ten_mon_an', function() {
                var slug = toSlug($(this).val());
                var payload = {
                    'slug_mon_an' : slug
                };
                axios
                    .post('/admin/mon-an/check-slug', payload)
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

             //Xóa
             $("body").on('click', '.delete', function() {
                var id = $(this).data('idma');
                $('#id_delete').val(id);
            });

            $("body").on('click', '#accpect_delete', function() {
                var id = $('#id_delete').val();
                var payload = {
                    'id': id
                };
                axios
                    .post('/admin/mon-an/delete', payload)
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

            // Lây dữ liệu edit
            $("body").on('click', '.edit', function() {
                var id = $(this).data('idma');
                $('#id_edit').val(id);
                var payload = {
                    'id': id
                }
                axios
                    .post('/admin/mon-an/edit', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.warning(res.data.message, 'Success');
                            $('#id_edit').val(res.data.monAn.id);
                            $('#edit_ten_mon_an').val(res.data.monAn.ten_mon_an);
                            $('#edit_slug_mon_an').val(res.data.monAn.slug_mon);
                            $('#edit_gia_ban').val(res.data.monAn.gia_ban);
                            $('#edit_tinh_trang').val(res.data.monAn.tinh_trang);
                            $('#edit_id_danh_muc').val(res.data.monAn.id_danh_muc);
                        } else {
                            toastr.error(res.data.message, 'Error');
                        }
                    });
            });

           // Accpect edit
            $('body').on('click', '#accpect_update', function() {
                var id          = $('#id_edit').val();
                var ten_mon_an  = $('#edit_ten_mon_an').val();
                var slug_mon_an = $('#edit_slug_mon_an').val();
                var gia_ban     = $('#edit_gia_ban').val();
                var tinh_trang  = $('#edit_tinh_trang').val();
                var id_danh_muc = $('#edit_id_danh_muc').val();
                var payload = {
                    'id'            : id,
                    'ten_mon_an'    : ten_mon_an,
                    'slug_mon_an'   : slug_mon_an,
                    'gia_ban'       : gia_ban,
                    'tinh_trang'    : tinh_trang,
                    'id_danh_muc'   : id_danh_muc,
                };
                axios
                    .post('/admin/mon-an/update', payload)
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

            // Thêm slug khi keyup
            $('body').on('keyup', '#edit_ten_mon_an', function() {
                $('#accpect_update').prop('disabled', true);
                var slug = toSlug($(this).val());
                $('#edit_slug_mon_an').val(slug);
            });

            // Check slug edit
            $('body').on('blur', '#edit_ten_mon_an', function() {
                var slug = toSlug($(this).val());
                var payload = {
                    'slug_mon_an'   : slug,
                    'id'            : $('#id_edit').val()
                };
                axios
                    .post('/admin/mon-an/check-slug', payload)
                    .then((res) => {
                        if(res.data.status == 1) {
                            toastr.success(res.data.message, 'Success');
                            $('#accpect_update').removeAttr('disabled');
                        } else if(res.data.status == 0) {
                            toastr.error(res.data.message, 'Error');
                            $('#accpect_update').prop('disabled', true);
                        } else if(res.data.status == 2) {
                            toastr.warning(res.data.message, 'Warning');
                        }
                    });
            });
        })
    </script>

@endsection
