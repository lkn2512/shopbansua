<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="row">
        <div class="col-md-5 card p-4 content mx-auto">
            <form class="form" action="{{ URL::to('/add-customer') }}" method="POST"
                onsubmit="return validateForm()">
                @csrf
                <span class="title">Đăng ký</span>
                <p class="message">Đăng ký ngay để nhận ưu đãi đầy đủ của chúng tôi. </p>
                <label>
                    <input required type="text" class="input form-control" name="customer_name"
                        value="{{ old('customer_name') }}">
                    <span>Họ và tên</span>
                </label>
                <label>
                    <input required type="email" class="input form-control" name="customer_email"
                        value="{{ old('customer_email') }}">
                    <span>Email</span>
                    @error('customer_email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </label>
                <label>
                    <input required type="text" class="input form-control" name="customer_phone"
                        oninput="validatePhone()" value="{{ old('customer_phone') }}">
                    <span>Số điện thoại</span>
                    <span id="phoneError"></span>
                    @error('customer_phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </label>
                <label class="password-wrapper">
                    <input required type="password" class="input form-control" name="customer_password"
                        id="customer_password">
                    <span>Mật khẩu</span>
                    <span class="toggle-password" onclick="togglePasswordVisibility('customer_password', this)">
                        <i class="fa fa-eye-slash"></i>
                    </span>
                </label>
                <label class="password-wrapper">
                    <input required type="password" class="input form-control" name="customer_repeat_pass"
                        id="customer_repeat_pass" oninput="validatePassword()">
                    <span>Nhập lại mật khẩu</span>
                    <span class="toggle-password" onclick="togglePasswordVisibility('customer_repeat_pass', this)">
                        <i class="fa fa-eye-slash"></i>
                    </span>
                </label>
                <span id="passwordError"></span>
                <button class="submit form-control" type="submit" id="registerButton" disabled>Đăng ký</button>
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ url('/') }}" class="home-shop"><i class="fa-solid fa-house"></i> Trang
                            chủ</a>
                    </div>
                    <div class="col-md-9">
                        <p class="signin">Bạn đã có tài khoản? <a href="{{ url('login') }}">Đăng nhập</a> </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/jquery.min.js') }}"></script>
    <script>
        function checkInputs() {
            var inputs = document.querySelectorAll('.form input');
            var allInputsFilled = true;
            inputs.forEach(function(input) {
                if (input.value.trim() === '') {
                    allInputsFilled = false;
                }
            });
            return allInputsFilled;
        }

        function validatePhone() {
            var phoneInput = document.querySelector('input[name="customer_phone"]');
            var phoneError = document.getElementById('phoneError');
            var phoneRegex = /^0[0-9]{9,10}$/;

            var phoneValue = phoneInput.value.trim();

            if (phoneValue === '') {
                return false;
            } else if (!phoneRegex.test(phoneValue)) {
                phoneError.textContent = "Số điện thoại không hợp lệ.";
                return false;
            } else {
                phoneError.textContent = "";
                return true;
            }
        }

        function togglePasswordVisibility(inputId, iconSpan) {
            var input = document.getElementById(inputId);
            var icon = iconSpan.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }

        function validatePassword() {
            var passwordInput = document.querySelector('input[name="customer_password"]');
            var repeatPasswordInput = document.querySelector('input[name="customer_repeat_pass"]');
            var passwordError = document.getElementById('passwordError');
            var passwordValue = passwordInput.value.trim();
            var repeatPasswordValue = repeatPasswordInput.value.trim();

            if (passwordValue === '' || repeatPasswordValue === '') {
                return false;
            } else if (passwordValue !== repeatPasswordValue) {
                passwordError.textContent = "Mật khẩu không khớp.";
                return false;
            } else {
                passwordError.textContent = "";
                return true;
            }
        }

        function validateForm() {
            var isPhoneValid = validatePhone();
            var isPasswordValid = validatePassword();

            if (isPhoneValid && isPasswordValid) {
                return true;
            } else {
                return false;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var registerButton = document.getElementById('registerButton');
            var formInputs = document.querySelectorAll('.form input');

            formInputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    var isPhoneValid = validatePhone();
                    var isPasswordValid = validatePassword();
                    var value = this.value;
                    if (value === '' || value[0] === ' ') {
                        this.value = value.trim();
                    }

                    if (isPhoneValid && isPasswordValid && checkInputs()) {
                        registerButton.disabled = false;
                    } else {
                        registerButton.disabled = true;
                    }
                });
            });
        });
    </script>
</body>

</html>
