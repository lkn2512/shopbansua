@foreach ($admin as $ad)
    <div class="row-background">
        <img class="img-adminInfo" src="{{ URL::to('/backend/images/backgroundAdmin.jpg') }}" alt="">
        <div class="image-container">
            @if ($ad->avatar)
                <img class="img-avatar-admin" src="{{ asset('uploads/user/' . $ad->avatar) }}">
            @else
                <img class="img-avatar-admin" src="{{ asset('backend/images/user.png') }}">
            @endif
            <form id="upload-avatar-form" action="{{ URL::to('Admin/update-avatar-admin/' . $ad->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $ad->id }}">
                <input type="file" name="file_img" id="file-input-avatar"
                    onchange="document.getElementById('upload-avatar-form').submit();" style="display: none;"
                    accept="image/*">
                <a href="{{ URL::to('Admin/update-avatar-admin/' . $ad->id) }}"
                    onclick="document.getElementById('file-input-avatar').click(); return false;"
                    title="Thay đổi ảnh đại diện">
                    <i class="fa-solid fa-camera " id="file-icon"
                        style="border-radius:100px;height: 100px; width: 100px; padding-top: 40px; padding-left:40px; color:white; margin-left: 10px"></i>
                </a>
            </form>
        </div>
        <h3 class="name-admin" id="name-admin">{{ $ad->name }}</h3>
        <span class="power">Quản trị viên</span>
        <a href="#" class="btn-edit-account" id="edit-name-button" data-bs-toggle="modal"
            data-bs-target="#exampleModal" data-bs-whatever="@fat">
            <i class="fa-solid fa-user-pen"></i> Đổi tên
        </a>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" id="modal-dialog-input">
            @php
                $id = Session::get('user_id');
            @endphp
            <form method="POST" action="{{ URL::to('Admin/rename-admin/' . $id) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Thay đổi tên</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="col-form-label">Nhập vào tên mới:</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                    </div>
                    <div class="modelFooter">
                        <button type="button" class="btn-cancle" data-bs-dismiss="modal">Huỷ bỏ</button>
                        <button type="submit" class="btn-submit">Xác nhận</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
