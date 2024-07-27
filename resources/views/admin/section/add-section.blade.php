@extends('admin_layout')
@section('admin_content')
    <form role="form" action="{{ URL::to('Admin/save-section-product') }}" method="post" id="saveForm">
        {{ csrf_field() }}
        <div class="header-title">
            <div class="">
                <h3 class="title-content">Tạo chuyên mục</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/all-section-product') }}">Chuyên mục sản phẩm </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tạo chuyên mục
                    </li>
                </ol>
            </div>
            <div class="btn-header">
                <a href=""onclick="window.location.reload(); return false;">
                    <button type="button" class="btn-ref refesh-page"><i class="fa-solid fa-arrows-rotate"></i> Tải lại
                        trang
                    </button>
                </a>
                <a href="">
                    <button type="submit" class="btn-add" id="submitBtn">
                        <span class="button-text"><i class="fa-solid fa-plus"></i> Thêm</span>
                    </button>
                </a>
                <a href="{{ URL::to('Admin/all-section-product') }}">
                    <button type="button" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Trở
                        về
                    </button>
                </a>
            </div>

        </div>
        <div class="row">
            <div class="col-md-5 offset-md-2">
                <div class="card ">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tên chuyên mục<small class="note"><span class="required">*</span></small></label>
                            <input type="text" name="section_name" required class="form-control"
                                placeholder="Nhập vào tên chuyên mục cho sản phẩm" maxlength="50"
                                data-slug-source="section_name" id="check_name">
                            <span id="error-message" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label>Slug<small class="note"><span class="required">*</span><span> (tự
                                        động)</span></small></label>
                            <input type="text" name="section_slug" class="form-control" placeholder="Nhập vào slug"
                                required data-slug-target="section_name">
                        </div>
                        <div class="form-group">
                            <label>Mô tả<small class="note">(không bắt buộc)</small></label>
                            <textarea style="resize:none" rows="4" name="section_desc" class="form-control"
                                placeholder="Nhập vào mô tả cho chuyên mục của sản phẩm"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-select" name="section_status">
                                <option value="1" selected>Hiển thị</option>
                                <option value="0">Ẩn</option>
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
    </form>
@endsection
