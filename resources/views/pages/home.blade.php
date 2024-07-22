@extends('layout')
@section('content')
    @include('pages.content-top.slider')

    {{-- danh mục sản phẩm --}}
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
    {{-- danh mục sản phẩm --}}

    {{-- sản phẩm mới nhất --}}
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
                        <input type="hidden" class="cart_product_price_{{ $new->product_id }}"
                            value="{{ $new->promotional_price }}">
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
    {{-- sản phẩm mới nhất --}}

    {{-- Sản phẩm bán chạy được nhiều người tin dùng --}}
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
    {{-- Sản phẩm bán chạy được nhiều người tin dùng --}}

    {{-- sự kiện sản phẩm --}}
    @php
        use Carbon\Carbon;
        $currentDate = Carbon::now()->toDateString();
    @endphp
    @foreach ($holidayEvent as $value)
        @if ($currentDate >= $value->event_date && $currentDate <= $value->event_end_date)
            <div class="row holiday-carosel"
                style="background-image: url('{{ asset('frontend/images/home/background-holiday.png') }}');">
                <div class="col-lg-4 col-md-6 col-sm-12 carosel-left">
                    <span class="holiday-name">{{ $value->event_name }}</span>
                    <span class="holiday-end-date">Ngày kết thúc:
                        {{ \Carbon\Carbon::parse($value->event_end_date)->format('d-m-Y') }}
                    </span>
                    <img src="{{ asset('/uploads/event/' . $value->event_image) }}" alt="">
                </div>
                <div class="col-lg-8 col-md-6 col-sm-12 carosel-right">
                    <div class="featured-carousel owl-carousel">
                        @foreach ($productsByEvent[$value->holiday_event_id] as $product)
                            <div class="blog-entry col-lg-2 col-md-4 col-sm-6">
                                <div class="productinfo">
                                    <a class="img-center blog-20">
                                        <img src="{{ URL::to('/uploads/product/' . $product->product_image) }}" />
                                        @if ($product->promotional_price > 0)
                                            <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                                        @endif
                                    </a>
                                    <a href="{{ URL::to('chi-tiet-san-pham/' . $product->product_id) }}">
                                        <p class="product-name">{{ $product->product_name }}</p>
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
            </div>
        @endif
    @endforeach
    {{-- sự kiện sản phẩm --}}

    {{-- Sản phẩm nổi bật --}}
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
    {{-- Sản phẩm nổi bật --}}

    {{-- được quan tâm nhiều --}}
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
    {{-- được quan tâm nhiều --}}

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
@endsection
