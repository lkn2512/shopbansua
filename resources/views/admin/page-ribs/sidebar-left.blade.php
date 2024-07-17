    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a class="brand-link">
            <img src="{{ asset('backend/images/AdminLTELogo.png') }}" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light"> Quản Trị Viên</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                @foreach ($get_user as $us)
                    <div class="image">
                        <img src="/uploads/user/{{ $us->avatar }}" class="img-circle elevation-2" />
                    </div>
                    <div class="info">
                        <a href="{{ URL::to('Admin/profile/' . Session::get('user_id')) }}"
                            class="d-block {{ Request::is('Admin/profile/*') ? 'active' : '' }}">{{ $us->name }}</a>
                    </div>
                @endforeach
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('Admin/dashboard') ? 'active' : '' }}"
                            href="{{ URL::to('Admin/dashboard') }}">
                            <i class="nav-icon fa-solid fa-house"></i>
                            <p>Tổng quan</p>
                        </a>
                    </li>
                    <li class="nav-header">Danh mục</li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/all-category-product') }}"
                            class="nav-link {{ Request::is('Admin/all-category-product') ||
                            Request::is('Admin/add-category-product') ||
                            Request::is('Admin/edit-category-product/*') ||
                            Request::is('Admin/search-category-product*')
                                ? 'active'
                                : '' }}">
                            <i class="nav-icon fa-solid fa-layer-group"></i>
                            <p>Danh mục sản phẩm</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/all-category-post') }}"
                            class="nav-link {{ Request::is('Admin/all-category-post') ||
                            Request::is('Admin/add-category-post*') ||
                            Request::is('Admin/edit-category-post/*') ||
                            Request::is('Admin/search-category-post*')
                                ? 'active'
                                : '' }}">
                            <i class="nav-icon fa-solid fa-table-list"></i>
                            <p>Danh mục tin tức</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/all-brand-product') }}"
                            class="nav-link {{ Request::is('Admin/all-brand-product') ||
                            Request::is('Admin/add-brand-product') ||
                            Request::is('Admin/edit-brand-product/*') ||
                            Request::is('Admin/search-brand*')
                                ? 'active'
                                : '' }}">
                            <i class="nav-icon fa-solid fa-copyright"></i>
                            <p>Thương hiệu</p>
                        </a>
                    </li>
                    <li class="nav-header">Quảng bá</li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/show-video') }}"
                            class="nav-link {{ Request::is('Admin/show-video') ||
                            Request::is('Admin/add-video') ||
                            Request::is('Admin/edit-video/*') ||
                            Request::is('Admin/search-video*')
                                ? 'active'
                                : '' }}">
                            <i class="nav-icon fa-brands fa-youtube"></i>
                            <p>Video</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/all-product') }}"
                            class="nav-link {{ Request::is('Admin/all-product') ||
                            Request::is('Admin/add-product') ||
                            Request::is('Admin/edit-product/*') ||
                            Request::is('Admin/add-gallery/*') ||
                            Request::is('Admin/search-product*')
                                ? 'active'
                                : '' }}">
                            <i class="nav-icon fa-brands fa-product-hunt"></i>
                            <p>Sản phẩm</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/manage-slider') }}"
                            class="nav-link {{ Request::is('Admin/manage-slider') ||
                            Request::is('Admin/add-slider') ||
                            Request::is('Admin/edit-slider/*') ||
                            Request::is('Admin/search-slider*')
                                ? 'active'
                                : '' }}">
                            <i class="nav-icon fa-solid fa-flag"></i>
                            <p>Banner</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/list-post') }}"
                            class="nav-link {{ Request::is('Admin/list-post') ||
                            Request::is('Admin/add-post') ||
                            Request::is('Admin/edit-post/*') ||
                            Request::is('Admin/search-post*')
                                ? 'active'
                                : '' }}">
                            <i class="nav-icon fa-solid fa-blog"></i>
                            <p>Tin tức - Bài viết</p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ Request::is('Admin/logo-home') || Request::is('Admin/information') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('Admin/logo-home') || Request::is('Admin/information') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-circle-info"></i>
                            <p>Thông tin website<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ URL::to('Admin/logo-home') }}"
                                    class="nav-link {{ Request::is('Admin/logo-home') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Logo</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ URL::to('Admin/information') }}"
                                    class="nav-link {{ Request::is('Admin/information') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Chi tiết Liên hệ</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header">Ưu đãi</li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/holiday-event') }}"
                            class="nav-link {{ Request::is('Admin/holiday-event') ||
                            Request::is('Admin/holiday-event/create') ||
                            Request::is('Admin/holiday-event/edit/*')
                                ? 'active'
                                : '' }}">
                            <i class="nav-icon fa-solid fa-wand-sparkles"></i>
                            <p>Sự kiện ngày lễ</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/list-coupon') }}"
                            class="nav-link {{ Request::is('Admin/list-coupon') ||
                            Request::is('Admin/insert-coupon') ||
                            Request::is('Admin/edit-coupon/*') ||
                            Request::is('Admin/search-coupon*')
                                ? 'active'
                                : '' }}">
                            <i class="nav-icon fa-solid fa-ticket"></i>
                            <p>Mã giảm giá</p>
                        </a>
                    </li>
                    <li class="nav-header">Khách hàng</li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/all-customer') }}"
                            class="nav-link {{ Request::is('Admin/all-customer') ||
                            Request::is('Admin/info-customer/*') ||
                            Request::is('Admin/search-customer*')
                                ? 'active'
                                : '' }}">
                            <i class="nav-icon fa-regular fa-user"></i>
                            <p>Tài khoản</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/manage-order') }}"
                            class="nav-link {{ Request::is('Admin/manage-order') || Request::is('Admin/view-order/*') || Request::is('Admin/search-order*')
                                ? 'active'
                                : '' }}">
                            <i class="nav-icon fa-solid fa-cart-flatbed"></i>
                            <p>Đơn đặt hàng</p>
                            @if ($notifications_order_count > 0)
                                <span class="badge badge-info right">{{ $notifications_order_count }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/list-comment') }}"
                            class="nav-link {{ Request::is('Admin/list-comment') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-comments"></i>
                            <p>Bình luận</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ URL::to('Admin/all-message') }}"
                            class="nav-link {{ Request::is('Admin/all-message') || Request::is('Admin/search-contact-customer*') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-file-signature"></i>
                            <p>Liên hệ</p>
                            @if ($notifications_contact_count > 0)
                                <span class="badge badge-info right">{{ $notifications_contact_count }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
