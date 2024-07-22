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

        <div class="col-lg-12 col-md-12 col-sm-12">
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
                            @if ($value2->product_id)
                                <a href="{{ URL::to('chi-tiet-san-pham/' . $value2->product_id) }}"
                                    title="Xem chi tiết">
                                    <img src="{{ asset('uploads/slider/' . $value2->slider_image) }}"
                                        class="d-block w-100" alt="{{ $value2->slider_name }}">
                                </a>
                            @else
                                <a>
                                    <img src="{{ asset('uploads/slider/' . $value2->slider_image) }}"
                                        class="d-block w-100" alt="{{ $value2->slider_name }}">
                                </a>
                            @endif
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
    </div>
</div>
