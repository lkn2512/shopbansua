<!DOCTYPE html>

<head>
    <title>Trang quản lý Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{{ asset('/backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/css/style-responsive.css') }}" rel="stylesheet" />
    <style>
        html {
            height: 100%;
        }

        body {
            height: 100%;
            margin: 0;
        }

        .menu {
            height: 100%;
            background-image: url(/backend/images/bg-dark.jpg);
            background-size: cover;
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="menu">
        <div class="container py-4">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="/backend/images/login.webp" alt="login form" class="img-fluid"
                                    style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form action="{{ URL::to('Admin/admin-check') }}" method="post">
                                        {{ csrf_field() }}
                                        <h2 class="fw-normal mb-3 pb-3 fw-bold"
                                            style="letter-spacing: 1px; text-align: center;">Đăng nhập</h2>
                                        <br>
                                        <div class="form-outline mb-4">
                                            <input type="text" class="form-control form-control-lg"
                                                placeholder="Email" name="admin_email" required />
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="password" class="form-control form-control-lg"
                                                placeholder="Mật khẩu" name="admin_password" required />
                                        </div>
                                        <?php
                                        
                                        use Illuminate\Support\Facades\Session;
                                        
                                        $message = Session::get('message');
                                        if ($message) {
                                            echo '<p class="text-danger">', $message, '</p>';
                                            Session::put('message', null);
                                        }
                                        ?>

                                        <div class="pt-1 mb-4">
                                            <div class="d-grid gap-2">
                                                <button class="btn btn-primary btn-lg btn-block" type="submit"
                                                    name="login">Đăng nhập
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p class="mb-5 pb-lg-2" style="color: #393f81;">Bạn chưa có tài khoản?
                                                    <a href="registration.html" style="color: #393f81;">Đăng ký</a>
                                                </p>
                                            </div>
                                            <div class="col">
                                                <a style="float: right;"
                                                    class="link-offset-2 link-underline link-underline-opacity-0 text-muted "
                                                    href="#">Quên mật khẩu?</a>
                                            </div>
                                        </div>
                                        <a href="#!" class="small text-muted">Terms of use.</a>
                                        <a href="#!" class="small text-muted">Privacy policy</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('/backend/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
