@extends('layout')
@section('content')
    @include('pages.content-top.slider')
    <div class="row title-product text-center">
        <h2 class="text">DANH MỤC SẢN PHẨM</h2>
    </div>
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

    <div class="title-product">
        <h2 class="text">Sản phẩm mới nhất</h2>
    </div>
    <div class="row row-content">
        @foreach ($all_product_new as $key => $new)
            <div class="col-md-2 col-sm-4 col-lg-2 ">
                <div class="col-border">
                    <div class="mb-5">
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
                                            <span class="price-small">{{ number_format($new->product_price, 0, ',', '.') }}
                                            </span>
                                            <span class="currency-unit">₫</span>
                                        </div>
                                        <div class="price-content2">
                                            <span class="promotional-price">
                                                {{ number_format($new->promotional_price, 0, ',', '.') }}
                                            </span>
                                            <span class="currency-unit">₫</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="price-content">
                                        <span class="price">{{ number_format($new->product_price, 0, ',', '.') }}
                                        </span>
                                        <span class="currency-unit">₫</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="view-all">
            <a href="{{ url('/all-products-new') }}">Xem tất cả</a>
        </div>
    </div>

    <div class="title-product">
        <h2 class="text">Sản phẩm bán chạy được nhiều người tin dùng</h2>
    </div>
    <div class="row row-content">
        @foreach ($selling_product as $key => $sell)
            <div class="col-md-2 col-sm-4 col-lg-2">
                <div class="col-border">
                    <div class="mb-5">
                        <div class="productinfo">
                            <a class="img-center">
                                <img class="img-products"
                                    src="{{ URL::to('/uploads/product/' . $sell->product_image) }}" />
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
                                            <span
                                                class="price-small">{{ number_format($sell->product_price, 0, ',', '.') }}
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
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="view-all">
            <a href="{{ url('/all-product-selling') }}">Xem tất cả</a>
        </div>
    </div>
    @php
        use Carbon\Carbon;
        $currentDate = Carbon::now()->toDateString();
    @endphp
    @foreach ($holidayEvent as $value)
        @if ($currentDate >= $value->event_date && $currentDate <= $value->event_end_date)
            <div class="row row-content holiday-carosel"
                style="background-image: url('{{ asset('frontend/images/home/bgBlue.jpg') }}');">
                <div class="col-md-4 carosel-left">
                    <span class="holiday-name">{{ $value->event_name }}</span>
                    <span class="holiday-end-date">Ngày kết thúc:
                        {{ \Carbon\Carbon::parse($value->event_end_date)->format('d-m-Y') }}
                    </span>
                    <img src="{{ asset('/uploads/event/' . $value->event_image) }}" alt=""
                        style="width: 100%; height: 100%; object-fit: cover">
                </div>
                <div class="col-md-8 carosel-right">
                    <div class="featured-carousel owl-carousel">
                        @foreach ($productsByEvent[$value->holiday_event_id] as $product)
                            <div class="blog-entry">
                                <a class="img-center">
                                    <img src="{{ URL::to('/uploads/product/' . $product->product_image) }}" />
                                    @if ($product->promotional_price > 0)
                                        <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                                    @endif
                                </a>
                                <div class="text">
                                    <h3 class="heading"><a
                                            href="{{ URL::to('chi-tiet-san-pham/' . $product->product_id) }}">{{ $product->product_name }}</a>
                                    </h3>
                                </div>
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
                                            <span class="price">{{ number_format($product->product_price, 0, ',', '.') }}
                                            </span>
                                            <span class="currency-unit">₫</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    <div class="title-product">
        <h2 class="text">Sản phẩm nổi bật</h2>
    </div>
    <div class="row row-content">
        @foreach ($featuredProducts as $key => $avgRat)
            <div class="col-md-2 col-sm-4 col-lg-2">
                <div class="col-border">
                    <div class="mb-5">
                        <div class="productinfo">
                            <a class="img-center">
                                <img class="img-products"
                                    src="{{ URL::to('/uploads/product/' . $avgRat->product_image) }}" />
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
                                            <span
                                                class="price-small">{{ number_format($avgRat->product_price, 0, ',', '.') }}
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
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="view-all">
            <a href="{{ url('/san-pham-noi-bat') }}">Xem tất cả</a>
        </div>
    </div>

    <div class="title-product">
        <h2 class="text">Được quan tâm nhiều nhất</h2>
    </div>
    <div class="row row-content">
        @foreach ($view_product as $key => $view)
            <div class="col-md-2 col-sm-4 col-lg-2">
                <div class="col-border">
                    <div class="mb-5">
                        <div class="productinfo">
                            <a class="img-center">
                                <img class="img-products"
                                    src="{{ URL::to('/uploads/product/' . $view->product_image) }}" />
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
                                            <span
                                                class="price-small">{{ number_format($view->product_price, 0, ',', '.') }}
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
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="view-all">
            <a href="{{ url('/duoc-quan-tam-nhieu') }}">Xem tất cả</a>
        </div>
    </div>

    <div class="aboutAs">
        <div class="about-shop">
            <h2 class="text">Về Chúng tôi</h2>
            <img class="img" src="{{ URL::to('/frontend/images/home/gc.png') }}" alt="Image">
        </div>
        <div class="site-section bg-left-half mb-5">
            <div class=" owl-2-style">
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
