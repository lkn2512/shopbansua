@extends('layout')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-items"><a href="{{ URL::to('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-items active" aria-current="page">Giỏ hàng của bạn</li>
        </ol>
    </nav>
    <h2 class="title-product text-center mb-3">Giỏ hàng của bạn</h2>
    @if (Session::get('cart') == true)
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="shopping-cart">
                    <table class="table align-middle bordered">
                        <thead>
                            <tr>
                                <th class="px-4 ">Sản phẩm đặt mua</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Giá bán</th>
                                <th class="text-center ">Tổng</th>
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
                                    $qtyFail = $cart['product_qty'] > $cart['product_quantity'];
                                @endphp
                                <tr>
                                    <td class="px-4">
                                        <div class="product-item width400">
                                            <a class="product-thumb">
                                                <img src="{{ asset('/uploads/product/' . $cart['product_image']) }}"
                                                    alt="Product"></a>
                                            <div class="product-info">
                                                <h4 class="product-title">
                                                    <a
                                                        href="{{ url('chi-tiet-san-pham/' . $cart['product_slug']) }}">{{ $cart['product_name'] }}</a>
                                                </h4>
                                                <span class="sub-product">Loại: {{ $cart['category'] }}</span>
                                                <span class="sub-product">Thương hiệu: {{ $cart['brand'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center width100">
                                        <div class="count-input">
                                            <form action="{{ url('/update-cart') }}" method="POST">
                                                @csrf
                                                @if ($qtyFail)
                                                    <input
                                                        class="cart_quantity_input form-controls quantity-input border border-danger text-danger"
                                                        type="number" name="cart_qty[{{ $cart['session_id'] }}]"
                                                        value="{{ $cart['product_qty'] }}" autocomplete="off" min="1"
                                                        onkeypress="validateInput(event)" oninput="validateInput(event)"
                                                        onchange="validateInput(event)">
                                                @else
                                                    <input class="cart_quantity_input form-controls quantity-input"
                                                        type="number" name="cart_qty[{{ $cart['session_id'] }}]"
                                                        value="{{ $cart['product_qty'] }}" autocomplete="off"
                                                        min="1" onkeypress="validateInput(event)"
                                                        oninput="validateInput(event)" onchange="validateInput(event)">
                                                @endif
                                                <button type="submit" style="visibility: hidden"></button>
                                            </form>
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
                                        </div>
                                    </td>
                                    <td class="text-center text-lg text-medium">
                                        {{ number_format($cart['product_price'], 0, ',', '.') }}đ</td>
                                    <td class="text-center text-lg text-medium ">
                                        {{ number_format($subtotal, 0, ',', '.') }}đ</td>
                                    <td class="text-center">
                                        <a class="remove-from-cart" title="Xoá sản phẩm ra khỏi giỏ"
                                            href="{{ url('delete-product-cart/' . $cart['session_id']) }}"
                                            data-toggle="tooltip" title="" data-original-title="Remove item"><i
                                                class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @if ($qtyFail)
                                    <tr>
                                        <td colspan="5">
                                            <span class="text-danger">Số lượng bạn đặt đã vượt quá số lượng trong kho của
                                                chúng tôi</span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="shopping-cart-footer row">
                    <div class="col-lg-3">
                        <a class="continue-shopping" href="{{ url('/') }}">Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="summary-cart">
                    <span class="title">Tổng quan giỏ hàng</span>
                    <div class="flex-center-between row-summary">
                        <span>Tổng cộng</span>
                        <span>
                            {{ number_format($total, 0, ',', '.') }}đ
                        </span>
                    </div>
                    <div class="flex-center-between row-summary">
                        <span>Mã giảm giá</span>
                        <span class="coupon-used">
                            @if (Session::get('coupon'))
                                @foreach (Session::get('coupon') as $key => $cou)
                                    @if ($cou['coupon_condition'] == 1)
                                        -{{ $cou['coupon_number'] }}%
                                    @elseif ($cou['coupon_condition'] == 2)
                                        -{{ number_format($cou['coupon_number'], 0, ',', '.') }}đ
                                    @endif
                                @endforeach
                            @else
                                0đ
                            @endif
                        </span>
                    </div>
                    <div class="flex-center-between row-summary">
                        <span>Phí vận chuyển</span>
                        <span>20.000đ</span>
                    </div>
                    <hr>
                    <div class="coupon-container">
                        @if (Session::get('coupon'))
                            <div class="flex-center-between">
                                <span class="coupon-used"><i class="fa-regular fa-circle-check"></i> Đã áp dụng mã giảm
                                    giá</span>
                                <a href="{{ url('/remove-coupon') }}"
                                    onclick="return confirm('Bạn có chắc chắn muốn xoá mã giảm giá này không?');"
                                    class="delete-coupon-text" title="Xoá mã giảm giá">Xoá mã giảm giá</a>
                            </div>
                        @endif
                        @if (Session::get('customer_id'))
                            <form action="{{ url('/check-coupon') }}" method="post">
                                @csrf
                                <div class="flex-center-between row-summary">
                                    <input type="text" class="coupon-input" name="coupon"
                                        placeholder="Mã giảm giá (nếu có)" required />
                                    <button type="submit" class="check_coupon" name="check_coupon">Áp
                                        dụng</button>
                                </div>
                            </form>
                        @else
                            <div class="flex-center-between row-summary">
                                <input type="text" disabled class="coupon-input disabled" name="coupon"
                                    placeholder="Vui lòng đăng nhập để sử dụng mã giảm giá!" />
                                <button type="button" class="check_coupon disabled" disabled>Áp dụng</button>
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="flex-center-between row-summary">
                        <span class="fw-bold">Thành tiền</span>
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
                                $total_after = $total_after_coupon + 20000;
                            } elseif (!Session::get('coupon')) {
                                $total_after = $total + 20000;
                            }
                            echo number_format($total_after, 0, ',', '.') . 'đ';
                            ?>
                        </span>
                    </div>
                    <div class="shopping-cart-footer mt-3">
                        <div class="checkout">
                            @if ($qtyFail)
                                <a class="checkout-btn-cart disabled">Thanh toán</a>
                            @else
                                <a class="checkout-btn-cart"
                                    href="{{ Session::get('customer_id') ? url('/checkout') : url('/login') }}">Thanh
                                    toán</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @else
        <p class="text-center"> Hiện không có sản phẩm nào trong giỏ hàng của bạn.
            <a href="{{ url('/') }}">Mua sắm?</a>
        </p>
    @endif
@endsection
