@extends('layout')
@section('content')
    @include('pages.content-top.slider')

    <h2 class="title-product text-center mb-3">DANH MỤC SẢN PHẨM</h2>
    <div class="tr-job-posted section-padding">
        <div class="job-tab">
            <div class="text-center">
                <ul class="nav nav-tabs center" role="tablist">
                    @php $i = 0; @endphp
                    @foreach ($category as $key => $cate_tab)
                        @php $i++; @endphp
                        <li role="presentation" class="tabs_pro" data-id="{{ $cate_tab->category_id }}">
                            <a class="{{ $i == 1 ? 'active' : '' }}" href="" role="tab"
                                data-bs-toggle="tab">{{ $cate_tab->category_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div id="tab_product">
                {{-- sản phẩm theo danh mục hiển thị ở đây --}}
            </div>
        </div>
    </div>

    <h2 class="title-product">Sản phẩm mới nhất</h2>
    <div class="row product-row-container">
        @foreach ($all_product_new as $key => $new)
            <div class="col-lg-2 col-md-4 col-sm-6 product-content">
                <div class="productinfo">
                    <a class="img-center">
                        <img class="img-products" src="{{ URL::to('/uploads/product/' . $new->product_image) }}" />
                        @if ($new->promotional_price > 0)
                            <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                        @endif
                    </a>
                    <a href="{{ URL::to('chi-tiet-san-pham/' . $new->product_id) }}">
                        <p class="product-name">{{ $new->product_name }}</p>
                    </a>
                    <div class="price-product">
                        @if ($new->promotional_price > 0)
                            <div class="price-info">
                                <div class="price-content1">
                                    <span class="price-small">{{ number_format($new->product_price, 0, ',', '.') }}</span>
                                    <span class="currency-unit">₫</span>
                                </div>
                                <div class="price-content2">
                                    <span
                                        class="promotional-price">{{ number_format($new->promotional_price, 0, ',', '.') }}</span>
                                    <span class="currency-unit">₫</span>
                                </div>
                            </div>
                        @else
                            <div class="price-content">
                                <span class="price">{{ number_format($new->product_price, 0, ',', '.') }}</span>
                                <span class="currency-unit">₫</span>
                            </div>
                        @endif
                    </div>
                    <form>
                        @csrf
                        <input type="hidden" class="cart_product_id_{{ $new->product_id }}"
                            value="{{ $new->product_id }}">
                        <input type="hidden" class="cart_product_name_{{ $new->product_id }}"
                            value="{{ $new->product_name }}">
                        <input type="hidden" class="cart_product_image_{{ $new->product_id }}"
                            value="{{ $new->product_image }}">
                        <input type="hidden" class="cart_product_quantity_{{ $new->product_id }}"
                            value="{{ $new->product_quantity }}">
                        @if ($new->promotional_price > 0)
                            <input type="hidden" class="cart_product_price_{{ $new->product_id }}"
                                value="{{ $new->promotional_price }}">
                        @else
                            <input type="hidden" class="cart_product_price_{{ $new->product_id }}"
                                value="{{ $new->product_price }}">
                        @endif
                        <input type="hidden" class="cart_category_product_{{ $new->product_id }}"
                            value="{{ $new->category->category_name }}">
                        <input type="hidden" class="cart_brand_product_{{ $new->product_id }}"
                            value="{{ $new->brand->brand_name }}">
                        <input type="hidden" class="cart_product_qty_{{ $new->product_id }}" value="1">

                        <div class="order-button">
                            <a class="add-to-cart" data-id="{{ $new->product_id }}"><i
                                    class="fa-solid fa-cart-arrow-down"></i>Đặt hàng
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
        <div class="view-all">
            <a href="{{ url('/all-products-new') }}">Xem tất cả</a>
        </div>
    </div>

    <h2 class="title-product">Sản phẩm bán chạy được nhiều người tin dùng</h2>
    <div class="row product-row-container">
        @foreach ($selling_product as $key => $sell)
            <div class="col-lg-2 col-md-4 col-sm-6 product-content">
                <div class="productinfo">
                    <a class="img-center">
                        <img class="img-products" src="{{ URL::to('/uploads/product/' . $sell->product_image) }}" />
                        @if ($sell->promotional_price > 0)
                            <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                        @endif
                    </a>
                    <a href="{{ URL::to('chi-tiet-san-pham/' . $sell->product_id) }}">
                        <p class="product-name">{{ $sell->product_name }}</p>
                    </a>
                    <div class="price-product">
                        @if ($sell->promotional_price > 0)
                            <div class="price-info">
                                <div class="price-content1">
                                    <span class="price-small">{{ number_format($sell->product_price, 0, ',', '.') }}
                                    </span>
                                    <span class="currency-unit">₫</span>
                                </div>
                                <div class="price-content2">
                                    <span class="promotional-price">
                                        {{ number_format($sell->promotional_price, 0, ',', '.') }}
                                    </span>
                                    <span class="currency-unit">₫</span>
                                </div>
                            </div>
                        @else
                            <div class="price-content">
                                <span class="price">{{ number_format($sell->product_price, 0, ',', '.') }}
                                </span>
                                <span class="currency-unit">₫</span>
                            </div>
                        @endif
                    </div>
                    <form>
                        @csrf
                        <input type="hidden" class="cart_product_id_{{ $sell->product_id }}"
                            value="{{ $sell->product_id }}">
                        <input type="hidden" class="cart_product_name_{{ $sell->product_id }}"
                            value="{{ $sell->product_name }}">
                        <input type="hidden" class="cart_product_image_{{ $sell->product_id }}"
                            value="{{ $sell->product_image }}">
                        <input type="hidden" class="cart_product_quantity_{{ $sell->product_id }}"
                            value="{{ $sell->product_quantity }}">
                        @if ($sell->promotional_price > 0)
                            <input type="hidden" class="cart_product_price_{{ $sell->product_id }}"
                                value="{{ $sell->promotional_price }}">
                        @else
                            <input type="hidden" class="cart_product_price_{{ $sell->product_id }}"
                                value="{{ $sell->product_price }}">
                        @endif
                        <input type="hidden" class="cart_category_product_{{ $sell->product_id }}"
                            value="{{ $sell->category->category_name }}">
                        <input type="hidden" class="cart_brand_product_{{ $sell->product_id }}"
                            value="{{ $sell->brand->brand_name }}">
                        <input type="hidden" class="cart_product_qty_{{ $sell->product_id }}" value="1">

                        <div class="order-button">
                            <a class="add-to-cart" data-id="{{ $sell->product_id }}"><i
                                    class="fa-solid fa-cart-arrow-down"></i>Đặt hàng
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
        <div class="view-all">
            <a href="{{ url('/all-product-selling') }}">Xem tất cả</a>
        </div>
    </div>

    {{-- sự kiện sản phẩm --}}
    @php
        use Carbon\Carbon;
        $currentDate = Carbon::now()->toDateString();
    @endphp
    @foreach ($holidayEvent as $value)
        @if ($currentDate >= $value->event_date && $currentDate <= $value->event_end_date)
            <section class="ftco-section-holiday">
                <div class="row mt-4">
                    <div class="col-lg-5 col-md-6 col-sm-6 holiday-left">
                        <span class="holiday-name">{{ $value->event_name }}</span>
                        <span class="holiday-end-date countdown-timer"
                            data-end-date="{{ \Carbon\Carbon::parse($value->event_end_date)->format('Y-m-d H:i:s') }}"></span>
                        <img src="{{ asset('/uploads/event/' . $value->event_image) }}" alt="">
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-6 holiday-right">
                        <div class="featured-carousel owl-carousel">
                            @foreach ($productsByEvent[$value->holiday_event_id] as $product)
                                <div class="item">
                                    <div class="blog-entry">
                                        <a href="#" class="block-20 d-flex align-items-start"
                                            style="background-image: url('{{ URL::to('/uploads/product/' . $product->product_image) }}');">
                                            @if ($product->promotional_price > 0)
                                                {{-- <span class="header-image-promotional">Khuyến mãi đặc biệt</span> --}}
                                                <div class="meta-date text-center p-2">
                                                    <span class="day">Giá</span>
                                                    <span class="mos">ưu</span>
                                                    <span class="yr">đãi!</span>
                                                </div>
                                            @endif
                                        </a>
                                        <a href="{{ URL::to('chi-tiet-san-pham/' . $product->product_id) }}">
                                            <p class="heading-product-name">{{ $product->product_name }}</p>
                                        </a>
                                        <div class="price-product">
                                            @if ($product->promotional_price > 0)
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
                                            @else
                                                <div class="price-content">
                                                    <span
                                                        class="price">{{ number_format($product->product_price, 0, ',', '.') }}
                                                    </span>
                                                    <span class="currency-unit">₫</span>
                                                </div>
                                            @endif
                                        </div>
                                        <form>
                                            @csrf
                                            <input type="hidden" class="cart_product_id_{{ $product->product_id }}"
                                                value="{{ $product->product_id }}">
                                            <input type="hidden" class="cart_product_name_{{ $product->product_id }}"
                                                value="{{ $product->product_name }}">
                                            <input type="hidden" class="cart_product_image_{{ $product->product_id }}"
                                                value="{{ $product->product_image }}">
                                            <input type="hidden"
                                                class="cart_product_quantity_{{ $product->product_id }}"
                                                value="{{ $product->product_quantity }}">
                                            @if ($product->promotional_price > 0)
                                                <input type="hidden"
                                                    class="cart_product_price_{{ $product->product_id }}"
                                                    value="{{ $product->promotional_price }}">
                                            @else
                                                <input type="hidden"
                                                    class="cart_product_price_{{ $product->product_id }}"
                                                    value="{{ $product->product_price }}">
                                            @endif
                                            <input type="hidden"
                                                class="cart_category_product_{{ $product->product_id }}"
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
                </div>
                <script>
                    // Hàm để thêm số 0 vào trước những số có một chữ số
                    function formatNumber(number) {
                        return number < 10 ? '0' + number : number;
                    }

                    // Hàm khởi tạo đếm ngược cho từng phần tử
                    function initializeCountdown(element) {
                        var endDate = new Date(element.getAttribute('data-end-date')).getTime();

                        var countdownFunction = setInterval(function() {
                            var now = new Date().getTime();
                            var distance = endDate - now;

                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            // Định dạng các số để đảm bảo chúng có hai chữ số
                            days = formatNumber(days);
                            hours = formatNumber(hours);
                            minutes = formatNumber(minutes);
                            seconds = formatNumber(seconds);

                            // Hiển thị kết quả trong phần tử
                            element.innerHTML = "Còn " + days + " ngày, " + hours + ":" + minutes + ":" + seconds;

                            // Nếu đếm ngược kết thúc, hiển thị thông báo
                            if (distance < 0) {
                                clearInterval(countdownFunction);
                                element.innerHTML = "Sự kiện đã kết thúc";
                            }
                        }, 1000);
                    }

                    // Tìm tất cả các phần tử có class "countdown-timer" và khởi tạo đếm ngược
                    document.querySelectorAll('.countdown-timer').forEach(function(element) {
                        initializeCountdown(element);
                    });
                </script>
            </section>
        @endif
    @endforeach
    {{-- sự kiện sản phẩm --}}

    <h2 class="title-product">Sản phẩm nổi bật</h2>
    <div class="row product-row-container">
        @foreach ($featuredProducts as $key => $avgRat)
            <div class="col-lg-2 col-md-4 col-sm-6 product-content">
                <div class="productinfo">
                    <a class="img-center">
                        <img class="img-products" src="{{ URL::to('/uploads/product/' . $avgRat->product_image) }}" />
                        @if ($avgRat->promotional_price > 0)
                            <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                        @endif
                    </a>
                    <a href="{{ URL::to('chi-tiet-san-pham/' . $avgRat->product_id) }}">
                        <p class="product-name">{{ $avgRat->product_name }}</p>
                    </a>
                    <div class="price-product">
                        @if ($avgRat->promotional_price > 0)
                            <div class="price-info">
                                <div class="price-content1">
                                    <span class="price-small">{{ number_format($avgRat->product_price, 0, ',', '.') }}
                                    </span>
                                    <span class="currency-unit">₫</span>
                                </div>
                                <div class="price-content2">
                                    <span class="promotional-price">
                                        {{ number_format($avgRat->promotional_price, 0, ',', '.') }}
                                    </span>
                                    <span class="currency-unit">₫</span>
                                </div>
                            </div>
                        @else
                            <div class="price-content">
                                <span class="price">{{ number_format($avgRat->product_price, 0, ',', '.') }}
                                </span>
                                <span class="currency-unit">₫</span>
                            </div>
                        @endif
                    </div>
                    <form>
                        @csrf
                        <input type="hidden" class="cart_product_id_{{ $avgRat->product_id }}"
                            value="{{ $avgRat->product_id }}">
                        <input type="hidden" class="cart_product_name_{{ $avgRat->product_id }}"
                            value="{{ $avgRat->product_name }}">
                        <input type="hidden" class="cart_product_image_{{ $avgRat->product_id }}"
                            value="{{ $avgRat->product_image }}">
                        <input type="hidden" class="cart_product_quantity_{{ $avgRat->product_id }}"
                            value="{{ $avgRat->product_quantity }}">
                        @if ($avgRat->promotional_price > 0)
                            <input type="hidden" class="cart_product_price_{{ $avgRat->product_id }}"
                                value="{{ $avgRat->promotional_price }}">
                        @else
                            <input type="hidden" class="cart_product_price_{{ $avgRat->product_id }}"
                                value="{{ $avgRat->product_price }}">
                        @endif
                        <input type="hidden" class="cart_category_product_{{ $avgRat->product_id }}"
                            value="{{ $avgRat->category->category_name }}">
                        <input type="hidden" class="cart_brand_product_{{ $avgRat->product_id }}"
                            value="{{ $avgRat->brand->brand_name }}">
                        <input type="hidden" class="cart_product_qty_{{ $avgRat->product_id }}" value="1">

                        <div class="order-button">
                            <a class="add-to-cart" data-id="{{ $avgRat->product_id }}"><i
                                    class="fa-solid fa-cart-arrow-down"></i>Đặt hàng
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
        <div class="view-all">
            <a href="{{ url('/san-pham-noi-bat') }}">Xem tất cả</a>
        </div>
    </div>

    <h2 class="title-product">Được quan tâm nhiều nhất</h2>
    <div class="row product-row-container">
        @foreach ($view_product as $key => $view)
            <div class="col-lg-2 col-md-4 col-sm-6 product-content">
                <div class="productinfo">
                    <a class="img-center">
                        <img class="img-products" src="{{ URL::to('/uploads/product/' . $view->product_image) }}" />
                        @if ($view->promotional_price > 0)
                            <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                        @endif
                    </a>
                    <a href="{{ URL::to('chi-tiet-san-pham/' . $view->product_id) }}">
                        <p class="product-name">{{ $view->product_name }}</p>
                    </a>
                    <div class="price-product">
                        @if ($view->promotional_price > 0)
                            <div class="price-info">
                                <div class="price-content1">
                                    <span class="price-small">{{ number_format($view->product_price, 0, ',', '.') }}
                                    </span>
                                    <span class="currency-unit">₫</span>
                                </div>
                                <div class="price-content2">
                                    <span class="promotional-price">
                                        {{ number_format($view->promotional_price, 0, ',', '.') }}
                                    </span>
                                    <span class="currency-unit">₫</span>
                                </div>
                            </div>
                        @else
                            <div class="price-content">
                                <span class="price">{{ number_format($view->product_price, 0, ',', '.') }}
                                </span>
                                <span class="currency-unit">₫</span>
                            </div>
                        @endif
                    </div>
                    <form>
                        @csrf
                        <input type="hidden" class="cart_product_id_{{ $view->product_id }}"
                            value="{{ $view->product_id }}">
                        <input type="hidden" class="cart_product_name_{{ $view->product_id }}"
                            value="{{ $view->product_name }}">
                        <input type="hidden" class="cart_product_image_{{ $view->product_id }}"
                            value="{{ $view->product_image }}">
                        <input type="hidden" class="cart_product_quantity_{{ $view->product_id }}"
                            value="{{ $view->product_quantity }}">
                        @if ($view->promotional_price > 0)
                            <input type="hidden" class="cart_product_price_{{ $view->product_id }}"
                                value="{{ $view->promotional_price }}">
                        @else
                            <input type="hidden" class="cart_product_price_{{ $view->product_id }}"
                                value="{{ $view->product_price }}">
                        @endif
                        <input type="hidden" class="cart_category_product_{{ $view->product_id }}"
                            value="{{ $view->category->category_name }}">
                        <input type="hidden" class="cart_brand_product_{{ $view->product_id }}"
                            value="{{ $view->brand->brand_name }}">
                        <input type="hidden" class="cart_product_qty_{{ $view->product_id }}" value="1">

                        <div class="order-button">
                            <a class="add-to-cart" data-id="{{ $view->product_id }}"><i
                                    class="fa-solid fa-cart-arrow-down"></i>Đặt hàng
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
        <div class="view-all">
            <a href="{{ url('/duoc-quan-tam-nhieu') }}">Xem tất cả</a>
        </div>
    </div>

    <h2 class="title-product">Best selling!</h2>
    <div class="product-details row mb-5">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="view-product text-center">
                <ul id="imageGallery">
                    <li data-thumb="{{ URL::to('uploads/product/' . $best_selling->product_image) }}"
                        data-src="{{ URL::to('uploads/product/' . $best_selling->product_image) }}">
                        <img class="img-ligtSlider"
                            src="{{ URL::to('uploads/product/' . $best_selling->product_image) }}" alt="" />
                    </li>
                    @foreach ($galleries as $key => $gal)
                        <li data-thumb="{{ URL::to('uploads/gallery/' . $gal->gallery_image) }}"
                            data-src="{{ URL::to('uploads/gallery/' . $gal->gallery_image) }}">
                            <img class="img-ligtSlider" src="{{ URL::to('uploads/gallery/' . $gal->gallery_image) }}"
                                alt="" />
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <div class="product-information">
                <span class="name">
                    {{ $best_selling->product_name }}
                </span>
                <div class="slogan-favo">
                    <input class="favorite-product" type="hidden" data-product_id="{{ $best_selling->product_id }}"
                        data-customer_id="{{ Session::get('customer_id') }}">
                    <span class="slogan">KN-MILK uy tín và chất lượng</span>
                    <div id="show_favorite">
                        {{-- Hiển thị trạng thái sản phẩm yêu thích --}}
                    </div>
                </div>
                <div class="row row-information">
                    <div class="col-lg-3 col-md-4 col-sm-3">
                        <span class="title">Mã SP:</span>
                    </div>
                    <div class="col-lg-9 col-md-6 col-sm-9">
                        <span class="code">#{{ $best_selling->product_code }}</span>
                    </div>
                </div>
                <div class="row row-information">
                    <div class="col-lg-3 col-md-4 col-sm-3">
                        <span class="title">Tình trạng:</span>
                    </div>
                    <div class="col-lg-9 col-md-6 col-sm-9">
                        @if ($best_selling->product_condition == '0' || $best_selling->product_quantity <= '0')
                            <span class="status-sold-out">Hết hàng</span>
                        @else
                            <span class="status-stocking"><i class="fa-solid fa-circle"></i>Còn hàng</span>
                        @endif
                    </div>
                </div>
                <div class="row row-information">
                    <div class="col-lg-3 col-md-4 col-sm-3">
                        <span class="title">Danh mục:</span>
                    </div>
                    <div class="col-lg-9 col-md-6 col-sm-9">
                        <span class="text">{{ $best_selling->category->category_name }}</span>
                    </div>
                </div>
                <div class="row row-information">
                    <div class="col-lg-3 col-md-4 col-sm-3">
                        <span class="title">Thương hiệu:</span>
                    </div>
                    <div class="col-lg-9 col-md-6 col-sm-9">
                        <span class="text">{{ $best_selling->brand->brand_name }}</span>
                    </div>
                </div>
                @if ($best_selling->promotional_price > 0)
                    <div class="price-info">
                        <h3 class="price">{{ number_format($best_selling->promotional_price, 0, ',', '.') }}đ
                        </h3>
                        <h3 class="price-small text-dark-emphasis">
                            {{ number_format($best_selling->product_price, 0, ',', '.') }}đ
                        </h3>
                    </div>
                @else
                    <h3 class="price">{{ number_format($best_selling->product_price, 0, ',', '.') }}đ
                        <span class="đ"></span>
                    </h3>
                @endif
                <div class="text-sold">Đã bán
                    {{ number_format($best_selling->product_sold) }}</div>
                @if ($best_selling->product_condition == '0' || $best_selling->product_quantity <= '0')
                    <img class="img-condition" src="{{ URL::to('frontend/images/product-details/sold_out.png') }}"
                        alt="">
                    <p class="soldout-note"><i class="fa-solid fa-circle-info"></i> Sản phẩm này đã bán hết, vui lòng
                        quay lại sau.</p>
                @else
                    <form>
                        @csrf
                        <input type="hidden" class="cart_product_id_{{ $best_selling->product_id }}"
                            value="{{ $best_selling->product_id }}">
                        <input type="hidden" class="cart_product_name_{{ $best_selling->product_id }}"
                            value="{{ $best_selling->product_name }}">
                        <input type="hidden" class="cart_product_image_{{ $best_selling->product_id }}"
                            value="{{ $best_selling->product_image }}">
                        <input type="hidden" class="cart_product_quantity_{{ $best_selling->product_id }}"
                            value="{{ $best_selling->product_quantity }}">
                        @if ($value->promotional_price > 0)
                            <input type="hidden" class="cart_product_price_{{ $best_selling->product_id }}"
                                value="{{ $best_selling->promotional_price }}">
                        @else
                            <input type="hidden" class="cart_product_price_{{ $best_selling->product_id }}"
                                value="{{ $best_selling->product_price }}">
                        @endif
                        <input type="hidden" class="cart_category_product_{{ $best_selling->product_id }}"
                            value="{{ $best_selling->category->category_name }}">
                        <input type="hidden" class="cart_brand_product_{{ $best_selling->product_id }}"
                            value="{{ $best_selling->brand->brand_name }}">
                        <div class="quantity">
                            <input type="hidden" class="cart_product_qty_{{ $best_selling->product_id }}"
                                value="1">
                            <a class="view-detail"
                                href="{{ URL::to('chi-tiet-san-pham/' . $best_selling->product_id) }}" type="button">
                                Xem chi tiết
                            </a>
                            <button type="button" class="add-to-cart buy-now" name="add-to-cart"
                                data-id="{{ $best_selling->product_id }}">
                                Đặt hàng ngay <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
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
    </div>

    @foreach ($sections_products as $section)
        <h2 class="title-product">{{ $section['section_name'] }}</h2>
        <div class="row product-row-container">
            @foreach ($section['products'] as $key => $proSec)
                <div class="col-lg-2 col-md-4 col-sm-6 product-content">
                    <div class="productinfo">
                        <a class="img-center">
                            <img class="img-products"
                                src="{{ URL::to('/uploads/product/' . $proSec->product_image) }}" />
                            @if ($proSec->promotional_price > 0)
                                <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                            @endif
                        </a>
                        <a href="{{ URL::to('chi-tiet-san-pham/' . $proSec->product_id) }}">
                            <p class="product-name">{{ $proSec->product_name }}</p>
                        </a>
                        <div class="price-product">
                            @if ($proSec->promotional_price > 0)
                                <div class="price-info">
                                    <div class="price-content1">
                                        <span
                                            class="price-small">{{ number_format($proSec->product_price, 0, ',', '.') }}</span>
                                        <span class="currency-unit">₫</span>
                                    </div>
                                    <div class="price-content2">
                                        <span
                                            class="promotional-price">{{ number_format($proSec->promotional_price, 0, ',', '.') }}</span>
                                        <span class="currency-unit">₫</span>
                                    </div>
                                </div>
                            @else
                                <div class="price-content">
                                    <span class="price">{{ number_format($proSec->product_price, 0, ',', '.') }}</span>
                                    <span class="currency-unit">₫</span>
                                </div>
                            @endif
                        </div>
                        <form>
                            @csrf
                            <input type="hidden" class="cart_product_id_{{ $proSec->product_id }}"
                                value="{{ $proSec->product_id }}">
                            <input type="hidden" class="cart_product_name_{{ $proSec->product_id }}"
                                value="{{ $proSec->product_name }}">
                            <input type="hidden" class="cart_product_image_{{ $proSec->product_id }}"
                                value="{{ $proSec->product_image }}">
                            <input type="hidden" class="cart_product_quantity_{{ $proSec->product_id }}"
                                value="{{ $proSec->product_quantity }}">
                            @if ($proSec->promotional_price > 0)
                                <input type="hidden" class="cart_product_price_{{ $proSec->product_id }}"
                                    value="{{ $proSec->promotional_price }}">
                            @else
                                <input type="hidden" class="cart_product_price_{{ $proSec->product_id }}"
                                    value="{{ $proSec->product_price }}">
                            @endif
                            <input type="hidden" class="cart_category_product_{{ $proSec->product_id }}"
                                value="{{ $proSec->category_name }}">
                            <input type="hidden" class="cart_brand_product_{{ $proSec->product_id }}"
                                value="{{ $proSec->brand_name }}">
                            <input type="hidden" class="cart_product_qty_{{ $proSec->product_id }}" value="1">

                            <div class="order-button">
                                <a class="add-to-cart" data-id="{{ $proSec->product_id }}"><i
                                        class="fa-solid fa-cart-arrow-down"></i>Đặt hàng</a>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
            <div class="view-all">
                <a href="{{ url('chuyen-muc-san-pham/' . $section['section_slug']) }}">Xem tất cả</a>
            </div>
        </div>
    @endforeach

    <div class="aboutAs">
        <div class="about-shop">
            <h2 class="text">Về Chúng tôi</h2>
            <img class="img" src="{{ URL::to('/frontend/images/home/gc.png') }}" alt="Image">
        </div>
        <div class="site-section bg-left-half mb-5">
            <div class="owl-2-style">
                <div class="owl-carousel owl-2">
                    <div class="media-29101">
                        <img src="{{ URL::to('/frontend/images/home/taste.png') }}" alt="Image" class="img-fluid">
                        <h3>KN-MILK Hương vị tuyệt hảo</h3>
                        <p>Niềm đam mê của chúng tôi là mang lại cho bạn một sản phẩm với hương vị hoàn hảo nhất</p>
                    </div>
                    <div class="media-29101">
                        <img src="{{ URL::to('/frontend/images/home/pro.png') }}" alt="Image" class="img-fluid">
                        <h3>An toàn là trên hết</h3>
                        <p>KN-MILK sử dụng những nguyên liệu không chỉ ngon, an toàn, mà còn tốt cho sức khoẻ cho bạn
                        </p>
                    </div>
                    <div class="media-29101">
                        <img src="{{ URL::to('/frontend/images/home/dd.jpg') }}" alt="Image" class="img-fluid">
                        <h3>Sản phẩm đa dạng</h3>
                        <p> Chúng tôi cung cấp cho bạn nhiều loại sữa khác nhau, đa dạng, đủ thể loại cho bạn lựa chọn
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
