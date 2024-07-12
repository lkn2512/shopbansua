@extends('admin.admin-information.info-admin')
@section('profile-content')
    @foreach ($admin as $ad)
        <div class="card">
            <div class="card-header">
                <h4 class="title m-0">Bảo mật
                    <a href="{{ URL::to('Admin/security/' . $ad->id) }}" class="icon-refesh" title="Tải lại trang">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </a>
                </h4>
            </div>
            <div class="card-body">
                <h5 class="title">Địa chỉ email</h5>
                <span>Email hiện tại của bạn là:
                    <span style="color: #0d6efd">{{ $ad->email }}</span>
                </span>
                <div class="change-email">
                    <form action="{{ URL::to('Admin/change-email-admin/' . $ad->id) }}" id="saveForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Thay đổi email?</label>
                            <input type="email" name="email" class="form-control input-w500" required>
                        </div>
                        <button type="submit" class="btn-add btn-submit" data-mdb-ripple-init id="submit-button">
                            <span class="button-text">Thay đổi</span>
                            <span id="spinner" class="spinner">
                                <i class="fa fa-spinner fa-spin"></i>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <form action="{{ URL::to('Admin/change-password-admin/' . $ad->id) }}" method="POST" id="change-password-form">
                @csrf
                <div class="card-header">
                    <h5 class="title m-0">Thay đổi mật khẩu</h5>
                </div>
                <div class="card-body">
                    <div class="form-group group-eyes">
                        <label>Mật khẩu cũ</label>
                        <div class="password-wrapper">
                            <input type="password" name="old_password" class="form-control input-w500" id="old_password"
                                required>
                            <i class="fa fa-eye-slash" onclick="togglePasswordVisibility('old_password')"></i>
                        </div>
                        <div id="password-old-message" class="error-message"></div>
                    </div>
                    <div class="form-group group-eyes">
                        <label>Mật khẩu mới</label>
                        <div class="password-wrapper">
                            <input type="password" name="new_password" class="form-control input-w500" id="new_password"
                                required>
                            <i class="fa fa-eye-slash" onclick="togglePasswordVisibility('new_password')"></i>
                        </div>
                        <div id="password-strength-message" class="error-message"></div>
                    </div>
                    <div class="form-group group-eyes">
                        <label>Nhập lại mật khẩu mới</label>
                        <div class="password-wrapper">
                            <input type="password" name="new_password_confirmation" class="form-control input-w500"
                                id="new_password_confirmation" required>
                            <i class="fa fa-eye-slash" onclick="togglePasswordVisibility('new_password_confirmation')"></i>
                        </div>
                        <div id="password-match-message" class="error-message"></div>
                    </div>
                    <button type="submit" class="btn-add btn-submit" data-mdb-ripple-init id="submit-button">
                        <span class="button-text">Lưu mật khẩu</span>
                        <span id="spinner" class="spinner">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    @endforeach
    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const icon = passwordField.nextElementSibling;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const oldPasswordInput = document.getElementById('old_password');
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('new_password_confirmation');
            const passwordStrengthMessage = document.getElementById('password-strength-message');
            const passwordMatchMessage = document.getElementById('password-match-message');
            const passwordOldMessage = document.getElementById('password-old-message');
            const form = document.getElementById('change-password-form');

            newPasswordInput.addEventListener('input', function() {
                const password = newPasswordInput.value;
                let strengthMessage = '';
                passwordStrengthMessage.classList.remove('weak', 'strong');
                if (password.length < 8) {
                    strengthMessage = 'Mật khẩu phải có ít nhất 8 ký tự.';
                    passwordStrengthMessage.classList.add('weak');
                } else if (!/[A-Z]/.test(password)) {
                    strengthMessage = 'Mật khẩu phải có ít nhất một chữ hoa.';
                    passwordStrengthMessage.classList.add('weak');
                } else if (!/[a-z]/.test(password)) {
                    strengthMessage = 'Mật khẩu phải có ít nhất một chữ thường.';
                    passwordStrengthMessage.classList.add('weak');
                } else if (!/[0-9]/.test(password)) {
                    strengthMessage = 'Mật khẩu phải có ít nhất một chữ số.';
                    passwordStrengthMessage.classList.add('weak');
                } else {
                    strengthMessage = 'Mật khẩu mạnh.';
                    passwordStrengthMessage.classList.add('strong');
                }
                passwordStrengthMessage.textContent = strengthMessage;

                // Kiểm tra mật khẩu mới có trùng với mật khẩu cũ không
                const oldPassword = oldPasswordInput.value;
                if (password === oldPassword) {
                    passwordOldMessage.textContent = 'Mật khẩu mới không thể trùng với mật khẩu cũ.';
                } else {
                    passwordOldMessage.textContent = '';
                }
            });

            confirmPasswordInput.addEventListener('input', function() {
                const newPassword = newPasswordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                if (newPassword !== confirmPassword) {
                    passwordMatchMessage.textContent = 'Mật khẩu không khớp.';
                    passwordMatchMessage.classList.add('weak');
                } else {
                    passwordMatchMessage.textContent = '';
                    passwordMatchMessage.classList.remove('weak');
                }
            });

            form.addEventListener('submit', function(event) {
                const newPassword = newPasswordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                const oldPassword = oldPasswordInput.value;

                if (newPassword === oldPassword) {
                    passwordOldMessage.textContent = 'Mật khẩu mới không thể trùng với mật khẩu cũ.';
                    event.preventDefault();
                }

                if (newPassword !== confirmPassword) {
                    passwordMatchMessage.textContent = 'Mật khẩu không khớp.';
                    event.preventDefault();
                }

                if (passwordStrengthMessage.textContent !== 'Mật khẩu mạnh.') {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
