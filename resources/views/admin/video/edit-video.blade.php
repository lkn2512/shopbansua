@extends('admin_layout')
@section('admin_content')
    @foreach ($edit_video as $key => $edit_value)
        <form role="form" action="{{ URL::to('Admin/update-video/' . $edit_value->video_id) }}" method="post"
            id="saveForm">
            @csrf
            <div class="header-title">
                <div class="">
                    <h3 class="title-content">Chỉnh sửa video</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/show-video') }}">Quản lý video</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Chỉnh sửa video
                        </li>
                    </ol>
                </div>
                <div class="btn-header">
                    <a href="javascript:location.reload(true)"> <button type="button" class="btn-ref refesh-page"><i
                                class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button></a>
                    <a href="">
                        <button type="submit" class="btn-add" data-mdb-ripple-init>
                            <span class="button-text"><i class="fa-solid fa-check"></i> Lưu</span>
                            <span id="spinner" class="spinner">
                                <i class="fa fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </a>
                    <a href="{{ URL::to('Admin/show-video') }}"><button type="button" class="btn-back"><i
                                class="fa-solid fa-arrow-left"></i> Trở về</button></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 offset-md-2">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Chỉnh sửa video</h3>
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
                            <div class="form-group">
                                <label>Tiêu đề<small class="note"><span class="required">*</span><span> (không chứa ký tự
                                            đặc biệt)</span></small></label>
                                <input type="text" name="video_title" class="form-control"
                                    placeholder="Nhập vào tiêu đề video" required maxlength="500" data-slug-source="video"
                                    value="{{ $edit_value->video_title }}">
                            </div>
                            <div class="form-group">
                                <label>Slug<small class="note"><span class="required">*</span><span> (tự
                                            động)</span></small></label>
                                <input type="text" name="video_slug" class="form-control"
                                    placeholder="Nhập vào tiêu đề slug" required data-slug-target="video"
                                    value="{{ $edit_value->video_slug }}">
                            </div>
                            <div class="form-group">
                                <label>Link<small class="note"><span class="required">*</span></small></label>
                                <input type="text" name="video_link" class="form-control"
                                    placeholder="Dán link video vào đây" required value="{{ $edit_value->video_link }}">
                            </div>
                            <div class="form-group">
                                <label>Mô tả<small class="note">(không bắt buộc)</small></label>
                                <textarea style="resize:none" rows="3" name="video_description" class="form-control"
                                    placeholder="Nhập vào mô tả ngắn" maxlength="255"> {{ $edit_value->video_description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Video</h3>
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
                        <div class="card-body" style="height: 300px">
                            <span>{!! $edit_value->video_iframe !!}</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
