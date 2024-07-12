<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a class="navbar-brand">
            {{-- <img src="../../dist/img/AdminLTELogo.png" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
            <span class="brand-text font-bold">Quản trị viên</span>
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL::to('Admin/dashboard') }}" class="nav-link">Trang chủ</a>
                </li>
            </ul>
        </div>
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand  ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="far fa-bell"></i>
                    @if ($notifications_count > 0)
                        <span class="badge bg-danger navbar-badge">{{ $notifications_count }}</span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <li><span class="dropdown-header">Thông báo</span></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @if ($notifications_order_count > 0)
                        <li>
                            <a href="{{ URL::to('Admin/manage-order') }}" class="dropdown-item">
                                <img class="img-icon-small"
                                    src="{{ asset('backend/images/order_icon.png') }}">{{ $notifications_order_count }}
                                đơn
                                hàng mới
                                <span class="float-end text-muted text-sm">Chưa xem</span>
                            </a>
                        </li>
                    @endif
                    @if ($notifications_contact_count > 0)
                        <li>
                            <a href="{{ URL::to('Admin/all-message') }}" class="dropdown-item">
                                <i class="fa-solid fa-file-signature"></i> {{ $notifications_contact_count }} Liên
                                hệ
                                <span class="float-end text-muted text-sm">Chưa xem</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>
