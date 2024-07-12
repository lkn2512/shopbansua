<div class="card">
    <div class="card-header">
        <h5 class="title m-0">Cài đặt tài khoản</h5>
    </div>
    <div class="card-body">
        <div class="card-setting">
            <a class="item-text {{ Request::is('Admin/profile/*') ? 'active' : '' }}"
                href="{{ URL::to('Admin/profile/' . Session::get('user_id')) }}"><i class="fa-regular fa-user"></i> Thông
                tin
                cá nhân
            </a>
            <a class="item-text {{ Request::is('Admin/security/*') ? 'active' : '' }}"
                href="{{ URL::to('Admin/security/' . Session::get('user_id')) }}">
                <img class="img-icon-small" src="{{ URL::to('/backend/images/lock.png') }}">Bảo mật
            </a>
            <a class="item-text {{ Request::is('Admin/delete-profile/*') ? 'active' : '' }}"
                href="{{ URL::to('Admin/delete-profile/' . Session::get('user_id')) }}">
                <img class="img-icon-small" src="{{ URL::to('/backend/images/delete.png/') }}">Xoá tài khoản
            </a>
            <a class="item-text" href="{{ URL::to('Admin/logout-admin') }}">
                <img class="img-icon-small" src="{{ URL::to('/backend/images/logout.png/') }}">Đăng xuất
            </a>
        </div>
    </div>
</div>
