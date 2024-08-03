@extends('layout')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-items"><a href="{{ URL::to('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-items">
                <a href="{{ URL::to('danh-muc-bai-viet/' . $categoryPost->cate_post_slug) }}">{{ $cate_post_name }}</a>
            </li>
            <li class="breadcrumb-items active" aria-current="page">{{ $post->post_title }}</li>
        </ol>
    </nav>
    <div class="row" style="margin-left: 0px">
        <div class="col-md-9 post-left">
            <h3 class="post-title">{{ $post->post_title }} </h3>
            <span class="content-post">{!! $post->post_content !!}</span>
        </div>
        <div class="col-md-3">
            <div class="post-right position-sticky top-0">
                <h2>TIN TỨC LIÊN QUAN</h2>
                @foreach ($related_post as $key => $re_po)
                    <div class="row post-info mb-2">
                        <img class="img" src="{{ URL::to('/uploads/post/' . $re_po->post_image) }}" alt="" />
                        <a href="{{ URL::to('bai-viet/' . $re_po->post_slug) }}">
                            <h3 class="title">{{ $re_po->post_title }}</h3>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
