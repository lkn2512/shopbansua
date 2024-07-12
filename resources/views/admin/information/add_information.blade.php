@extends('admin_layout')
@section('admin_content')
    @foreach ($contact as $key => $contt)
        <form role="form" action="{{ URL::to('Admin/update-info/' . $contt->info_id) }}" method="post"
            enctype="multipart/form-data" id="saveForm">
            {{ csrf_field() }}
            <div class="header-title">
                <div class="">
                    <h3 class="title-content">Chi tiết liên hệ</h3>
                </div>
                <div class="btn-header">
                    <a href="javascript:location.reload(true)"> <button type="button" class="btn-ref refesh-page"
                            data-mdb-ripple-init><i class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button></a>
                    <a href="">
                        <button type="submit" class="btn-add" data-mdb-ripple-init name="add_info">
                            <span class="button-text"><i class="fa-solid fa-check"></i> Lưu</span>
                            <span id="spinner" class="spinner">
                                <i class="fa fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" name="info_address" class="form-control"
                                    value="{{ $contt->info_address }}" required>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="number" name="info_phone" class="form-control"
                                    value="{{ $contt->info_phone }}" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="info_email" class="form-control"
                                    value="{{ $contt->info_email }}" required>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Fanpage</label>
                                <input type="url" name="info_fanpage_url" class="form-control"
                                    value="{{ $contt->info_fanpage_url }}" required>
                            </div>
                            {!! $contt->info_fanpage !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Bản đồ</label>
                                <textarea style="resize:none" rows="8" name="info_map" class="form-control" required>{{ $contt->info_map }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            {!! $contt->info_map !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Ghi chú thêm</label>
                            <textarea style="resize:none" name="info_note" class="form-control" minlength="10" rows="5">{{ $contt->info_note }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
