@extends('admin_layout')
@section('admin_content')
    @foreach ($contact as $key => $contt)
        <form role="form" action="{{ URL::to('Admin/update-info-logo/' . $contt->info_id) }}" method="post"
            enctype="multipart/form-data" id="saveForm">
            {{ csrf_field() }}
            <div class="row header-title">
                <div class="col-md-5">
                    <h3 class="title-content">Logo website</h3>
                </div>
                <div class="col-md-7 btn-header">
                    <a href="javascript:location.reload(true)">
                        <button type="button" class="btn-ref refesh-page" data-mdb-ripple-init><i
                                class="fa-solid fa-arrows-rotate"></i> Tải lại trang
                        </button>
                    </a>
                    <a href="">
                        <button type="submit" class="btn-add" data-mdb-ripple-init>
                            <span class="button-text"><i class="fa-solid fa-check"></i> Lưu</span>
                            <span id="spinner" class="spinner">
                                <i class="fa fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="card-content">
                        <div class="form-group">
                            <label>Logo</label>
                            <input type="file" name="info_image" class="form-control"><br>
                            <img src="{{ url('/uploads/contact/' . $contt->info_image) }}" height="100px" width="auto">
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="form-group">
                            <label>Khẩu hiệu</label>
                            <input type="text" name="slogan_image" value="{{ $contt->slogan_image }}"
                                class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card-content">
                        <label for="">Kết quả hiển thị trên website</label>
                        <div style="background-color: #103667; padding: 20px">
                            <img src="{{ url('/uploads/contact/' . $contt->info_image) }}" height="100px" width="auto">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
