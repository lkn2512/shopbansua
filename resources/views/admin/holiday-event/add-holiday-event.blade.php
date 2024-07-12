@extends('admin_layout')
@section('admin_content')
    <form action="{{ URL::to('Admin/save-holiday-event') }}" method="POST" onsubmit="return validateFormCheck()"
        enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="header-title">
            <div class="">
                <h3 class="title-content">Tạo sự kiện</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/holiday-event') }}">Sự kiện ngày lễ</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tạo sự kiện
                    </li>
                </ol>
            </div>
            <div class="btn-header">
                <a href="javascript:location.reload(true)">
                    <button type="button" class="btn-ref refesh-page"><i class="fa-solid fa-arrows-rotate"></i> Tải lại
                        trang
                    </button>
                </a>
                <a href="">
                    <button type="submit" class="btn-add">
                        <span class="button-text"> <i class="fa-solid fa-plus"></i> Thêm</span>
                    </button>
                </a>
                <a href="{{ URL::to('Admin/holiday-event') }}">
                    <button type="button" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Trở về
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card position-sticky top-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tên sự kiện<small class="note"><span class="required">*</span></small></label>
                            <input type="text" name="event_name" class="form-control" placeholder="Nhập vào tên sự kiện"
                                required maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="event_date">Ngày diễn ra<small class="note"><span
                                        class="required">*</span></small></label>
                            <input type="date" name="event_date" id="event_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="event_date">Ngày kết thúc<small class="note"><span
                                        class="required">*</span></small></label>
                            <input type="date" name="event_end_date" id="event_end_date" class="form-control" required>
                            <div class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh sự kiện
                                <small class="note"><span class="required">*</span></small>
                            </label>
                            <input type="file" name="event_image" required
                                class="form-control file-Image-input preview-image" accept="image/*"
                                onchange="previewImage(this)">
                            <img src="{{ URL::to('backend/images/no-image.png') }}" alt="" id="preview_image"
                                class="img-review">
                            <span class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-select" name="event_status">
                                <option value="1" selected>Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sản phẩm tham gia</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="searchProduct">Tìm kiếm sản phẩm:</label>
                                <input type="text" id="searchProduct" class="form-control"
                                    placeholder="Nhập tên sản phẩm...">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <a href="#" class="btn btn-sm btn-primary filter-link" data-filter="checked">Đã
                                    chọn</a>
                                <a href="#" class="btn btn-sm btn-info filter-link" data-filter="unchecked">Chưa
                                    chọn</a>
                                <a href="#" class="btn btn-sm btn-secondary filter-link" data-filter="all">Tất
                                    cả</a>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-md-3 product-item" data-checked="0">
                                    <div class="form-group form-content">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="products[]"
                                                value="{{ $product->product_id }}"
                                                id="product_{{ $product->product_id }}">
                                            <label class="form-check-label check-product-name"
                                                for="product_{{ $product->product_id }}">
                                                {{ $product->product_name }}
                                            </label>
                                            <div class="text-center">
                                                <img class="img-product-event"
                                                    src="/uploads/product/{{ $product->product_image }}">

                                            </div>
                                            @if ($product->promotional_price > 0)
                                                <span class="product-promotional">Khuyến mãi</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        function validateFormCheck() {
            var checkboxes = document.querySelectorAll('input[name="products[]"]');
            var productIds = [];

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    productIds.push(checkbox.value);
                }
            });
            // Kiểm tra xem có ít nhất 4 sản phẩm đã được chọn chưa
            if (productIds.length < 4) {
                alert('Vui lòng chọn ít nhất 4 sản phẩm.');
                return false;
            }

            // Kiểm tra ngày kết thúc phải lớn hơn ngày diễn ra
            var eventStartDate = document.getElementById('event_date').value;
            var eventEndDate = document.getElementById('event_end_date').value;

            if (eventEndDate <= eventStartDate) {
                var errorMessage = document.querySelector('.error-message');
                errorMessage.textContent = 'Ngày kết thúc phải lớn hơn ngày diễn ra.';
                errorMessage.style.display = 'block';
                return false;
            } else {
                var errorMessage = document.querySelector('.error-message');
                errorMessage.textContent = ''; // Reset error message
                errorMessage.style.display = 'none';
            }

            return true; // Nếu các điều kiện đều hợp lệ, cho phép submit form
        }
    </script>
@endsection
