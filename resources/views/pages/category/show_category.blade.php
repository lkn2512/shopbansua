@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('pages.filter-product.sort-product')
        </div>
        <div class="col-md-9">
            @include('pages.filter-product.brand-filter')
            <div class="category-product">
                @foreach ($category_name as $key => $name)
                    <span class="text">{{ $name->category_name }}</span>
                @endforeach
            </div>
            <div class="row row-content">
                @foreach ($category_by_id as $key => $product)
                    <div class="col-md-3 col-sm-6">
                        <div class="col-border">
                            <div class="mb-5">
                                <div class="single-products">
                                    <div class="productinfo">
                                        <a class="img-center"
                                            href="{{ URL::to('/chi-tiet-san-pham/' . $product->product_id) }}">
                                            <img class="img-products"
                                                src="{{ URL::to('/uploads/product/' . $product->product_image) }}" />
                                            @if ($product->promotional_price > 0)
                                                <span class="header-image-promotional">Khuyến mãi đặc biệt</span>
                                            @endif
                                        </a>
                                        <a href="{{ URL::to('/chi-tiet-san-pham/' . $product->product_id) }}">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <footer class="panel-footer">
                    {!! $category_by_id->withQueryString()->appends(Request::all())->links('pagination::bootstrap-4') !!}
                </footer>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function handleFilterChange() {
                let params = new URLSearchParams(window.location.search);
                let brands = [];
                document.querySelectorAll('.brand-filter:checked').forEach(function(element) {
                    brands.push(element.value);
                });
                if (brands.length > 0) {
                    params.set('brand', brands.join(','));
                } else {
                    params.delete('brand');
                }
                window.location.search = params.toString();
            }
            document.querySelectorAll('.brand-filter').forEach(function(element) {
                element.addEventListener('change', handleFilterChange);
            });
        });
    </script>
@endsection
