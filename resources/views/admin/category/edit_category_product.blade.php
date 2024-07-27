@extends('admin_layout')
@section('admin_content')
    @foreach ($edit_category_product as $key => $edit_value)
        <form role="form" action="{{ URL::to('Admin/update-category-product/' . $edit_value->category_id) }}" method="post"
            id="editForm">
            @csrf
            <div class="header-title">
                <div class="">
                    <h3 class="title-content">Chỉnh sửa danh mục sản phẩm</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/all-category-product') }}">Danh mục sản phẩm</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa danh mục sản phẩm</li>
                    </ol>
                </div>
                <div class=" btn-header">
                    <a href="javascript:location.reload(true)"> <button type="button" class="btn-ref refesh-page"
                            data-mdb-ripple-init><i class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button></a>
                    <a href="">
                        <button type="submit" class="btn-add" data-mdb-ripple-init>
                            <span class="button-text"><i class="fa-solid fa-check"></i> Lưu</span>
                            <span id="spinner" class="spinner">
                                <i class="fa fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </a>
                    <a href="{{ URL::to('Admin/all-category-product') }}"><button type="button" class="btn-back"
                            data-mdb-ripple-init><i class="fa-solid fa-arrow-left"></i> Trở về</button></a>
                </div>
            </div>
            <hr class="titl-hr">
            <div class="panel panel-default">
                <div class="row">
                    <div class="col-md-5 offset-md-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Tên danh mục<small class="note"><span class="required">*</span></small></label>
                                    <input type="text" value="{{ $edit_value->category_name }}"
                                        name="category_product_name" required class="form-control"
                                        placeholder="Nhập vào tên danh mục cho sản phẩm" maxlength="50" id="check_name">
                                    <span id="error-message" class="error-message"></span>
                                </div>
                                <div class="form-group">
                                    <label>Mô tả<small class="note">(không bắt
                                            buộc)</small></label>
                                    <textarea style="resize:none" rows="4" type="password" name="category_product_desc" class="form-control"
                                        placeholder="Nhập vào mô tả cho danh mục của sản phẩm">{{ $edit_value->category_desc }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="form-select" name="category_product_status">
                                        @if ($edit_value->category_status == '1')
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
                    <div class="col-md-3">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Danh mục hiện hành</h3>
                                <div class="card-tools">
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
                                    @foreach ($category_product as $cate_pro)
                                        <span>{{ $cate_pro->category_name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
