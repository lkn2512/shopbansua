<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('/frontend/fonts/fonts-login/icomoon/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/login.css') }}" rel="stylesheet">
</head>

<body>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-5 content mx-auto">
            <div class="contents card p-5 mb-5 center">
                <div class="mb-2 text-center">
                    <h3 class="fw-bold" style="color: #103667;">KN-MILK</h3>
                </div>
                <form method="POST" action="{{ URL::to('/login-customer') }}" class="signin-form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="email" class="form-control" id="username" placeholder="Email"
                            name="email_account" required>
                    </div>
                    <div class="form-group last mb-4">
                        <input type="password" class="form-control" id="password" placeholder="Mật khẩu"
                            name="pass_account" required>
                        <span id="toggle-password" class="toggle-password">
                            <i id="eye-icon" class="fa fa-eye-slash"></i>
                        </span>
                    </div>
                    <div class="d-flex mb-4 align-items-center justify-content-between">
                        <div>
                            <label class="control control--checkbox mb-0"><span>Ghi nhớ</span>
                                <input type="checkbox" checked="checked" />
                                <div class="control__indicator"></div>
                            </label>
                        </div>
                        <div>
                            <a href="{{ '/forgot-password' }}" class="forgot-pass">Quên mật khẩu?</a>
                        </div>
                    </div>
                    <div class="d-grid gap-2 mb-4">
                        @php
                            $message = Session::get('message');
                            if ($message) {
                                echo '<span class="text-danger">';
                                echo $message;
                                echo ' </span>';
                                Session::put('message', null);
                            }
                        @endphp
                        <button class="btn-login" type="submit" name="createUser">Đăng nhập</button>
                    </div>
                    <span class="d-block text-center my-3 text-muted">&mdash; Hoặc đăng nhập với &mdash;</span>
                    <div class="social-login d-flex align-items-center justify-content-between">
                        <a href="" class="facebook">
                            <span><i class="fa-brands fa-facebook"></i> Facebook</span>
                        </a>
                        {{-- <a href="#" class="twitter">
                            <span class="icon-twitter mr-3"></span>
                        </a> --}}
                        <a href="{{ url('/login-customer-google') }}" class="google">
                            <span><i class="fa-brands fa-google"></i> Google</span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <a href="{{ URL::to('/') }}" class="home-shop"><i class="fa-solid fa-house"></i> Trang
                                chủ</a>
                        </div>
                        <div>
                            <span class="userNotAccount">Bạn chưa có tài khoản?<a href="{{ url('register') }}">
                                    Đăng ký</a>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    <script src="{{ asset('public/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.getElementById('toggle-password').addEventListener('click', function() {
            var passwordField = document.getElementById('password');
            var eyeIcon = document.getElementById('eye-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });
    </script>

</body>

</html>
