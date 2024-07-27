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

    {{-- <table class="table table-hover align-middle table-bordered" id="example1">
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
    </table> --}}

    <form id="delete-order-form">
        @csrf
        <table class="table table-hover align-middle table-bordered" id="example1">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
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
                    <tr data-id="{{ $orders->order_id }}">
                        <td><input type="checkbox" name="order_ids[]" value="{{ $orders->order_id }}">
                        </td>
                        <td>{{ $i++ }}</td>
                        <td style="text-transform: uppercase">#{{ $orders->order_code }}</td>
                        <td>
                            @if ($orders->order_status == 1)
                                <a class="order-status-waitting">Đang chờ xử lý...</a>
                            @elseif($orders->order_status == 2)
                                <a class="order-status-delivered">Đã xử lý</a>
                            @else
                                <a class="order-status-cancle">Đã huỷ</a>
                            @endif
                        </td>
                        <td>{{ number_format($orders->order_total, 0, ',', '.') }}đ</td>
                        <td>{{ \Carbon\Carbon::parse($orders->created_at)->format('H:i, d-m-Y') }}</td>
                        <td>
                            <a href="{{ URL::to('Admin/manage-order/view-order/' . $orders->order_code) }}"
                                class="btn-detail-view">
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
        <button type="button" id="delete-selected-orders" class="btn-icon" title="Xoá đơn hàng đã chọn"><i
                class="fa-regular fa-trash-can"></i></button>
        <a href="" class="btn-icon" onclick="location.reload()" type="button" title="Tải lại trang">
            <i class="fa-solid fa-arrows-rotate"></i></a>
    </form>

    <script>
        document.getElementById('select-all').onclick = function() {
            var checkboxes = document.querySelectorAll('input[name="order_ids[]"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }

        document.getElementById('delete-selected-orders').onclick = function() {
            var selectedOrderIds = [];
            var checkboxes = document.querySelectorAll('input[name="order_ids[]"]:checked');

            for (var checkbox of checkboxes) {
                selectedOrderIds.push(checkbox.value);
            }

            if (selectedOrderIds.length > 0) {
                var numberOfSelectedOrders = selectedOrderIds.length;
                var confirmMessage = 'Bạn có chắc là muốn xóa ' + numberOfSelectedOrders + ' đơn hàng đã chọn?';

                if (confirm(confirmMessage)) {
                    var formData = new FormData();
                    formData.append('_token', document.querySelector('input[name="_token"]').value);
                    formData.append('order_ids', JSON.stringify(selectedOrderIds));

                    fetch('{{ route('delete.order') }}', {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                for (var id of selectedOrderIds) {
                                    document.querySelector('tr[data-id="' + id + '"]').remove();
                                    toastr.success('Xóa đơn hàng thành công!');
                                }
                            } else {
                                toastr.error('Có lỗi xảy ra khi xóa đơn hàng.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error('Có lỗi xảy ra khi xóa đơn hàng.');
                        });
                }
            } else {
                alert('Vui lòng chọn ít nhất một đơn hàng!');
            }
        }
    </script>
@endsection
