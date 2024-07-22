@extends('layout')
@section('content')
    <div class="row" style="margin-left: 0px">
        <div class="col-md-9 post-page-left">
            @foreach ($catepost as $key => $cate_post)
                <h3 class="title-post">{{ $cate_post->cate_post_name }} </h3>
            @endforeach
            @foreach ($post as $key => $po)
                <div class="row post-info mb-5">
                    <div class="col-lg-3 col-md-5 col-sm-6">
                        <img class="img-post" src="{{ URL::to('/uploads/post/' . $po->post_image) }}" alt="" />
                    </div>
                    <div class="col-lg-9 col-md-7 col-sm-6 post-desc">
                        <h3 class="title">{{ $po->post_title }}</h3>
                        <p class="text-desc">{{ $po->post_desc }}</p>
                        <a href="{{ URL::to('bai-viet/' . $po->post_id) }}">
                            <button type="button" class="btn btn-view-continue">Xem tiếp
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </a>
                    </div>
                </div>
            @endforeach
            <footer class="panel-footer">
                {!! $post->withQueryString()->appends(Request::all())->links('pagination::bootstrap-5') !!}
            </footer>
        </div>
        <div class="col-md-3">
            <div class="post-page-right">
                <h3>DANH MỤC BLOG</h3>
                @foreach ($category_post as $key => $cate)
                    <a href="{{ URL::to('danh-muc-bai-viet/' . $cate->cate_post_id) }}">
                        <p>{{ $cate->cate_post_name }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
