@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (isset($post_positions))
                <h4 class="post-title-single">
                    {{ $post_positions->post_title }}
                </h4>
                <hr>
                <span class="content-post">{!! $post_positions->post_content !!}</span>
            @else
                <h5 class="text-center">Không có bài viết nào.</h5>
            @endif
        </div>
    </div>
@endsection
