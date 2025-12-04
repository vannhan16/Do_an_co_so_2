// public/assets/js/cart.js

// 1. CẤU HÌNH & KHỞI TẠO
const CART_KEY = "drinky_cart_v1";
let cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];

// Định dạng tiền tệ VNĐ
const formatMoney = (amount) => {
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(amount);
};

// 2. CÁC HÀM XỬ LÝ (GLOBAL)
// Hàm bật/tắt giỏ hàng
window.toggleCart = function () {
  const drawer = document.getElementById("cart-drawer");
  const overlay = document.getElementById("cart-overlay");

  if (!drawer || !overlay) return;

  if (drawer.classList.contains("translate-x-full")) {
    // Mở ra
    drawer.classList.remove("translate-x-full");
    overlay.classList.remove("hidden");
    setTimeout(() => overlay.classList.remove("opacity-0"), 10);
  } else {
    // Đóng lại
    drawer.classList.add("translate-x-full");
    overlay.classList.add("opacity-0");
    setTimeout(() => overlay.classList.add("hidden"), 300);
  }
};

// Hàm thêm sản phẩm
window.addToCart = function (product) {
  const existing = cart.find((item) => item.id == product.id);
  if (existing) {
    existing.qty += 1;
  } else {
    cart.push({ ...product, qty: 1 });
  }
  saveAndRender();

  // Mở giỏ hàng ngay khi thêm (tùy chọn)
  const drawer = document.getElementById("cart-drawer");
  if (drawer.classList.contains("translate-x-full")) {
    window.toggleCart();
  }
};

// Hàm xóa/tăng giảm
window.updateItem = function (id, action) {
  const index = cart.findIndex((item) => item.id == id);
  if (index === -1) return;

  if (action === "increase") {
    cart[index].qty++;
  } else if (action === "decrease") {
    cart[index].qty--;
    if (cart[index].qty <= 0) cart.splice(index, 1);
  } else if (action === "remove") {
    cart.splice(index, 1);
  }
  saveAndRender();
};

// Lưu và Vẽ lại giao diện
function saveAndRender() {
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
  renderCartDrawer();
  updateCartIconCount();
}

function renderCartDrawer() {
  const listEl = document.getElementById("cart-items-list");
  const totalEl = document.getElementById("drawer-total");
  const countEl = document.getElementById("drawer-count");

  if (!listEl) return;

  // Tính tổng
  let total = 0;
  let totalQty = 0;

  if (cart.length === 0) {
    listEl.innerHTML = `
            <div class="flex flex-col items-center justify-center h-64 text-gray-400">
                <i class="fa-solid fa-basket-shopping text-4xl mb-3 opacity-50"></i>
                <p>Giỏ hàng đang trống</p>
                <button onclick="toggleCart()" class="text-primary font-medium mt-2 hover:underline">Tiếp tục xem menu</button>
            </div>`;
    totalEl.innerText = formatMoney(0);
    countEl.innerText = 0;
    return;
  }

  // Vẽ HTML
  listEl.innerHTML = cart
    .map((item) => {
      total += item.price * item.qty;
      totalQty += item.qty;
      return `
        <div class="flex gap-4 p-3 bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition-shadow">
            <div class="w-16 h-16 shrink-0 rounded-lg overflow-hidden border border-gray-100">
                <img src="${item.img}" class="w-full h-full object-cover">
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-bold text-gray-800 line-clamp-1" title="${
                  item.name
                }">${item.name}</h4>
                <p class="text-xs text-gray-500 mb-2">${formatMoney(
                  item.price
                )}</p>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-1">
                        <button onclick="updateItem('${
                          item.id
                        }', 'decrease')" class="w-5 h-5 flex items-center justify-center bg-white rounded shadow-sm text-gray-600 hover:text-primary transition-colors text-xs"><i class="fa-solid fa-minus"></i></button>
                        <span class="text-xs font-bold w-3 text-center">${
                          item.qty
                        }</span>
                        <button onclick="updateItem('${
                          item.id
                        }', 'increase')" class="w-5 h-5 flex items-center justify-center bg-white rounded shadow-sm text-gray-600 hover:text-primary transition-colors text-xs"><i class="fa-solid fa-plus"></i></button>
                    </div>
                    <button onclick="updateItem('${
                      item.id
                    }', 'remove')" class="text-gray-300 hover:text-red-500 transition-colors p-1">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </div>
            </div>
        </div>
        `;
    })
    .join("");

  totalEl.innerText = formatMoney(total);
  countEl.innerText = totalQty;
}

function updateCartIconCount() {
  const iconBadge = document.getElementById("cart-count"); // Badge trên Header
  if (iconBadge) {
    const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
    iconBadge.innerText = totalQty;
    iconBadge.classList.toggle("hidden", totalQty === 0);
  }
}
// public/assets/js/cart.js

// ... (Các hàm toggleCart, addToCart, renderCart... giữ nguyên như cũ) ...

// --- THÊM/SỬA HÀM NÀY Ở CUỐI FILE ---

window.processCheckout = function () {
  // 1. Kiểm tra giỏ hàng
  if (cart.length === 0) {
    alert("Giỏ hàng đang trống!");
    return;
  }

  // 2. Lấy thông tin từ các ô Input trong cart_drawer.php
  const nameEl = document.getElementById("cust-name");
  const tableEl = document.getElementById("cust-table");
  const noteEl = document.getElementById("cust-note");

  // Kiểm tra xem các ô input có tồn tại không (Tránh lỗi null)
  if (!nameEl || !tableEl) {
    alert("Lỗi giao diện: Không tìm thấy ô nhập tên/bàn.");
    return;
  }

  const name = nameEl.value.trim();
  const table = tableEl.value.trim();
  const note = noteEl ? noteEl.value.trim() : "";

  if (name === "" || table === "") {
    alert("Vui lòng nhập Tên và Số bàn để chúng tôi phục vụ!");
    return;
  }

  // 3. Tính tổng tiền
  const totalAmount = cart.reduce(
    (sum, item) => sum + item.price * item.qty,
    0
  );

  // 4. Đóng gói dữ liệu
  const orderData = {
    customer_name: name + " (Bàn " + table + ")",
    note: note,
    total_amount: totalAmount,
    cart_items: cart,
  };

  // 5. Hiệu ứng nút bấm
  const btn = event.currentTarget;
  const originalText = btn.innerHTML;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang gửi...';
  btn.disabled = true;

  // 6. Gửi AJAX
  fetch("index.php?page=checkout_submit", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(orderData),
  })
    .then((response) => response.json()) // Chuyển phản hồi về JSON
    .then((data) => {
      if (data.success) {
        // Thành công
        localStorage.removeItem(CART_KEY); // Xóa giỏ hàng cũ
        cart = [];
        renderCartDrawer();
        updateCartIconCount();
        toggleCart(); // Đóng sidebar

        alert("Đặt món thành công! Vui lòng chờ nhân viên xác nhận.");
        window.location.href = "index.php?page=tracking"; // Chuyển trang
      } else {
        // Thất bại
        alert("Lỗi: " + data.message);
        btn.innerHTML = originalText;
        btn.disabled = false;
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Có lỗi xảy ra. Vui lòng thử lại!");
      btn.innerHTML = originalText;
      btn.disabled = false;
    });
};
// 3. KHỞI CHẠY
document.addEventListener("DOMContentLoaded", () => {
  saveAndRender();
});
