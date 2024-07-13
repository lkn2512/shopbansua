<div class="menu">
    @php
        $customer_id = Session::get('customer_id');
        $shipping_id = Session::get('shipping_id');
    @endphp
    <div class="header-top">
        <div class="container">
            <div class="row-header">
                <div class="col-logo">
                    @foreach ($contact_footer as $cont_header)
                        <a class="img-logo" href="{{ URL::to('/') }}">
                            <img src="{{ asset('/uploads/contact/' . $cont_header->info_image) }}" />
                        </a>
                    @endforeach
                </div>
                <div class="search-center">
                    <div class="search_box">
                        <form action="{{ URL::to('/search-items') }}" autocomplete="off" method="POST">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" name="keywords_submit" placeholder="Tìm kiếm" id="keywords"
                                    class="form-control" />
                                <button type="submit" class="btn btn-search-info">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                            <div id="search_ajax"></div>
                        </form>
                    </div>
                    <div class="cart-header">
                        <a href="{{ URL::to('/your-cart') }}">
                            <span class="position-relative">
                                <img src="{{ URL::to('/frontend/images/cart/cart.png') }}" class="cart-icon" />
                                <div id="showCartQuantity"></div>
                            </span>
                        </a>
                        <div class="cart-view" id="cart-view">
                        </div>
                    </div>
                </div>
                <div class="col-customer">
                    <div class="user-customer">
                        @if ($customer_id)
                            <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                aria-controls="offcanvasRight">
                                @foreach ($customer as $cus)
                                    @if ($cus->customer_image)
                                        <img class="img-user" src="/uploads/customer/{{ $cus->customer_image }}">
                                    @else
                                        <img class="img-user" src="/frontend/images/home/avatar-default.jpg">
                                    @endif
                                    {{ $cus->customer_name }}
                                @endforeach
                            </a>
                        @else
                            <a href="{{ URL::to('/login') }}" class="btn-sign-in">Đăng nhập</a>
                            <a href="{{ URL::to('/register') }}" class="btn-sign-up">Đăng ký</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($customer_id)
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel"
            style="width: 320px;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasRightLabel">
                    @foreach ($customer as $cus2)
                        @if ($cus->customer_image)
                            <img class="img-user" src="/uploads/customer/{{ $cus2->customer_image }}">
                        @else
                            <img class="img-user" src="/frontend/images/home/avatar-default.jpg">
                        @endif
                        {{ $cus2->customer_name }}
                    @endforeach
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <a href="{{ URL::to('/thong-tin-ca-nhan') }}">
                    <img class="icon-offcan" src="{{ URL::to('/frontend/images/home/user.png') }}">Thông tin
                    cá nhân
                </a>
                <hr class="hr">
                <a href="{{ URL::to('/your-cart') }}">
                    <img class="icon-offcan" src="{{ URL::to('/frontend/images/home/cart.png') }}">Giỏ hàng
                </a>
                <a href="{{ URL::to('/checkout') }}"><img class="icon-offcan"
                        src="{{ URL::to('/frontend/images/home/checkout.png') }}" alt="">Thanh toán
                </a>
                <input class="favorite_customer_id" type="hidden" value="{{ Session::get('customer_id') }}">
                <a href="#" class="show-favorites" data-bs-toggle="modal" data-bs-target="#favorites">
                    <img class="icon-offcan" src="{{ URL::to('/frontend/images/home/favorite.png') }}">Danh
                    sách yêu thích
                </a>
                <a href="{{ url('history-order') }}">
                    <img class="icon-offcan" src="{{ URL::to('/frontend/images/home/history.png') }}">Lịch
                    sử đơn hàng
                </a>
                <hr class="hr">
                <a href="#">
                    <img class="icon-offcan" src="{{ URL::to('/frontend/images/home/support.png') }}" alt="Hỗ trợ">
                    Hỗ trợ
                </a>
                <a href="{{ URL::to('/setting') }}">
                    <img class="icon-offcan" src="{{ URL::to('/frontend/images/home/setting.png') }}">Cài đặt
                </a>
                <hr class="hr">
                <a class="sign-out-text" href="{{ URL::to('/logout') }}">Đăng xuất</a>
            </div>
        </div>
    @endif
</div>
<nav class="navbar navbar-expand-lg shadow bg-body-tertiary navbar-header">
    <div class="container-md">
        <a class="navbar-brand" href="{{ URL::to('/') }}">Trang Chủ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Danh Mục Sản Phẩm
                    </button>
                    <ul class="dropdown-menu dropdown-menu-light dropdown-hover">
                        @foreach ($category as $key => $cate)
                            <li>
                                <a class="dropdown-item item-hover"
                                    href="{{ URL::to('danh-muc-san-pham/' . $cate->category_id) }}">{{ $cate->category_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Tin Tức
                    </button>
                    <ul class="dropdown-menu dropdown-menu-light dropdown-hover">
                        @foreach ($category_post_frontend as $key => $blog)
                            <li>
                                <a class="dropdown-item item-hover"
                                    href="{{ URL::to('danh-muc-bai-viet/' . $blog->cate_post_id) }}">{{ $blog->cate_post_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li><a class="btn btn-light" href="{{ URL::to('/lien-he') }}">Liên Hệ Với Chúng Tôi</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- Danh sách yêu thích --}}
<div class="modal fade" id="favorites" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-xxl-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color:#103667">
                    <img class="icon-offcan" src="{{ URL::to('/frontend/images/home/favorite.png') }}"> DANH
                    SÁCH YÊU THÍCH CỦA BẠN
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="container-md" style="background: rgb(240, 240, 240);">
                <div class="modal-body" id="favorite_body">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
</div>
{{-- Danh sách yêu thích --}}
