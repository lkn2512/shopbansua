@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Chi tiết liên hệ</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('Admin/all-message') }}">Liên hệ </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Chi tiết liên hệ
                </li>
            </ol>
        </div>
        <div class="btn-header">
            <a href="{{ URL::to('Admin/add-category-product') }}">
                <button type="button" class="btn-ref refesh-page" data-mdb-ripple-init><i
                        class="fa-solid fa-arrows-rotate"></i> Tải lại trang
                </button>
            </a>
            <a href="{{ URL::to('Admin/all-message') }}">
                <button type="button" class="btn-back" data-mdb-ripple-init><i class="fa-solid fa-arrow-left"></i> Trở
                    về
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 contact-customer-left">
            <div class="card">
                <div class="card-body">
                    <h5 class="account">Thông tin người gửi</h5>
                    <span class="info"><i class="fa-solid fa-pencil"></i>{{ $contact->contact_name }}</span>
                    <span class="info"><i class="fa-regular fa-envelope"></i>{{ $contact->contact_email }}</span>
                    @if ($contact->contact_subject)
                        <span class="info"><i class="fa-solid fa-person"></i>{{ $contact->contact_subject }}</span>
                    @endif
                </div>
            </div>

        </div>
        <div class="col-md-10 contact-customer-right">
            <div class="card">
                <div class="card-body">
                    <h5 class="account">Nội dung tin nhắn liên hệ</h5>
                    <b class="name"> {{ $contact->contact_name }}</b>
                    <span class="message">{{ $contact->contact_message }}</span>
                    <span class="time">Gửi vào lúc: {{ $contact->created_at->format('H:i, d-m-Y') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
