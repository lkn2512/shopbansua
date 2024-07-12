<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chi tiết đơn hàng</title>
    <style>
        body,
        html {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        table {
            margin-top: 50px;
            border-collapse: collapse;
        }

        th {
            text-align: right;
            padding: 10px 0px;
            text-transform: uppercase;
        }

        td {
            border-top: 1px solid black;
            text-align: right;
            padding: 10px 0px;
        }

        .td-name {
            width: 40%;
            text-align: left
        }

        .header {
            background-color: #103667;
            height: 5.5%;
            width: 100vw;
            padding: 20px 50px
        }

        .content-order {
            padding: 50px;
        }

        .content-order .name {}

        .title-order {
            font-size: 40px;
            text-transform: uppercase
        }

        .img-logo {
            width: auto;
            height: 65px;
            float: left;
        }

        .detail-customer p {
            font-weight: bold;

        }

        .detail-customer p span {
            font-weight: 400;
        }

        .order-left {
            float: left;
        }

        .order-right {
            text-align: right;
        }

        .order-right .code {
            font-weight: bold;
        }

        .order-right .code span {
            text-transform: uppercase;
        }


        .no-border td {
            border: none;
            padding: 1px;
            text-align: right
        }

        .content-footer {
            margin-top: 50px
        }

        .content-footer p {
            font-weight: bold;
        }

        .content-footer p span {
            font-weight: 400;
        }

        .info-contact {
            text-align: right;
        }

        .info-contact .contact-item {
            color: white;
            font-size: 0.6rem;
            display: block;
        }
    </style>
</head>

<body>
    <div class="header">
        @foreach ($contact_printPDF as $contactP)
            <img class="img-logo" src="{{ public_path('uploads/contact/' . $contactP->info_image) }}">
            <div class="info-contact">
                <span class="contact-item">{{ $contactP->info_address }}</span>
                <span class="contact-item">Email: {{ $contactP->info_email }}</span>
                <span class="contact-item">SĐT: {{ $contactP->info_phone }}</span>
            </div>
        @endforeach
    </div>
    <div class="content-order">
        <div class="order-left">
            <h1 class="title-order">Hoá đơn</h1>
        </div>
        <div class="order-right">
            <p class="code">Hoá đơn: <span>#{{ $order_code }}</span></p>
            <p>Vào lúc: {{ \Carbon\Carbon::parse($order_date)->format('H:i | d/m/Y') }}</p>
        </div>
        <hr>
        <div class="detail-customer">
            <h3 class="name">{{ $shipping->shipping_name }}</h3>
            <p>Điện thoại liên lạc: <span>{{ $shipping->shipping_phone }}</span></p>
            <p>Địa chỉ: <span>{{ $shipping->province->name }},
                    {{ $shipping->district->name }}, {{ $shipping->wards->name }}</span>
            </p>
            <p>Đường, số nhà:
                <span>
                    @if ($shipping->shipping_address)
                        {{ $shipping->shipping_address }}
                    @else
                        không có
                    @endif
                </span>
            </p>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="td-name">Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá bán</th>
                    <th style="padding-left: 10px">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_detail as $detail)
                    <tr>
                        <td class="td-name">{{ $detail->product->product_name }}</td>
                        <td>{{ $detail->product_sales_quantity }}</td>
                        <td>{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                        <td>{{ number_format($detail->product_sales_quantity * $detail->price, 0, ',', '.') }}đ
                        </td>
                    </tr>
                @endforeach
                @php
                    $total = 0;
                    foreach ($order_detail as $key => $detail) {
                        $subtotal = $detail->product_sales_quantity * $detail->price;
                        $total += $subtotal;
                    }
                @endphp
                <tr class="no-border">
                    <td></td>
                    <td></td>
                    <td>Tổng cộng</td>
                    <td> {{ number_format($total, 0, ',', '.') }}đ </td>
                </tr>
                <tr class="no-border">
                    <td></td>
                    <td></td>
                    <td>Giảm giá</td>
                    <td>
                        @if ($detail->product_coupon != '0')
                            @if ($coupon_condition == 1)
                                -{{ number_format($coupon_number, 0, ',', '.') }}%
                            @elseif($coupon_condition == 2)
                                -{{ number_format($coupon_number, 0, ',', '.') }}đ
                            @endif
                        @else
                            0đ
                        @endif
                    </td>
                </tr>
                <tr class="no-border">
                    <td></td>
                    <td></td>
                    <td>Vận chuyển</td>
                    <td> {{ number_format($product_feeship, 0, ',', '.') }}đ</td>
                </tr>

                <tr class="no-border">
                    <td></td>
                    <td colspan="2" style="color:#103667; padding-top: 10px"><b>TỔNG THANH TOÁN</b></td>
                    <td>
                        @foreach ($order as $orderT)
                            <b style="color:#103667">
                                {{ number_format($orderT->order_total, 0, ',', '.') }}đ</b>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="content-footer">
            <div>
                <p class="title"> Tình trạng:
                    @if ($order_status == 1)
                        <span class="status-loading">Đang chờ xử lý...</span>
                    @elseif($order_status == 2)
                        <span class="status-success">Đã giao hàng</span>
                    @elseif($order_status == 3)
                        <span class="status-destroy">Đã bị huỷ</span>
                    @endif
                </p>
            </div>
            <p>Hình thức thanh toán:
                <span>
                    @if ($shipping->shipping_method == 1)
                        Thanh toán khi nhận hàng
                    @else
                        Thanh toán & nhận tại cửa hàng
                    @endif
                </span>
            </p>
            <p>Ghi chú của người nhận:
                <span>
                    @if ($shipping->shipping_notes)
                        {{ $shipping->shipping_notes }}
                    @else
                        không có
                    @endif
                </span>
            </p>
        </div>
    </div>
</body>

</html>
