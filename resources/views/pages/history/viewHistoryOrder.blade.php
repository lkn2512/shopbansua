@extends('layout')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-items"><a href="{{ URL::to('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-items"><a href="{{ URL::to('thong-tin-ca-nhan') }}">Thông tin cá nhân</a></li>
            <li class="breadcrumb-items"><a href="{{ URL::to('history-order') }}">Lịch sử đơn hàng</a></li>
            <li class="breadcrumb-items active" aria-current="page" style="text-transform: uppercase">#{{ $order_code }}
            </li>
        </ol>
    </nav>
    <div class="view-order-detail">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md order-code">
                                <label class="title">Mã đơn hàng</label>
                                <span class="Code"> #{{ $order_code }}</span>
                            </div>
                            <div class="col-md text-center order-customer">
                                <label class="title">Người đặt hàng</label>
                                <span class="name">{{ $shipping->shipping_name }}</span>
                            </div>
                            <div class="col-md order-time">
                                <label class="title">Đặt hàng vào lúc</label>
                                <span class="date">
                                    @php
                                        $createdAt = \Carbon\Carbon::parse($getOrder->created_at);
                                        echo $createdAt->format('H:i, d-m-Y');
                                    @endphp
                                </span>
                            </div>
                            <div class="col-md" style="display: flex; justify-content: end; margin-top: 12px">
                                <a href="{{ URL::to('print-order/' . $order_code) }}" target="_blank">
                                    <button type="button" class="btn-print" data-mdb-ripple-init>
                                        <i class="fa-solid fa-print"></i> In đơn hàng
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <label class="mb-3 fw-bold fs-6">Sản phẩm đã đặt</label>
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá bán</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($order_detail as $key => $detail)
                                    <tr>
                                        <td class="width400">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <img src="{{ URL::to('/uploads/product/' . $detail->product->product_image) }}"
                                                        class="img-order">
                                                </div>
                                                <div class="col-md-10 product-order">
                                                    <span class="title"> {{ $detail->product->product_name }}</span>
                                                    <span class="product-code">Mã sản phẩm:
                                                        {{ $detail->product->product_code }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $detail->product_sales_quantity }}
                                        </td>
                                        <td>
                                            {{ number_format($detail->price, 0, ',', '.') }}đ</td>
                                        <td>
                                            {{ number_format($detail->product_sales_quantity * $detail->price, 0, ',', '.') }}đ
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <label class="mb-3 fw-bold fs-6">Chi tiết liên lạc</label>
                            <div class="col-md-3 order-contact">
                                <label class="title">
                                    <img class="img-icon-small" src="{{ URL::to('/backend/images/address.png') }}">Địa chỉ
                                    giao hàng
                                </label>
                                <span class="address">{{ $shipping->province->name }},
                                    {{ $shipping->district->name }},
                                    {{ $shipping->wards->name }}
                                </span>
                            </div>
                            <div class="col-md-3 order-contact">
                                <label class="title"><i class="fa-regular fa-envelope"></i>&#160;Email</label>
                                @if ($shipping->shipping_email)
                                    <span>{{ $shipping->shipping_email }}</span>
                                @else
                                    <span>Không có</span>
                                @endif
                            </div>
                            <div class="col-md-3 order-contact">
                                <label class="title"> <img class="img-icon-small"
                                        src="{{ URL::to('/backend/images/phone.png') }}">Số điện thoại</label>
                                <span class="">{{ $shipping->shipping_phone }}</span>
                            </div>
                            <div class="col-md-3 order-contact">
                                <label class="title"><i class="fa-regular fa-credit-card"></i>&#160;Hình thức
                                    thanh toán</label>
                                @if ($shipping->shipping_method == 1)
                                    Thanh toán khi nhận hàng
                                @else
                                    Thanh toán & nhận tại cửa hàng
                                @endif
                            </div>
                            <div class="order-contact">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="title">Đường, số nhà:
                                            <span class="text">
                                                @if ($shipping->shipping_address)
                                                    {{ $shipping->shipping_address }}
                                                @else
                                                    không có
                                                @endif
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="title">Ghi chú:
                                            <span class="text">
                                                @if ($shipping->shipping_notes)
                                                    {{ $shipping->shipping_notes }}
                                                @else
                                                    không có
                                                @endif
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        @if ($order_status == 1)
                            <label class="mb-3 fw-bold fs-6 status-label"><i class="fa-solid fa-circle color-loading"></i>
                                Trạng thái</label>
                            <span class="status-loading"><i class="fa-solid fa-hourglass-half"></i> Đang chờ xử
                                lý...</span>
                        @elseif($order_status == 2)
                            <label class="mb-3 fw-bold fs-6 status-label"><i class="fa-solid fa-circle color-success"></i>
                                Trạng thái</label>
                            <span class="status-success"><i class="fa-solid fa-check-circle"></i> Đã giao hàng</span>
                        @elseif($order_status == 3)
                            <label class="mb-3 fw-bold fs-6 status-label"><i class="fa-solid fa-circle color-destroy"></i>
                                Trạng thái</label>
                            <span class="status-destroy"><i class="fa-solid fa-times-circle"></i> Đã bị huỷ</span>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <label class="mb-3 fw-bold fs-6">Mã giảm giá</label>
                        @if ($product_coupon != 0)
                            <span class="coupon-item">Tên phiếu: {{ $coupon_name }}</span>
                            <span class="coupon-item coupon-value">{{ $product_coupon }}</span>
                        @else
                            <span class="coupon-null">Không có mã giảm giá!</span>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <label class="mb-3 fw-bold fs-6">Chi tiết thanh toán</label>
                        @php
                            $total = 0;
                            foreach ($order_detail as $key => $detail) {
                                $subtotal = $detail->product_sales_quantity * $detail->price;
                                $total += $subtotal;
                            }
                        @endphp
                        <div class="payment">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="">Tổng số lượng</span>
                                <span>{{ $qty_count }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="">Tổng tiền đơn hàng</span>
                                <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="">Giảm giá</span>
                                <span>
                                    @if ($detail->product_coupon != '0')
                                        @if ($coupon_condition == 1)
                                            -{{ number_format($coupon_number, 0, ',', '.') }}%
                                        @elseif($coupon_condition == 2)
                                            -{{ number_format($coupon_number, 0, ',', '.') }}đ
                                        @endif
                                    @else
                                        0đ
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="">Chi phí vận chuyển</span>
                                <span> {{ number_format($product_feeship, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 summary-order">
                                <span class="fw-bold">Thành tiền</span>
                                <span class="money">
                                    @foreach ($order as $orderT)
                                        {{ number_format($orderT->order_total, 0, ',', '.') }}đ
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($order_status == 3)
                    <div class="card">
                        <div class="card-body">
                            <span class="reason_cancel">Lý do huỷ: </span><span>
                                {{ $order_reason_cancel }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
