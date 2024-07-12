@extends('admin_layout')
@section('admin_content')
    <form role="form" action="{{ URL::to('Admin/save-product') }}" method="post" enctype="multipart/form-data"
        autocomplete="off" id="saveForm">
        @csrf
        <div class="header-title">
            <div class="title-left">
                <h3 class="title-content">Thêm sản phẩm</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/all-product') }}">Quản lý sản phẩm</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Thêm sản phẩm
                    </li>
                </ol>
            </div>
            <div class="btn-header">
                <a href="{{ URL::to('Admin/add-product') }}">
                    <button type="button" class="btn-ref refesh-page" data-mdb-ripple-init><i
                            class="fa-solid fa-arrows-rotate"></i> Tải lại trang
                    </button>
                </a>
                <a href="">
                    <button type="submit" class="btn-add" data-mdb-ripple-init>
                        <span class="button-text"><i class="fa-solid fa-plus"></i> Thêm</span>
                        <span id="spinner" class="spinner">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </a>
                <a href="{{ URL::to('Admin/all-product') }}">
                    <button type="button" class="btn-back" data-mdb-ripple-init><i class="fa-solid fa-arrow-left"></i>
                        Trở về</button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-info-emphasis">Sản phẩm</h3>
                        <div class="card-tools">

                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tên sản phẩm<small class="note"><span class="required">*</span></small></label>
                            <input maxlength="70" type="text" name="product_name" required class="form-control"
                                placeholder="Nhập vào tên sản phẩm" data-slug-source="product">
                        </div>
                        <div class="form-group">
                            <label>Slug<small class="note"><span class="required">*</span><span> (tự
                                        động)</span></small></label>
                            <input type="text" name="product_slug" class="form-control" placeholder="Nhập vào slug"
                                required data-slug-target="product">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh đại diện
                                <small class="note"><span class="required">*</span></small>
                                <small class="note">(Kích thước ảnh nên là 680 x 760px - rộng x cao)</small>
                            </label>
                            <input type="file" name="product_image" required
                                class="form-control file-Image-input preview-image" accept="image/*"
                                onchange="previewImage(this)">

                            <img src="{{ URL::to('backend/images/no-image.png') }}" alt="" id="preview_image"
                                class="img-review">
                            <span class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label>Nội dung<small class="note">(không bắt buộc)</small></label>
                            <textarea style="resize:none" name="product_content" class="form-control" id="ckeditor_add_product"></textarea>
                        </div>
                        <div class="form-group select-button-groupt">
                            <button type="button" class="btn-video" data-bs-toggle="modal" data-bs-target="#videoModal">
                                Chọn video
                            </button>
                            <!-- Modal -->
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
                                                <label for="searchVideo" class="form-label">Tìm kiếm theo tiêu đề</label>
                                                <a href="{{ URL::to('Admin/add-video') }}" class="add-video-page">Thêm
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

                                    // Xử lý phân trang
                                    var videosPerPage = 16; // Chỉ hiển thị một video trên mỗi trang
                                    var videoItems = document.querySelectorAll('.video-item');
                                    var totalPages = Math.ceil(videoItems.length / videosPerPage);
                                    var currentPage = 1;

                                    function showPage(page) {
                                        // Ẩn tất cả video
                                        videoItems.forEach(function(item) {
                                            item.style.display = 'none';
                                        });

                                        // Hiển thị video của trang hiện tại
                                        var startIndex = (page - 1) * videosPerPage;
                                        var endIndex = startIndex + videosPerPage;
                                        for (var i = startIndex; i < endIndex; i++) {
                                            if (videoItems[i]) {
                                                videoItems[i].style.display = 'block';
                                            }
                                        }

                                        // Đánh dấu nút phân trang hiện tại là active
                                        var paginationButtons = document.querySelectorAll('.pagination-btn');
                                        paginationButtons.forEach(function(button) {
                                            if (parseInt(button.textContent) === page) {
                                                button.classList.add('active');
                                            } else {
                                                button.classList.remove('active');
                                            }
                                        });
                                    }

                                    // Hiển thị trang đầu tiên khi tải modal
                                    showPage(currentPage);

                                    // Tạo nút phân trang
                                    var pagination = document.getElementById('pagination');
                                    for (var i = 1; i <= totalPages; i++) {
                                        var button = document.createElement('button');
                                        button.textContent = i;
                                        button.classList.add('pagination-btn');
                                        button.setAttribute('data-page', i);
                                        pagination.appendChild(button);
                                    }

                                    // Xử lý khi người dùng chuyển trang
                                    var paginationButtons = document.querySelectorAll('.pagination-btn');
                                    paginationButtons.forEach(function(button) {
                                        button.addEventListener('click', function() {
                                            currentPage = parseInt(this.getAttribute('data-page'));
                                            showPage(currentPage);
                                        });
                                    });
                                });
                            </script>
                            <span id="selected_video_title">Chưa chọn video</span>
                            <input type="hidden" name="selected_video_id" id="selected_video_id">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card ">
                    <div class="card-header">
                        <h3 class="card-title text-info-emphasis">Chi tiết sản phẩm</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Mã sản phẩm<small class="note"><span class="required">*</span></small></label>
                            <input minlength="3" maxlength="10" type="text" name="product_code" required
                                class="form-control" placeholder="Nhập vào mã sản phẩm">
                        </div>
                        <div class="form-group">
                            <label>Số lượng<small class="note"><span class="required">*</span></small></label>
                            <input type="text" name="product_quantity" required class="form-control money_format"
                                maxlength="9" oninput="formatCurrency(this)" placeholder="Nhập vào số lượng sản phẩm">
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
                                    @foreach ($cate_product as $key => $cate)
                                        <option value="{{ $cate->category_id }}">{{ $cate->category_name }}</option>
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
                                    @foreach ($brand_product as $key => $brand)
                                        <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-info-emphasis">Giá sản phẩm</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Giá gốc<small class="note"><span class="required">*</span></small></label>
                            <input type="text" name="product_cost" required class="form-control money_format"
                                maxlength="11" oninput="formatCurrency(this)" placeholder="10,000đ" maxlength="11">
                        </div>
                        <div class="form-group">
                            <label>Giá bán<small class="note"><span class="required">*</span></small></label>
                            <input type="text" name="product_price" required class="form-control money_format"
                                maxlength="11" oninput="formatCurrency(this)" placeholder="10,000đ" maxlength="11">
                        </div>
                        <div class="form-group">
                            <label>Giá khuyến mãi<small class="note">(không bắt buộc)</small></label>
                            <input type="text" name="promotional_price" class="form-control money_format"
                                maxlength="11" oninput="formatCurrency(this)" placeholder="10,000đ">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-info-emphasis">Tuỳ chọn</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tình trạng</label>
                            <select class="form-select" name="product_condition">
                                <option value="1" selected>Còn hàng</option>
                                <option value="0">Hết hàng</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-select" name="product_status">
                                <option value="1" selected>Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
