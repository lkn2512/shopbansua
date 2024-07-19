@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Quản lý Banner
                <span class="count-number">({{ number_Format($count_slider) }})</span>
            </h3>
        </div>
        <div class="btn-header">
            <a href="{{ URL::to('Admin/manage-slider') }}">
                <button type="button" class="btn-refesh"><i class="fa-solid fa-arrows-rotate"></i> Tải lại
                    trang
                </button>
            </a>
            <a href="{{ URL::to('Admin/add-slider') }}">
                <button type="button" class="btn-add-page"><i class="fa-solid fa-plus"></i> Thêm Banner
                </button>
            </a>
        </div>
    </div>

    <table class="table table-hover align-middle table-bordered" id="example1">
        @php $i = 1; @endphp
        <thead>
            <tr>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tên Banner</th>
                <th>Mô tả</th>
                <th>Sản phẩm</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_slider as $key => $slide)
                <tr id="slider-row-{{ $slide->slider_id }}">
                    <td>{{ $i++ }}</td>
                    <td><img class="bannerImage" src="{{ asset('uploads/slider/' . $slide->slider_image) }}"></td>
                    <td class="width200">{{ $slide->slider_name }}</td>
                    <td class="width200">{{ $slide->slider_desc }}</td>
                    <td class="width200">{{ $slide->product ? $slide->product->product_name : '' }}</td>
                    <td>
                        <span class="text-ellipsis">
                            <button type="button"
                                class="toggle-status btn {{ $slide->slider_status == 1 ? 'active' : '' }}"
                                data-id="{{ $slide->slider_id }}"
                                data-active-url="{{ URL::to('Admin/active-slide/' . $slide->slider_id) }}"
                                data-inactive-url="{{ URL::to('Admin/unactive-slide/' . $slide->slider_id) }}"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ $slide->slider_status == 1 ? 'Hiển thị' : 'Ẩn' }}">
                            </button>
                        </span>
                    </td>
                    <td>
                        <a href="{{ URL::to('Admin/edit-slider/' . $slide->slider_id) }}" class="btn-edit"
                            ui-toggle-class=""><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0);" class="btn-remove" data-id="{{ $slide->slider_id }}"
                            data-type="slider" data-confirm-message="Bạn có chắc là muốn xoá banner này?"
                            onclick="deleteItem(this)">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
