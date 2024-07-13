<!DOCTYPE html>

<head>
    <title>Quản trị viên</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('/frontend/images/home/icon-web.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
        rel="stylesheet" />
    <link href="{{ asset('/backend/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}"rel="stylesheet" />
    <link href="{{ asset('/backend/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/backend/plugins/sweetalert2/sweetalert2.css') }}" rel="stylesheet" />
    <!-- DataTables -->
    <link href="{{ asset('/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{ asset('/backend/plugins/select2/css/select2.min.css') }}"rel="stylesheet">
    <link href="{{ asset('/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/css/adminlte.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/css/main-style.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/css/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/css/style-responsive.css') }}" rel="stylesheet" />
    <link href="{{ asset('/backend/css/ionicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/backend/css/jquery-ui.css') }}" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="preloader" id="preloader">
            <div class="progress-bar"></div>
        </div>
        @include('admin.page-ribs.header')
        @include('admin.page-ribs.sidebar-left')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @yield('admin_content')
                </div>
            </section>
        </div>
        @include('admin.page-ribs.footer')
    </div>
    <script>
        $.widget.bridge("uibutton", $.ui.button);
    </script>

    <script src="{{ asset('/backend/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('/backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('/backend/plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('/backend/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/backend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/backend/js/adminlte.js') }}"></script>
    <script src="{{ asset('/backend/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('/backend/js/morris.js') }}"></script>
    <script src="{{ asset('/backend/js/morris.min.js') }}"></script>
    <script src="{{ asset('/backend/js/raphael-min.js') }}"></script>
    <script src="{{ asset('/backend/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('/backend/js/toastr.min.js') }}"></script>
    <script src="{{ asset('/backend/ckeditor/ckeditor.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    {{-- <script src="{{ asset('/backend/js/jquery-3.6.0.min.js') }}"></script> (đụng độ js) --}}
    {!! Toastr::message() !!}

    @if (session('error_alert'))
        <script>
            alert("{{ session('error_alert') }}");
        </script>
    @endif

    {{-- Select 2 --}}
    <script>
        $(function() {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
    {{-- Select 2 --}}


    {{-- Xoá dữ liệu trong table --}}
    <script>
        function deleteItem(element) {
            var id = $(element).data('id');
            var type = $(element).data('type');
            var confirmMessage = $(element).data('confirm-message');

            if (confirm(confirmMessage)) {
                $.ajax({
                    url: 'delete-' + type + '/' + id,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            $('#' + type + '-row-' + id).remove();
                        } else if (response.status === 'info') {
                            toastr.info(response.message);
                        } else if (response.status === 'warning') {
                            toastr.warning(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Đã xảy ra lỗi khi xoá');
                    }
                });
            }
        }
    </script>
    {{-- Xoá dữ liệu trong table --}}

    {{-- xem trước hình ảnh --}}
    <script>
        function previewImage(input) {
            var file = $('.preview-image').get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    $('#preview_image').attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

    {{-- sử dụng data table --}}
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    {{-- sử dụng data table --}}

    {{-- loading button add and save --}}
    {{-- <script>
        document.getElementById('saveForm').addEventListener('submit', function() {
            var addBtn = document.querySelector('.btn-add');
            addBtn.classList.add('loading');
            addBtn.disabled = true;
        });
    </script> --}}
    {{-- loading button add and save --}}

    {{-- Kiểm tra input file ảnh --}}
    <script>
        document.querySelectorAll('.file-Image-input').forEach(input => {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                const errorMessage = event.target.parentElement.querySelector('.error-message');
                errorMessage.textContent = '';
                if (file) {
                    const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    const allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    const fileMimeType = file.type;

                    if (!allowedExtensions.includes(fileExtension) || !allowedMimeTypes.includes(
                            fileMimeType)) {
                        errorMessage.textContent = 'Định dạng tập tin không hợp lệ!';
                        event.target.value = '';
                    }
                }
            });
        });
    </script>
    {{-- Kiểm tra input file ảnh --}}

    <!-- Sắp xếp theo....-->
    <script>
        $(document).ready(function() {
            $('#sort_name').on('change', function() {
                var url = $(this).val();
                if (url) {
                    window.location = url;
                }
                return false;
            })
            $('#sort_condition').on('change', function() {
                var url = $(this).val();
                if (url) {
                    window.location = url;
                }
                return false;
            })
            $('#sort_status').on('change', function() {
                var url = $(this).val();
                if (url) {
                    window.location = url;
                }
                return false;
            })
        })
    </script>
    <!-- Sắp xếp theo....-->

    {{-- status button --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-status');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const activeUrl = this.getAttribute('data-active-url');
                    const inactiveUrl = this.getAttribute('data-inactive-url');
                    const currentStatus = this.classList.contains('active') ? 1 : 0;
                    const newStatus = currentStatus === 1 ? 0 : 1;
                    const url = newStatus === 1 ? activeUrl : inactiveUrl;
                    fetch(url, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                this.classList.toggle('active');
                                this.title = newStatus === 1 ? 'Hiển thị' : 'Ẩn';
                            } else {
                                console.error('Đã xảy ra lỗi khi cập nhật trạng thái.');
                            }
                        })
                        .catch(error => {
                            console.error('Đã xảy ra lỗi:', error);
                        });
                });
            });
        });
    </script>
    {{-- status button --}}

    {{-- Thu gọn sidebar --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarToggle = document.querySelector('.sidebar-toggle-box');
            const menu = document.querySelector('.menu');
            const header = document.querySelector('.header');

            sidebarToggle.addEventListener('click', function() {
                menu.classList.toggle('active');
                header.classList.toggle('active');
            });
        });
    </script>
    {{-- Thu gọn sidebar --}}

    <!-- Thêm hình ảnh phụ cho sản phẩm -->
    <script>
        $(document).ready(function() {
            load_gallery();

            function load_gallery() {
                var pro_id = $('.pro_id').val();
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ url('Admin/select-gallery') }}",
                    method: "POST",
                    data: {
                        pro_id: pro_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#gallery_load').html(data);
                    }
                })
            }
            $('#file').change(function() {
                var error = '';
                var files = $('#file')[0].files;
                if (files.length > 10) {
                    error += 'Bạn chỉ được phép chọn tối đa 10 ảnh';
                } else if (files.size > 2000000) {
                    error += 'Dung lượng ảnh đã vượt quá 2MB';
                }
                if (error == '') {
                    error += 'Vui lòng thêm tối thiểu 1 ảnh';
                } else {
                    $('#file').val('');
                    $('#error_gallery').html(error);
                    return false;
                }
            });
            // $(document).on('blur', '.edit_gal_name', function() {
            //     var gal_id = $(this).data('gal_id');
            //     var gal_text = $(this).text();
            //     var _token = $("input[name='_token']").val();
            //     $.ajax({
            //         url: "{{ url('Admin/update-gallery-name') }}",
            //         method: "POST",
            //         data: {
            //             gal_id: gal_id,
            //             gal_text: gal_text,
            //             _token: _token
            //         },
            //         success: function(data) {
            //             load_gallery();
            //             alert('Tên hình ảnh đã được thay đổi!')
            //         }
            //     })
            // });
            $(document).on('click', '.delete-gallery', function() {
                var gal_id = $(this).data('gal_id');
                var _token = $("input[name='_token']").val();
                if (confirm('Bạn có chắc là muốn xoá hình ảnh này?')) {
                    $.ajax({
                        url: "{{ url('Admin/delete-gallery') }}",
                        method: "POST",
                        data: {
                            gal_id: gal_id,
                            _token: _token
                        },
                        success: function(data) {
                            toastr.success('Xoá hình ảnh thành công');
                            load_gallery();
                        }
                    })
                }
            });
            $(document).on('change', '.file_image', function() {
                var gal_id = $(this).data('gal_id');
                var image = document.getElementById('file-' + gal_id).files[0];
                var form_data = new FormData();
                form_data.append('file', image);
                form_data.append('gal_id', gal_id);
                $.ajax({
                    url: "{{ url('Admin/update-gallery') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        toastr.success('Thay đổi hỉnh ảnh thành công');
                        load_gallery();
                    }
                })
            })
        });
    </script>
    <!-- Thêm hình ảnh phụ cho sản phẩm -->

    <!-- Hiển thị lịch, ngày tháng khi nhấn vào input, đồng thời kiểm tra điều kiện (nếu có) -->
    <script>
        $(function() {
            $("#datepicker_fromDate").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "yy-mm-dd",
                dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"],
                monthNames: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7",
                    "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
                ],
                monthNamesShort: ["Thg 1", "Thg 2", "Thg 3", "Thg 4", "Thg 5", "Thg 6", "Thg 7", "Thg 8",
                    "Thg 9", "Thg 10", "Thg 11", "Thg 12"
                ],
                duration: "slow",
            });
            $("#datepicker_toDate").datepicker({
                prevText: "Tháng trước",
                nextText: "Tháng sau",
                dateFormat: "yy-mm-dd",
                dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"],
                monthNames: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7",
                    "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
                ],
                monthNamesShort: ["Thg 1", "Thg 2", "Thg 3", "Thg 4", "Thg 5", "Thg 6", "Thg 7", "Thg 8",
                    "Thg 9", "Thg 10", "Thg 11", "Thg 12"
                ],
                duration: "slow",
            });
        });
    </script>
    <!-- Hiển thị lịch khi nhấn vào input -->

    <!-- Biểu đồ hình cột -->
    <script>
        $(document).ready(function() {
            chart30daysorder()
            var chart = new Morris.Bar({
                element: 'myfirstchart',
                parseTime: false,
                hideHover: 'auto',
                xkey: 'period',
                ykeys: ['order', 'sales', 'profit', 'quantity'],
                labels: ['Đơn hàng', 'Doanh thu', 'Lợi nhuận', 'Số lượng'],
                barColors: ['#103667', '#007F54', '#976D00', '#8E1E20']
            });

            function chart30daysorder() {
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ url('Admin/days-order-default') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        _token: _token
                    },
                    success: function(data) {
                        chart.setData(data);
                    }
                })
            }
            $('.dashboard-filter').change(function() {
                var dashboard_value = $(this).val();
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ url('Admin/dashboard-filter') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        dashboard_value: dashboard_value,
                        _token: _token
                    },
                    success: function(data) {
                        chart.setData(data);
                    }
                })
            });
            $('#btn-dashboard-filter').click(function() {
                var from_date = $('#datepicker_fromDate').val();
                var to_date = $('#datepicker_toDate').val();
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ url('Admin/filter-by-date') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        _token: _token
                    },
                    success: function(data) {
                        chart.setData(data);
                    }
                })
            })
        })
    </script>
    <!-- Biểu đồ hình cột -->

    <!-- Bình luận -->
    <script>
        $('.btn-reply-comment').click(function() {
            var comment_id = $(this).data('comment_id');
            var comment = $('.text-reply_' + comment_id).val();
            var comment_product_id = $(this).data('product_id');
            $.ajax({
                url: "{{ url('Admin/reply-comment') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    comment: comment,
                    comment_id: comment_id,
                    comment_product_id: comment_product_id,
                },
                success: function(data) {
                    location.reload();
                    $('.text-reply_' + comment_id).val('');
                }
            })
        })
    </script>
    <!-- Bình luận -->

    <!-- ckeditor -->
    <script>
        function initializeCKEditor(textareaId) {
            CKEDITOR.replace(textareaId, {
                filebrowserImageBrowseUrl: '{{ url('Admin/laravel-filemanager?type=Images') }}',
                filebrowserImageUploadUrl: '{{ url('Admin/laravel-filemanager/upload?type=Images&_token=' . csrf_token()) }}',
                filebrowserBrowseUrl: '{{ url('Admin/laravel-filemanager?type=Files') }}',
                filebrowserUploadUrl: '{{ url('Admin/laravel-filemanager/upload?type=Files&_token=' . csrf_token()) }}',
                filebrowserUploadMethod: 'form',
                removeButtons: 'Save,ImageButton,Iframe',
                removePlugins: 'forms,about,language'
            });
        }

        var textareaIds = ['ckeditor_add_product', 'ckeditor_edit_product', 'ckeditor_add_post_content',
            'ckeditor_add_post_desc', 'ckeditor_info_contact'
        ];

        textareaIds.forEach(function(id) {
            initializeCKEditor(id);
        });
    </script>
    <!-- ckeditor -->

    <!-- Kiểm tra số lượng và thay đổi trạng thái đơn hàng-->
    <script>
        $('.order_details').change(function() {
            var order_status = $(this).val();
            var order_id = $(this).children(":selected").attr("id");
            var _token = $('input[name="_token"]').val();
            //lay so luong
            quantity = [];
            $("input[name='product_sales_quantity']").each(function() {
                quantity.push($(this).val());
            });
            //lay product_id
            order_product_id = [];
            $("input[name='order_product_id']").each(function() {
                order_product_id.push($(this).val());
            });
            j = 0;
            for (i = 0; i < order_product_id.length; i++) {
                var order_qty = $('.order_qty_' + order_product_id[i]).val();
                var order_qty_storage = $('.order_qty_storage_' + order_product_id[i]).val();
                if (parseInt(order_qty) > parseInt(order_qty_storage)) {
                    j = j + 1;
                    if (j == 1) {
                        alert("Số lượng sản phẩm trong kho không đủ");
                    }
                    $('.color_qty_' + order_product_id[i]).css('background-color', 'orange');
                }
            }
            if (j == 0) {
                if (order_status == 3) {
                    Swal.fire({
                        title: "Thông báo xác nhận!",
                        text: "Bạn có chắc là huỷ đơn hàng này?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        cancelButtonText: "Đóng",
                        confirmButtonText: "Xác nhận",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ url('Admin/update-order-quantity') }}",
                                method: 'POST',
                                data: {
                                    order_status: order_status,
                                    order_id: order_id,
                                    _token: _token,
                                    quantity: quantity,
                                    order_product_id: order_product_id
                                },
                                success: function(data) {
                                    Swal.fire({
                                        title: "Thông báo",
                                        text: "Đơn hàng đã bị huỷ.",
                                        icon: "success",
                                        confirmButtonText: "Đóng",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                }
                            });
                        } else {
                            init_reload()
                        }
                    });
                } else {
                    $.ajax({
                        url: "{{ url('Admin/update-order-quantity') }}",
                        method: 'POST',
                        data: {
                            order_status: order_status,
                            order_id: order_id,
                            _token: _token,
                            quantity: quantity,
                            order_product_id: order_product_id
                        },
                        success: function(data) {
                            if (order_status == 1) {
                                Swal.fire({
                                    title: "Thay đổi trạng thái",
                                    text: "Đã chuyển đơn hàng thành chờ xử lý!",
                                    icon: "success",
                                    confirmButtonText: "Đóng",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: "Thay đổi trạng thái",
                                    text: "Đơn hàng đã được xử lý!",
                                    icon: "success",
                                    confirmButtonText: "Đóng",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            }
                        }
                    });
                }
            }

            function init_reload() {
                setInterval(function() {
                    window.location.reload();
                }, 500);
            }
        });
    </script>
    <!-- Kiểm tra số lượng trong đơn đặt hàng có lơn hơn số lượng trong kho hay không? -->

    <!-- format_number khi nhập vào thẻ input -->
    <script>
        function formatCurrency(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            let formattedValue = new Intl.NumberFormat('en-US').format(value);
            input.value = formattedValue;
        }
    </script>
    <!-- format_number khi nhập vào thẻ input -->

    <!-- Hàm kiểm tra nếu phím được nhấn là khoảng trắng -->
    <script>
        function preventWhitespace(event) {
            if (event.keyCode === 32) {
                event.preventDefault();
                alert("Trường này không thể chứa khoảng trắng!")
            }
        }
    </script>
    <!-- Hàm kiểm tra nếu phím được nhấn là khoảng trắng -->

    {{-- Tự động tạo slug --}}
    <script>
        function removeVietnameseDiacritics(str) {
            return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        }

        function getRandomString(length) {
            var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var result = '';
            for (var i = 0; i < length; i++) {
                result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
            }
            return result;
        }

        document.querySelectorAll('[data-slug-source]').forEach(function(input) {
            input.addEventListener('input', function() {
                var sourceType = this.getAttribute('data-slug-source');
                var title = this.value;
                var slug = removeVietnameseDiacritics(title)
                    .toLowerCase()
                    .replace(/ /g, '-')
                    .replace(/[^\w-]+/g, '')
                    .replace(/--+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');

                var now = new Date();
                var timestamp = now.getFullYear().toString().substr(-2) +
                    ('0' + (now.getMonth() + 1)).slice(-2) +
                    ('0' + now.getDate()).slice(-2) +
                    ('0' + now.getHours()).slice(-2) +
                    ('0' + now.getMinutes()).slice(-2) +
                    ('0' + now.getSeconds()).slice(-2);

                var randomString = getRandomString(4); // Độ dài chuỗi ngẫu nhiên

                slug += '-' + timestamp + '-' + randomString;

                var targetInput = document.querySelector('[data-slug-target="' + sourceType + '"]');
                if (targetInput) {
                    targetInput.value = slug;
                }
            });
        });
    </script>
    {{-- Tự động tạo slug --}}

    {{-- lọc sản phẩm tham gia sự kiện --}}
    <script>
        document.querySelectorAll('.filter-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var filterType = this.getAttribute('data-filter');
                filterProducts(filterType);
            });
        });

        function filterProducts(filterType) {
            var productList = document.querySelectorAll('.product-item');

            productList.forEach(function(item) {
                var isChecked = item.querySelector('input[type="checkbox"]').checked;

                if (filterType === 'checked' && isChecked) {
                    item.style.display = 'block'; // Hiển thị sản phẩm đã checked
                } else if (filterType === 'unchecked' && !isChecked) {
                    item.style.display = 'block'; // Hiển thị sản phẩm chưa checked
                } else if (filterType === 'all') {
                    item.style.display = 'block'; // Hiển thị tất cả sản phẩm
                } else {
                    item.style.display = 'none'; // Ẩn sản phẩm không phù hợp với bộ lọc
                }
            });
        }

        document.getElementById('searchProduct').addEventListener('input', function() {
            var searchKeyword = this.value.trim().toLowerCase();
            var productList = document.querySelectorAll('.product-item');

            productList.forEach(function(item) {
                var productName = item.querySelector('.check-product-name').textContent.toLowerCase();

                if (productName.includes(searchKeyword)) {
                    item.style.display = 'block'; // Hiển thị sản phẩm phù hợp với từ khóa tìm kiếm
                } else {
                    item.style.display = 'none'; // Ẩn sản phẩm không phù hợp với từ khóa tìm kiếm
                }
            });
        });
    </script>
    {{-- lọc sản phẩm tham gia sự kiện --}}
</body>

</html>
