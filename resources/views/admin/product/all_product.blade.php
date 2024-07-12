@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Quản lý sản phẩm
                <span class="count-number">({{ number_Format($count_product) }})</span>
            </h3>
        </div>
        <div class="btn-header">
            <a href="{{ URL::to('Admin/all-product') }}">
                <button type="button" class="btn-refesh"><i class="fa-solid fa-arrows-rotate"></i>
                    Tải lại trang
                </button>
            </a>
            <a href="{{ URL::to('Admin/add-product') }}">
                <button type="button" class="btn-add-page"><i class="fa-solid fa-plus"></i>Thêm sản
                    phẩm
                </button>
            </a>
        </div>
    </div>

    <table class="table table-hover align-middle table-bordered " id="example1">
        @php $i = 1; @endphp
        <thead>
            <tr class="position-sticky top-0 z-3">
                <th>STT</th>
                <th>Hình</th>
                <th>Mã</th>
                <th>Tên sản phẩm</th>
                <th>Giá gốc</th>
                <th>Giá bán</th>
                <th>Khuyến mãi</th>
                <th>Kho</th>
                <th>Danh mục</th>
                <th>Thương hiệu</th>
                <th>Video</th>
                <th>Bán ra</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_product as $key => $pro)
                <tr id="product-row-{{ $pro->product_id }}">
                    <td>{{ $i++ }}</td>
                    <td class="info-product">
                        <img class="img-product" src="/uploads/product/{{ $pro->product_image }}">
                        <a class="image-library" href="{{ 'add-gallery/' . $pro->product_id }}" title="Thêm thư viện ảnh">
                            <img src="/backend/images/add_image2.png" alt="">
                        </a>
                    </td>
                    <td>{{ $pro->product_code }}</td>
                    <td class="width300">
                        <a class="text-black" href="{{ url('chi-tiet-san-pham/' . $pro->product_id) }}"
                            target="_blank">{{ $pro->product_name }}</a>
                    </td>
                    <td>{{ number_format($pro->product_cost, 0, ',', '.') }}đ</td>
                    @if ($pro->promotional_price)
                        <td class="text-decoration-line-through">
                            {{ number_format($pro->product_price, 0, ',', '.') }}đ
                        </td>
                    @else
                        <td>{{ number_format($pro->product_price, 0, ',', '.') }}đ</td>
                    @endif

                    @if ($pro->promotional_price > 0)
                        <td class="text-danger">{{ number_format($pro->promotional_price, 0, ',', '.') }}đ</td>
                    @else
                        <td>{{ number_format($pro->promotional_price, 0, ',', '.') }}đ</td>
                    @endif

                    <td>{{ number_format($pro->product_quantity, 0, ',', '.') }}</td>
                    <td>{{ $pro->category->category_name }}</td>
                    <td>{{ $pro->brand->brand_name }}</td>
                    <td>
                        @if ($pro->video_id !== null)
                            <span>Có</span>
                        @else
                            <span class="text-secondary">Không</span>
                        @endif
                    </td>
                    <td>{{ $pro->product_sold }}</td>
                    <td>
                        <button type="button" class="toggle-status btn {{ $pro->product_status == 1 ? 'active' : '' }}"
                            data-id="{{ $pro->product_id }}"
                            data-active-url="{{ URL::to('Admin/active-product/' . $pro->product_id) }}"
                            data-inactive-url="{{ URL::to('Admin/unactive-product/' . $pro->product_id) }}"
                            data-toggle="tooltip" data-placement="top"
                            title="{{ $pro->product_status == 1 ? 'Hiển thị' : 'Ẩn' }}">
                        </button>
                    </td>
                    <td>
                        <a href="{{ URL::to('Admin/edit-product/' . $pro->product_id) }}" class="btn-edit"
                            ui-toggle-class=""><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0);" class="btn-remove" data-id="{{ $pro->product_id }}"
                            data-type="product" data-confirm-message="Bạn có chắc là muốn xoá sản phẩm này?"
                            onclick="deleteItem(this)">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
