@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Sự kiện ngày lễ
                <span class="count-number">({{ number_Format($count_holiday) }})</span>
            </h3>
        </div>
        <div class="btn-header">
            <a href="{{ URL::to('Admin/holiday-event') }}">
                <button type="button" class="btn-refesh refesh-page"><i class="fa-solid fa-arrows-rotate"></i> Tải
                    lại trang
                </button>
            </a>
            <a href="{{ URL::to('Admin/holiday-event/create') }}">
                <button type="button" class="btn-add-page add-products"><i class="fa-solid fa-plus"></i> Tạo sự kiện
                </button>
            </a>
        </div>
    </div>
    @php
        use Carbon\Carbon;
        $currentDate = Carbon::now()->toDateString();
    @endphp
    <table class="table table-hover align-middle table-bordered" id="example1">
        @php $i = 1;@endphp
        <thead>
            <tr class="position-sticky top-0 z-3">
                <th>STT</th>
                <th>Tên sự kiện</th>
                <th>Hình ảnh</th>
                <th>Ngày diễn ra</th>
                <th>Ngày kết thúc</th>
                <th>Sản phẩm</th>
                <th>Hoạt động</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($holidayEvent as $value)
                <tr id="holiday-event-row-{{ $value->holiday_event_id }}">
                    <td>{{ $i++ }}</td>
                    <td>{{ $value->event_name }}</td>
                    <td>
                        <img class="img-event-list" src="/uploads/event/{{ $value->event_image }}">
                    </td>
                    <td>{{ \Carbon\Carbon::parse($value->event_date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($value->event_end_date)->format('d-m-Y') }}</td>
                    <td>{{ $productCounts[$value->event_name] ?? 0 }}</td>
                    <td>
                        @if ($currentDate >= $value->event_date && $currentDate <= $value->event_end_date)
                            <span class="event-status ongoing">Đang diễn ra</span>
                        @elseif($currentDate < $value->event_date)
                            <span class="event-status upcoming">Sắp diễn ra</span>
                        @else
                            <span class="event-status finished">Đã kết thúc</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="toggle-status btn {{ $value->event_status == 1 ? 'active' : '' }}"
                            data-id="{{ $value->holiday_event_id }}"
                            data-active-url="{{ URL::to('Admin/active-holiday-event/' . $value->holiday_event_id) }}"
                            data-inactive-url="{{ URL::to('Admin/unactive-holiday-event/' . $value->holiday_event_id) }}"
                            data-toggle="tooltip" data-placement="top"
                            title="{{ $value->event_status == 1 ? 'Hiển thị' : 'Ẩn' }}">
                        </button>
                    </td>
                    <td>
                        <a href="{{ URL::to('Admin/holiday-event/edit/' . $value->holiday_event_id) }}" class="btn-edit"><i
                                class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0);" class="btn-remove" data-id="{{ $value->holiday_event_id }}"
                            data-type="holiday-event" data-confirm-message="Bạn có chắc là muốn xoá sự kiện này?"
                            onclick="deleteItem(this)">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
