@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Quản lý tin tức - bài viết <span
                    class="count-number">({{ number_Format($count_post) }})</span>
            </h3>
        </div>
        <div class="btn-header">
            <a href="{{ URL::to('Admin/list-post') }}">
                <button type="button" class="btn-refesh"><i class="fa-solid fa-arrows-rotate"></i> Tải lại trang
                </button>
            </a>
            <a href="{{ URL::to('Admin/add-post') }}">
                <button type="button" class="btn-add-page"><i class="fa-solid fa-plus"></i>Thêm tin tức</button>
            </a>
        </div>
    </div>

    <table class="table table-hover align-middle table-bordered" id="example1">
        @php $i = 1; @endphp
        <thead>
            <tr>
                <th>STT</th>
                <th>Hình ảnh</th>
                <th>Tiêu đề</th>
                <th>Mô tả ngắn</th>
                <th>Danh mục</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_post as $key => $post)
                <tr id="post-row-{{ $post->post_id }}">
                    <td>{{ $i++ }}</td>
                    <td><img class="img-post" src="{{ asset('uploads/post/' . $post->post_image) }}"></td>
                    <td>{{ $post->post_title }}</td>
                    <td class="text-auto">{{ $post->post_desc }}</td>
                    <td>{{ $post->cate_post_name }}</td>
                    <td>
                        <button type="button" class="toggle-status btn {{ $post->post_status == 1 ? 'active' : '' }}"
                            data-id="{{ $post->post_id }}"
                            data-active-url="{{ URL::to('Admin/active-post/' . $post->post_id) }}"
                            data-inactive-url="{{ URL::to('Admin/unactive-post/' . $post->post_id) }}"
                            data-toggle="tooltip" data-placement="top"
                            title="{{ $post->post_status == 1 ? 'Hiển thị' : 'Ẩn' }}">
                        </button>
                    </td>
                    <td>
                        <a href="{{ URL::to('Admin/edit-post/' . $post->post_id) }}" class="btn-edit" ui-toggle-class=""><i
                                class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0);" class="btn-remove" data-id="{{ $post->post_id }}" data-type="post"
                            data-confirm-message="Bạn có chắc là muốn xoá tin tức này?" onclick="deleteItem(this)">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
