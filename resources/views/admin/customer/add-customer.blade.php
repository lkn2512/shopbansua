@extends('admin_layout')
@section('admin_content')
    <form role="form" action="{{ URL::to('Admin/save-customer') }}" method="post" enctype="multipart/form-data"
        id="addForm">
        {{ csrf_field() }}
        <div class="row header-title">
            <div class="col-md-3">
                <h3 class="title-content">Thêm khách hàng</h3>
            </div>
            <div class="col-md-9 btn-header">
                <a href="javascript:location.reload(true)"> <button type="button" class="btn-ref refesh-page"
                        data-mdb-ripple-init><i class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button></a>
                <a href="">
                    <button type="submit" class="btn-add" data-mdb-ripple-init>
                        <span class="button-text"><i class="fa-solid fa-plus"></i> Thêm</span>
                        <span id="spinner" class="spinner">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </a>
                <a href="{{ URL::to('Admin/all-customer') }}"><button type="button" class="btn-back"
                        data-mdb-ripple-init><i class="fa-solid fa-arrow-left"></i> Trở về</button></a>
            </div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('Admin/all-customer') }}">Quản lý khách hàng</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Thêm khách hàng
                </li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-5 offset-md-1">
                <div class="card">
                    <div class="card-body">
                        <h5 class="title-hr">Thông tin cá nhân</h5>
                        <div class="form-group">
                            <label>Tên khách hàng<small class="note"><span class="required">*</span></small></label>
                            <input type="text" name="customer_name" class="form-control"
                                placeholder="Nhập vào tên khách hàng" required value="{{ old('customer_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Ảnh đại diện<small class="note">(không bắt buộc)</small></label>
                            <input type="file" name="customer_img" accept="image/*"
                                class="form-control file-Image-input">
                            <div class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại<small class="note"><span class="required">*</span></small></label>
                            <input type="number" name="customer_phone" class="form-control"
                                placeholder="Nhập vào số điện thoại" required value="{{ old('customer_phone') }}">
                            @error('customer_phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ<small class="note">(không bắt buộc)</small></label>
                            <input type="text" name="customer_address" class="form-control"
                                placeholder="Nhập vào địa chỉ khách hàng" value="{{ old('customer_address') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="title-hr">Thông tin đăng nhập</h5>
                        <div class="form-group">
                            <label>Email<small class="note"><span class="required">*</span></small></label>
                            <input type="email" name="customer_email" class="form-control" placeholder="Nhập vào email"
                                required value="{{ old('customer_email') }}">
                            @error('customer_email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu<small class="note"><span class="required">*</span></small></label>
                            <input type="password" name="customer_password" class=" form-control" id="customer_password"
                                placeholder="Nhập vào mật khẩu" required>
                            @error('customer_password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nhập lại mật khẩu<small class="note"><span class="required">*</span></small></label>
                            <input required type="password" class="form-control" name="customer_repeat_pass"
                                placeholder="Nhập lại mật khẩu">
                            <div id="passwordMismatchMsg" class="error-message" style="display: none;">
                                Mật khẩu không khớp.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var passwordInput = document.querySelector('input[name="customer_password"]');
            var confirmPasswordInput = document.querySelector('input[name="customer_repeat_pass"]');
            var submitButton = document.querySelector('button[type="submit"]');
            var passwordMismatchMsg = document.getElementById('passwordMismatchMsg');
            confirmPasswordInput.addEventListener('input', validatePassword);

            function validatePassword() {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    submitButton.disabled = true;
                    passwordMismatchMsg.style.display = 'block';
                } else {
                    submitButton.disabled = false;
                    passwordMismatchMsg.style.display = 'none';
                }
            }
        });
    </script>
@endsection
