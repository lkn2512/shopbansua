@extends('admin_layout')
@section('admin_content')
    @foreach ($edit_coupon_code as $key => $cou_val)
        <form role="form" action="{{ URL::to('Admin/update-coupon/' . $cou_val->coupon_id) }}" method="post"
            enctype="multipart/form-data" id="saveForm">
            @csrf
            <div class="header-title">
                <div class="">
                    <h3 class="title-content">Chỉnh sửa mã giảm giá</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ URL::to('Admin/list-coupon') }}">Quản lý mã giảm giá </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Chỉnh sửa mã giảm giá
                        </li>
                    </ol>
                </div>
                <div class="btn-header">
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
                    <a href="{{ URL::to('Admin/list-coupon') }}"><button type="button" class="btn-back"
                            data-mdb-ripple-init><i class="fa-solid fa-arrow-left"></i> Trở về</button></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if ($order_details_check > 0)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-exclamation-circle"></i> Vì mã giảm giá này đã được <b>sử dụng</b> nên một
                            số
                            thông tin sẽ không thể thay đổi!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                <div class="col-md-5 offset-md-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Tên phiếu giảm giá<small class="note"><span
                                            class="required">*</span></small></label>
                                <input type="text" name="coupon_name" required class="form-control" id=""
                                    maxlength="50" value="{{ $cou_val->coupon_name }}"
                                    placeholder="Nhập vào tên phiếu giảm giá">
                            </div>
                            <div class="form-group">
                                <div class="label-container">
                                    <label>Mã giảm giá<small class="note"><span class="required">*</span></small></label>
                                    <span class="add-new">
                                        <a class="btn-random" id="generateCouponBtn" onclick="generateCoupon()"
                                            {{ $order_details_check > 0 ? 'style=pointer-events:none;opacity:0.5;' : '' }}>Tạo
                                            ngẫu nhiên</a>
                                    </span>
                                </div>
                                <input type="text" name="coupon_code" required class="form-control" id="name_code_edit"
                                    maxlength="20" value="{{ $cou_val->coupon_code }}" onkeypress="preventWhitespace(event)"
                                    placeholder="Nhập vào mã giảm giá" {{ $order_details_check > 0 ? 'readonly' : '' }}>
                                <script>
                                    function generateCoupon() {
                                        var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                                        var coupon = '';
                                        for (var i = 0; i < 20; i++) {
                                            coupon += chars.charAt(Math.floor(Math.random() * chars.length));
                                        }
                                        document.getElementById('name_code_edit').value = coupon;
                                    }

                                    var orderDetailsCheck = @json($order_details_check);
                                    if (orderDetailsCheck > 0) {
                                        document.getElementById('generateCouponBtn').style.pointerEvents = 'none';
                                        document.getElementById('generateCouponBtn').style.opacity = '0.5';
                                    }
                                </script>
                            </div>
                            <div class="form-group">
                                <label>Số lượng mã<small class="note"><span class="required">*</span></small></label>
                                <input type="number" name="coupon_times" required class="form-control input-number"
                                    value="{{ $cou_val->coupon_time }}"placeholder="Nhập vào số lượng mã giảm giá">
                            </div>

                            <div class="form-group">
                                <label>Giảm theo</label>
                                <select class="form-select" name="coupon_condition">
                                    @if ($order_details_check > 0)
                                        @if ($cou_val->coupon_condition == '1')
                                            <option value="1" selected>Giảm theo phần trăm</option>
                                        @else
                                            <option value="2" selected>Tiền tệ(đ)</option>
                                        @endif
                                    @else
                                        @if ($cou_val->coupon_condition == '1')
                                            <option value="1" selected>Giảm theo phần trăm</option>
                                            <option value="2">Giảm theo tiền</option>
                                        @else
                                            <option value="2" selected>Tiền tệ(đ)</option>
                                            <option value="1">Phần trăm(%)</option>
                                        @endif
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Giá trị giảm<small class="note"><span class="required">*</span></small></label>
                                <input type="number" name="coupon_number" required class="form-control input-number"
                                    value="{{ $cou_val->coupon_number }}" placeholder="Nhập vào giá trị giảm"
                                    {{ $order_details_check > 0 ? 'readonly' : '' }}>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Từ ngày</label>
                                        <input type="date" class="form-control" name="coupon_date_start"
                                            value="{{ $cou_val->coupon_date_start }}" title="Ví dụ: 2001-01-01" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Đến ngày</label>
                                        <input type="date" class="form-control" name="coupon_date_end"
                                            value="{{ $cou_val->coupon_date_end }}" title="Ví dụ: 2001-01-01" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Mã giảm giá hiện hành</h3>
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
                                @foreach ($coupon_list as $couponL)
                                    <span>{{ $couponL->coupon_name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
