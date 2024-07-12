<div id="slider">
    <div class="row">
        <div class="col-md-3">
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
                        <img class="card-background" src="/uploads/slider/{{ $slide->slider_image }}">
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
        </script>
    </div>
</div>
