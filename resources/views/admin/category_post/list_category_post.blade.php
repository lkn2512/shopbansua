@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Danh mục bài viết
                <span class="count-number">({{ number_Format($countCatePost, 0, ',', '.') }})</span>
            </h3>
        </div>
        <div class="btn-header">
            <a href="{{ URL::to('Admin/all-category-post') }}">
                <button type="button" class=" btn-refesh"><i class="fa-solid fa-arrows-rotate"></i> Tải lại
                    trang
                </button>
            </a>
            <a href="{{ URL::to('Admin/add-category-post') }}">
                <button type="button" class=" btn-add-page"><i class="fa-solid fa-plus"></i> Thêm danh mục
                </button>
            </a>
        </div>
    </div>
    <table class="table table-hover align-middle table-bordered" id="example1">
        @php $i = 1; @endphp
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên danh mục</th>
                <th>Bài viết</th>
                <th>Vị trí</th>
                <th>Trạng thái</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($category_post as $key => $cate_post)
                <tr id="category-post-row-{{ $cate_post->cate_post_id }}">
                    <td>{{ $i++ }}</td>
                    <td class="text-auto">{{ $cate_post->cate_post_name }}</td>
                    <td> {{ number_format($post_counts[$cate_post->cate_post_id]) }}</td>
                    <td>
                        @if ($cate_post->cate_post_positions == 0)
                            Mặc định
                        @elseif($cate_post->cate_post_positions == 1)
                            Đầu trang
                        @else
                            Cuối trang
                        @endif
                    </td>
                    <td>
                        <button type="button"
                            class="toggle-status btn {{ $cate_post->cate_post_status == 1 ? 'active' : '' }}"
                            data-id="{{ $cate_post->cate_post_id }}"
                            data-active-url="{{ URL::to('Admin/active-category-post/' . $cate_post->cate_post_id) }}"
                            data-inactive-url="{{ URL::to('Admin/unactive-category-post/' . $cate_post->cate_post_id) }}"
                            data-toggle="tooltip" data-placement="top"
                            title="{{ $cate_post->cate_post_status == 1 ? 'Hiển thị' : 'Ẩn' }}">
                        </button>
                    </td>
                    <td>
                        <a href="{{ URL::to('Admin/edit-category-post/' . $cate_post->cate_post_id) }}" class="btn-edit"><i
                                class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0);" class="btn-remove" data-id="{{ $cate_post->cate_post_id }}"
                            data-type="category-post" data-confirm-message="Bạn có chắc là muốn xoá danh mục tin tức này?"
                            onclick="deleteItem(this)">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
