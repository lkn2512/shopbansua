@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-9">
            @foreach ($catepost as $key => $cate_post)
                <h3 class="category-title text-center">{{ $cate_post->cate_post_name }}</h3>
            @endforeach
            @if ($post->count() > 0)
                <div class="row">
                    @foreach ($post as $key => $po)
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="post-item h-100">
                                <a href="{{ URL::to('bai-viet/' . $po->post_slug) }}">
                                    <img class="card-img-top img-post" src="{{ URL::to('/uploads/post/' . $po->post_image) }}"
                                        alt="" />
                                    <div class="card-body-content d-flex flex-column">
                                        <h5 class="post-title card-title">{{ $po->post_title }}</h5>
                                        <p class="post-desc card-text">{{ $po->post_desc }}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center">Danh mục này vẫn đang trong quá trình cập nhật bài viết !</p>
            @endif
            <div class="panel-footer">
                {!! $post->withQueryString()->appends(Request::all())->links('pagination-custom') !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="blog-categories">
                <h3 class="category-title">DANH MỤC BLOG</h3>
                @foreach ($category_post_default as $key => $cate)
                    <a href="{{ URL::to('danh-muc-bai-viet/' . $cate->cate_post_slug) }}"
                        class="category-link {{ request()->url() === URL::to('danh-muc-bai-viet/' . $cate->cate_post_slug) ? 'active' : '' }}">
                        <i class="fas fa-chevron-right"></i>
                        <p>{{ $cate->cate_post_name }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
