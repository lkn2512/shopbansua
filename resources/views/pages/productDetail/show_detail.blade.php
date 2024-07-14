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
        <div class="product-details row">
            <div class="col-md-4">
                <div class="view-product text-center">
                    <ul id="imageGallery">
                        <li data-thumb="{{ URL::to('uploads/product/' . $value->product_image) }}"
                            data-src="{{ URL::to('uploads/product/' . $value->product_image) }}">
                            <img class="img-ligtSlider" src="{{ URL::to('uploads/product/' . $value->product_image) }}"
                                alt="" />
                        </li>
                        @foreach ($gallery as $key => $gal)
                            <li data-thumb="{{ URL::to('uploads/gallery/' . $gal->gallery_image) }}"
                                data-src="{{ URL::to('uploads/gallery/' . $gal->gallery_image) }}">
                                <img class="img-ligtSlider" src="{{ URL::to('uploads/gallery/' . $gal->gallery_image) }}"
                                    alt="" />
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-5">
                <div class="product-information">
                    <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                    <h5 class="name">{{ $value->product_name }}
                        <span class="logo">KN-MILK uy tín và chất lượng
                            @if (Session::get('customer_id'))
                                @if ($favorite)
                                    <i class="fa-solid fa-heart favorite-red"></i>
                                @else
                                    <button class="button_favorite add_favorite" data-id="{{ $value->product_id }}"
                                        data-customer_id="{{ Session::get('customer_id') }}"><span class="favorite-text"><i
                                                class="fa-solid fa-heart-circle-plus icon-favo"></i>Yêu
                                            thích</span></button>
                                @endif
                            @endif
                        </span>
                    </h5>
                    <p>Mã sản phẩm: <span class="text-detail text-warning-emphasis">#{{ $value->product_code }}</span></p>

                    @if ($value->product_condition == '0' || $value->product_quantity <= '0')
                        <p>Tình trạng: <span class="text-detail">Hết hàng</span></p>
                    @else
                        <p>Tình trạng: <span class="text-detail text-success">Còn hàng</span></p>
                    @endif

                    <p>Danh mục sản phẩm: <span class="text-detail">{{ $value->category->category_name }}</span></p>
                    <p>Thương hiệu: <span class="text-detail">{{ $value->brand->brand_name }}</span></p>
                    @if ($value->promotional_price > 0)
                        <div class="price-info">
                            <h3 class="price">{{ number_format($value->promotional_price, 0, ',', '.') }}đ
                            </h3>
                            <h3 class="price-small">{{ number_format($value->product_price, 0, ',', '.') }}đ
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
                        <img class="img-condition" src="{{ URL::to('frontend/images/product-details/sold_out.png') }}"
                            alt="">
                        <p class="soldout-note"><i class="fa-solid fa-circle-info"></i> Sản phẩm này đã bán hết, vui lòng
                            quay lại sau.</p>
                    @else
                        <form>
                            @csrf
                            <input type="hidden" class="cart_product_id_{{ $value->product_id }}"
                                value="{{ $value->product_id }}">
                            <input type="hidden" class="cart_product_name_{{ $value->product_id }}"
                                value="{{ $value->product_name }}">
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
            <div class="col-md-3">
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
        <div class="row">
            <div class="col-md-10">
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
            </div>
            <div class="col-md-2">
                <table class="table-product table-bordered position-sticky top-0">
                    <thead>
                        <tr class="tr-promotional">
                            <th class="title-promotional text-center">khuyến mãi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($promotional_product as $key => $product)
                            <tr>
                                <th scope="row">
                                    <div class="single-products">
                                        <div class="productinfo">
                                            <a class="img-center">
                                                <img class="img-products"
                                                    src="{{ URL::to('/uploads/product/' . $product->product_image) }}" />
                                            </a>
                                            <a href="{{ URL::to('/chi-tiet-san-pham/' . $product->product_id) }}">
                                                <p class="product-name-table underline">{{ $product->product_name }}</p>
                                            </a>
                                            <div class="price-info-right-content">
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
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    <div class="product-related">
        <div class="row title-product">
            <div class="col-md-9">
                <h2 class="text">Sản phẩm cùng loại</h2>
            </div>
        </div>
        <div class="row row-content">
            @foreach ($related as $key => $relate)
                <div class="col-md-2">
                    <div class="col-border">
                        <div class="mb-5">
                            <div class="single-products">
                                <div class="productinfo">
                                    <a class="img-center">
                                        <img src="{{ URL::to('uploads/product/' . $relate->product_image) }}"
                                            class="img-products" />
                                        @if ($relate->promotional_price > 0)
                                            <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                                        @endif
                                    </a>
                                    <a href="{{ URL::to('chi-tiet-san-pham/' . $relate->product_id) }}">
                                        <p class="product-name">{{ $relate->product_name }}</p>
                                    </a>
                                    <div class="price-product">
                                        @if ($relate->promotional_price > 0)
                                            <div class="price-info">
                                                <div class="price-content1">
                                                    <span
                                                        class="price-small">{{ number_format($relate->product_price, 0, ',', '.') }}
                                                    </span>
                                                    <span class="currency-unit">₫</span>
                                                </div>
                                                <div class="price-content2">
                                                    <span class="promotional-price">
                                                        {{ number_format($relate->promotional_price, 0, ',', '.') }}
                                                    </span>
                                                    <span class="currency-unit">₫</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="price-content">
                                                <span
                                                    class="price">{{ number_format($relate->product_price, 0, ',', '.') }}
                                                </span>
                                                <span class="currency-unit">₫</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
