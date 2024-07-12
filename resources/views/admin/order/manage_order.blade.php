@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Quản lý đơn đặt hàng
                <span class="count-number">({{ number_Format($count_order) }})</span>
            </h3>
        </div>
        <div class=" btn-header">
            <a href="{{ URL::to('Admin/manage-order') }}">
                <button type="button" class="btn-refesh"><i class="fa-solid fa-arrows-rotate"></i> Tải lại
                    trang
                </button>
            </a>
        </div>
    </div>

    <table class="table table-hover align-middle table-bordered" id="example1">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã đơn hàng</th>
                <th>Tình trạng</th>
                <th>Tổng tiền</th>
                <th>Thời gian đặt hàng</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($order as $key => $orders)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td style="text-transform: uppercase" class="">
                        #{{ $orders->order_code }}
                    </td>
                    <td>
                        @if ($orders->order_status == 1)
                            <a class="order-status-waitting">Đang chờ xử lý...</a>
                        @elseif($orders->order_status == 2)
                            <a class="order-status-delivered">Đã xử lý</a>
                        @else
                            <a class="order-status-cancle">Đã huỷ</a>
                        @endif
                    </td>
                    <td>
                        {{ number_format($orders->order_total, 0, ',', '.') }}đ
                    </td>
                    <td> {{ \Carbon\Carbon::parse($orders->created_at)->format('H:i, d-m-Y') }}</td>
                    <td>

                        <a href="{{ URL::to('Admin/view-order/' . $orders->order_code) }}" class="btn-detail-view">
                            @if (!$orders->notification->isEmpty() && $orders->notification->where('read', 0)->isNotEmpty())
                                <span class="unread-dot" title="Chưa xem"></span>
                            @endif
                            Xem chi tiết
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
