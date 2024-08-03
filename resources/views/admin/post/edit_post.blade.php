@extends('admin_layout')
@section('admin_content')
    @foreach ($edit_post as $key => $edit_p)
        <form role="form" action="{{ URL::to('Admin/update-post/' . $edit_p->post_id) }}" method="post"
            enctype="multipart/form-data" id="editForm">
            {{ csrf_field() }}
            <div class="header-title">
                <div class="">
                    <h3 class="title-content">Chỉnh sửa tin tức</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/list-post') }}">Quản lý bài viết</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Chỉnh sửa tin tức
                        </li>
                    </ol>
                </div>
                <div class=" btn-header">
                    <a href="javascript:location.reload(true)">
                        <button type="button" class="btn-ref refesh-page" data-mdb-ripple-init><i
                                class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button>
                    </a>
                    <a href="">
                        <button type="submit" id="saveButton" class="btn-add" data-mdb-ripple-init>
                            <span class="button-text"><i class="fa-solid fa-check"></i> Lưu</span>
                            <span id="spinner" class="spinner">
                                <i class="fa fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </a>
                    <a href="{{ URL::to('Admin/list-post') }}">
                        <button type="button" class="btn-back" data-mdb-ripple-init><i class="fa-solid fa-arrow-left"></i>
                            Trở về</button>
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
                                    placeholder="Nhập vào tiêu đề tin tức" value="{{ $edit_p->post_title }}"
                                    data-slug-source="post">
                            </div>
                            <div class="form-group">
                                <label>Slug<small class="note"><span class="required">*</span><span> (tự
                                            động)</span></small></label>
                                <input type="text" name="post_slug" class="form-control" placeholder="Nhập vào slug"
                                    required data-slug-target="post" value="{{ $edit_p->post_slug }}">
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh<small class="note"><span class="required">*</span></small></label>
                                <input type="file" name="post_image" accept="image/*"
                                    class="form-control file-Image-input">
                                <span class="error-message"></span>
                                <img class="img-edit-product" id="img-edit-{{ $edit_p->post_id }}"
                                    src="{{ URL::to('/uploads/post/' . $edit_p->post_image) }}">
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Danh mục bài viết
                                            <span style="margin-left: 39px">
                                                <a href="{{ URL::to('Admin/add-category-post') }}">Thêm mới</a>
                                            </span>
                                        </label>
                                        <select class="form-select select2" name="cate_post_id">
                                            @foreach ($cate_post as $key => $cate_p)
                                                @if ($cate_p->cate_post_id == $edit_p->cate_post_id)
                                                    <option value="{{ $cate_p->cate_post_id }}" selected>
                                                        {{ $cate_p->cate_post_name }}</option>
                                                @else
                                                    <option value="{{ $cate_p->cate_post_id }}">
                                                        {{ $cate_p->cate_post_name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Trạng thái</label>
                                        <select class="form-select" name="post_status">
                                            @if ($edit_p->post_status == '1')
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
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Mô tả ngắn<small class="note"><span class="required">*</span></small></label>
                                <textarea maxlength="250" style="resize:none" rows="4" name="post_desc" class="form-control"
                                    placeholder="Nhập vào mô tả ngắn cho tin tức" required>{{ $edit_p->post_desc }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name="post_content" class="form-control" id="summernote_edit_post" required>{{ $edit_p->post_content }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
