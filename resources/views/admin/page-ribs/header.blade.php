<nav class="main-header navbar navbar-expand navbar-white navbar-light ">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                aria-expanded="false">
                <i class="far fa-bell"></i>
                @if ($notifications_count > 0)
                    <span class="badge bg-danger navbar-badge">{{ $notifications_count }}</span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-lg">
                <li><span class="dropdown-header">Thông báo</span></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                @if ($notifications_order_count > 0)
                    <li>
                        <a href="{{ URL::to('Admin/manage-order') }}" class="dropdown-item">
                            <img class="img-icon-small"
                                src="{{ asset('backend/images/order_icon.png') }}">{{ $notifications_order_count }} đơn
                            hàng mới
                            <span class="float-end text-muted text-sm">Chưa xem</span>
                        </a>
                    </li>
                @endif
                @if ($notifications_contact_count > 0)
                    <li>
                        <a href="{{ URL::to('Admin/all-message') }}" class="dropdown-item">
                            <i class="fa-solid fa-file-signature"></i> {{ $notifications_contact_count }} Liên hệ
                            <span class="float-end text-muted text-sm">Chưa xem</span>
                        </a>
                    </li>
                @endif
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                {{-- <li><a href="#" class="dropdown-item dropdown-footer">See All Notifications</a></li> --}}
            </ul>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
