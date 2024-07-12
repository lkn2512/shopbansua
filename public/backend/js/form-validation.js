function validateForm(form) {
    form.validate({
        rules: {
            customer_name: {
                required: true,
                minlength: 2,
            },
            customer_email: {
                required: true,
                email: true
            },
            customer_phone: {
                required: true,
                minlength: 10,
                digits: true
            },
            customer_password: {
                required: true,
                minlength: 6
            },
            customer_repeat_pass: {
                required: true,
                equalTo: '#customer_password'
            },
            category_product_name: {
                required: true,
                minlength: 2,
                maxlength: 20
            },
            cate_post_name: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
            brand_product_name: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
        },
        messages: {
            customer_name: {
                required: "Vui lòng nhập vào họ tên khách hàng",
                minlength: "Họ tên phải ít nhất 2 ký tự",
            },
            customer_email: {
                required: "Vui lòng nhập vào địa chỉ email",
                email: "Địa chỉ email không hợp lệ"
            },
            customer_phone: {
                required: "Vui lòng nhập số điện thoại",
                minlength: "Số điện thoại phải ít nhất 10 chữ số",
                digits: "Số điện thoại chỉ được chứa ký tự số"
            },
            customer_password: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải ít nhất 8 ký tự"
            },
            customer_repeat_pass: {
                required: "Vui lòng nhập lại mật khẩu",
                equalTo: "Mật khẩu không khớp"
            },
            category_product_name: {
                required: "Vui lòng nhập vào tên danh mục",
                minlength: "Nhập tổi thiểu 2 ký tự",
                maxlength: "Nhập tối đa 50 ký tự"
            },
            cate_post_name: {
                required: "Vui lòng nhập vào tên danh mục",
                minlength: "Nhập tổi thiểu 2 ký tự",
                maxlength: "Nhập tối đa 50 ký tự"
            },
            brand_product_name: {
                required: "Vui lòng nhập vào tên thương hiệu",
                minlength: "Nhập tổi thiểu 2 ký tự",
                maxlength: "Nhập tối đa 50 ký tự"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.insertAfter(element);
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
}