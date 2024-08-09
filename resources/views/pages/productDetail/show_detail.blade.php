@extends('layout')
@section('content')

    @foreach ($detail_product as $key => $value)
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-items"><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                <li class="breadcrumb-items"><a
                        href="{{ URL::to('/danh-muc-san-pham/' . $category_id) }}">{{ $product_cate }}</a></li>
                <li class="breadcrumb-items active" aria-current="page">{{ $product_name }}</li>
            </ol>
        </nav>
        {{-- Chi tiết sản phẩm --}}
        <div class="product-details row">
            <div class="col-lg-4 col-md-6 col-sm-12 ">
                <div class="view-product">
                    <ul id="imageGallery">
                        <li data-thumb="{{ URL::to('uploads/product/' . $value->product_image) }}"
                            data-src="{{ URL::to('uploads/product/' . $value->product_image) }}">
                            <img class="img-ligtSlider" src="{{ URL::to('uploads/product/' . $value->product_image) }}" />
                        </li>
                        @foreach ($gallery as $key => $gal)
                            <li data-thumb="{{ URL::to('uploads/gallery/' . $gal->gallery_image) }}"
                                data-src="{{ URL::to('uploads/gallery/' . $gal->gallery_image) }}">
                                <img class="img-ligtSlider" src="{{ URL::to('uploads/gallery/' . $gal->gallery_image) }}" />
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <div class="product-information">
                    <span class="name">{{ $value->product_name }}</span>
                    <div class="slogan-favo">
                        <input class="favorite-product" type="hidden" data-product_id="{{ $value->product_id }}"
                            data-customer_id="{{ Session::get('customer_id') }}">
                        <span class="slogan">KN-MILK uy tín và chất lượng</span>
                        <div id="show_favorite">
                            {{-- Hiển thị trạng thái sản phẩm yêu thích --}}
                        </div>
                    </div>
                    <div class="row row-information">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <span class="title">Mã SP:</span>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <span class="code">#{{ $value->product_code }}</span>
                        </div>
                    </div>
                    <div class="row row-information">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <span class="title">Tình trạng:</span>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            @if ($value->product_condition == '0' || $value->product_quantity <= '0')
                                <span class="status-sold-out">Hết hàng</span>
                            @else
                                <span class="status-stocking"><i class="fa-solid fa-circle"></i>Còn hàng</span>
                            @endif
                        </div>
                    </div>
                    <div class="row row-information">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <span class="title">Danh mục:</span>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <span class="text">{{ $value->category->category_name }}</span>
                        </div>
                    </div>
                    <div class="row row-information">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <span class="title">Thương hiệu:</span>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <span class="text">{{ $value->brand->brand_name }}</span>
                        </div>
                    </div>
                    @if ($value->promotional_price > 0)
                        <div class="price-info">
                            <h3 class="price">{{ number_format($value->promotional_price, 0, ',', '.') }}đ
                            </h3>
                            <h3 class="price-small text-dark-emphasis">
                                {{ number_format($value->product_price, 0, ',', '.') }}đ
                            </h3>
                        </div>
                    @else
                        <h3 class="price">{{ number_format($value->product_price, 0, ',', '.') }}đ
                            <span class="đ"></span>
                        </h3>
                    @endif
                    <div class="text-sold">Đã bán
                        {{ number_format($value->product_sold) }}</div>
                    @if ($value->product_condition == '0' || $value->product_quantity <= '0')
                        <img class="img-condition" src="{{ URL::to('frontend/images/product-details/sold_out.png') }}">
                        <p class="soldout-note mt-4"> Sản phẩm này đã bán hết, vui
                            lòng quay lại sau.</p>
                    @else
                        <form>
                            @csrf
                            <input type="hidden" class="cart_product_id_{{ $value->product_id }}"
                                value="{{ $value->product_id }}">
                            <input type="hidden" class="cart_product_name_{{ $value->product_id }}"
                                value="{{ $value->product_name }}">
                            <input type="hidden" class="cart_product_slug_{{ $value->product_id }}"
                                value="{{ $value->product_slug }}">
                            <input type="hidden" class="cart_product_image_{{ $value->product_id }}"
                                value="{{ $value->product_image }}">
                            <input type="hidden" class="cart_product_quantity_{{ $value->product_id }}"
                                value="{{ $value->product_quantity }}">
                            @if ($value->promotional_price > 0)
                                <input type="hidden" class="cart_product_price_{{ $value->product_id }}"
                                    value="{{ $value->promotional_price }}">
                            @else
                                <input type="hidden" class="cart_product_price_{{ $value->product_id }}"
                                    value="{{ $value->product_price }}">
                            @endif
                            <input type="hidden" class="cart_category_product_{{ $value->product_id }}"
                                value="{{ $value->category->category_name }}">
                            <input type="hidden" class="cart_brand_product_{{ $value->product_id }}"
                                value="{{ $value->brand->brand_name }}">
                            <div class="quantity">
                                <b class="title-qty">Số lượng:</b>
                                <input type="number" class="cart_product_qty_{{ $value->product_id }}" value="1"
                                    min="1" onkeypress="validateInput(event)" oninput="validateInput(event)"
                                    onchange="validateInput(event)">
                                <button type="button" class="add-to-cart buy-now" name="add-to-cart"
                                    data-id="{{ $value->product_id }}">
                                    Đặt hàng ngay <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
            {{-- Trung bình đánh giá sao sản phẩm --}}
            <div class="col-lg-3 col-md-12 col-sm-12">
                <div class="rating-summary">
                    <div class="average-rating">
                        <div class="average-value">
                            <span class="rating-number">{{ number_format($averageRating, 1) }}</span>
                            <span class="title">Đánh giá trung bình</span><br>
                            <span class="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $averageRating)
                                        ★
                                    @else
                                        ☆
                                    @endif
                                @endfor
                            </span>
                        </div>
                    </div>
                    <div class="starts-container">
                        <div class="stars">
                            @foreach ($starPercentages as $star => $percentage)
                                <div class="star">
                                    <div class="progress-bar" role="progressbar" aria-label="Basic example"
                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="count" id="{{ $star }}-star-count">
                                        @if (floor($percentage) == $percentage)
                                            {{ $percentage }}%
                                        @else
                                            {{ number_format($percentage, 1) }}%
                                        @endif
                                    </span>
                                    <span>
                                        @for ($i = 1; $i <= $star; $i++)
                                            ★
                                        @endfor
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            {{-- Trung bình đánh giá sao sản phẩm --}}
        </div>
        {{-- Chi tiết sản phẩm --}}

        {{-- Sản phẩm cùng loại --}}
        @if ($related->count() > 0)
            <div class="product-carosel">
                <h2 class="title-product hr-title">Sản phẩm cùng loại
                </h2>
                <div class="arrow arrow-left"><i class="fa-solid fa-square-caret-left"></i></div>
                <div class="arrow arrow-right"><i class="fa-solid fa-square-caret-right"></i></div>
                <div class="row row-content-carosel">
                    @foreach ($related as $key => $relate)
                        <div class="col-lg-2 col-md-4 col-sm-6 product-content">
                            <div class="productinfo">
                                <a class="img-center">
                                    <img src="{{ URL::to('uploads/product/' . $relate->product_image) }}"
                                        class="img-products" />
                                    @if ($relate->promotional_price > 0)
                                        <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                                    @endif
                                </a>
                                <a href="{{ URL::to('chi-tiet-san-pham/' . $relate->product_slug) }}">
                                    <p class="product-name">{{ $relate->product_name }}</p>
                                </a>
                                <div class="price-product">
                                    @if ($relate->promotional_price > 0)
                                        <div class="price-info">
                                            <div class="price-content1">
                                                <span
                                                    class="price-small">{{ number_format($relate->product_price, 0, ',', '.') }}</span>
                                                <span class="currency-unit">₫</span>
                                            </div>
                                            <div class="price-content2">
                                                <span
                                                    class="promotional-price">{{ number_format($relate->promotional_price, 0, ',', '.') }}</span>
                                                <span class="currency-unit">₫</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="price-content">
                                            <span
                                                class="price">{{ number_format($relate->product_price, 0, ',', '.') }}</span>
                                            <span class="currency-unit">₫</span>
                                        </div>
                                    @endif
                                </div>
                                <form>
                                    @csrf
                                    <input type="hidden" class="cart_product_id_{{ $relate->product_id }}"
                                        value="{{ $relate->product_id }}">
                                    <input type="hidden" class="cart_product_name_{{ $relate->product_id }}"
                                        value="{{ $relate->product_name }}">
                                    <input type="hidden" class="cart_product_slug_{{ $relate->product_id }}"
                                        value="{{ $relate->product_slug }}">
                                    <input type="hidden" class="cart_product_image_{{ $relate->product_id }}"
                                        value="{{ $relate->product_image }}">
                                    <input type="hidden" class="cart_product_quantity_{{ $relate->product_id }}"
                                        value="{{ $relate->product_quantity }}">
                                    @if ($relate->promotional_price > 0)
                                        <input type="hidden" class="cart_product_price_{{ $relate->product_id }}"
                                            value="{{ $relate->promotional_price }}">
                                    @else
                                        <input type="hidden" class="cart_product_price_{{ $relate->product_id }}"
                                            value="{{ $relate->product_price }}">
                                    @endif
                                    <input type="hidden" class="cart_category_product_{{ $relate->product_id }}"
                                        value="{{ $relate->category_name }}">
                                    <input type="hidden" class="cart_brand_product_{{ $relate->product_id }}"
                                        value="{{ $relate->brand_name }}">
                                    <input type="hidden" class="cart_product_qty_{{ $relate->product_id }}"
                                        value="1">

                                    <div class="order-button">
                                        <a class="add-to-cart" data-id="{{ $relate->product_id }}"><i
                                                class="fa-solid fa-cart-arrow-down"></i>Đặt hàng</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const rowContent = document.querySelector('.row-content-carosel');
                const leftArrow = document.querySelector('.arrow-left');
                const rightArrow = document.querySelector('.arrow-right');

                leftArrow.addEventListener('click', function() {
                    rowContent.scrollBy({
                        top: 0,
                        left: -rowContent.clientWidth /
                            2, // Cuộn nửa chiều rộng của phần tử chứa sản phẩm
                        behavior: 'smooth'
                    });
                });

                rightArrow.addEventListener('click', function() {
                    rowContent.scrollBy({
                        top: 0,
                        left: rowContent.clientWidth /
                            2, // Cuộn nửa chiều rộng của phần tử chứa sản phẩm
                        behavior: 'smooth'
                    });
                });
            });
        </script>
        {{-- Sản phẩm cùng loại --}}

        <div class="row">
            <div class="col-lg-10 col-md-9 col-sm-9 position-sticky top-0 pe-0">
                {{-- Mô tả sản phẩm --}}
                <div class="product-details-desc">
                    <h5 class="titleDetails">Mô tả sản phẩm</h5>
                    <span class="content-desc">
                        {!! $value->product_content !!}
                        @if ($value->video)
                            <iframe width="80%" height="450px"
                                src="https://www.youtube.com/embed/{{ $value->video->video_code_link }}"
                                title="{{ $value->video->video_title }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        @else
                            <span class="text-secondary">Hiện chưa có video cho sản phẩm này</span>
                        @endif
                    </span>
                </div>
                {{-- Mô tả sản phẩm --}}

                {{-- Đánh giá sản phẩm --}}
                <div class="comment">
                    <h4 class="title">Đánh giá sản phẩm</h4>
                    <div class="comment-write">
                        @if (Session::get('customer_id'))
                            <form>
                                @csrf
                                <input class="comment_product_id" type="hidden" name="comment_product_id"
                                    value="{{ $value->product_id }}">
                                <div class="form-group">
                                    @foreach ($customer as $customers)
                                        <input type="text" disabled class="form-control comment-name"
                                            value="{{ $customers->customer_name }}" id="inputAddress2"
                                            placeholder="Tên của bạn">
                                    @endforeach
                                    <input class="customer-id" type="hidden" value="{{ Session::get('customer_id') }}">
                                </div>
                                <div class="form-group-rating">
                                    <div class="rating">
                                        <span class="star" data-value="1">&#9733;</span>
                                        <span class="star" data-value="2">&#9733;</span>
                                        <span class="star" data-value="3">&#9733;</span>
                                        <span class="star" data-value="4">&#9733;</span>
                                        <span class="star" data-value="5">&#9733;</span>
                                    </div>
                                    <input type="hidden" name="rating" id="rating">
                                </div>
                                <textarea class="comment-content text-comment" name="comment" placeholder="Viết bình luận của bạn ở đây..."
                                    maxlength="800" minlength="1"></textarea>
                                <button type="button" class="send-comment">Đăng bình luận</button>
                                <div class="comment-error-message"></div>
                            </form>
                        @else
                            <a href="{{ url('login') }}">
                                <button type="button" class="login-comment">Đăng nhập để bình luận</button>
                            </a>
                        @endif
                    </div>
                    <form>
                        @csrf
                        <input class="comment_product_id" type="hidden" name="comment_product_id"
                            value="{{ $value->product_id }}">
                        <div id="comment_show">

                        </div>
                        <button id="load_more_btn" class="load-more-btn" type="button" style="display: none;">Tải
                            thêm bình luận</button>
                    </form>
                </div>
                {{-- Đánh giá sản phẩm --}}
            </div>
            {{-- Sản phẩm khuyến mãi --}}
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="promotional-product">
                    @foreach ($promotional_product as $key => $product)
                        <div class="col-lg-12 product-content">
                            <div class="productinfo">
                                <a class="img-center">
                                    <img class="img-products"
                                        src="{{ URL::to('/uploads/product/' . $product->product_image) }}" />
                                </a>
                                <a href="{{ URL::to('chi-tiet-san-pham/' . $product->product_slug) }}">
                                    <p class="product-name-table underline">{{ $product->product_name }}</p>
                                </a>
                                <div class="price-product">
                                    <div class="price-info">
                                        <div class="price-content1">
                                            <span
                                                class="price-small">{{ number_format($product->product_price, 0, ',', '.') }}
                                            </span>
                                            <span class="currency-unit">₫</span>
                                        </div>
                                        <div class="price-content2">
                                            <span class="promotional-price">
                                                {{ number_format($product->promotional_price, 0, ',', '.') }}
                                            </span>
                                            <span class="currency-unit">₫</span>
                                        </div>
                                    </div>
                                </div>
                                <form>
                                    @csrf
                                    <input type="hidden" class="cart_product_id_{{ $product->product_id }}"
                                        value="{{ $product->product_id }}">
                                    <input type="hidden" class="cart_product_name_{{ $product->product_id }}"
                                        value="{{ $product->product_name }}">
                                    <input type="hidden" class="cart_product_slug_{{ $product->product_id }}"
                                        value="{{ $product->product_slug }}">
                                    <input type="hidden" class="cart_product_image_{{ $product->product_id }}"
                                        value="{{ $product->product_image }}">
                                    <input type="hidden" class="cart_product_quantity_{{ $product->product_id }}"
                                        value="{{ $product->product_quantity }}">
                                    @if ($product->promotional_price > 0)
                                        <input type="hidden" class="cart_product_price_{{ $product->product_id }}"
                                            value="{{ $product->promotional_price }}">
                                    @else
                                        <input type="hidden" class="cart_product_price_{{ $product->product_id }}"
                                            value="{{ $product->product_price }}">
                                    @endif
                                    <input type="hidden" class="cart_category_product_{{ $product->product_id }}"
                                        value="{{ $product->category->category_name }}">
                                    <input type="hidden" class="cart_brand_product_{{ $product->product_id }}"
                                        value="{{ $product->brand->brand_name }}">
                                    <input type="hidden" class="cart_product_qty_{{ $product->product_id }}"
                                        value="1">

                                    <div class="order-button">
                                        <a class="add-to-cart" data-id="{{ $product->product_id }}"><i
                                                class="fa-solid fa-cart-arrow-down"></i>Đặt hàng
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- Sản phẩm khuyến mãi --}}
        </div>
    @endforeach

    {{-- Sản phẩm cùng thương hiệu --}}
    @if ($same_brand->count() > 0)
        <div class="product-same-brand">
            <h2 class="title-product">Sản phẩm cùng thương hiệu</h2>
            <div class="row product-row-container">
                @foreach ($same_brand as $key => $relate)
                    <div class="col-lg-2 col-md-4 col-sm-6 product-content">
                        <div class="productinfo">
                            <a class="img-center">
                                <img src="{{ URL::to('uploads/product/' . $relate->product_image) }}"
                                    class="img-products" />
                                @if ($relate->promotional_price > 0)
                                    <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                                @endif
                            </a>
                            <a href="{{ URL::to('chi-tiet-san-pham/' . $relate->product_slug) }}">
                                <p class="product-name">{{ $relate->product_name }}</p>
                            </a>
                            <div class="price-product">
                                @if ($relate->promotional_price > 0)
                                    <div class="price-info">
                                        <div class="price-content1">
                                            <span
                                                class="price-small">{{ number_format($relate->product_price, 0, ',', '.') }}</span>
                                            <span class="currency-unit">₫</span>
                                        </div>
                                        <div class="price-content2">
                                            <span
                                                class="promotional-price">{{ number_format($relate->promotional_price, 0, ',', '.') }}</span>
                                            <span class="currency-unit">₫</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="price-content">
                                        <span
                                            class="price">{{ number_format($relate->product_price, 0, ',', '.') }}</span>
                                        <span class="currency-unit">₫</span>
                                    </div>
                                @endif
                            </div>
                            <form>
                                @csrf
                                <input type="hidden" class="cart_product_id_{{ $relate->product_id }}"
                                    value="{{ $relate->product_id }}">
                                <input type="hidden" class="cart_product_name_{{ $relate->product_id }}"
                                    value="{{ $relate->product_name }}">
                                <input type="hidden" class="cart_product_slug_{{ $relate->product_id }}"
                                    value="{{ $relate->product_slug }}">
                                <input type="hidden" class="cart_product_image_{{ $relate->product_id }}"
                                    value="{{ $relate->product_image }}">
                                <input type="hidden" class="cart_product_quantity_{{ $relate->product_id }}"
                                    value="{{ $relate->product_quantity }}">
                                @if ($relate->promotional_price > 0)
                                    <input type="hidden" class="cart_product_price_{{ $relate->product_id }}"
                                        value="{{ $relate->promotional_price }}">
                                @else
                                    <input type="hidden" class="cart_product_price_{{ $relate->product_id }}"
                                        value="{{ $relate->product_price }}">
                                @endif
                                <input type="hidden" class="cart_category_product_{{ $relate->product_id }}"
                                    value="{{ $relate->category_name }}">
                                <input type="hidden" class="cart_brand_product_{{ $relate->product_id }}"
                                    value="{{ $relate->brand_name }}">
                                <input type="hidden" class="cart_product_qty_{{ $relate->product_id }}"
                                    value="1">

                                <div class="order-button">
                                    <a class="add-to-cart" data-id="{{ $relate->product_id }}"><i
                                            class="fa-solid fa-cart-arrow-down"></i>Đặt hàng
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    {{-- Sản phẩm cùng thương hiệu --}}

    <!-- Modal thông báo đăng nhập trước khi thêm yêu thích -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title" id="loginModalLabel">Thông báo</label>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="text">Bạn cần đăng nhập để thêm sản phẩm vào danh sách yêu thích.</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancle" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn-submit" id="confirmLogin">Đăng nhập</button>
                </div>
            </div>
        </div>
    </div>
@endsection
