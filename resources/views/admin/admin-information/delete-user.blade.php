@extends('admin.admin-information.info-admin')
@section('profile-content')
    <div class="card">
        @foreach ($admin as $ad)
            <div class="card-header">
                <h4 class="title m-0">Xoá tài khoản của bạn</h4>
            </div>
            <div class="card-body">
                <h5 style="color: red">Cảnh báo</h5>
                <span>Nếu bạn xoá khoản của mình, bạn sẽ mất quyền truy cập vĩnh viễn.</span><br><br>
                <form action="">
                    {{-- <div class="form-group">
                            <label>Xác nhận mật khẩu<small class="note"><span class="required">*</span></small></label>
                            <input type="password" name="password" class="form-control input-w500"
                                placeholder="Nhập vào mật khẩu của bạn" required>
                        </div> --}}
                    <a href="#" class="btn-delete"
                        onclick="showConfirmationModal('{{ URL::to('Admin/delete-user-action/' . $ad->id) }}')">Xoá tài
                        khoản
                    </a>
                </form>
            </div>
        @endforeach
    </div>
    </div>

    <div class="modal fade" id="confirmationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title warning-title"><i class="fa-solid fa-triangle-exclamation"></i> Cảnh báo!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="warning-text">Nếu bạn xoá tài khoản của mình, bạn sẽ
                        <b>mất quyền truy cập vĩnh viễn.</b><br>
                        <span>Bạn có chắc là muốn xoá?</span>
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancle" data-bs-dismiss="modal">Huỷ bỏ</button>
                    <button type="button" id="deleteButton" class="btn btn-danger" onclick="deleteItem()">Xoá</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showConfirmationModal(deleteUrl) {
            var modal = document.getElementById('confirmationModal');
            var modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
            document.getElementById('deleteButton').setAttribute('onclick', 'deleteItem("' + deleteUrl + '")');
        }

        function deleteItem(deleteUrl) {
            window.location.href = deleteUrl;
        }
    </script>
@endsection
