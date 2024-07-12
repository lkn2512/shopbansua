<div class="border-white">
    @foreach ($customer as $cus)
        <div class="flex-inline position-relative">
            <img src="{{ asset('uploads/customer/' . $cus->customer_image) }}" class="avatar-customer">
            <div class="upload-icon-wrapper">
                <form action="{{ url('upload-avatar-customer/' . $cus->customer_id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <label for="customer_image" class="upload-icon" title="Thay đổi ảnh đại diện">
                        <img src="{{ asset('frontend/images/home/camera.png') }}" alt="Upload Image">
                    </label>
                    <input type="file" id="customer_image" name="customer_image" style="display: none;"
                        onchange="this.form.submit()" accept="image/*">
                </form>
            </div>
        </div>
        <div class="information-customer">
            <div class="flex-inline">
                <div class="title"></div>
                <a class="btn-edit " onclick="editContact()"><i class="fa-solid fa-pen"></i> Chỉnh sửa</a>
            </div>
            <form action="{{ URL::to('update-info-customer/' . $cus->customer_id) }}" method="POST">
                @csrf
                <div class="flex-inline">
                    <div class="title">Họ và tên</div>
                    <div id="customer_name" class="name">{{ $cus->customer_name }}</div>
                    <input class="input-change" type="text" id="nameInput" style="display: none;"
                        value="{{ $cus->customer_name }}" name="customer_name">
                </div>
                <div class="flex-inline">
                    <div class="title">Địa chỉ</div>
                    <div id="customer_address" class="name">
                        @if ($cus->customer_address)
                            {{ $cus->customer_address }}
                        @else
                            Hiện chưa có địa chỉ
                        @endif
                    </div>
                    <input class="input-change" type="text" id="addressInput" style="display: none;"
                        value="{{ $cus->customer_address }}" name="customer_address">
                </div>
                <div class="flex-inline">
                    <div class="title">Số điện thoại</div>
                    <div id="customer_phone" class="name">{{ $cus->customer_phone }}</div>
                    <input class="input-change" type="text" id="phoneInput" style="display: none;"
                        value="{{ $cus->customer_phone }}" name="customer_phone">
                </div>
                <div class="text-end">
                    <button type="submit" class="btn-save-change" id="saveButton" style="display: none;"><i
                            class="fa-solid fa-check"></i>
                        Lưu</button>
                </div>
            </form>

        </div>
    @endforeach

    <script>
        function editContact() {
            var nameText = document.getElementById('customer_name');
            var nameInput = document.getElementById('nameInput');
            var addressText = document.getElementById('customer_address');
            var addressInput = document.getElementById('addressInput');
            var phoneText = document.getElementById('customer_phone');
            var phoneInput = document.getElementById('phoneInput');
            var saveButton = document.getElementById('saveButton');
            var refreshButton = document.getElementById('refreshButton');

            if (nameText.style.display === 'none') {
                // Exit edit mode
                nameText.style.display = 'inline';
                nameInput.style.display = 'none';
                addressText.style.display = 'inline';
                addressInput.style.display = 'none';
                phoneText.style.display = 'inline';
                phoneInput.style.display = 'none';
                saveButton.style.display = 'none';
                refreshButton.style.display = 'none';
            } else {
                // Enter edit mode
                nameText.style.display = 'none';
                nameInput.style.display = 'inline';
                addressText.style.display = 'none';
                addressInput.style.display = 'inline';
                phoneText.style.display = 'none';
                phoneInput.style.display = 'inline';
                saveButton.style.display = 'inline';
                refreshButton.style.display = 'inline';
            }
        }

        function saveChanges() {
            var newName = document.getElementById('nameInput').value;
            var newAddress = document.getElementById('addressInput').value;
            var newPhone = document.getElementById('phoneInput').value;

            document.getElementById('customer_name').textContent = newName;
            document.getElementById('customer_address').textContent = newAddress;
            document.getElementById('customer_phone').textContent = newPhone;

            exitEditMode();
        }

        function exitEditMode() {
            var nameText = document.getElementById('customer_name');
            var nameInput = document.getElementById('nameInput');
            var addressText = document.getElementById('customer_address');
            var addressInput = document.getElementById('addressInput');
            var phoneText = document.getElementById('customer_phone');
            var phoneInput = document.getElementById('phoneInput');
            var saveButton = document.getElementById('saveButton');
            var refreshButton = document.getElementById('refreshButton');

            nameText.style.display = 'inline';
            nameInput.style.display = 'none';
            addressText.style.display = 'inline';
            addressInput.style.display = 'none';
            phoneText.style.display = 'inline';
            phoneInput.style.display = 'none';
            saveButton.style.display = 'none';
            refreshButton.style.display = 'none';
        }
    </script>

</div>
