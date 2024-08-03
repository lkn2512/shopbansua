@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('pages.filter-product.sort-product')
        </div>
        <div class="col-md-9">
            @include('pages.filter-product.category-filter')
            <div class="category-product">
                <span class="text">{{ $brand_product_one->brand_name }}</span>
            </div>
            <div class="row product-row-container">
                @if ($brand_by_slug->count() > 0)
                    @foreach ($brand_by_slug as $key => $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 product-content p-2">
                            <div class="productinfo">
                                <a class="img-center">
                                    <img class="img-products"
                                        src="{{ URL::to('/uploads/product/' . $product->product_image) }}" />
                                    @if ($product->promotional_price > 0)
                                        <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                                    @endif
                                </a>
                                <a href="{{ URL::to('chi-tiet-san-pham/' . $product->product_slug) }}">
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
                                            <span class="price">{{ number_format($product->product_price, 0, ',', '.') }}
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
                    <div class="panel-footer">
                        {!! $brand_by_slug->withQueryString()->appends(Request::all())->links('pagination-custom') !!}
                    </div>
                @else
                    <span class="mt-3">Thương hiệu này hiện chưa có sản phẩm !</span>
                @endif
            </div>
        </div>
    </div>

@endsection
