@extends('admin_layout')
@section('admin_content')
    <form role="form" action="{{ URL::to('Admin/save-post') }}" method="post" enctype="multipart/form-data" id="addForm">
        {{ csrf_field() }}
        <div class="header-title">
            <div class="">
                <h3 class="title-content">Thêm tin tức</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/list-post') }}">Quản lý bài viết</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Thêm tin tức
                    </li>
                </ol>
            </div>
            <div class=" btn-header">
                <a href="javascript:location.reload(true)">
                    <button type="button" class="btn-ref refesh-page" data-mdb-ripple-init><i
                            class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button>
                </a>
                <a href="">
                    <button type="submit" class="btn-add " data-mdb-ripple-init>
                        <span class="button-text"><i class="fa-solid fa-plus"></i> Thêm</span>
                        <span id="spinner" class="spinner">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </a>
                <a href="{{ URL::to('Admin/list-post') }}">
                    <button type="button" class="btn-back" data-mdb-ripple-init><i class="fa-solid fa-arrow-left"></i> Trở
                        về</button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tiêu đề tin tức<small class="note"><span class="required">*</span></small></label>
                            <input type="text" name="post_title" required class="form-control" maxlength="60"
                                placeholder="Nhập vào tiêu đề tin tức" value="{{ old('post_title') }}"
                                data-slug-source="post" data-slug-source="cate_post_slug">
                        </div>
                        <div class="form-group">
                            <label>Slug<small class="note"><span class="required">*</span><span> (tự
                                        động)</span></small></label>
                            <input type="text" name="post_slug" class="form-control" placeholder="Nhập vào slug" required
                                data-slug-target="post">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh<small class="note"><span class="required">*</span></small></label>
                            <input type="file" name="post_image" accept="image/*" required
                                class="form-control file-Image-input preview-image" onchange="previewImage(this)">
                            <span class="error-message"></span>
                            <img src="{{ URL::to('backend/images/no-image.png') }}" alt="" id="preview_image"
                                class="img-review">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>Danh mục bài viết</label>
                                    <select class="form-select select2" name="cate_post_id">
                                        @foreach ($cate_post as $key => $cate)
                                            <option value="{{ $cate->cate_post_id }}">{{ $cate->cate_post_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="form-select" name="post_status">
                                        <option value="1" selected>Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Mô tả ngắn<small class="note"><span class="required">*</span></small></label>
                            <textarea maxlength="250" style="resize:none" rows="4" name="post_desc" class="form-control"
                                placeholder="Nhập vào mô tả ngắn cho tin tức" required>{{ old('post_desc') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea name="post_content" class="form-control" id="summernote_post" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
