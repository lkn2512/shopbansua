<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('/backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/css/adminlte.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('/backend/css/main-style.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/css/toastr.min.css') }}" rel="stylesheet">
</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">
        @include('admin.admin-information.header')
        @include('admin.page-ribs.sidebar-left')
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container">
                    <div class="card">
                        @include('admin.admin-information.background-header')
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            @include('admin.admin-information.setting-account-left')
                        </div>
                        <div class="col-lg-8">
                            @yield('profile-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if (session('error_alert'))
        <script>
            alert("{{ session('error_alert') }}");
        </script>
    @endif

    <script src="{{ asset('/backend/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/backend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/backend/js/adminlte.js') }}"></script>
    <script src="{{ asset('/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/backend/js/toastr.min.js') }}"></script>
    {!! Toastr::message() !!}
</body>

</html>
