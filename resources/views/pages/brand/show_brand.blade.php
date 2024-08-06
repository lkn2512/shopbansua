@extends('layout')
@section('content')
    @php
        // Nhóm các thương hiệu theo chữ cái đầu tiên
        $groupedBrands = $brand_product->groupBy(function ($item) {
            return strtoupper(substr($item->brand_name, 0, 1));
        });
        // Tạo mảng chữ cái có trong danh sách thương hiệu
        $availableChars = $groupedBrands->keys()->sort()->toArray();
    @endphp
    <h2 class="title-product text-center m-0 mb-3">Thương hiệu sản phẩm</h2>
    <nav id="navbar-example2" class="navbar mb-3 card">
        <a class="navbar-brand">Chữ cái</a>
        <ul class="nav nav-pills" style="height: 50px">
            @foreach ($availableChars as $char)
                <li class="nav-item">
                    <a class="nav-link char-hover" href="#scrollspyHeading{{ $char }}">{{ $char }}</a>
                </li>
            @endforeach
        </ul>
    </nav>

    <!-- Phần nội dung -->
    <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%"
        data-bs-smooth-scroll="true" class="scrollspy-example p-4 card" tabindex="0">
        @foreach ($groupedBrands as $key => $brands)
            <div class="mb-2">
                <h4 class="mb-3" id="scrollspyHeading{{ $key }}">{{ $key }}</h4>
                <div class="d-flex flex-wrap">
                    @foreach ($brands as $brand)
                        <a href="{{ URL::to('thuong-hieu-san-pham/' . $brand->brand_slug) }}"
                            class="text-decoration-none me-5">
                            <h5 class="pe-3 fw-normal text-dark">
                                {{ $brand->brand_name }}</h5>
                        </a>
                    @endforeach
                </div>
            </div>
            <hr>
        @endforeach
    </div>

    <!-- JavaScript để điều chỉnh vị trí cuộn -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var navbarHeight = document.querySelector('.navbar').offsetHeight;
            var offsetAdjustment = 200; // Điều chỉnh giá trị offset tại đây
            // Điều chỉnh vị trí cuộn khi nhấn vào link
            document.querySelectorAll('a.nav-link').forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    var targetId = this.getAttribute('href').substring(1);
                    var targetElement = document.getElementById(targetId);
                    var offsetPosition = targetElement.getBoundingClientRect().top + window
                        .pageYOffset - navbarHeight - offsetAdjustment;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>

    <style>
        .scrollspy-example h4 {
            color: #103667;
            font-weight: 600
        }

        .scrollspy-example h5 {
            border: 1px solid #95b0d3;
            padding: 10px 15px;
            text-align: center;
            border-radius: 100px;
        }

        .text-primary {
            font-weight: bold;
        }

        .border-bottom {
            transition: border-color 0.3s ease;
        }

        a:hover .border-bottom {
            border-color: #103667;
        }
    </style>
@endsection
