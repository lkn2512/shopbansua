@extends('admin_layout')
@section('admin_content')
    @foreach ($edit_section_product as $key => $edit_value)
        <form role="form" action="{{ URL::to('Admin/update-section-product/' . $edit_value->section_id) }}" method="post"
            id="saveForm">
            @csrf
            <div class="header-title">
                <div class="">
                    <h3 class="title-content">Chỉnh sửa chuyên mục</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/all-section-product') }}">Chuyên mục sản phẩm</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa chuyên mục</li>
                    </ol>
                </div>
                <div class=" btn-header">
                    <a href="javascript:location.reload(true)"> <button type="button" class="btn-ref refesh-page"
                            data-mdb-ripple-init><i class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button></a>
                    <a href="">
                        <button type="submit" class="btn-add" data-mdb-ripple-init>
                            <span class="button-text"><i class="fa-solid fa-check"></i> Lưu</span>
                        </button>
                    </a>
                    <a href="{{ URL::to('Admin/all-section-product') }}"><button type="button" class="btn-back"
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
                                    <label>Tên chuyên mục<small class="note"><span
                                                class="required">*</span></small></label>
                                    <input type="text" value="{{ $edit_value->section_name }}"
                                        name="section_product_name" required class="form-control"
                                        placeholder="Nhập vào tên chuyên mục cho sản phẩm" maxlength="50"
                                        data-slug-source="section_name">
                                </div>
                                <div class="form-group">
                                    <label>Slug<small class="note"><span class="required">*</span><span> (tự
                                                động)</span></small></label>
                                    <input type="text" name="section_slug" class="form-control"
                                        placeholder="Nhập vào slug" required data-slug-target="section_name"
                                        value="{{ $edit_value->section_slug }}">
                                </div>
                                <div class="form-group">
                                    <label>Mô tả<small class="note">(không bắt
                                            buộc)</small></label>
                                    <textarea style="resize:none" rows="4" type="password" name="section_product_desc" class="form-control"
                                        placeholder="Nhập vào mô tả cho chuyên mục của sản phẩm">{{ $edit_value->section_desc }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="form-select" name="section_product_status">
                                        @if ($edit_value->section_status == '1')
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
                                <h3 class="card-title">Chuyên mục hiện hành</h3>
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
                                    @foreach ($section_product as $value)
                                        <span>{{ $value->section_name }}</span>
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
