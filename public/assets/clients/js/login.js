$(document).ready(function () {
    // Page Login, Register

    //validate register form
    $("#register-form").submit(function (e) {
        let username = $('input[name="username"]').val();
        let email = $('input[name="email"]').val();
        let password = $('input[name="password"]').val();
        let comfirmpassword = $('input[name="comfirmpassword"]').val();

        let errorMessage = "";

        if (username.length < 5) {
            errorMessage += "Tên đăng nhập phải có ít nhất 5 ký tự. <br>";
        }

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errorMessage += "Email không hợp lệ. <br>";
        }

        if (password.length < 6) {
            errorMessage += "Mật khẩu phải có ít nhất 6 ký tự. <br>";
        }

        if (password != comfirmpassword) {
            errorMessage += "Mật khẩu nhập lại không khớp. <br>";
        }

        if (errorMessage != "") {
            toastr.error(errorMessage, "Lỗi");
            e.preventDefault();
        }
    });

    //Validate login form
    $("#login-form").submit(function (e) {
        let username = $('input[name="username"]').val().trim();
        let password = $('input[name="password"]').val().trim();
        let errorMessage = "";

        if (username.length < 5) {
            errorMessage += "Tên đăng nhập phải có ít nhất 5 ký tự. <br>";
        }

        if (password.length < 6) {
            errorMessage += "Mật khẩu phải có ít nhất 6 ký tự. <br>";
        }

        if (errorMessage != "") {
            toastr.error(errorMessage, "Lỗi");
            e.preventDefault();
        }
    });

    //Validate Reset Password
    $("#reset-password-form").submit(function (e) {
        let email = $('input[name="email"]').val();
        let password = $('input[name="password"]').val();
        let comfirmpassword = $('input[name="password_confirmation"]').val();

        let errorMessage = "";

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errorMessage += "Email không hợp lệ. <br>";
        }

        if (password.length < 6) {
            errorMessage += "Mật khẩu phải có ít nhất 6 ký tự. <br>";
        }

        if (password != comfirmpassword) {
            errorMessage += "Mật khẩu nhập lại không khớp. <br>";
        }

        if (errorMessage != "") {
            toastr.error(errorMessage, "Lỗi");
            e.preventDefault();
        }
    });


    //Where click on the image => open file
    $('.profile-pic').click(function (e) {
        if (e.target.id !== 'avatar') {
            $("#avatar").click();
        }
    })

    $("#avatar").change(function () {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                // Cập nhật ảnh đại diện trên giao diện ngay lập tức
                $("#userAvatarMain").attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
            $("#btn-save-avatar").removeClass('d-none');
            $("#status-badge").addClass('d-none');
        }
    });

    $("#update-account").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let urlUpdate = $(this).attr('action');

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $.ajax({
            url: urlUpdate,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforSend: function () {
                $(".btn-wrapper button").text('Đang cập nhật...').attr("disabled", true);
            },
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                    //Update new img
                    if (response.avatar) {
                        $('#userAvatarMain').attr('src', response.avatar);
                    }
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    toastr.error(value[0]);
                });
            },
            complete: function () {
                $(".btn-wrapper button")
                    .text("Cập nhật")
                    .attr("disabled", false);
            },
        })
    });


    $("#changePassForm").on("submit", function (e) {
        e.preventDefault();

        let formData = $(this).serialize();
        let url = $(this).attr('action');

        $.ajax({
            url: url,
            type: 'POST', // Laravel sẽ nhận là PUT nhờ @method('PUT')
            data: formData,
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                    $("#changePassForm")[0].reset(); // Xóa trắng form sau khi đổi thành công
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    // Nếu lỗi do validate của Laravel (same, min...)
                    if (errors) {
                        $.each(errors, function (key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        // Nếu lỗi do sai mật khẩu hiện tại (trả về từ controller)
                        toastr.error(xhr.responseJSON.message);
                    }
                } else {
                    toastr.error("Có lỗi xảy ra, vui lòng thử lại.");
                }
            }
        });
    });
    
});

// 1. Chức năng Lọc theo Danh mục (Category)
function filterProduct(categoryId, element) {
    // Cập nhật giao diện nút bấm
    $('#filter-buttons button').removeClass('btn-dark text-white').addClass('btn-outline-dark');
    $(element).removeClass('btn-outline-dark').addClass('btn-dark text-white');

    // Thực hiện ẩn/hiện sản phẩm
    if (categoryId === 'all') {
        $('.product-item').fadeIn(200);
    } else {
        $('.product-item').hide();
        $(`.product-item[data-category="${categoryId}"]`).fadeIn(200);
    }
}

// 2. Chức năng Sắp xếp (Sort) theo Giá và Xu
function sortProducts() {
    let sortBy = $('#sort-select').val();
    let $tbody = $('#product-list');
    let $rows = $tbody.find('.product-item').get();

    if (sortBy === 'default') return;

    $rows.sort(function (a, b) {
        let valA, valB;

        if (sortBy.includes('price')) {
            // Lấy giá trị từ cột "Giá bán" (Cột thứ 4)
            // Loại bỏ chữ 'đ' và dấu phẩy để chuyển thành số
            valA = parseFloat($(a).find('td:nth-child(4) span').text().replace(/\D/g, ''));
            valB = parseFloat($(b).find('td:nth-child(4) span').text().replace(/\D/g, ''));
        } else if (sortBy.includes('xu')) {
            // Lấy giá trị từ cột "Loại tài khoản" (Cột thứ 1 - phần Xu màu xanh)
            valA = parseInt($(a).find('td:nth-child(1) .text-primary').text().replace(/\D/g, ''));
            valB = parseInt($(b).find('td:nth-child(1) .text-primary').text().replace(/\D/g, ''));
        }

        // Logic so sánh Tăng dần (asc) hoặc Giảm dần (desc)
        if (sortBy.endsWith('asc')) {
            return valA - valB;
        } else {
            return valB - valA;
        }
    });

    // Cập nhật lại thứ tự các dòng trong bảng
    $.each($rows, function (index, row) {
        $tbody.append(row);
    });
}