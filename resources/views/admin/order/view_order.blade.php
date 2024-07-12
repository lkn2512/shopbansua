@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Chi tiết đơn đặt hàng</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('Admin/manage-order') }}">Quản lý đơn đặt hàng </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Chi tiết đơn đặt hàng
                </li>
            </ol>
        </div>
        <div class="btn-header">
            <a href="javascript:location.reload(true)"> <button type="button" class="btn-refesh refesh-page"
                    data-mdb-ripple-init><i class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button>
            </a>
            <a href="{{ URL::to('Admin/manage-order') }}"><button type="button" class="btn-back" data-mdb-ripple-init><i
                        class="fa-solid fa-arrow-left"></i> Trở về</button>
            </a>
        </div>
    </div>
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
                                <label class="title">Khách đặt hàng</label>
                                <span class="name">{{ $shipping->shipping_name }}</span>
                            </div>
                            <div class="col-md order-time">
                                <label class="title">Đặt hàng vào lúc</label>
                                <span class="date">
                                    @php
                                        $createdAt = \Carbon\Carbon::parse($order_date);
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
                        <label class="mb-3 fw-bold fs-1r5">Sản phẩm đã đặt</label>
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá bán</th>
                                    <th>Tổng</th>
                                    <th>Tồn kho</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($order_detail as $key => $detail)
                                    <tr>
                                        <td class="color_qty_{{ $detail->product_id }} width400">
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
                                        <td class="color_qty_{{ $detail->product_id }}">
                                            {{ $detail->product_sales_quantity }}
                                            <input type="hidden" min="1"
                                                class="order_qty_{{ $detail->product_id }}"
                                                value="{{ $detail->product_sales_quantity }}"
                                                name="product_sales_quantity">

                                            <input type="hidden" name="order_qty_storage"
                                                class="order_qty_storage_{{ $detail->product_id }}"
                                                value="{{ $detail->product->product_quantity }}">
                                            <input type="hidden" name="order_code" class="order_code"
                                                value="{{ $detail->order_code }}">
                                            <input type="hidden" name="order_product_id" class="order_product_id"
                                                value="{{ $detail->product_id }}">
                                        </td>
                                        <td class="color_qty_{{ $detail->product_id }}">
                                            {{ number_format($detail->price, 0, ',', '.') }}đ</td>
                                        <td class="color_qty_{{ $detail->product_id }}">
                                            {{ number_format($detail->product_sales_quantity * $detail->price, 0, ',', '.') }}đ
                                        </td>
                                        <td class="color_qty_{{ $detail->product_id }}">
                                            {{ $detail->product->product_quantity }}
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
                            <label class="mb-3 fw-bold fs-1r5">Chi tiết liên lạc</label>
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
                            <label class="mb-3 fw-bold fs-1r5 status-label"><i
                                    class="fa-solid fa-circle color-loading"></i>
                                Trạng thái</label>
                            <span class="status-loading"><i class="fa-solid fa-hourglass-half"></i> Đang chờ xử
                                lý...</span>
                        @elseif($order_status == 2)
                            <label class="mb-3 fw-bold fs-1r5 status-label"><i
                                    class="fa-solid fa-circle color-success"></i> Trạng thái</label>
                            <span class="status-success"><i class="fa-solid fa-check-circle"></i> Đã giao hàng</span>
                        @elseif($order_status == 3)
                            <label class="mb-3 fw-bold fs-1r5 status-label"><i
                                    class="fa-solid fa-circle color-destroy"></i> Trạng thái</label>
                            <span class="status-destroy"><i class="fa-solid fa-times-circle"></i> Đã bị huỷ</span>
                        @endif
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
                <div class="card">
                    <div class="card-body">
                        <div class="label-container">
                            <label class="mb-3 fw-bold fs-1r5">Tài khoản<small class="note">(đăng nhập)</small></label>
                            <span class="add-new" style="margin-top: -15px">
                                <a href="{{ URL::to('Admin/info-customer/' . $customer->customer_id) }}">Xem thông tin</a>
                            </span>
                        </div>
                        <div class="info-customer">
                            <div class="image-container">
                                @if ($customer->customer_image)
                                    <img class="img-avatar-medium"
                                        src="/uploads/customer/{{ $customer->customer_image }}">
                                @else
                                    <img class="img-avatar-medium" src="/backend/images/user.png">
                                @endif
                            </div>
                            <div class="info-right">
                                <label class="name">{{ $customer->customer_name }}</label>
                                <span class="text-secondary">Khách hàng kể từ ngày:
                                    {{ $customer->created_at->format('d-m-Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <label class="mb-3 fw-bold fs-1r5">Mã giảm giá</label>
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
                        <label class="mb-3 fw-bold fs-1r5">Chi tiết thanh toán</label>
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
                <div class="card">
                    <div class="card-body">
                        <label class="status-order-lable">Trạng thái đơn hàng:</label>
                        @foreach ($order as $key => $or)
                            <form>
                                @csrf
                                <select class="form-control order_details form-select">
                                    @if ($or->order_status == 1)
                                        <option id="{{ $or->order_id }}" value="1" selected>Chờ xử lý</option>
                                        <option id="{{ $or->order_id }}" value="2">Đã xử lý</option>
                                        <option id="{{ $or->order_id }}" value="3">Huỷ đơn hàng</option>
                                    @elseif($or->order_status == 2)
                                        <option id="{{ $or->order_id }}" value="1">Chờ xử lý</option>
                                        <option id="{{ $or->order_id }}" value="2" selected>Đã xử lý</option>
                                    @elseif($or->order_status == 3)
                                        <option selected>Huỷ đơn hàng</option>
                                    @endif
                                </select>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
