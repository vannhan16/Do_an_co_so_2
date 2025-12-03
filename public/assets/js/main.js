document.addEventListener("DOMContentLoaded", () => {
  // 1. Xử lý nút "Thêm vào giỏ"
  const addToCartButtons = document.querySelectorAll(".btn-add-cart");
  const cartCountBadge = document.querySelector("#cart-count");

  addToCartButtons.forEach((btn) => {
    btn.addEventListener("click", function () {
      // Hiệu ứng click đơn giản
      this.classList.add("scale-95");
      setTimeout(() => this.classList.remove("scale-95"), 150);

      // Logic giả lập tăng số lượng giỏ hàng
      let currentCount = parseInt(cartCountBadge.innerText);
      cartCountBadge.innerText = currentCount + 1;

      // Thông báo (có thể thay bằng Toast notification sau này)
      console.log("Đã thêm món: " + this.dataset.name);
    });
  });

  // 2. Xử lý Active Tab (Chuyển màu khi click danh mục)
  const categoryTabs = document.querySelectorAll(".category-tab");
  categoryTabs.forEach((tab) => {
    tab.addEventListener("click", (e) => {
      e.preventDefault();
      // Xóa active cũ
      categoryTabs.forEach((t) => {
        t.classList.remove(
          "border-b-primary",
          "text-gray-900",
          "dark:text-white"
        );
        t.classList.add("border-b-transparent", "text-gray-500");
      });
      // Thêm active mới
      tab.classList.remove("border-b-transparent", "text-gray-500");
      tab.classList.add("border-b-primary", "text-gray-900", "dark:text-white");
    });
  });
});
document.addEventListener("DOMContentLoaded", () => {
  // --- LOGIC MOBILE MENU ---
  const btnMobileMenu = document.getElementById("mobile-menu-btn");
  const mobileMenu = document.getElementById("mobile-menu");

  if (btnMobileMenu && mobileMenu) {
    btnMobileMenu.addEventListener("click", () => {
      // Toggle class 'hidden' để hiện/ẩn menu
      mobileMenu.classList.toggle("hidden");

      // Đổi icon từ 3 gạch (bars) sang dấu X (xmark)
      const icon = btnMobileMenu.querySelector("i");
      if (mobileMenu.classList.contains("hidden")) {
        icon.classList.remove("fa-xmark");
        icon.classList.add("fa-bars");
      } else {
        icon.classList.remove("fa-bars");
        icon.classList.add("fa-xmark");
      }
    });
  }
});
// --- LOGIC GIỎ HÀNG (cart.php) ---
document.addEventListener("DOMContentLoaded", () => {
  // --- KHAI BÁO CÁC BIẾN ---
  // Nút mở giỏ hàng (trên header) - Lưu ý: Bạn cần thêm id="open-cart-btn" cho nút giỏ hàng ở header.php
  const openCartBtn = document.getElementById("open-cart-btn"); // Hoặc querySelector nếu dùng class

  // Các thành phần của file cart.php
  const cartSidebar = document.getElementById("cart-sidebar");
  const cartOverlay = document.getElementById("cart-overlay");
  const closeCartBtn = document.getElementById("close-cart-btn");

  // --- HÀM MỞ GIỎ HÀNG ---
  function openCart() {
    if (!cartSidebar || !cartOverlay) return;

    // Hiện overlay
    cartOverlay.classList.remove("hidden");
    // setTimeout để tạo hiệu ứng fade-in mượt mà
    setTimeout(() => cartOverlay.classList.remove("opacity-0"), 10);

    // Trượt sidebar vào (xóa translate-x-full = về vị trí 0)
    cartSidebar.classList.remove("translate-x-full");
  }

  // --- HÀM ĐÓNG GIỎ HÀNG ---
  function closeCart() {
    if (!cartSidebar || !cartOverlay) return;

    // Trượt sidebar ra ngoài
    cartSidebar.classList.add("translate-x-full");

    // Ẩn overlay
    cartOverlay.classList.add("opacity-0");
    setTimeout(() => {
      cartOverlay.classList.add("hidden");
    }, 300); // Chờ 300ms cho animation chạy xong mới ẩn hẳn
  }

  // --- GẮN SỰ KIỆN ---

  // 1. Gắn sự kiện cho tất cả nút nào có class 'btn-open-cart' (Ví dụ nút giỏ hàng trên header)
  // Bạn nên sửa nút giỏ hàng trong header.php thêm class="btn-open-cart"
  const openBtns = document.querySelectorAll(".btn-open-cart, #cart-count-btn");
  openBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault(); // Chặn link nhảy
      openCart();
    });
  });

  // 2. Sự kiện đóng
  if (closeCartBtn) closeCartBtn.addEventListener("click", closeCart);
  if (cartOverlay) cartOverlay.addEventListener("click", closeCart); // Bấm ra ngoài cũng đóng
});
