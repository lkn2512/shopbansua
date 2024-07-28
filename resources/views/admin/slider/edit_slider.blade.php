@extends('admin_layout')
@section('admin_content')
    @foreach ($edit_slider as $key => $sli)
        <form role="form" id="editForm" action="{{ URL::to('Admin/update-slider/' . $sli->slider_id) }}" method="post"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="header-title">
                <div class="">
                    <h3 class="title-content">Chỉnh sửa Banner</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/manage-slider') }}">Quản lý banner</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Chỉnh sửa banner
                        </li>
                    </ol>
                </div>
                <div class="btn-header">
                    <a href="javascript:location.reload(true)"> <button type="button" class="btn-ref refesh-page"><i
                                class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button></a>
                    <a href="">
                        <button type="submit" class="btn-add">
                            <span class="button-text"><i class="fa-solid fa-check"></i> Lưu</span>
                        </button>
                    </a>
                    <a href="{{ URL::to('Admin/manage-slider') }}"><button type="button" class="btn-back"><i
                                class="fa-solid fa-arrow-left"></i> Trở về</button></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 offset-md-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tên Banner<small class="note">(không bắt buộc)</small></label>
                                <input type="text" name="slider_name" class="form-control"
                                    value="{{ $sli->slider_name }}" placeholder="Nhập vào tên banner">
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh<small class="note"><span class="required">*</span></small><small
                                        class="note">(Kích thước ảnh nên là 540 x 1000px - cao x rộng)</small></label>
                                <input type="file" name="slider_image" accept="image/*"
                                    class="form-control file-Image-input">
                                <div class="error-message"></div>
                                <img id="img-edit-{{ $sli->slider_id }}" class="img-edit-slider"
                                    src="{{ URL::to('/uploads/slider/' . $sli->slider_image) }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Mô tả<small class="note">(không bắt buộc)</small></label>
                                <textarea style="resize:none" rows="4" name="slider_desc" class="form-control"
                                    placeholder="Nhập vào mô tả cho banner">{{ $sli->slider_desc }}</textarea>
                            </div>
                            <div class="form-group">
                                <div class="label-container">
                                    <label>Sản phẩm liên kết<small class="note"><span
                                                class="required">*</span></small></label>
                                    <span class="add-new">
                                        <a href="{{ URL::to('Admin/add-product') }}">Thêm sản phẩm</a>
                                    </span>
                                </div>
                                <select class="form-select select2" name="product_id" required>
                                    <option value="">Chọn sản phẩm</option>
                                    @foreach ($products as $product)
                                        @if ($sli->product)
                                            @if ($sli->product->product_id == $product->product_id)
                                                <option value="{{ $product->product_id }}" selected>
                                                    {{ $product->product_name }} ( {{ $product->product_code }})
                                                </option>
                                            @else
                                                <option value="{{ $product->product_id }}">
                                                    {{ $product->product_name }} ( {{ $product->product_code }})
                                                </option>
                                            @endif
                                        @else
                                            <option value="{{ $product->product_id }}">
                                                {{ $product->product_name }} ( {{ $product->product_code }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select class="form-select" name="slider_status">
                                    @if ($sli->slider_status == '1')
                                        <option value="1" selected>Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    @else
                                        <option value="0" selected>Ẩn</option>
                                        <option value="1">Hiển thị</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
