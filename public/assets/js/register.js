// public/assets/js/register.js

document.addEventListener("DOMContentLoaded", function () {
  // Lấy tất cả các nút có class .toggle-password (icon con mắt)
  const toggleBtns = document.querySelectorAll(".toggle-password");

  toggleBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      // Lấy id của ô input cần toggle (được lưu trong data-target)
      const targetId = this.getAttribute("data-target");
      const input = document.getElementById(targetId);
      const icon = this.querySelector("i");

      if (!input) return; // Nếu không tìm thấy input thì dừng

      if (input.type === "password") {
        // 1. Chuyển sang hiện mật khẩu
        input.type = "text";

        // 2. Đổi icon: Từ mắt gạch chéo (ẩn) -> Mắt thường (hiện)
        // Xóa class cũ
        icon.classList.remove("fa-eye-slash");
        // Thêm class mới
        icon.classList.add("fa-eye");
      } else {
        // 1. Chuyển về ẩn mật khẩu
        input.type = "password";

        // 2. Đổi icon: Từ mắt thường -> Mắt gạch chéo
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      }
    });
  });
});
