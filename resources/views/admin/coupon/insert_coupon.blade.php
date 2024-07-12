@extends('admin_layout')
@section('admin_content')
    <form role="form" action="{{ URL::to('Admin/insert-coupon-code') }}" method="post" id="saveForm">
        @csrf
        <div class="header-title">
            <div class="">
                <h3 class="title-content">Thêm mã giảm giá</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to('Admin/list-coupon') }}">Quản lý mã giảm giá </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Thêm mã giảm giá
                    </li>
                </ol>
            </div>
            <div class="btn-header">
                <a href="{{ URL::to('Admin/insert-coupon') }}">
                    <button type="button" class="btn-ref refesh-page" data-mdb-ripple-init><i
                            class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button>
                </a>
                <a href="">
                    <button type="submit" class="btn-add">
                        <span class="button-text"> <i class="fa-solid fa-plus"></i> Thêm</span>
                        <span id="spinner" class="spinner">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </a>
                <a href="{{ URL::to('Admin/list-coupon') }}">
                    <button type="button" class="btn-back" data-mdb-ripple-init><i class="fa-solid fa-arrow-left"></i> Trở
                        về</button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tên phiếu giảm giá<small class="note"><span class="required">*</span></small></label>
                            <input type="text" name="coupon_name" required class="form-control" maxlength="50"
                                placeholder="Nhập vào tên phiếu giảm giá">
                        </div>
                        <div class="form-group">
                            <div class="label-container">
                                <label>Mã giảm giá
                                    <small class="note"><span class="required">*</span></small>
                                </label>
                                <span class="add-new"><a class="btn-random" onclick="generateCoupon()">Tạo
                                        ngẫu nhiên</a></span>
                            </div>
                            <input type="text" name="coupon_code" required class="form-control" maxlength="20"
                                id="name_code" onkeypress="preventWhitespace(event)" placeholder="Nhập vào mã giảm giá">
                            <script>
                                function generateCoupon() {
                                    var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                                    var coupon = '';
                                    for (var i = 0; i < 20; i++) {
                                        coupon += chars.charAt(Math.floor(Math.random() * chars.length));
                                    }
                                    document.getElementById('name_code').value = coupon;
                                }
                            </script>
                        </div>
                        <div class="form-group">
                            <label>Số lượng<small class="note"><span class="required">*</span></small></label>
                            <input type="number" name="coupon_times" required class="form-control input-number"
                                placeholder="Nhập vào số lượng mã giảm giá">
                        </div>
                        <div class="form-group">
                            <label>Giảm theo<small class="note"><span class="required">*</span></small></label>
                            <select class="form-select" name="coupon_condition">
                                <option value="1" selected>Phần trăm (%) </option>
                                <option value="2">Tiền tệ (đồng)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Giá trị giảm<small class="note">(chỉ cần nhập
                                    số)<span class="required">*</span> </small></label>
                            <input type="number" name="coupon_number" required class="form-control  input-number"
                                placeholder="Nhập vào giá trị giảm">

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Từ ngày<small class="note"><span class="required">*</span></small></label>
                                    <input type="date" class="form-control" name="coupon_date_start" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Đến ngày<small class="note"><span class="required">*</span></small></label>
                                    <input type="date" class="form-control" name="coupon_date_end" required>
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
@endsection
