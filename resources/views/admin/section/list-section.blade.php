@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Chuyên mục sản phẩm
                <span class="count-number">({{ number_Format($count_allSectionProduct) }})</span>
            </h3>
        </div>
        <div class="btn-header">
            <a href="{{ URL::to('Admin/all-section-product') }}">
                <button type="button" class="btn-refesh refesh-page"><i class="fa-solid fa-arrows-rotate"></i> Tải
                    lại trang
                </button>
            </a>
            <a href="{{ URL::to('Admin/all-section-product/create-section') }}">
                <button type="button" class="btn-add-page add-products"><i class="fa-solid fa-plus"></i> Tạo chuyên mục
                </button>
            </a>
        </div>
    </div>

    <table class="table table-hover align-middle table-bordered" id="example1">
        @php $i = 1; @endphp
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên chuyên mục</th>
                <th>Mô tả chi tiết</th>
                <th>Sản phẩm</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($section_product as $value)
                <tr id="section-product-row-{{ $value->section_id }}">
                    <td>{{ $i++ }}</td>
                    <td>{{ $value->section_name }}</td>
                    <td class="text-auto">{{ $value->section_description }}</td>
                    <td>{{ number_format($product_counts[$value->section_id]) }}</td>
                    <td>
                        <button type="button" class="toggle-status btn {{ $value->section_status == 1 ? 'active' : '' }}"
                            data-id="{{ $value->section_id }}"
                            data-active-url="{{ URL::to('Admin/active-section-product/' . $value->section_id) }}"
                            data-inactive-url="{{ URL::to('Admin/unactive-section-product/' . $value->section_id) }}"
                            data-toggle="tooltip" data-placement="top"
                            title="{{ $value->section_status == 1 ? 'Hiển thị' : 'Ẩn' }}">
                        </button>
                    </td>
                    <td>
                        <a href="{{ URL::to('Admin/all-section-product/edit-section/' . $value->section_id) }}"
                            class="btn-edit" ui-toggle-class=""><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0);" class="btn-remove" data-id="{{ $value->section_id }}"
                            data-type="section-product" data-confirm-message="Bạn có chắc là muốn xoá chuyên mục này?"
                            onclick="deleteItem(this)">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
