@extends('layout')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-items"><a href="{{ URL::to('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-items"><a href="{{ URL::to('thong-tin-ca-nhan') }}">Thông tin cá nhân</a></li>
            <li class="breadcrumb-items active" aria-current="page">Lịch sử đơn hàng
            </li>
        </ol>
    </nav>
    <div class="history-order-content">
        <div class="history-order-title mb-2">
            <h2 class="title-product">LỊCH SỬ ĐƠN HÀNG CỦA BẠN</h2>
            <div class="view-toggle">
                <span class="title">Chế độ hiển thị:</span>
                <img class="img-icon-medium" id="toggleViewIcon" src="{{ asset('frontend/images/home/grid.png') }}"
                    alt="Grid View">
                <span id="toggleViewText" class="name-status">Dạng thẻ</span>
            </div>
        </div>
        <div id="gridView" class="row">
            @foreach ($order as $key => $orders)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="items-grid mb-4 p-4">
                        <div class="flex-center-between">
                            <div>
                                <h6 class="card-subtitle">Mã đơn hàng</h6>
                                <h5>#{{ $orders->order_code }}</h5>
                            </div>
                            <div>
                                <a href="{{ URL::to('view-history-order/' . $orders->order_code) }}"
                                    class="card-link view-detail-history" title="Xem chi tiết">
                                    <input type="hidden" name="order_code" value="{{ $orders->order_code }}">
                                    <img class="img-icon-medium" src="{{ asset('frontend/images/home/detail.png') }}"
                                        alt="">
                                </a>
                                @if ($orders->order_status == 1)
                                    <a href="" class="card-link destroy-order" data-bs-toggle="modal"
                                        data-bs-target="#cancleOrder" data-bs-whatever="@mdo" title="Huỷ đơn hàng">
                                        <img class="img-icon-medium"
                                            src="{{ asset('frontend/images/home/cancel_order.png') }}" alt="">
                                    </a>
                                @endif
                            </div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="status-btn">
                            @if ($orders->order_status == 1)
                                <button class="bg-Pending btn-status"><i class="fas fa-clock"></i>Đang chờ xử
                                    lý...</button>
                            @elseif($orders->order_status == 2)
                                <button class="bg-delivered btn-status"><i class="fas fa-check-circle"></i>Đã giao
                                    hàng</button>
                            @else
                                <button class="bg-Canceled btn-status"><i class="fas fa-times-circle"></i>Đã bị
                                    huỷ</button>
                            @endif
                        </div>
                        <span class="card-text date-order">Ngày đặt:
                            @php
                                $createdAt = \Carbon\Carbon::parse($orders->created_at);
                                echo '<span>' . $createdAt->format('H:i, d-m-Y') . '</span>';
                            @endphp
                        </span>
                        <span class="card-text price price-order">
                            {{ number_format($orders->order_total, 0, ',', '.') }}đ
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
        <div id="tableView" class="table-responsive" style="display: none;">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th class="p-3 ">STT</th>
                        <th class="p-3 ">Mã đơn hàng</th>
                        <th class="p-3 ">Trạng thái</th>
                        <th class="p-3 ">Ngày đặt</th>
                        <th class="p-3 ">Tổng tiền</th>
                        <th class="p-3 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1;@endphp
                    @foreach ($order as $key => $orders)
                        <tr>
                            <td class="p-3">{{ $i++ }}</td>
                            <td class="p-3">#{{ $orders->order_code }}</td>
                            <td class="p-3">
                                @if ($orders->order_status == 1)
                                    <a class="order-status-waitting">Đang chờ xử lý...</a>
                                @elseif($orders->order_status == 2)
                                    <a class="order-status-delivered">Đã giao hàng</a>
                                @else
                                    <a class="order-status-cancle">Đã huỷ</a>
                                @endif
                            </td>
                            <td class="p-3 ">
                                @php
                                    $createdAt = \Carbon\Carbon::parse($orders->created_at);
                                    echo $createdAt->format('H:i, d-m-Y');
                                @endphp
                            </td>
                            <td class="p-3">{{ number_format($orders->order_total, 0, ',', '.') }}đ</td>
                            <td class="p-3 width100">
                                <div class="flex-center-between">
                                    <a href="{{ URL::to('view-history-order/' . $orders->order_code) }}"
                                        class="card-link view-detail-history">
                                        <input type="hidden" name="order_code" value="{{ $orders->order_code }}">
                                        <img class="img-icon-medium" src="{{ asset('frontend/images/home/detail.png') }}">
                                        <span>Xem</span>
                                    </a>
                                    @if ($orders->order_status == 1)
                                        <a href="" class="card-link destroy-order" data-bs-toggle="modal"
                                            data-bs-target="#cancleOrder" data-bs-whatever="@mdo">
                                            <img class="img-icon-medium"
                                                src="{{ asset('frontend/images/home/cancel_order.png') }}">
                                            <span>Huỷ</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            {!! $order->withQueryString()->appends(Request::all())->links('pagination-custom') !!}
        </div>
    </div>

    {{-- Modal hiển thị khi nhấn huỷ đơn hàng --}}
    <div class="modal fade" id="cancleOrder" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Huỷ đơn hàng</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Có thể cho chúng tôi
                                biết lý do bạn huỷ đơn hàng không?</label>
                            <div class="form-check-reason">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="reason" id="reason1"
                                        value="Thay đổi quyết định" checked>
                                    <label class="form-check-label" for="reason1">
                                        Thay đổi quyết định
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="reason" id="reason2"
                                        value="Tìm được giá tốt hơn">
                                    <label class="form-check-label" for="reason2">
                                        Tìm được giá tốt hơn
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="reason" id="reason3"
                                        value="Đơn hàng bị chậm trễ">
                                    <label class="form-check-label" for="reason3">
                                        Đơn hàng bị chậm trễ
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="reason" id="reason4"
                                        value="Other">
                                    <label class="form-check-label" for="reason4">
                                        Lý do khác
                                    </label>
                                </div>
                                <textarea class="form-control reason_cancellation" id="message-text" rows="3" style="display: none;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-secondary-subtle" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn bg-success text-white" id="confirm-button" disabled>
                            Xác nhận
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal hiển thị khi nhấn huỷ đơn hàng --}}
    <script>
        let selectedOrderCode = "";
        // Bật nút "Xác nhận" khi người dùng chọn đơn hàng để hủy
        document.querySelectorAll('.destroy-order').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                selectedOrderCode = this.closest('tr').querySelector('input[name="order_code"]').value;
                document.getElementById('confirm-button').disabled = false; // Bật nút "Xác nhận"
            });
        });
        // Gọi hàm cancellation_order khi nhấn nút "Xác nhận"
        document.getElementById('confirm-button').addEventListener('click', function() {
            if (selectedOrderCode) {
                cancellation_order(selectedOrderCode);
            } else {
                alert('Bạn chưa chọn đơn hàng để hủy.');
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var gridView = document.getElementById('gridView');
            var tableView = document.getElementById('tableView');
            var icon = document.getElementById('toggleViewIcon');
            var text = document.getElementById('toggleViewText');
            var currentView = localStorage.getItem('currentView') || 'grid';

            function toggleView() {
                if (currentView === 'grid') {
                    gridView.classList.remove('show');
                    setTimeout(function() {
                        gridView.style.display = 'none';
                        tableView.style.display = 'block';
                        setTimeout(function() {
                            tableView.classList.add('show');
                        }, 20);
                    }, 500);
                    icon.src = "{{ asset('frontend/images/home/table.png') }}";
                    text.textContent = 'Dạng bảng';
                    currentView = 'table';
                } else {
                    tableView.classList.remove('show');
                    setTimeout(function() {
                        tableView.style.display = 'none';
                        gridView.style.display = 'flex';
                        setTimeout(function() {
                            gridView.classList.add('show');
                        }, 20);
                    }, 500);
                    icon.src = "{{ asset('frontend/images/home/grid.png') }}";
                    text.textContent = 'Dạng thẻ';
                    currentView = 'grid';
                }
                localStorage.setItem('currentView', currentView);
            }

            if (currentView === 'table') {
                gridView.style.display = 'none';
                tableView.style.display = 'block';
                setTimeout(function() {
                    tableView.classList.add('show');
                }, 20);
                icon.src = "{{ asset('frontend/images/home/table.png') }}";
                text.textContent = 'Dạng bảng';
            } else {
                gridView.style.display = 'flex';
                tableView.style.display = 'none';
                setTimeout(function() {
                    gridView.classList.add('show');
                }, 20);
                icon.src = "{{ asset('frontend/images/home/grid.png') }}";
                text.textContent = 'Dạng thẻ';
            }

            icon.addEventListener('click', toggleView);
            text.addEventListener('click', toggleView);
        });
    </script>
@endsection
