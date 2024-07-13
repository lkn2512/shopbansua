<!DOCTYPE html>

<head>
    <title>Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/png" href="{{ asset('backend/images/login.png') }}" />

    <link href="{{ asset('/backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/admin-login/css/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('/backend/admin-login/css/util.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" id="loginForm" action="{{ URL::to('Admin/admin-check') }}"
                    method="post">
                    @csrf
                    <div class="login100-form-avatar">
                        <img src="{{ asset('backend/images/icon-web.png') }}" alt="AVATAR">
                    </div>
                    <span class="login100-form-title p-t-20 p-b-40">Quản trị viên</span>
                    <div class="wrap-input100 validate-input m-b-20" data-validate="Username is required">
                        <input class="input100" type="text" name="admin_email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input m-b-20" data-validate="Password is required">
                        <input class="input100" type="password" name="admin_password" placeholder="Mật khẩu">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <div id="error-message" class="text-danger"></div>
                    <div class="container-login100-form-btn p-t-10">
                        <button class="login100-form-btn" type="submit">Đăng nhập</button>
                    </div>
                    <div class="text-center w-full p-t-25">
                        <a href="#" class="txt1">Quên mật khẩu?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('/backend/admin-login/js/main.js') }}"></script>
    <script src="{{ asset('/backend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/backend/js/jquery-3.6.0.min.js') }}"></script>

    {{-- Kiểm tra tài khoản hoặc mật khẩu --}}
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.redirect_url;
                        } else {
                            $('#error-message').text(response.message);
                        }
                    }
                });
            });
        });
    </script>
    {{-- Kiểm tra tài khoản hoặc mật khẩu --}}

</body>

</html>
