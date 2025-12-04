// public/assets/js/product_modal.js

// 1. KHAI BÁO BIẾN TOÀN CỤC (Lưu trạng thái món đang chọn)
let currentProduct = {};
let currentSizePrice = 0;
let currentSizeName = "S";
let currentQty = 1;

// Hàm format tiền Việt
const fmtMoney = (amount) => {
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(amount);
};

// 2. HÀM MỞ MODAL (Được gọi khi bấm dấu cộng ở menu)
function openProductModal(product) {
  console.log("Đang mở món:", product);

  // Reset trạng thái
  currentProduct = product;
  currentQty = 1;
  currentSizePrice = 0; // Mặc định size S (0đ)
  currentSizeName = "S";

  // Reset giao diện HTML
  document.getElementById("modal-name").innerText = product.name;
  document.getElementById("modal-price").innerText = fmtMoney(product.price);
  if (product.description && product.description.trim() !== "") {
    document.getElementById("modal-desc").innerText = product.description;
  } else {
    document.getElementById("modal-desc").innerText =
      "Món này chưa có mô tả chi tiết.";
  }
  document.getElementById("modal-qty").innerText = "1";
  document.getElementById("modal-note").value = "";

  // Xử lý ảnh (Nếu lỗi thì hiện ảnh mặc định)
  const imgEl = document.getElementById("modal-img");
  imgEl.src = product.img;
  imgEl.onerror = function () {
    this.src = "https://via.placeholder.com/400x400?text=No+Image";
  };

  // Reset Checkbox Topping (Bỏ chọn hết)
  document
    .querySelectorAll(".addon-checkbox")
    .forEach((cb) => (cb.checked = false));

  // Reset Nút Size (Về mặc định Size S)
  document.querySelectorAll(".size-btn").forEach((btn) => {
    // Xóa class active (màu xanh)
    btn.classList.remove(
      "border-primary",
      "bg-green-50",
      "text-primary",
      "font-bold"
    );
    // Thêm class thường (màu xám)
    btn.classList.add("border-gray-200", "text-gray-600");

    // Nếu là nút S thì active lên
    if (btn.innerText.trim() === "S" || btn.innerText.trim() === "Small") {
      btn.classList.remove("border-gray-200", "text-gray-600");
      btn.classList.add(
        "border-primary",
        "bg-green-50",
        "text-primary",
        "font-bold"
      );
    }
  });

  // Tính lại giá tổng
  calculateModalPrice();

  // Hiện Modal
  const modal = document.getElementById("product-modal");
  const overlay = document.getElementById("modal-overlay");
  if (modal && overlay) {
    modal.classList.remove("hidden");
    overlay.classList.remove("hidden");
    setTimeout(() => {
      modal.classList.remove("opacity-0");
      overlay.classList.remove("opacity-0");
    }, 10);
  }
}

// 3. HÀM ĐÓNG MODAL
function closeModal() {
  const modal = document.getElementById("product-modal");
  const overlay = document.getElementById("modal-overlay");
  if (modal && overlay) {
    modal.classList.add("opacity-0");
    overlay.classList.add("opacity-0");
    setTimeout(() => {
      modal.classList.add("hidden");
      overlay.classList.add("hidden");
    }, 300);
  }
}

// 4. HÀM CHỌN SIZE (Xử lý khi bấm nút S, M, L)
function selectSize(size, price, btnElement) {
  // Cập nhật biến toàn cục
  currentSizeName = size;
  currentSizePrice = parseInt(price);

  // Reset style tất cả nút size
  document.querySelectorAll(".size-btn").forEach((b) => {
    b.classList.remove(
      "border-primary",
      "bg-green-50",
      "text-primary",
      "font-bold"
    );
    b.classList.add("border-gray-200", "text-gray-600");
  });

  // Active nút vừa bấm
  btnElement.classList.remove("border-gray-200", "text-gray-600");
  btnElement.classList.add(
    "border-primary",
    "bg-green-50",
    "text-primary",
    "font-bold"
  );

  // Tính lại tiền
  calculateModalPrice();
}

// 5. HÀM TĂNG GIẢM SỐ LƯỢNG
function updateModalQty(change) {
  let newQty = currentQty + change;
  if (newQty < 1) newQty = 1;
  currentQty = newQty;

  document.getElementById("modal-qty").innerText = currentQty;
  calculateModalPrice();
}

// 6. HÀM TÍNH TỔNG TIỀN (Chạy mỗi khi đổi size/topping/số lượng)
function calculateModalPrice() {
  let basePrice = parseInt(currentProduct.price);

  // Cộng tiền Topping
  let toppingPrice = 0;
  document.querySelectorAll(".addon-checkbox:checked").forEach((cb) => {
    toppingPrice += parseInt(cb.value);
  });

  // Công thức: (Giá gốc + Giá Size + Giá Topping) * Số lượng
  let unitPrice = basePrice + currentSizePrice + toppingPrice;
  let totalPrice = unitPrice * currentQty;

  // Hiển thị lên nút bấm
  document.getElementById("btn-total-price").innerText = fmtMoney(totalPrice);
}

// Lắng nghe sự kiện check topping để tính lại tiền ngay lập tức
document.addEventListener("change", (e) => {
  if (e.target.classList.contains("addon-checkbox")) {
    calculateModalPrice();
  }
});

// 7. HÀM THÊM VÀO GIỎ (Kết nối với cart.js)
function addToCartFromModal() {
  // Lấy danh sách tên Topping đã chọn
  let toppings = [];
  let toppingPrice = 0;
  document.querySelectorAll(".addon-checkbox:checked").forEach((cb) => {
    toppings.push(cb.getAttribute("data-name")); // Lấy tên topping
    toppingPrice += parseInt(cb.value);
  });

  const note = document.getElementById("modal-note").value;

  // Tạo ID duy nhất (để phân biệt: Trà sữa Size M khác Trà sữa Size L)
  const uniqueId = `${currentProduct.id}-${currentSizeName}-${toppings.join(
    ""
  )}`;

  // Tạo object sản phẩm hoàn chỉnh để gửi sang Cart
  const finalProduct = {
    unique_id: uniqueId,
    id: currentProduct.id,
    name: `${currentProduct.name} (${currentSizeName})`,
    price: parseInt(currentProduct.price) + currentSizePrice + toppingPrice,
    img: currentProduct.img,
    qty: currentQty,
    // Gộp ghi chú và topping vào làm một dòng mô tả
    note:
      (toppings.length > 0 ? "Topping: " + toppings.join(", ") : "") +
      (note ? ". Note: " + note : ""),
  };

  console.log("Thêm vào giỏ:", finalProduct);

  // Gọi hàm addToCart (Hàm này nằm bên file cart.js)
  if (typeof window.addToCart === "function") {
    window.addToCart(finalProduct);
  } else {
    alert("Lỗi: Không tìm thấy hàm addToCart trong cart.js");
  }

  closeModal();
}
