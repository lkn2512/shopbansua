@extends('admin_layout')
@section('admin_content')
    <form role="form" id="addForm" action="{{ URL::to('Admin/insert-slider') }}" method="post"
        enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="header-title">
            <div class="">
                <h3 class="title-content">Thêm Banner</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/manage-slider') }}">Quản lý Banner</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Thêm banner
                    </li>
                </ol>
            </div>
            <div class="btn-header">
                <a href="javascript:location.reload(true)"> <button type="button" class="btn-ref refesh-page"
                        data-mdb-ripple-init><i class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button></a>
                <a href="">
                    <button type="submit" class="btn-add">
                        <span class="button-text"> <i class="fa-solid fa-plus"></i> Thêm</span>
                    </button>
                </a>
                <a href="{{ URL::to('Admin/manage-slider') }}"><button type="button" class="btn-back"
                        data-mdb-ripple-init><i class="fa-solid fa-arrow-left"></i> Trở về</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tên Banner<small class="note">(không bắt buộc)</small></label>
                            <input type="text" name="slider_name" class="form-control" placeholder="Nhập vào tên banner">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh<small class="note"><span class="required">*</span></small> <small
                                    class="note">(Kích thước ảnh nên là 540 x 1000px - cao x rộng)</small></label>
                            <input type="file" name="slider_image" accept="image/*" required
                                class="form-control file-Image-input">
                            <div class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label>Mô tả<small class="note">(không bắt buộc)</small></label>
                            <textarea style="resize:none" rows="4" name="slider_desc" class="form-control"
                                placeholder="Nhập vào mô tả cho banner"></textarea>
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
                                <option value="" selected>Chọn sản phẩm</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->product_id }}">
                                        {{ $product->product_name }} ( {{ $product->product_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-select" name="slider_status">
                                <option value="1" selected>Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Banner hiện hành</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-review">
                            <?php
                            $i = 0;
                            foreach ($slider as $key => $slide) {
                                $i++;
                            ?>
                            <img src="/uploads/slider/{{ $slide->slider_image }}" class="banner-img">
                            <?php
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
