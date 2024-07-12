@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Quản lý bình luận <span
                    class="count-number">({{ number_Format($count_comment) }})</span></h3>
        </div>
        <div class=" btn-header">
            <a href="{{ URL::to('Admin/list-comment') }}">
                <button type="button" class="btn-refesh"><i class="fa-solid fa-arrows-rotate"></i> Tải lại
                    trang
                </button>
            </a>
        </div>
    </div>
    <?php
    $i = 1;
    ?>
    <table class="table table-hover align-middle table-bordered" id="example1">
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Bình luận</th>
                <th>Thời gian</th>
                <th>Sản phẩm</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comment as $key => $comm)
                <tr id="comment-row-{{ $comm->comment_id }}">
                    <td>{{ $i++ }}</td>
                    <td>{{ $comm->comment_name }}</td>
                    <td class="width700"><span class="comment-name-fix">{{ $comm->comment }}</span>
                        <div class="btn-group">
                            <button class="btn-reply-admin" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Phản hồi
                            </button>
                            <ul class="dropdown-menu drop-repComment">
                                <label class="title">Viết phản hồi của bạn:</label>
                                <textarea class="text-reply_{{ $comm->comment_id }}"></textarea>
                                <button class="btn-reply-comment" data-product_id="{{ $comm->comment_product_id }}"
                                    data-comment_id="{{ $comm->comment_id }}">Bình luận</button>
                            </ul>
                        </div>
                        <ul>
                            @foreach ($comment_reply as $key => $comm_reply)
                                @if ($comm_reply->comment_parent_comment == $comm->comment_id)
                                    <li class="reply-ul" id="comment-admin-row-{{ $comm_reply->comment_id }}">
                                        <span class="name">{{ $comm_reply->comment_name }}:</span>&ensp;
                                        {{ $comm_reply->comment }}
                                        <span class="time">
                                            &ensp;<i class="fa-regular fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($comm_reply->comment_date)->format('H:i, d-m-Y') }}
                                        </span>
                                        <div class="btn-group">
                                            <button class="btn-custom" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                ...
                                            </button>
                                            <ul class="dropdown-menu custom-ul-hover">
                                                <a href="javascript:void(0);" class="recall"
                                                    data-id="{{ $comm_reply->comment_id }}" data-type="comment-admin"
                                                    data-confirm-message="Bạn có chắc là muốn xoá bình luận của bạn?"
                                                    onclick="deleteItem(this)">
                                                    Xoá bình luận
                                                </a>
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($comm->comment_date)->format('H:i, d-m-Y') }}
                    </td>
                    <td class="text-auto">
                        <a class="underline text-dark" href="{{ url('chi-tiet-san-pham/' . $comm->product->product_id) }}"
                            target="_blank" title="{{ $comm->product->product_name }}">{{ $comm->product->product_name }}
                        </a>
                    </td>
                    </td>
                    <td>
                        <a href="javascript:void(0);" class="btn-remove" data-id="{{ $comm->comment_id }}"
                            data-type="comment"
                            data-confirm-message="Đây là bình luận của người dùng. Bạn có chắc là muốn xoá?"
                            onclick="deleteItem(this)" title="Xoá bình luận khách hàng">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
