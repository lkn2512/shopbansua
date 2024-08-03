@extends('admin_layout')
@section('admin_content')
    <form role="form" action="{{ URL::to('Admin/update-category-post/' . $category_post->cate_post_id) }}" method="post"
        id="editForm">
        {{ csrf_field() }}
        <div class="header-title">
            <div class="">
                <h3 class="title-content">Chỉnh sửa danh mục tin tức</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/all-category-post') }}">Danh mục bài viết</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Chỉnh sửa danh mục tin tức
                    </li>
                </ol>
            </div>
            <div class="btn-header">
                <a href="javascript:location.reload(true)"> <button type="button" class="btn-ref refesh-page"
                        data-mdb-ripple-init><i class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button></a>
                <a href="">
                    <button type="submit" class="btn-add" data-mdb-ripple-init name="add_post_cate">
                        <span class="button-text"><i class="fa-solid fa-check"></i> Lưu</span>
                        <span id="spinner" class="spinner"><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
                </a>
                <a href="{{ URL::to('Admin/all-category-post') }}"><button type="button" class="btn-back"
                        data-mdb-ripple-init><i class="fa-solid fa-arrow-left"></i> Trở về</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tên danh mục<small class="note"><span class="required">*</span></small></label>
                            <input type="text" name="cate_post_name" required class="form-control"
                                value="{{ $category_post->cate_post_name }}" placeholder="Nhập tên danh mục tin tức"
                                maxlength="100" data-slug-source="cate_post_slug">
                            <span id="error-message" class="error-message"></span>
                            <div class="form-group">
                                <label>Slug<small class="note"><span class="required">*</span><span> (tự
                                            động)</span></small></label>
                                <input type="text" name="cate_post_slug" class="form-control" placeholder="Nhập vào slug"
                                    required data-slug-target="cate_post_slug" value="{{ $category_post->cate_post_slug }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Mô tả<small class="note">(không bắt buộc)</small></label>
                            <textarea style="resize:none" rows="4" name="cate_post_desc" class="form-control"
                                placeholder="Nhập vào mô tả cho danh mục tin tức">{{ $category_post->cate_post_desc }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="form-select" name="cate_post_status">
                                        @if ($category_post->cate_post_status == 0)
                                            <option value="1">Hiển thị</option>
                                            <option value="0" selected>Ẩn</option>
                                        @else
                                            <option value="1" selected>Hiển thị</option>
                                            <option value="0">Ẩn</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Vị trí</label>
                                    <select class="form-select" name="cate_post_positions">
                                        <option value="0"
                                            {{ $category_post->cate_post_positions == 0 ? 'selected' : '' }}>Mặc
                                            định</option>
                                        <option value="1"
                                            {{ $category_post->cate_post_positions == 1 ? 'selected' : '' }}>Đầu
                                            trang</option>
                                        <option value="2"
                                            {{ $category_post->cate_post_positions == 2 ? 'selected' : '' }}>
                                            Cuối trang</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
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
                            @foreach ($category_post_edit as $cate_post)
                                <span>{{ $cate_post->cate_post_name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
