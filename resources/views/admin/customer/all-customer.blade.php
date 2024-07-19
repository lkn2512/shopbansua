@extends('admin_layout')
@section('admin_content')
    <div class="header-title">
        <div class="">
            <h3 class="title-content">Quản lý khách hàng
                <span class="count-number">({{ number_Format($count_customer) }})</span>
            </h3>
        </div>
        <div class="btn-header">
            <a href="{{ URL::to('Admin/all-customer') }}">
                <button type="button" class="btn-refesh refesh-page"><i class="fa-solid fa-arrows-rotate"></i> Tải
                    lại trang
                </button>
            </a>
            <a href="{{ URL::to('Admin/add-customer') }}">
                <button type="button" class="btn-add-page add-products"><i class="fa-solid fa-plus"></i> Thêm khách hàng
                </button>
            </a>
        </div>
    </div>

    <table class="table table-hover align-middle table-bordered" id="example1">
        @php $i = 1; @endphp
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên khách hàng</th>
                <th>Địa chỉ</th>
                <th>Email</th>
                <th>Đơn hàng</th>
                <th>Tác vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customer as $cus)
                <tr id="customer-row-{{ $cus->customer_id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($cus->customer_image)
                            <img class="img-customer" src="{{ asset('uploads/customer/' . $cus->customer_image) }}"
                                alt="Customer Image">
                        @else
                            <img class="img-customer" src="{{ asset('backend/images/user.png') }}" alt="Default User Image">
                        @endif
                        {{ $cus->customer_name }}
                    </td>
                    <td>
                        <img class="img-icon-small" src="{{ URL::to('/backend/images/address.png') }}" alt="Address Icon">
                        @if ($cus->customer_address)
                            {{ $cus->customer_address }}
                        @else
                            <span class="text-body-secondary">Chưa có thông tin địa chỉ</span>
                        @endif
                    </td>
                    <td><i class="fa-regular fa-envelope"></i>&ensp;{{ $cus->customer_email }}</td>
                    <td>
                        {{ $customerOrders[$cus->customer_id] ?? 0 }} đơn hàng
                    </td>
                    <td>
                        <a href="{{ URL::to('Admin/info-customer/' . $cus->customer_id) }}" class="btn-edit"
                            ui-toggle-class="">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <a href="#" class="btn-remove"
                            onclick="showConfirmationModal('{{ URL::to('Admin/delete-customer/' . $cus->customer_id) }}', '{{ $cus->customer_id }}')">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal hiển thị thông báo trước khi xoá -->
    <div class="modal fade" id="confirmationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title warning-title"><i class="fa-solid fa-triangle-exclamation"></i> Cảnh báo!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="warning-text">Sau khi xoá, những gì liên quan tới khách hàng này cũng sẽ bị xoá, bao gồm:
                        <b>đơn hàng, danh sách yêu thích</b>,...<br>
                        <span>Bạn có chắc là muốn xoá?</span>
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancle" data-bs-dismiss="modal">Huỷ bỏ</button>
                    <button type="button" id="deleteButton" class="btn btn-danger">Xoá</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal hiển thị thông báo trước khi xoá -->
    <script>
        function showConfirmationModal(deleteUrl, customerId) {
            var modal = $('#confirmationModal');
            modal.modal('show');
            var deleteButton = document.getElementById('deleteButton');
            deleteButton.onclick = function() {
                deleteCustomer(deleteUrl, customerId);
            };
        }

        function deleteCustomer(deleteUrl, customerId) {
            $.ajax({
                url: deleteUrl,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        $('#customer-row-' + customerId).remove(); // Xoá dòng từ bảng
                    } else {
                        toastr.error(response.message);
                    }
                    $('#confirmationModal').modal('hide'); // Ẩn modal sau khi xử lý
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    toastr.error('Đã xảy ra lỗi khi xoá khách hàng.');
                    $('#confirmationModal').modal('hide'); // Ẩn modal sau khi xử lý
                }
            });
        }
    </script>
@endsection
