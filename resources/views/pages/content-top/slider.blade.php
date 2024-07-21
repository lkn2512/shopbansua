<div id="slider">
    <div class="row">
        {{-- <div class="col-md-3">
            <div class="title-category">
                <h2><img src="{{ URL::to('/frontend/images/home/category.png') }}">Danh mục sản phẩm</h2>
                <div class="panel-group category-products scroll-category" id="accordian">
                    @foreach ($category as $key => $cate)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <a href="{{ URL::to('/danh-muc-san-pham/' . $cate->category_id) }}">{{ $cate->category_name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="slider-container">
                @foreach ($slider as $key => $slide)
                    <div class="card-slider">
                        <img class="card-background" src="{{ asset('uploads/slider/' . $slide->slider_image) }}">
                        <div class="view">
                            <a class="icon" href="{{ URL::to('chi-tiet-san-pham/' . $slide->product_id) }}"><i
                                    class="fa-solid fa-bars-staggered"></i></a>
                            <span class="text">
                                <a
                                    href="{{ URL::to('chi-tiet-san-pham/' . $slide->product_id) }}">{{ $slide->slider_name }}</a>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.card-slider');

                cards.forEach(card => {
                    const img = card.querySelector('.card-background');

                    img.addEventListener('click', function() {
                        card.classList.toggle('expanded');
                    });

                    card.addEventListener('mouseleave', function() {
                        if (card.classList.contains('expanded')) {
                            card.classList.remove('expanded');
                        }
                    });
                });
            });
        </script> --}}

        <div class="col-lg-9 col-md-8 col-sm-6">
            <div id="carouselExampleCaptions" class="carousel slide">
                <div class="carousel-indicators">
                    @php
                        $number = -1;
                        $slide = 0;
                    @endphp
                    @foreach ($slider as $value1)
                        @php
                            $number++;
                        @endphp
                        <button type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide-to="{{ $number }}" class="{{ $number == 0 ? 'active' : '' }}"
                            aria-current="{{ $number == 0 ? 'true' : '' }}">
                        </button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach ($slider as $value2)
                        @php
                            $slide++;
                        @endphp
                        <div class="carousel-item {{ $slide == 1 ? 'active' : '' }}">
                            <a href="{{ URL::to('chi-tiet-san-pham/' . $value2->product_id) }}" title="Xem chi tiết">
                                <img src="{{ asset('uploads/slider/' . $value2->slider_image) }}" class="d-block w-100"
                                    style="object-fit: cover; height: 350px; " alt="{{ $value2->slider_name }}">
                            </a>
                            <style>
                                .carousel-caption {
                                    background: linear-gradient(to right, rgba(16, 54, 103, 0) 0%, rgba(16, 54, 103, 0.6) 50%, rgba(16, 54, 103, 0) 100%);
                                    padding: 15px;
                                    color: white;
                                    text-align: center;
                                }

                                .carousel-caption h5 {
                                    font-weight: 500;
                                    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
                                    text-transform: capitalize;
                                }
                            </style>
                            <div class="carousel-caption d-none d-md-block">
                                <h5>{{ $value2->slider_name }}</h5>
                                {{-- <p>Some representative placeholder content for the first slide.</p> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="row">
                <div class="col-lg-12">
                    @foreach ($contact_footer as $cont)
                        <div style="max-width: 100%;">
                            {!! $cont->info_fanpage !!}</div>
                    @endforeach
                </div>
                <div class="col-lg-12" style="padding-top: 30px">
                    <img src="{{ asset('frontend/images/home/ut.jpg') }}"
                        style="height: 189px;max-width: 307px; object-fit: cover">
                </div>
            </div>
        </div>
    </div>
</div>
