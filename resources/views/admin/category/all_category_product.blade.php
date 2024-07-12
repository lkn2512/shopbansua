@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Danh mục sản phẩm
                <span class="count-number">({{ number_Format($count_allCategoryProduct) }})</span>
            </h3>
        </div>
        <div class="btn-header">
            <a href="{{ URL::to('Admin/all-category-product') }}">
                <button type="button" class="btn-refesh refesh-page"><i class="fa-solid fa-arrows-rotate"></i> Tải
                    lại trang
                </button>
            </a>
            <a href="{{ URL::to('Admin/add-category-product') }}">
                <button type="button" class="btn-add-page add-products"><i class="fa-solid fa-plus"></i> Thêm danh mục
                </button>
            </a>
        </div>
    </div>

    <table class="table table-hover align-middle table-bordered" id="example1">
        @php $i = 1; @endphp
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên danh mục</th>
                <th>Mô tả chi tiết</th>
                <th>Sản phẩm</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($category_product as $cate_pro)
                <tr id="category-product-row-{{ $cate_pro->category_id }}">
                    <td>{{ $i++ }}</td>
                    <td>{{ $cate_pro->category_name }}</td>
                    <td class="text-auto">{{ $cate_pro->category_desc }}</td>
                    <td>{{ number_format($product_counts[$cate_pro->category_id]) }}</td>
                    <td>
                        <button type="button"
                            class="toggle-status btn {{ $cate_pro->category_status == 1 ? 'active' : '' }}"
                            data-id="{{ $cate_pro->category_id }}"
                            data-active-url="{{ URL::to('Admin/active-category-product/' . $cate_pro->category_id) }}"
                            data-inactive-url="{{ URL::to('Admin/unactive-category-product/' . $cate_pro->category_id) }}"
                            data-toggle="tooltip" data-placement="top"
                            title="{{ $cate_pro->category_status == 1 ? 'Hiển thị' : 'Ẩn' }}">
                        </button>
                    </td>
                    <td>
                        <a href="{{ URL::to('Admin/edit-category-product/' . $cate_pro->category_id) }}" class="btn-edit"
                            ui-toggle-class=""><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0);" class="btn-remove" data-id="{{ $cate_pro->category_id }}"
                            data-type="category-product"
                            data-confirm-message="Bạn có chắc là muốn xoá danh mục sản phẩm này?"
                            onclick="deleteItem(this)">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
