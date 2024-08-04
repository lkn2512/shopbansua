<footer class="footer-main">
    <div class="container-xl">
        <div class="row align-items-center align-items-stretch">
            <div class="col-md-4 d-flex align-items-center">
                <label class="footer_title_top">Đăng ký để nhận tin tức và các thông báo khuyển mãi mới nhất của chúng
                    tôi</label>
            </div>
            <div class="col-md-8 d-flex align-items-center">
                <form action="#" class="subscribe-form w-100">
                    <div class="form-group d-flex">
                        <input type="text" class="form-control rounded-left" placeholder="Nhập email của bạn">
                        <button type="submit" class="form-control submit"><span>Đăng ký</span></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-lg-5 col-md-6 order-md-last">
                <h2 class="footer-heading"><a class="logo">KN-Milk</a></h2>
                @foreach ($contact_footer as $cont)
                    <label class="slogan">{{ $cont->slogan_image }}</label>
                @endforeach
                <p class="copyright">
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script> Bản quyền | Trang web được thực hiện bởi <i class="ion-ios-heart"
                        aria-hidden="true"></i><b>Lê Kim Ngọc - CK22V7K516</b>
                </p>
            </div>
            <div class="col-lg-7 col-md-6">
                <div class="row">
                    <div class="col">
                        <h2 class="footer-heading">Giới thiệu</h2>
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ URL::to('/lien-he') }}" class="py-1 d-block">
                                    <i class="fas fa-home me-2"></i>Liên hệ
                                </a>
                            </li>
                            <li>
                                <a class="py-1 d-block">
                                    <i class="fas fa-phone me-2"></i>0356 048 240
                                </a>
                            </li>
                            <li>
                                <a class="py-1 d-block">
                                    <i class="fas fa-envelope me-2"></i>lkn058@gmail.com
                                </a>
                            </li>
                        </ul>
                    </div>
                    @foreach ($category_post_footer as $category)
                        <div class="col">
                            <h2 class="footer-heading">{{ $category->cate_post_name }}</h2>
                            <ul class="list-unstyled">
                                @foreach ($post_footer[$category->cate_post_slug] as $post)
                                    <li>
                                        <a href="{{ url('huong-dan/' . $post->category_post->cate_post_slug . '/' . $post->post_slug) }}"
                                            class="py-1 d-block">
                                            {{ $post->post_title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</footer>
