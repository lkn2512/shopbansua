<div id="slider">
    <div class="row">
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
                                <a href="{{ URL::to('chi-tiet-san-pham/' . $value2->product->product_slug) }}"
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
