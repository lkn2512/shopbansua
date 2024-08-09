@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('pages.filter-product.sort-product')
            <br>
            @include('pages.filter-product.brand-filter-left')
        </div>
        <div class="col-md-9">
            @include('pages.filter-product.category-filter')
            <div class="row category-product">
                <span class="text">Sản phẩm được nhiều người tin dùng</span>
            </div>
            <div class="row product-row-container">
                @foreach ($product_selling as $key => $value)
                    <div class="col-lg-3 col-md-4 col-sm-6 product-content p-2">
                        <div class="productinfo">
                            <a class="img-center">
                                <img class="img-products" src="{{ URL::to('/uploads/product/' . $value->product_image) }}" />
                                @if ($value->promotional_price > 0)
                                    <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                                @endif
                            </a>
                            <a href="{{ URL::to('chi-tiet-san-pham/' . $value->product_slug) }}">
                                <p class="underline product-name">{{ $value->product_name }}</p>
                            </a>
                            <div class="price-product">
                                @if ($value->promotional_price > 0)
                                    <div class="price-info">
                                        <div class="price-content1">
                                            <span
                                                class="price-small">{{ number_format($value->product_price, 0, ',', '.') }}
                                            </span>
                                            <span class="currency-unit">₫</span>
                                        </div>
                                        <div class="price-content2">
                                            <span class="promotional-price">
                                                {{ number_format($value->promotional_price, 0, ',', '.') }}
                                            </span>
                                            <span class="currency-unit">₫</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="price-content">
                                        <span class="price">{{ number_format($value->product_price, 0, ',', '.') }}
                                        </span>
                                        <span class="currency-unit">₫</span>
                                    </div>
                                @endif
                            </div>
                            <form>
                                @csrf
                                <input type="hidden" class="cart_product_id_{{ $value->product_id }}"
                                    value="{{ $value->product_id }}">
                                <input type="hidden" class="cart_product_name_{{ $value->product_id }}"
                                    value="{{ $value->product_name }}">
                                <input type="hidden" class="cart_product_slug_{{ $new->product_id }}"
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
                                <input type="hidden" class="cart_product_qty_{{ $value->product_id }}" value="1">

                                <div class="order-button">
                                    <a class="add-to-cart" data-id="{{ $value->product_id }}"><i
                                            class="fa-solid fa-cart-arrow-down"></i>Đặt hàng
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
                <div class="panel-footer">
                    {!! $product_selling->withQueryString()->appends(Request::all())->links('pagination-custom') !!}
                </div>
            </div>
        </div>
    </div>
@endsection
