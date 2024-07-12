@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @foreach ($post_service_footer as $key => $posts)
                <h3 class="text-center" style="text-transform: uppercase;">
                    {{ $posts->post_title }} </h3>
                <hr>
                <span class="content-post">{!! $posts->post_content !!}</span>
            @endforeach
        </div>
    </div>
@endsection
