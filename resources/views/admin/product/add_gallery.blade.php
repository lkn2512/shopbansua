@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Thêm thư viện ảnh</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('Admin/all-product') }}">Quản lý sản phẩm</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Thêm thư viện ảnh</li>
            </ol>
        </div>
        <div class=" btn-header">
            <a href="javascript:location.reload(true)"> <button type="button" class="btn-ref refesh-page"
                    data-mdb-ripple-init><i class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button></a>
            <a href="{{ URL::to('Admin/all-product') }}"><button type="button" class="btn-back" data-mdb-ripple-init><i
                        class="fa-solid fa-arrow-left"></i> Trở về</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ url('Admin/insert-gallery/' . $pro_id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-5 offset-md-3">
                        <input type="file" class="form-control file-Image-input" accept="image/*" name="file[]"
                            id="file" multiple required>
                        <span class="error-message" id="error_gallery"></span>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn-upload" name="upload">
                            <i class="fa-solid fa-arrow-right-to-bracket" style="transform: rotate(90deg)"></i>
                            Tải ảnh
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-body-secondary">
                    <h4 class="card-title ">Ảnh đại diện sản phẩm <span>(#{{ $code_product }})</span>
                    </h4>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body text-center">
                    <div class="image-container">
                        <img class="width200" src="{{ asset('uploads/product/' . $product_image) }}">
                        <form id="upload-form" action="{{ URL::to('Admin/update-img-product') }}" method="post"
                            enctype="multipart/form-data" style="display: none;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product_id }}">
                            <input type="file" name="file_img" id="file-input"
                                onchange="document.getElementById('upload-form').submit();">
                        </form>
                        <a href="#" onclick="document.getElementById('file-input').click(); return false;">
                            <i class="fa-solid fa-image icon-gallery " id="file-icon"></i>
                        </a>
                    </div>
                    <div class="p-3">{{ $product_name }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-body-secondary">
                    <h4 class="card-title">Thư viện ảnh liên quan</h4>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                            <i class="fas fa-expand"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" value="{{ $pro_id }}" name="pro_id" class="pro_id">
                    <form>
                        @csrf
                        <div id="gallery_load">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
