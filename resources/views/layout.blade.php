<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | KN-Milk</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/frontend/images/home/icon-web.png') }}">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,300,400italic,500,700,100">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/prettyPhoto.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/price-range.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/carousel/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/lightslider.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/lightgallery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/prettify.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/holiday-event.css') }}">

</head>

<body>
    @include('pages.header.menu')
    <div class="container-md container-main">
        <div class="row">
            <div class="col-md-12">
                @yield('content')
            </div>
        </div>
    </div>
    @include('pages.chat.chat-with-admin')
    @include('pages.footer.footer')

    <script src="{{ asset('/frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('/frontend/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('/frontend/js/jquery.scrollUp.min.js') }}"></script> --}}
    <script src="{{ asset('/frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('/frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('/frontend/js/main.js') }}"></script>
    <script src="{{ asset('/frontend/carousel/js/popper.min.js') }}"></script>
    <script src="{{ asset('/frontend/carousel/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/frontend/carousel/js/main.js') }}"></script>
    <script src="{{ asset('/frontend/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/lightslider.js') }}"></script>
    <script src="{{ asset('/frontend/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/simple.money.format.js') }}"></script>
    <script src="{{ asset('/frontend/js/toastr.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/holiday-event.js') }}"></script>

    {!! Toastr::message() !!}

    @if (Session::has('message'))
        <script>
            alert("{{ Session::get('message') }}");
        </script>
        {{ Session::forget('message') }}
    @endif

    {{-- Chọn địa chỉ hành chính --}}
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/api/get-provinces',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(index, province) {
                        $('.shipping_address_province').append('<option value="' + province
                            .matp + '">' + province.name + '</option>');
                    });
                },
                error: function(err) {
                    console.error('Error fetching provinces:', err);
                }
            });
            $('.shipping_address_province').change(function() {
                var province_id = $(this).val();
                if (province_id) {
                    $.ajax({
                        url: '/api/get-districts/' + province_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('.shipping_address_district').empty();
                            $('.shipping_address_district').append(
                                '<option value="">Chọn Quận (huyện)</option>');
                            $.each(data, function(index, district) {
                                $('.shipping_address_district').append(
                                    '<option value="' + district.maqh + '">' +
                                    district.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('.shipping_address_district').empty();
                    $('.shipping_address_wards').empty();
                }
            });

            $('.shipping_address_district').change(function() {
                var district_id = $(this).val();
                if (district_id) {
                    $.ajax({
                        url: '/api/get-wards/' + district_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('.shipping_address_wards').empty();
                            $('.shipping_address_wards').append(
                                '<option value="">Chọn Xã (phường)</option>');
                            $.each(data, function(index, wards) {
                                $('.shipping_address_wards').append('<option value="' +
                                    wards.xaid + '">' + wards.name + '</option>');
                            });
                        },
                        error: function(err) {
                            console.error('Error fetching wards:', err);
                        }
                    });
                } else {
                    $('.shipping_address_wards').empty();
                }
            });
        });
    </script>

    {{-- Chọn địa chỉ hành chính --}}

    {{-- input number --}}
    <script>
        function validateInput(event) {
            const input = event.target;
            // Chỉ cho phép nhập số
            if (event.type === 'keypress') {
                if (event.charCode < 48 || event.charCode > 57) {
                    event.preventDefault();
                }
            }
            // Loại bỏ số 0 ở đầu
            if (event.type === 'input') {
                if (input.value.startsWith('0')) {
                    input.value = input.value.replace(/^0+/, '');
                }
            }
            // Đảm bảo giá trị không nhỏ hơn 1
            if (event.type === 'change') {
                if (input.value < 1) {
                    input.value = '1';
                }
            }
        }
    </script>
    {{-- input number --}}

    <!-- Lọc giá tiền từ... đến ....-->
    <script>
        $(document).ready(function() {

            function formatCurrency(amount) {
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(amount);
            };
            // var min_price = <?php echo $min_price; ?>;
            // var max_price = <?php echo $max_price; ?>;
            var min_price = {{ $min_price }};
            var max_price = {{ $max_price }};
            $("#slider-range").slider({
                orientation: "horizontal",
                range: true,
                min: min_price,
                max: max_price,
                step: 1000,
                values: [min_price, max_price],
                slide: function(event, ui) {
                    var start_price = formatCurrency(ui.values[0]);
                    var end_price = formatCurrency(ui.values[1]);

                    $("#amount").val(start_price + " - " + end_price);
                    $("#start_price").val(ui.values[0]);
                    $("#end_price").val(ui.values[1]);
                }
            });
            var start_price = formatCurrency($("#slider-range").slider("values", 0));
            var end_price = formatCurrency($("#slider-range").slider("values", 1));
            $("#amount").val(start_price + " - " + end_price);
        });
    </script>
    <!-- Lọc giá tiền từ... đến ....-->

    <!-- Sắp xếp theo....-->
    <script>
        $(document).ready(function() {
            $('#sort_price').on('change', function() {
                var url = $(this).val();
                if (url) {
                    window.location = url;
                }
                return false;
            })
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
        })
    </script>
    <!-- Sắp xếp theo....-->

    <!-- Danh sách yêu thích-->
    <script>
        $(document).ready(function() {
            $('.add_favorite').click(function() {
                var product_id = $(this).data('id');
                var customer_id = $(this).data('customer_id');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('/add-favorites-list') }}",
                    method: 'POST',
                    data: {
                        product_id: product_id,
                        customer_id: customer_id,
                        _token: _token
                    },
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON.error;
                        alert(errorMessage);
                    }
                });
            })
            $(document).on('click', '.unFavorite', function() {
                var favorite_id = $(this).data('id');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('/delete-favorite') }}",
                    method: 'POST',
                    data: {
                        favorite_id: favorite_id,
                        _token: _token
                    },
                    success: function(data) {
                        if (data.success) {
                            $(this).closest('.col-md-3').remove();
                        } else {
                            alert('Xoá sản phẩm khỏi danh sách yêu thích thất bại.');
                        }
                    }.bind(this)
                });
            })
            $(document).on('click', '.deleteAll-favorites', function() {
                var customer_id = $(this).data('customer_id');
                if (confirm("Bạn có chắc là muốn xoá tất cả?")) {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ url('/deleteAll-favorites') }}",
                        method: 'POST',
                        data: {
                            customer_id: customer_id,
                            _token: _token
                        },
                        success: function(data) {
                            if (data.success) {
                                $('#favorite_body').empty();
                            } else {
                                alert('Xoá tất cả sản phẩm khỏi danh sách yêu thích thất bại.');
                            }
                        }
                    });
                }
            })
            $('.show-favorites').click(function() {
                var favorite_customer_id = $('.favorite_customer_id').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('/favorites-list') }}",
                    method: 'POST',
                    data: {
                        favorite_customer_id: favorite_customer_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#favorite_body').html(data);
                    }
                });
            })

        })
    </script>
    <!-- Danh sách yêu thích-->

    <!-- tab danh mục-->
    <script>
        $(document).ready(function() {
            var cate_id = $('.tabs_pro').data('id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ url('/product-tabs') }}",
                method: 'POST',
                data: {
                    cate_id: cate_id,
                    _token: _token
                },
                success: function(data) {
                    $('#tab_product').html(data);
                }
            });
            $('.tabs_pro').click(function() {
                var cate_id = $(this).data('id');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('/product-tabs') }}",
                    method: 'POST',
                    data: {
                        cate_id: cate_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#tab_product').html(data);
                    }
                });
            })
        })
    </script>
    <!-- tab danh mục-->

    <!-- Bình luận-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const ratingValue = this.getAttribute('data-value');
                    ratingInput.value = ratingValue;

                    // Optional: Add visual feedback (e.g., highlight selected stars)
                    stars.forEach(s => {
                        if (parseInt(s.getAttribute('data-value')) <= parseInt(
                                ratingValue)) {
                            s.classList.add('selected');
                        } else {
                            s.classList.remove('selected');
                        }
                    });
                });
            });
        });
        $(document).ready(function() {
            function load_comment(page) {
                var product_id = $('.comment_product_id').val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ url('/load-comment?page=') }}" + page,
                    method: 'POST',
                    data: {
                        product_id: product_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#comment_show').html(data.output);
                    }
                });
            }

            load_comment();

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                load_comment(page);
            });

            $('.star').click(function() {
                var ratingValue = $(this).attr('data-value');
                $('#rating').val(ratingValue);
                $('.star').removeClass('selected');
                $(this).addClass('selected');
            });

            $('.send-comment').click(function() {
                var product_id = $('.comment_product_id').val();
                var comment_name = $('.comment-name').val();
                var comment_content = $('.comment-content').val();
                var customer_id = $('.customer-id').val();
                var rating = $('#rating').val(); // Lấy giá trị số sao đã chọn
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ url('/send-comment') }}",
                    method: 'POST',
                    data: {
                        product_id: product_id,
                        comment_name: comment_name,
                        comment_content: comment_content,
                        customer_id: customer_id,
                        rating: rating, // Gửi số sao đã chọn
                        _token: _token
                    },
                    success: function(data) {
                        if (data.error) {
                            $('.comment-error-message').text(data.error).show();
                        } else {
                            load_comment(1);
                            $('.comment-content').val('');
                            $('#rating').val('');
                            $('.star').removeClass(
                                'selected');
                            $('.comment-error-message').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $(document).on('click', '.recall-comment', function() {
                var comment_id = $(this).data('comment_id');
                var _token = $('input[name="_token"]').val();

                if (confirm('Bạn có chắc là muốn xóa bình luận này?')) {
                    $.ajax({
                        url: "{{ url('/recall-comment') }}",
                        method: 'POST',
                        data: {
                            comment_id: comment_id,
                            _token: _token
                        },
                        success: function(data) {
                            load_comment();
                        }
                    });
                }
            });
        });
    </script>
    <!-- Bình luận-->

    <!-- Tìm kiếm-->
    <script>
        $('#keywords').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('/autocomplete-ajax') }}",
                    method: 'POST',
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#search_ajax').fadeIn();
                        $('#search_ajax').html(data);
                    }
                });
            } else {
                $('#search_ajax').fadeOut();
            }
        });
        $(document).on('click', '.li-search-ajax', function() {
            $('#keywords').val($(this).text());
            $('#search_ajax').fadeOut();
        })
    </script>
    <!-- Tìm kiếm-->

    <!-- Hình ảnh thu nhỏ - gallery -->
    <script>
        $(document).ready(function() {
            $('#imageGallery').lightSlider({
                gallery: true,
                item: 1,
                loop: true,
                thumbItem: 4,
                slideMargin: 0,
                enableDrag: true,
                currentPagerPosition: 'left',
                onSliderLoad: function(el) {
                    el.lightGallery({
                        selector: '#imageGallery .lslide'
                    });
                }
            });
        });
    </script>
    <!-- Hình ảnh thu nhỏ-->

    <!-- Giỏ hàng-->
    <script>
        hover_cart_view()
        show_cart_quantity()

        function hover_cart_view() {
            $.ajax({
                url: "{{ url('/hover-cart-view') }}",
                method: "GET",
                success: function(data) {
                    $('#cart-view').html(data);
                }
            })
        }

        function show_cart_quantity() {
            $.ajax({
                url: "{{ url('/show-cart-quantity') }}",
                method: "GET",
                success: function(data) {
                    $('#showCartQuantity').html(data);
                }
            })
        }
        $(document).on('click', '.remove-cart-view', function(e) {
            e.preventDefault();
            var session_id = $(this).data('session-id');
            $.ajax({
                url: "{{ url('delete-product-cart') }}/" + session_id,
                method: "GET",
                success: function(data) {
                    show_cart_quantity()
                    hover_cart_view()
                }
            });
        });
        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                var id = $(this).data('id');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var cart_category_product = $('.cart_category_product_' + id).val();
                var cart_brand_product = $('.cart_brand_product_' + id).val();
                var _token = $('input[name="_token"]').val();

                if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
                    alert("Số lượng bạn đặt đã vượt quá số lượng trong kho của chúng tôi");
                } else {
                    $.ajax({
                        url: "{{ url('/add-cart-ajax') }}",
                        method: 'POST',
                        data: {
                            cart_product_id: cart_product_id,
                            cart_product_name: cart_product_name,
                            cart_product_image: cart_product_image,
                            cart_product_price: cart_product_price,
                            cart_product_qty: cart_product_qty,
                            cart_category_product: cart_category_product,
                            cart_brand_product: cart_brand_product,
                            cart_product_quantity: cart_product_quantity,
                            _token: _token
                        },
                        success: function(data) {
                            toastr.options = {
                                "positionClass": "toast-bottom-right",
                                "timeOut": "3000"
                            };
                            toastr.success('Đã thêm sản phẩm vào giỏ hàng', '')
                            show_cart_quantity();
                            hover_cart_view();
                        }
                    });
                }
            });
        });
    </script>
    <!-- Giỏ hàng -->

    <!-- Hàm kiểm tra số điện thoại hợp lệ -->
    <script>
        function validatePhoneNumber(input) {
            var phoneNumber = input.value;
            var errorSpan = document.getElementById("phone-error");
            if (/^0\d{9,}$/.test(phoneNumber)) {
                errorSpan.textContent = "";
                return true;
            } else {
                errorSpan.textContent = "Số điện thoại không hợp lệ"; // Thiết lập nội dung thông báo
                return false;
            }
        }
    </script>
    <!-- Hàm kiểm tra số điện thoại hợp lệ -->

    <!-- Không được nhập khoảng trắng ở các ký tự đầu-->
    <script>
        function removeLeadingSpaces(input) {
            var value = input.value;
            if (value.charAt(0) === ' ') {
                input.value = value.trimLeft();
            }
        }
    </script>
    <!-- Không được nhập khoảng trắng ở các ký tự đầu-->

    <!-- Đặt hàng-->
    <script>
        $(document).ready(function() {
            function checkRequiredFields() {
                var filled = true;
                $('.form-control[required]').each(function() {
                    if ($(this).val() === '') {
                        filled = false;
                        return false;
                    }
                });
                return filled;
            }

            function isValidPhoneNumber(phoneNumber) {
                var phoneRegex = /^\d{10,}$/;
                return phoneRegex.test(phoneNumber);
            }

            function toggleSendOrderButton() {
                if (checkRequiredFields() && isValidPhoneNumber($('.shipping_phone').val())) {
                    $('.send_order').removeAttr('disabled');
                } else {
                    $('.send_order').attr('disabled', 'disabled');
                }
            }

            toggleSendOrderButton();

            $('.form-control').on('input', function() {
                toggleSendOrderButton();
            });

            $('.shipping_phone').on('input', function() {
                toggleSendOrderButton();
            });

            $('.send_order').click(function() {
                swal({
                        title: "Xác nhận đơn hàng!",
                        text: "Bạn có chắc là muốn đặt đơn hàng này?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "bg-primary text-white",
                        confirmButtonText: "Xác nhận",
                        cancelButtonClass: "bg-body-secondary",
                        cancelButtonText: "Suy nghĩ lại",
                        closeOnConfirm: false,
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            var shipping_name = $('.shipping_name').val();
                            var shipping_phone = $('.shipping_phone').val();

                            var shipping_address_city = $('.shipping_address_province').val();
                            var shipping_address_district = $('.shipping_address_district').val();
                            var shipping_address_wards = $('.shipping_address_wards').val();

                            var shipping_address = $('.shipping_address').val();
                            var shipping_notes = $('.shipping_notes').val();
                            var shipping_email = $('.shipping_email').val();
                            var shipping_method = $('.payment_select').val();
                            var order_fee = $('.order_fee').val();
                            var order_coupon = $('.order_coupon').val();
                            var order_total = $('.order_total').val();
                            var _token = $('input[name="_token"]').val();

                            $.ajax({
                                url: "{{ url('/confirm-order') }}",
                                method: 'POST',
                                data: {
                                    shipping_name: shipping_name,
                                    shipping_phone: shipping_phone,
                                    shipping_address_city: shipping_address_city,
                                    shipping_address_district: shipping_address_district,
                                    shipping_address_wards: shipping_address_wards,
                                    shipping_address: shipping_address,
                                    shipping_notes: shipping_notes,
                                    shipping_email: shipping_email,
                                    shipping_method: shipping_method,
                                    order_fee: order_fee,
                                    order_coupon: order_coupon,
                                    order_total: order_total,
                                    _token: _token
                                },
                                success: function(data) {
                                    swal({
                                            title: "Đặt hàng thành công!",
                                            text: "Chúng tôi đã nhận được đơn đặt hàng của bạn.",
                                            type: "success",
                                            confirmButtonClass: "bg-primary text-white",
                                            confirmButtonText: "OK"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                window.location.href =
                                                    "{{ url('/') }}";
                                            }
                                        })
                                },
                            });
                        }
                    });
            });
        });
    </script>
    <!-- Đặt hàng-->

    {{-- Lý do huỷ đơn hàng --}}
    <script>
        function checkFormValidity() {
            var reason = document.querySelector('input[name="reason"]:checked').value;
            var textarea = document.querySelector('.reason_cancellation');
            var confirmButton = document.querySelector('.modal-footer button[type="button"].btn.bg-success');

            if (reason === "Other" && textarea.value.trim() === "") {
                confirmButton.disabled = true;
            } else {
                confirmButton.disabled = false;
            }
        }

        document.querySelectorAll('input[name="reason"]').forEach((elem) => {
            elem.addEventListener("change", function(event) {
                var value = event.target.value;
                var textarea = document.querySelector('.reason_cancellation');
                if (value === "Other") {
                    textarea.style.display = "block";
                } else {
                    textarea.style.display = "none";
                }
                checkFormValidity();
            });
        });

        document.querySelector('.reason_cancellation').addEventListener("input", checkFormValidity);

        function cancellation_order(id) {
            var order_code = id;
            var reason = document.querySelector('input[name="reason"]:checked').value;
            var other_reason = document.querySelector('.reason_cancellation').value;
            if (reason === 'Other') {
                reason = other_reason;
            }
            var _token = document.querySelector('input[name="_token"]').value;
            $.ajax({
                url: "{{ url('/huy-don-hang') }}",
                method: 'POST',
                data: {
                    order_code: order_code,
                    reason: reason,
                    _token: _token
                },
                success: function(data) {
                    alert('Huỷ đơn hàng thành công');
                    location.reload();
                },
            });
        }
    </script>
    {{-- Lý do huỷ đơn hàng --}}

    <!-- Xác nhận xoá mã giảm giá?-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var deleteLinks = document.querySelectorAll('.delete-coupon');

            deleteLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    var confirmDelete = confirm("Bạn có chắc chắn muốn xoá bỏ mã giảm giá này?");
                    if (confirmDelete) {
                        window.location.href = link.getAttribute('href');
                    }
                });
            });
        });
    </script>
    <!-- Xác nhận xoá mã giảm giá?-->

</body>

</html>
