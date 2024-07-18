@extends('layout')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-items"><a href="{{ URL::to('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-items"><a href="{{ URL::to('/your-cart') }}">Giỏ hàng</a></li>
            <li class="breadcrumb-items active" aria-current="page">Thông tin giao hàng</li>
        </ol>
    </nav>
    <div class="row">
        @php
            use Illuminate\Support\Facades\Session;
            $total = 0;
        @endphp
        @if (Session::get('cart'))
            @foreach (Session::get('cart') as $key => $cart)
                @php
                    $subtotal = $cart['product_price'] * $cart['product_qty'];
                    $total += $subtotal;
                @endphp
            @endforeach
            {{-- điền thông tin vận chuyển --}}
            <div class="col-md-8">
                <div class="content-checkout">
                    <div class="title-product mb-3">
                        <h2 class="text">Thông tin giao hàng</h2>
                    </div>
                    <form id="checkout-form">
                        @csrf
                        {{-- lấy mã giảm giá --}}
                        @if (Session::get('coupon'))
                            @foreach (Session::get('coupon') as $key => $cou)
                                <input name="order_coupon" type="hidden" class="order_coupon"
                                    value="{{ $cou['coupon_code'] }}" />
                            @endforeach
                        @else
                            <input name="order_coupon" type="hidden" class="order_coupon" value="0" />
                        @endif
                        {{-- lấy phí vận chuyển --}}
                        <input name="order_fee" type="hidden" class="order_fee" value="20000" />

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input name="shipping_name" type="text" class="form-control shipping_name"
                                    placeholder="Họ và tên" required oninput="validateForm()"
                                    value="{{ isset($shippingInfoLast) ? $shippingInfoLast->shipping_name : '' }}" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <input name="shipping_phone" type="number" min="1"
                                    class="form-control shipping_phone" placeholder="Số điện thoại" required
                                    oninput="validateForm()"
                                    value="{{ isset($shippingInfoLast) ? $shippingInfoLast->shipping_phone : '' }}" />
                                <span id="phone-error" style="color: red; padding-top: 5px; font-size: 15px;"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input name="shipping_email" type="email" class="form-control shipping_email"
                                placeholder="you@example.com (nếu có)" oninput="validateForm()"
                                value="{{ isset($shippingInfoLast) ? $shippingInfoLast->shipping_email : '' }}">
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-4">
                                <select name="shipping_address_city"
                                    class="form-select form-select-lg p-3 shipping_address_province" required
                                    oninput="validateForm()">
                                    <option value="" {{ isset($shippingInfoLast->matp) ? 'selected' : '' }}>
                                        @if ($shippingInfoLast)
                                            {{ $shippingInfoLast->province->name }}
                                        @else
                                            Chọn Tỉnh (thành)
                                        @endif
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="shipping_address_district"
                                    class="form-select form-select-lg p-3 shipping_address_district" required
                                    oninput="validateForm()">
                                    <option value="" {{ isset($shippingInfoLast->maqh) ? 'selected' : '' }}>
                                        @if ($shippingInfoLast)
                                            {{ $shippingInfoLast->district->name }}
                                        @else
                                            Chọn Quận (huyện)
                                        @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="shipping_address_wards"
                                    class="form-select form-select-lg p-3 shipping_address_wards" required
                                    oninput="validateForm()">
                                    <option value="" {{ isset($shippingInfoLast->xaid) ? 'selected' : '' }}>
                                        @if ($shippingInfoLast)
                                            {{ $shippingInfoLast->wards->name }}
                                        @else
                                            Chọn Xã (phường)
                                        @endif
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input name="shipping_address" type="text" class="form-control shipping_address"
                                placeholder="Tên đường, số nhà,..." required oninput="validateForm()"
                                value="{{ isset($shippingInfoLast) ? $shippingInfoLast->shipping_address : '' }}" />
                        </div>
                        <div class="mb-3">
                            <textarea style="resize:none; height: 100px;" type="text" name="shipping_notes" class="form-control shipping_notes"
                                id="exampleInputPassword1" placeholder="Ghi chú (nếu có)" oninput="validateForm()">{{ isset($shippingInfoLast) ? $shippingInfoLast->shipping_notes : '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hình thức thanh toán</label>
                            <select class="form-select payment_select" name="payment_select" required
                                oninput="validateForm()">
                                @if ($shippingInfoLast)
                                    @if ($shippingInfoLast->shipping_method == 1)
                                        <option value="1" selected>Thanh toán khi nhận hàng</option>
                                        <option value="2">Thanh toán & nhận tại cửa hàng</option>
                                    @else
                                        <option value="1">Thanh toán khi nhận hàng</option>
                                        <option value="2"selected>Thanh toán & nhận tại cửa hàng</option>
                                    @endif
                                @else
                                    <option value="1" selected>Thanh toán khi nhận hàng</option>
                                    <option value="2">Thanh toán & nhận tại cửa hàng</option>
                                @endif
                            </select>
                        </div>
                        <div class="save-info-checkout">
                            <i class="fa-regular fa-bookmark"></i> Thông tin này của bạn sẽ tự động lưu lại cho lần thanh
                            toán sau
                        </div>
                        <button type="button" class="send_order mb-2" name="send_order" disabled>Hoàn tất đặt hàng</button>
                    </form>
                </div>
            </div>
            {{-- Chi tiết hoá đơn --}}
            <div class="col-md-4">
                <div class="invoice-details">
                    <div class="p-4">
                        <h6 class="mb-3">Chi tiết hoá đơn</h6>
                        @foreach (Session::get('cart') as $key => $cart)
                            <div class="d-flex justify-content-between mb-2">
                                <span style="padding-right: 20px;"><i class="fa-solid fa-caret-right"></i>
                                    {{ $cart['product_name'] }}
                                    (x{{ $cart['product_qty'] }})
                                </span><span>{{ number_format($cart['product_qty'] * $cart['product_price'], 0, ',', '.') }}đ</span>
                            </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Tổng đơn hàng</span> <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Giảm giá</span>
                            <span class="text-danger">
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
                            @if (Session::get('coupon'))
                                <a href="{{ url('/remove-coupon') }}" class="delete-coupon" title="Xoá mã giảm giá"><i
                                        class="fa-regular fa-circle-xmark"></i>
                                </a>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Vận chuyển</span>
                            <span id="shipping_fee">
                                {{ number_format(20000, 0, ',', '.') }}đ
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Thành tiền</strong>
                            <strong class="text-dark">
                                <?php
                            if (Session::get('coupon')) {
                                foreach (Session::get('coupon') as $key => $cou) {
                                    if ($cou['coupon_condition'] == 1) {
                                        $total_coupon = ($total * $cou['coupon_number']) / 100;
                                        $total_after_coupon = $total + 20000 - $total_coupon;
                                    } elseif ($cou['coupon_condition'] == 2) {
                                        $total_after_coupon = $total - $cou['coupon_number'] + 20000;
                                    }
                                }
                                $total_after = $total_after_coupon;
                            } elseif (!Session::get('coupon')) {
                                $total_after = $total + 20000;
                            }
                            if ($total_after < 0) {
                            ?>
                                0đ
                                <?php
                            } else {
                                echo number_format($total_after, 0, ',', '.') . 'đ';
                            }
                            ?>
                                <input type="hidden" class="order_total" name="order_total"
                                    value="{{ $total_after }}">
                            </strong>
                        </div>
                        <!-- coupon -->
                        {{-- <form action="{{ url('/check-coupon') }}" method="post">
                            @csrf
                            <div class="row">
                                <label class="form-label">Mã giảm giá (Nếu có)</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="coupon"
                                        placeholder="Mã giảm giá" /><br>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="check_coupon" name="check_coupon">Áp dụng</button>
                                </div>
                            </div>
                        </form> --}}
                        <!-- END - coupon -->
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
