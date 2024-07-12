@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Thông tin khách hàng</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('Admin/dashboard') }}">Tổng quan</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('Admin/all-customer') }}">Quản lý khách hàng</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Thông tin khách hàng
                </li>
            </ol>
        </div>
        <div class="btn-header">
            <a href="javascript:location.reload(true)"> <button type="button" class="btn-ref refesh-page"
                    data-mdb-ripple-init><i class="fa-solid fa-arrows-rotate"></i> Tải lại trang</button></a>
            <a href="{{ URL::to('Admin/all-customer') }}"><button type="button" class="btn-back" data-mdb-ripple-init><i
                        class="fa-solid fa-arrow-left"></i> Trở về</button></a>
        </div>
    </div>
    @foreach ($customer as $cus)
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="info-customer">
                            <div class="image-container">
                                @if ($cus->customer_image)
                                    <img class="img-avatar" src="/uploads/customer/{{ $cus->customer_image }}">
                                @else
                                    <img class="img-avatar" src="/backend/images/user.png">
                                @endif
                                <form id="upload-avatar-form" action="{{ URL::to('Admin/update-avatar-customer') }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="customer_id" value="{{ $cus->customer_id }}">
                                    <input type="file" name="file_img" id="file-input-avatar"
                                        onchange="document.getElementById('upload-avatar-form').submit();"
                                        style="display: none;">
                                    <a href="{{ URL::to('Admin/update-avatar-customer') }}"
                                        onclick="document.getElementById('file-input-avatar').click(); return false;"
                                        title="Thay đổi ảnh đại diện">
                                        <i class="fa-solid fa-camera" id="file-icon"
                                            style="border-radius:100px;height: 100%; padding-top: 40px; padding-left:40px; color:white"></i>
                                    </a>
                                </form>
                            </div>
                            <div class="info-right">
                                <span class="name">{{ $cus->customer_name }}</span>
                                <span class="address">
                                    <img class="img-icon-small" src="{{ URL::to('/backend/images/email.png') }}">
                                    @if ($cus->customer_email)
                                        {{ $cus->customer_email }}
                                    @else
                                        Chưa có thông tin địa chỉ
                                    @endif
                                </span>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-order-customer">
                                    <label class="title">Tổng đơn hàng</label>
                                    <h5 class="long-number">{{ $order_total }}</h5>
                                    <span class="sub-title">Đã được đặt</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-order-customer">
                                    <label class="title">Tổng chi tiêu</label>
                                    <h5 class="long-number">{{ number_format($order_delivered, 0, ',', '.') }}đ</h5>
                                    <span class="sub-title">Cho {{ $order_delivered_count }} đơn hàng đã được
                                        giao</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-order-customer">
                                    <label class="title">Trung bình đơn hàng</label>
                                    <h5 class="long-number">{{ number_format($order_average, 0, ',', '.') }}đ</h5>
                                    <span class="sub-title">Trong tổng số {{ $order_total }} đơn hàng đã đặt</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-body-secondary">
                        <h3 class="card-title">Đơn hàng gần đây</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover align-middle table-bordered" id="example2">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã đơn hàng</th>
                                    <th>Tình trạng</th>
                                    <th>Tổng tiền</th>
                                    <th>Thời gian đặt hàng</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($order as $key => $orders)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td style="text-transform: uppercase">#{{ $orders->order_code }}</td>
                                        <td>
                                            @if ($orders->order_status == 1)
                                                <a class="order-status-waitting">Đang chờ xử lý...</a>
                                            @elseif($orders->order_status == 2)
                                                <a class="order-status-delivered">Đã xử lý</a>
                                            @else
                                                <a class="order-status-cancle">Đã huỷ</a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ number_format($orders->order_total, 0, ',', '.') }}đ
                                        </td>
                                        <td> {{ \Carbon\Carbon::parse($orders->created_at)->format('H:i, Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ URL::to('Admin/view-order/' . $orders->order_code) }}"
                                                class="btn-detail-view"><i class="fa-regular fa-eye"></i> Xem
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-body-secondary">
                        <h3 class="card-title">liên hệ </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="info-contact">
                            <h4>Thông tin chi tiết
                                <span class="edit"><a href="javascript:void(0);" onclick="editContact()">Chỉnh
                                        sửa</a></span>
                            </h4>
                            <form id="contact-form"
                                action="{{ URL::to('Admin/edit-info-customer/' . $cus->customer_id) }}" method="post">
                                {{ csrf_field() }}
                                <span class="address">
                                    <img class="img-icon-small" src="{{ URL::to('/backend/images/address.png') }}">
                                    <span id="address-text">{{ $cus->customer_address }}</span>
                                    <input type="text" id="address-input" name="customer_address" class="input-small"
                                        value="{{ $cus->customer_address }}">
                                </span>
                                <span class="phone">
                                    <img class="img-icon-small" src="{{ URL::to('/backend/images/phone.png') }}">
                                    <span id="phone-text">{{ $cus->customer_phone }}</span>
                                    <input type="text" id="phone-input" name="customer_phone"class="input-small"
                                        value="{{ $cus->customer_phone }}">
                                </span><br>
                                <button id="save-button" class="btn-save-infoCustomer" style="display:none;"
                                    type="submit">Lưu</button>
                            </form><br>
                            <span class="sub-title">Cập nhật lần cuối: {{ $cus->updated_at->format('d/m/Y') }}</span>
                            <script>
                                function editContact() {
                                    var emailText = document.getElementById('address-text');
                                    var emailInput = document.getElementById('address-input');
                                    var phoneText = document.getElementById('phone-text');
                                    var phoneInput = document.getElementById('phone-input');
                                    var saveButton = document.getElementById('save-button');

                                    if (emailText.style.display === 'none') {
                                        emailText.style.display = 'inline';
                                        emailInput.style.display = 'none';
                                        phoneText.style.display = 'inline';
                                        phoneInput.style.display = 'none';
                                        saveButton.style.display = 'none';
                                    } else {
                                        emailText.style.display = 'none';
                                        emailInput.style.display = 'inline';
                                        phoneText.style.display = 'none';
                                        phoneInput.style.display = 'inline';
                                        saveButton.style.display = 'inline';
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2">
                            <h3 class="card-title">Tài khoản được khởi tạo vào lúc </h3><br>
                        </div>
                        <span><i class="fa-regular fa-calendar"></i> {{ $cus->created_at->format('H:i, d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
