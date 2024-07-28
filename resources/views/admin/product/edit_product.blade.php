@extends('admin_layout')
@section('admin_content')
    @foreach ($edit_product as $key => $pro)
        <form role="form" action="{{ URL::to('Admin/update-product/' . $pro->product_id) }}" method="post"
            enctype="multipart/form-data" id="editForm">
            {{ csrf_field() }}
            <div class="header-title">
                <div class="">
                    <h3 class="title-content">Chỉnh sửa sản phẩm</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/all-product') }}">Quản lý sản phẩm</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Chỉnh sửa sản phẩm
                        </li>
                    </ol>
                </div>
                <div class="btn-header">
                    <a href="{{ URL::to('Admin/edit-product/' . $pro->product_id) }}"> <button type="button"
                            class="btn-ref refesh-page" data-mdb-ripple-init><i class="fa-solid fa-arrows-rotate"></i>
                            Tải lại trang</button></a>
                    <a href="">
                        <button type="submit" class="btn-add" data-mdb-ripple-init>
                            <span class="button-text"><i class="fa-solid fa-check"></i> Lưu</span>
                        </button>
                    </a>
                    <a href="{{ URL::to('Admin/all-product') }}"><button type="button" class="btn-back"
                            data-mdb-ripple-init><i class="fa-solid fa-arrow-left"></i> Trở về</button></a>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-info-emphasis">Sản phẩm</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Tên sản phẩm<small class="note"><span class="required">*</span></small></label>
                                    <input maxlength="70" type="text" name="product_name" required class="form-control"
                                        placeholder="Nhập vào tên sản phẩm" value="{{ $pro->product_name }}"
                                        data-slug-source="product">
                                </div>
                                <div class="form-group">
                                    <label>Slug<small class="note"><span class="required">*</span><span> (tự
                                                động)</span></small></label>
                                    <input type="text" name="product_slug" class="form-control"
                                        placeholder="Nhập vào slug" required data-slug-target="product"
                                        value="{{ $pro->product_slug }}">
                                </div>
                                <div class="form-group">
                                    <label>Hình ảnh đại diện
                                        <small class="note"><span class="required">*</span></small>
                                        <small class="note">(Kích thước ảnh nên là 680 x 760px - rộng x cao)</small>
                                    </label>
                                    <input type="file" name="product_image" class="form-control file-Image-input"
                                        accept="image/*">
                                    <span class="error-message"></span>
                                    <img class="img-edit-product" id="img-edit-{{ $pro->product_id }}"
                                        src="{{ URL::to('/uploads/product/' . $pro->product_image) }}">
                                </div>
                                <div class="form-group">
                                    <label>Nội dung<small class="note">(không bắt buộc)</small></label>
                                    <textarea id="summernote_edit_product" name="product_content">{{ $pro->product_content }}</textarea>
                                </div><br>
                                <div class="form-group select-button-groupt">
                                    <button class="btn-video" type="button" data-bs-toggle="modal"
                                        data-bs-target="#videoModal">Chọn video
                                    </button>
                                    {{-- Xử lý chọn video --}}
                                    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel"
                                        aria-hidden="true" data-bs-keyboard="false" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="videoModalLabel">Chọn video</h5>

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="searchVideo" class="form-label">Tìm kiếm theo tiêu
                                                            đề</label>
                                                        <a href="{{ URL::to('Admin/add-video') }}"class="add-video-page">Thêm
                                                            video</a>
                                                        <input type="text" class="form-control" id="searchVideo"
                                                            placeholder="Nhập từ khóa tìm kiếm">
                                                    </div>
                                                    <div class="row" id="videoList">
                                                        @foreach ($videos as $value)
                                                            <div class="col-md-3">
                                                                <div class="video-item" style="display: none;">
                                                                    <div class="card">
                                                                        <div class="card-header text-auto"
                                                                            title="{{ $value->video_title }}">
                                                                            <input type="radio" name="selected_video"
                                                                                {{ $videoTitle == $value->video_title ? 'checked' : '' }}
                                                                                value="{{ $value->video_id }}">
                                                                            {{ $value->video_title }}
                                                                        </div>
                                                                        <div class="card-body">
                                                                            {!! $value->video_iframe !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="mt-3 d-flex justify-content-center">
                                                        <div id="pagination"></div> <!-- Placeholder for pagination -->
                                                    </div>
                                                </div>
                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="button" class="btn bg-default"
                                                        id="confirm_video_selection">Chọn</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var myModal = new bootstrap.Modal(document.getElementById('videoModal'), {
                                                keyboard: false
                                            });

                                            var confirmBtn = document.getElementById('confirm_video_selection');
                                            confirmBtn.addEventListener('click', function() {
                                                var selectedVideoId = document.querySelector('input[name="selected_video"]:checked');
                                                if (selectedVideoId) {
                                                    var selectedVideoTitle = selectedVideoId.parentElement.textContent.trim();
                                                    document.getElementById('selected_video_id').value = selectedVideoId.value;
                                                    document.getElementById('selected_video_title').textContent = selectedVideoTitle;
                                                    myModal.hide();
                                                } else {
                                                    alert('Vui lòng chọn một video.');
                                                }
                                            });

                                            // Xử lý sự kiện tìm kiếm
                                            var searchInput = document.getElementById('searchVideo');
                                            searchInput.addEventListener('input', function() {
                                                var searchText = this.value.toLowerCase();
                                                var videoItems = document.querySelectorAll('.video-item');

                                                videoItems.forEach(function(item) {
                                                    var titleElement = item.querySelector('.card-header');
                                                    var titleText = titleElement.textContent.trim().toLowerCase();

                                                    if (titleText.includes(searchText)) {
                                                        item.style.display = 'block';
                                                    } else {
                                                        item.style.display = 'none';
                                                    }
                                                });
                                            });

                                            // Hiển thị tất cả các video
                                            var videoItems = document.querySelectorAll('.video-item');
                                            videoItems.forEach(function(item) {
                                                item.style.display = 'block';
                                            });
                                        });
                                    </script>
                                    {{-- Xử lý chọn video --}}
                                    <span id="selected_video_title"> {{ $videoTitle }}</span>
                                    <input type="hidden" name="selected_video_id" id="selected_video_id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-info-emphasis">Chi tiết sản phẩm</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Mã sản phẩm<small class="note"><span
                                                    class="required">*</span></small></label>
                                        <input minlength="3" maxlength="10" type="text" name="product_code" required
                                            class="form-control" placeholder="Nhập vào mã sản phẩm"
                                            value="{{ $pro->product_code }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Số lượng<small class="note"><span
                                                    class="required">*</span></small></label>
                                        <input type="text" name="product_quantity" required
                                            class="form-control money_format" maxlength="9"
                                            oninput="formatCurrency(this)" placeholder="Nhập vào số lượng sản phẩm"
                                            value="{{ $pro->product_quantity }}">
                                    </div>
                                    <div class="form-group">
                                        <div class="label-container">
                                            <label>Danh mục</label>
                                            <span class="add-new">
                                                <a href="{{ URL::to('Admin/add-category-product') }}">Thêm mới</a>
                                            </span>
                                        </div>
                                        <div class="input-group mb-3">
                                            <select class="form-control select2" name="product_cate">
                                                @foreach ($cate_product as $cate)
                                                    <option value="{{ $cate->category_id }}"
                                                        {{ $cate->category_id == $pro->category_id ? 'selected' : '' }}>
                                                        {{ $cate->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="label-container">
                                            <label>Thương hiệu</label>
                                            <span class="add-new">
                                                <a href="{{ URL::to('Admin/add-brand-product') }}">Thêm mới</a>
                                            </span>
                                        </div>
                                        <div class="input-group mb-3">
                                            <select class="form-control select2" name="product_brand">
                                                @foreach ($brand_product as $brand)
                                                    <option value="{{ $brand->brand_id }}"
                                                        {{ $brand->brand_id == $pro->brand_id ? 'selected' : '' }}>
                                                        {{ $brand->brand_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="label-container">
                                            <label>Chuyên mục</label>
                                            <span class="add-new">
                                                <a href="{{ URL::to('Admin/all-section-product/create-section') }}">Thêm
                                                    mới</a>
                                            </span>
                                        </div>
                                        <div class="input-group mb-3">
                                            <select class="form-control select2" name="section_id">
                                                <option value={{ null }}>Không có</option>
                                                @foreach ($section_product as $sec)
                                                    <option value="{{ $sec->section_id }}"
                                                        {{ $pro->section_id == $sec->section_id ? 'selected' : '' }}>
                                                        {{ $sec->section_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-info-emphasis">Giá sản phẩm</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Giá gốc<small class="note"><span
                                                    class="required">*</span></small></label>
                                        <input type="text" name="product_cost" required
                                            class="form-control money_format price" oninput="formatCurrency(this)"
                                            placeholder="10,000đ" value="{{ $pro->product_cost }}" maxlength="11">
                                    </div>
                                    <div class="form-group">
                                        <label>Giá bán<small class="note"><span
                                                    class="required">*</span></small></label>
                                        <input type="text" name="product_price" required
                                            class="form-control money_format price" oninput="formatCurrency(this)"
                                            placeholder="10,000đ" value="{{ $pro->product_price }}" maxlength="11">
                                    </div>
                                    <div class="form-group">
                                        <label>Giá khuyến mãi<small class="note"><span
                                                    class="required">*</span></small></label>
                                        <input type="text" name="promotional_price"
                                            class="form-control money_format price" oninput="formatCurrency(this)"
                                            placeholder="10,000đ" value="{{ $pro->promotional_price }}" maxlength="11">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-info-emphasis">Tuỳ chọn</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Tình trạng</label>
                                        <select class="form-select" name="product_condition">
                                            @if ($pro->product_condition == '1')
                                                <option value="1" selected>Còn hàng</option>
                                                <option value="0">Hết hàng</option>
                                            @else
                                                <option value="0" selected>Hết hàng</option>
                                                <option value="1">Còn Hàng</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <select class="form-select" name="product_status">
                                            @if ($pro->product_status == '1')
                                                <option value="1" selected>Hiển thị</option>
                                                <option value="0">Ẩn</option>
                                            @else
                                                <option value="0" selected>Ẩn</option>
                                                <option value="1">Hiển thị</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
