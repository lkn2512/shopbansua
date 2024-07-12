@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Quản lý video
                <span class="count-number">({{ number_format($video_count) }})</span>
            </h3>
        </div>
        <div class="btn-header">
            <a href="{{ URL::to('Admin/show-video') }}">
                <button type="button" class="btn-refesh refesh-page"><i class="fa-solid fa-arrows-rotate"></i> Tải
                    lại trang
                </button>
            </a>
            <a href="{{ URL::to('Admin/add-video') }}">
                <button type="button" class="btn-add-page add-products"><i class="fa-solid fa-plus"></i> Thêm
                    video
                </button>
            </a>
        </div>
    </div>
    <table class="table table-hover align-middle table-bordered" id="example1">
        <thead>
            <tr>
                <th>STT</th>
                <th>Link</th>
                <th>Tiêu đề</th>
                <th>Video</th>
                {{-- <th>Trạng thái</th> --}}
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1;@endphp
            @foreach ($video as $value)
                <tr id="video-row-{{ $value->video_id }}">
                    <td>{{ $i++ }}</td>
                    <td class="width200">{{ $value->video_link }}</td>
                    <td class="width300">{{ $value->video_title }}</td>
                    <td>
                        <span>{!! $value->video_iframe !!}</span>
                    </td>
                    {{-- <td>
                        <button type="button" class="toggle-status btn {{ $value->video_status == 1 ? 'active' : '' }}"
                            data-id="{{ $value->video_id }}"
                            data-active-url="{{ URL::to('Admin/active-video/' . $value->video_id) }}"
                            data-inactive-url="{{ URL::to('Admin/unactive-video/' . $value->video_id) }}"
                            data-toggle="tooltip" data-placement="top"
                            title="{{ $value->video_status == 1 ? 'Hiển thị' : 'Ẩn' }}">
                        </button>
                    </td> --}}
                    <td>
                        <a href="{{ URL::to('Admin/edit-video/' . $value->video_id) }}" class="btn-edit"
                            ui-toggle-class=""><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0);" class="btn-remove" data-id="{{ $value->video_id }}" data-type="video"
                            data-confirm-message="Bạn có chắc là muốn xoá video này?" onclick="deleteItem(this)">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
