@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Quản lý mã giảm giá
                <span class="count-number">({{ number_Format($count_coupon) }})</span>
            </h3>
        </div>
        <div class="btn-header">
            <a href="{{ URL::to('Admin/list-coupon') }}">
                <button type="button" class="btn-refesh ">
                    <i class="fa-solid fa-arrows-rotate"></i> Tải lại trang
                </button>
            </a>
            <a href="{{ URL::to('Admin/insert-coupon') }}">
                <button type="button" class="btn-add-page ">
                    <i class="fa-solid fa-plus"></i> Thêm mã giảm giá
                </button>
            </a>
        </div>
    </div>

    <table class="table table-hover align-middle table-bordered" id="example1">
        @php
            $i = 1;
        @endphp
        <thead>
            <tr class="position-sticky top-0 z-3">
                <th>STT</th>
                <th>Tên phiếu</th>
                <th>Mã giảm giá</th>
                <th>Giảm</th>
                <th>Số lượng</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Trạng thái</th>
                <th>Thời hạn</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coupon as $key => $cou)
                <tr id="coupon-row-{{ $cou->coupon_id }}">
                    <td>{{ $i++ }}</td>
                    <td class="width200">{{ $cou->coupon_name }}</td>
                    <td class="width300">{{ $cou->coupon_code }}</td>
                    <td>
                        <span class="text-ellipsis">
                            @if ($cou->coupon_condition == 1)
                                {{ number_format($cou->coupon_number) }}%
                            @else
                                {{ number_format($cou->coupon_number, 0, ',', '.') }}đ
                            @endif
                        </span>
                    </td>
                    <td>{{ number_format($cou->coupon_time) }}</td>
                    <td>{{ $cou->coupon_date_start }}</td>
                    <td>{{ $cou->coupon_date_end }}</td>
                    <td>
                        <button type="button" class="toggle-status btn {{ $cou->coupon_status == 1 ? 'active' : '' }}"
                            data-id="{{ $cou->coupon_id }}"
                            data-active-url="{{ URL::to('Admin/active-coupon/' . $cou->coupon_id) }}"
                            data-inactive-url="{{ URL::to('Admin/unactive-coupon/' . $cou->coupon_id) }}"
                            data-toggle="tooltip" data-placement="top"
                            title="{{ $cou->coupon_status == 1 ? 'Hiển thị' : 'Ẩn' }}">
                        </button>
                    </td>
                    <td class="width200">
                        @php
                            $today = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->startOfDay();
                            $endDate = \Carbon\Carbon::parse($cou->coupon_date_end)->startOfDay();
                            if ($endDate->gte($today)) {
                                $endDate->addDay();
                                $daysRemaining = $today->diffInDays($endDate);
                                echo 'Còn ' . floor($daysRemaining) . ' ngày';
                            } else {
                                echo '<span class="text-danger">Hết hạn</span>';
                            }
                        @endphp
                    </td>
                    <td>
                        <a href="{{ URL::to('Admin/edit-coupon/' . $cou->coupon_id) }}" class="btn-edit">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn-remove" data-id="{{ $cou->coupon_id }}" data-type="coupon"
                            data-confirm-message="Bạn có chắc là muốn xoá mã giảm giá này?" onclick="deleteItem(this)">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
