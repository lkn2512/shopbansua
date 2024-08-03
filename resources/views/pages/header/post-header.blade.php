@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($post_positions_header)
                <h4 class="post-title-single">
                    {{ $post_positions_header->post_title }}
                </h4>
                <div class="content-post">{!! $post_positions_header->post_content !!}</div>
            @endif
        </div>
    </div>
@endsection
