@extends('admin.admin-information.info-admin')
@section('profile-content')
    @foreach ($admin as $ad)
        <div class="card">
            <div class="card-header">
                <div class="label-container">
                    <h5 class="title m-0">Thông tin cá nhân</h5>
                    <span class="add-new">
                        <a href="javascript:void(0);" id="edit-button">
                            <i class="fa-regular fa-pen-to-square"></i> Chỉnh sửa
                        </a>
                    </span>
                </div>
            </div>
            <div class="card-body">
                @php
                    $id = Session::get('user_id');
                @endphp
                <form action="{{ URL::to('Admin/update-profile/' . $id) }}" method="POST" id="saveForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <p id="phone">{{ $ad->phone }}</p>
                                <input type="text" id="phone-input" name="phone" value="{{ $ad->phone }}"
                                    style="display:none;"class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Ngày sinh</label>
                                <p id="dob">{{ $ad->birthday }}</p>
                                <input type="date" id="dob-input" name="birthday" value="{{ $ad->birthday }}"
                                    style="display:none;"class="form-control">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Địa chỉ 1</label>
                                <p id="address1">{{ $ad->first_address }}</p>
                                <input type="text" id="address1-input" name="first_address"
                                    value="{{ $ad->first_address }}" style="display:none;"class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ 2</label>
                                <p id="address2">{{ $ad->second_address }}</p>
                                <input type="text" id="address2-input" name="second_address"
                                    value="{{ $ad->second_address }}" style="display:none;"class="form-control">
                            </div>
                        </div>
                    </div>
                    <span class="sub-title" id="sub-title">Thay đổi lần cuối:
                        @if ($ad->updated_at)
                            {{ $ad->updated_at->format('d/m/Y') }}
                        @endif
                    </span>

                    <button type="submit" class="btn-add btn-submit" data-mdb-ripple-init id="submit-button"
                        style="display:none;">
                        <span class="button-text">Cập nhật</span>
                        <span id="spinner" class="spinner">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    @endforeach
    <script>
        document.getElementById('edit-button').addEventListener('click', function() {
            var inputs = ['phone', 'dob', 'address1', 'address2'];
            var isInputVisible = document.getElementById('phone-input').style.display === 'block';

            inputs.forEach(function(id) {
                document.getElementById(id).style.display = isInputVisible ? 'block' : 'none';
                document.getElementById(id + '-input').style.display = isInputVisible ? 'none' : 'block';
            });
            document.getElementById('submit-button').style.display = isInputVisible ? 'none' : 'block';
            document.getElementById('sub-title').style.display = isInputVisible ? 'block' : 'none';
        });
    </script>
@endsection
