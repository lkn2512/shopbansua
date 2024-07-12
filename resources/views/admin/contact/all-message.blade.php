@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Quản lý liên hệ <span class="count-number">({{ number_format($count_contact) }})</span>
            </h3>
        </div>
        <div class=" btn-header">
            <a href="{{ URL::to('Admin/all-message') }}">
                <button type="button" class="btn-refesh"><i class="fa-solid fa-arrows-rotate"></i> Tải lại
                    trang
                </button>
            </a>
        </div>
    </div>
    <div class="row search-data">
        <div class="col-md-12">
            <form action="{{ url('Admin/search-contact-customer') }}" method="GET">
                <div class="input-group">
                    <button type="submit" class="btn-search" data-mdb-ripple-init title="Tìm kiếm">
                        <i class="fas fa-search"></i>
                    </button>
                    <input type="search" id="search-input" class="form-control" name="keyword"
                        placeholder="Tìm kiếm tin nhắn" value="{{ request('keyword') }}" />
                </div>
            </form>
        </div>
    </div>
    @foreach ($contact as $con)
        <div class="contact-border" id="contact-customer-row-{{ $con->contact_id }}">
            <div class="row">
                <div class="col-md-2">
                    <label class="form-check-label">
                        {{ $con->contact_name }}
                        @if (!$con->notification->isEmpty() && $con->notification->where('read', 0)->isNotEmpty())
                            <span class="unread-dot" title="Chưa xem"></span>
                        @endif
                    </label>
                </div>
                <div class="col-md-8 contact-message">
                    <span> {{ $con->contact_message }}</span>
                </div>
                <div class="col-md-2 text-end">
                    <span> {{ $con->created_at->format('H:i, d-m-Y') }}</span>
                    <div class="action-contact">
                        <a href="{{ URL::to('Admin/view-contact-customer/' . $con->contact_id) }}" class="icon"><i
                                class="fa-regular fa-eye" title="Xem chi tiết"></i></a>
                        <a href="javascript:void(0);" class="icon" data-id="{{ $con->contact_id }}"
                            data-type="contact-customer" data-confirm-message="Bạn có chắc là muốn xoá tin nhắn này này?"
                            onclick="deleteItem(this)">
                            <i class="fa-regular fa-trash-can"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <footer class="panel-footer">
        {!! $contact->withQueryString()->appends(Request::all())->links('pagination::bootstrap-5') !!}
    </footer>
@endsection
