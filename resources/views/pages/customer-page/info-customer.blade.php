@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('pages.customer-page.customer-left')
        </div>
        <div class="col-md-8">
            <div class="border-white">
                <label class="title-top">Thống kê</label>
                <div class="order-statistics">
                    <div class="col-statistics">
                        <span class="title">Tổng đơn hàng</span>
                        <b>{{ $order_total }}</b>
                        <span class="sub-tile">Đã đặt hàng</span>
                    </div>
                    <div class="col-statistics">
                        <span class="title">Tổng chi tiêu</span>
                        <b>{{ number_format($order_delivered, 0, ',', '.') }}đ</b>
                        <span class="sub-tile">Cho 1 đơn hàng đã được giao</span>
                    </div>
                    <div class="col-statistics">
                        <span class="title">Trung bình mỗi đơn hàng</span>
                        <b>{{ number_format($order_average, 0, ',', '.') }}đ</b>
                        <span class="sub-tile">Trong tổng số {{ $order_total }} đơn hàng đã đặt</span>
                    </div>
                </div>
            </div>
            <div class="border-white">
                <label class="title-top">Đơn hàng đã đặt</label>
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="p-3">STT</th>
                            <th class="p-3">Mã đơn hàng</th>
                            <th class="p-3">Tình trạng</th>
                            <th class="p-3">Tổng tiền</th>
                            <th class="p-3">Thời gian đặt hàng</th>
                            <th class="p-3">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach ($order as $key => $orders)
                            <tr>
                                <td class="p-3">{{ $i++ }}</td>
                                <td class="p-3" style="text-transform: uppercase">#{{ $orders->order_code }}</td>
                                <td class="p-3">
                                    @if ($orders->order_status == 1)
                                        <a class="order-status-waitting">Đang chờ xử lý...</a>
                                    @elseif($orders->order_status == 2)
                                        <a class="order-status-delivered">Đã xử lý</a>
                                    @else
                                        <a class="order-status-cancle">Đã huỷ</a>
                                    @endif
                                </td>
                                <td class="p-3">
                                    {{ number_format($orders->order_total, 0, ',', '.') }}đ
                                </td>
                                <td class="p-3"> {{ \Carbon\Carbon::parse($orders->created_at)->format('H:i, Y-m-d') }}
                                </td>
                                <td class="p-3">
                                    <a href="{{ URL::to('view-history-order/' . $orders->order_code) }}"
                                        class="card-link view-detail-history">
                                        <img class="img-icon-medium" src="{{ asset('frontend/images/home/detail.png') }}"
                                            alt="">
                                        <span>Xem chi tiết</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <footer class="panel-footer">
                    {!! $order->withQueryString()->appends(Request::all())->links('pagination::bootstrap-4') !!}
                </footer>
            </div>
        </div>
    </div>
@endsection
