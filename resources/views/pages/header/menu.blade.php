@php
    $customer_id = Session::get('customer_id');
    $shipping_id = Session::get('shipping_id');
@endphp
<div class="position-sticky top-0" style="z-index: 100">
    <div class="header-top">
        <div class="container-xl">
            <div class="row header-container">
                <div class="col-lg-2 col-md-3 col-sm-5 col-xs-3">
                    @foreach ($contact_footer as $cont_header)
                        <a class="img-logo" href="{{ URL::to('/') }}">
                            <img src="{{ asset('/uploads/contact/' . $cont_header->info_image) }}" />
                        </a>
                    @endforeach
                </div>
                <div class="col-lg-8 col-md-5 col-sm-7 ">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="search_box col-lg-11 col-md-9 col-sm-9 ">
                            <form action="{{ URL::to('/search-items') }}" autocomplete="off" method="GET">
                                <div class="input-group">
                                    <input type="text" name="keywords_submit" placeholder="Tìm kiếm" id="keywords"
                                        class="form-control" value="{{ request('keywords_submit') }}" />
                                    <button type="submit" class="btn btn-search-info">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                                <div id="search_ajax"></div>
                            </form>
                        </div>
                        <div class="cart-header col-lg-1 col-md-3 col-sm-3 ">
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
                </div>
                <div class="col-lg-2 col-md-4 col-sm-5  p-0">
                    <div class="user-customer">
                        @if ($customer_id)
                            <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                aria-controls="offcanvasRight">
                                @foreach ($customer as $cus)
                                    @if ($cus->customer_image)
                                        <img class="img-user"
                                            src="{{ asset('uploads/customer/' . $cus->customer_image) }}">
                                    @else
                                        <img class="img-user"
                                            src="{{ asset('frontend/images/home/avatar-default.jpg') }}">
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
                            <img class="img-user" src="{{ asset('uploads/customer/' . $cus2->customer_image) }}">
                        @else
                            <img class="img-user" src="{{ asset('frontend/images/home/avatar-default.jpg') }}">
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
    <header class="header-area shadow-sm ">
        <div class="container-xl">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="main-nav">
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="{{ URL::to('/') }}"
                                    class="{{ Request::is('/') ? 'active' : '' }}">Trang chủ</a>
                            </li>
                            <li class="submenu">
                                <a href="javascript:;">Danh mục</a>
                                <ul class="sub-ul">
                                    @foreach ($category as $cate)
                                        <li class="sub-li">
                                            <a class="{{ Request::is('danh-muc-san-pham/' . $cate->category_id) ? 'active' : '' }}"
                                                href="{{ URL::to('danh-muc-san-pham/' . $cate->category_id) }}">{{ $cate->category_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:;">Blog</a>
                                <ul class="sub-ul">
                                    @foreach ($category_post_default as $blog)
                                        <li class="sub-li">
                                            <a class="{{ Request::is('danh-muc-bai-viet/' . $blog->cate_post_slug) ? 'active' : '' }}"
                                                href="{{ URL::to('danh-muc-bai-viet/' . $blog->cate_post_slug) }}">{{ $blog->cate_post_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:;">Chuyên mục sản phẩm</a>
                                <ul class="sub-ul">
                                    @foreach ($sections as $sec)
                                        <li class="sub-li">
                                            <a class="{{ Request::is('chuyen-muc-san-pham/' . $sec->section_slug) ? 'active' : '' }}"
                                                href="{{ URL::to('chuyen-muc-san-pham/' . $sec->section_slug) }}">{{ $sec->section_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="scroll-to-section ">
                                <a class="" href="{{ URL::to('/danh-sach-thuong-hieu') }}">Thương hiệu</a>
                            </li>
                            <li class="scroll-to-section ">
                                <a class="{{ Request::is('lien-he') ? 'active' : '' }}"
                                    href="{{ URL::to('/lien-he') }}">Liên hệ với chúng tôi</a>
                            </li>
                            @foreach ($post_header as $category)
                                <li class="scroll-to-section">
                                    <a
                                        href="{{ URL::to('pages/' . $category['cate_post_slug'] . '/' . $category['post_slug']) }}">
                                        {{ $category['cate_post_name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</div>
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
{{-- Danh sách yêu thích --}}
