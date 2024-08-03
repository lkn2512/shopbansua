@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Quản lý thương hiệu
                <span class="count-number">({{ number_Format($count_brand) }})</span>
            </h3>
        </div>
        <div class="btn-header">
            <a href="{{ URL::to('Admin/all-brand-product') }}">
                <button type="button" class="btn-refesh refesh-page"><i class="fa-solid fa-arrows-rotate"></i> Tải
                    lại trang
                </button>
            </a>
            <a href="{{ URL::to('Admin/add-brand-product') }}">
                <button type="button" class="btn-add-page add-products"><i class="fa-solid fa-plus"></i> Thêm
                    thương hiệu
                </button>
            </a>
        </div>
    </div>

    <table class="table table-hover align-middle table-bordered" id="example1">
        @php $i = 1;@endphp
        <thead>
            <tr class="position-sticky top-0 z-3">
                <th>STT</th>
                <th>Tên thương hiệu</th>
                <th>Sản phẩm</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_brand_product as $value)
                <tr id="brand-row-{{ $value->brand_id }}">
                    <td>{{ $i++ }}</td>
                    <td>{{ $value->brand_name }}</td>
                    <td>{{ number_format($product_counts[$value->brand_id]) }}</td>
                    <td>
                        <button type="button" class="toggle-status btn {{ $value->brand_status == 1 ? 'active' : '' }}"
                            data-id="{{ $value->brand_id }}"
                            data-active-url="{{ URL::to('Admin/active-brand-product/' . $value->brand_id) }}"
                            data-inactive-url="{{ URL::to('Admin/unactive-brand-product/' . $value->brand_id) }}"
                            data-toggle="tooltip" data-placement="top"
                            title="{{ $value->brand_status == 1 ? 'Hiển thị' : 'Ẩn' }}">
                        </button>
                    </td>
                    <td>
                        <a href="{{ URL::to('Admin/edit-brand-product/' . $value->brand_id) }}" class="btn-edit"><i
                                class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0);" class="btn-remove" data-id="{{ $value->brand_id }}" data-type="brand"
                            data-confirm-message="Bạn có chắc là muốn xoá thương hiệu này?" onclick="deleteItem(this)">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
