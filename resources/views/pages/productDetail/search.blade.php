@extends('layout')
@section('content')
    <h3 class="search-title"><i class="fa-solid fa-magnifying-glass"></i>
        CÓ {{ $count_search_product }} KẾT QUẢ TÌM KIẾM PHÙ HỢP
    </h3>
    <div class="row product-row-container">
        @foreach ($search_product as $key => $searh_pro)
            <div class="col-lg-2 col-md-4 col-sm-6 product-content">
                <div class="productinfo">
                    <a class="img-center" href="{{ URL::to('/chi-tiet-san-pham/' . $searh_pro->product_id) }}">
                        <img class="img-products" src="{{ URL::to('/uploads/product/' . $searh_pro->product_image) }}" />
                        @if ($searh_pro->promotional_price > 0)
                            <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                        @endif
                    </a>
                    <a href="{{ URL::to('/chi-tiet-san-pham/' . $searh_pro->product_id) }}">
                        <p class="product-name">{{ $searh_pro->product_name }}</p>
                    </a>
                    <div class="price-product">
                        @if ($searh_pro->promotional_price > 0)
                            <div class="price-info">
                                <div class="price-content1">
                                    <span class="price-small">{{ number_format($searh_pro->product_price, 0, ',', '.') }}
                                    </span>
                                    <span class="currency-unit">₫</span>
                                </div>
                                <div class="price-content2">
                                    <span class="promotional-price">
                                        {{ number_format($searh_pro->promotional_price, 0, ',', '.') }}
                                    </span>
                                    <span class="currency-unit">₫</span>
                                </div>
                            </div>
                        @else
                            <div class="price-content">
                                <span class="price">{{ number_format($searh_pro->product_price, 0, ',', '.') }}
                                </span>
                                <span class="currency-unit">₫</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        <footer class="panel-footer">
            {!! $search_product->withQueryString()->appends(Request::all())->links('pagination::bootstrap-4') !!}
        </footer>
    </div>
@endsection
