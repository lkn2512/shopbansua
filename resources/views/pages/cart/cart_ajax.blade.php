@extends('layout')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-items"><a href="{{ URL::to('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-items active" aria-current="page">Giỏ hàng của bạn</li>
        </ol>
    </nav>
    <div class="shopping-cart-content row">
        <div class="title-product">
            <h2 class="text mb-3">Giỏ hàng của bạn</h2>
        </div>
        @if (Session::get('cart') == true)
            <form action="{{ url('/update-cart') }}" method="POST">
                @csrf
                <div class="shopping-cart">
                    <table class="table table-responsive table-hover bordered">
                        <thead>
                            <tr>
                                <th class="px-4">Sản phẩm</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Giá bán</th>
                                <th class="text-center">Tổng tiền</th>
                                <th class="text-center">
                                    <a class="btn btn-sm btn-outline-danger" href="{{ url('/delete-all-product-cart') }}"
                                        onclick="return confirm('Bạn có chắc là muốn xoá tất cả sản phẩm ra khỏi giỏ hàng?')">Xoá
                                        tất cả
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach (Session::get('cart') as $key => $cart)
                                @php
                                    $subtotal = $cart['product_price'] * $cart['product_qty'];
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td class="px-4">
                                        <div class="product-item">
                                            <a class="product-thumb" href="#"><img
                                                    src="{{ asset('/uploads/product/' . $cart['product_image']) }}"
                                                    alt="Product"></a>
                                            <div class="product-info">
                                                <h4 class="product-title">
                                                    <a
                                                        href="{{ url('chi-tiet-san-pham/' . $cart['product_id']) }}">{{ $cart['product_name'] }}</a>
                                                </h4>
                                                <span><em>Loại:</em> {{ $cart['category'] }}</span>
                                                <span><em>Thương hiệu:</em> {{ $cart['brand'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="count-input">
                                            <input class="cart_quantity_input form-controls quantity-input" type="number"
                                                name="cart_qty[{{ $cart['session_id'] }}]"
                                                value="{{ $cart['product_qty'] }}" autocomplete="off" min="1"
                                                onkeypress="validateInput(event)" oninput="validateInput(event)"
                                                onchange="validateInput(event)">
                                        </div>
                                    </td>
                                    <td class="text-center text-lg text-medium">
                                        {{ number_format($cart['product_price'], 0, ',', '.') }}đ</td>
                                    <td class="text-center text-lg text-medium">
                                        {{ number_format($subtotal, 0, ',', '.') }}đ</td>
                                    <td class="text-center">
                                        <a class="remove-from-cart"
                                            href="{{ url('delete-product-cart/' . $cart['session_id']) }}"
                                            data-toggle="tooltip" title="" data-original-title="Remove item"><i
                                                class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th class="p-4">
                                    @if (Session::get('coupon'))
                                        <span class="coupon-used">
                                            <i class="fa-regular fa-circle-check"></i>&nbsp;Đã sử dụng mã giảm giá:&nbsp;
                                            @foreach (Session::get('coupon') as $key => $cou)
                                                @if ($cou['coupon_condition'] == 1)
                                                    -{{ $cou['coupon_number'] }}%
                                                @elseif ($cou['coupon_condition'] == 2)
                                                    -{{ number_format($cou['coupon_number'], 0, ',', '.') }}đ
                                                @endif
                                            @endforeach
                                        </span>
                                    @endif
                                </th>
                                <th class="text-center">
                                    @if (Session::get('coupon'))
                                        <a href="{{ url('/remove-coupon') }}"
                                            onclick="return confirm('Bạn có chắc chắn muốn xoá mã giảm giá này không?');"
                                            class="delete-coupon-text" title="Xoá mã giảm giá">Xoá mã giảm giá</a>
                                    @endif
                                </th>
                                <th class="text-center"><span class="total">Thành Tiền:</span>
                                </th>
                                <th class="text-center">
                                    <span class="total">
                                        <?php
                                        if (Session::get('coupon')) {
                                            foreach (Session::get('coupon') as $key => $cou) {
                                                if ($cou['coupon_condition'] == 1) {
                                                    $total_coupon = ($total * $cou['coupon_number']) / 100;
                                                    $total_after_coupon = $total - $total_coupon;
                                                } elseif ($cou['coupon_condition'] == 2) {
                                                    $total_after_coupon = $total - $cou['coupon_number'];
                                                }
                                            }
                                            $total_after = $total_after_coupon;
                                        } elseif (!Session::get('coupon')) {
                                            $total_after = $total;
                                        }
                                        echo number_format($total_after, 0, ',', '.') . 'đ';
                                        ?>
                                </th>
                                <th></th>
                            </tr>
                            <button type="submit" id="updateCartSubmit"></button>
                        </tbody>
                    </table>
                </div>
            </form>
            <div class="shopping-cart-footer row">
                <div class="col-lg-8 col-md-6 col-sm-12 coupon-container">
                    @if (Session::get('customer_id'))
                        <form action="{{ url('/check-coupon') }}" method="post">
                            @csrf
                            <input type="text" class="coupon-input" name="coupon"
                                placeholder="Điền mã giảm giá của bạn ở đây (Nhấn Enter để áp dụng)" />
                            <button type="submit" class="check_coupon" name="check_coupon">Áp dụng</button>
                        </form>
                    @else
                        <input type="text" disabled class="coupon-input" name="coupon"
                            placeholder="Vui lòng đăng nhập để sử dụng mã giảm giá!" />
                    @endif
                </div>
                <div class="col-lg-2 col-md-3 col-sm-12">
                    <a class="continue-shopping" href="{{ url('/') }}">
                        <span class="continue-shopping-content">
                            <i class="fa-solid fa-arrow-left arrow-icon"></i>&nbsp;Tiếp tục mua sắm
                        </span>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-12 checkout">
                    <a class="checkout-btn-cart"
                        href="{{ Session::get('customer_id') ? url('/checkout') : url('/login') }}">Thanh toán</a>
                </div>
            </div>
        @else
            <div class="row">
                <p> Hiện không có sản phẩm nào trong giỏ hàng của bạn.
                    <a class="buy" href="{{ url('/') }}">Mua sắm?</a>
                </p>
            </div>
        @endif
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.quantity-input').forEach(function(input) {
                input.addEventListener('keypress', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        var form = input.closest('form');
                        form.querySelector('button[type="submit"]').click();
                    }
                });
            });
        });
    </script>
@endsection
