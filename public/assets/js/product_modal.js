// public/assets/js/product_modal.js

let currentProduct = {};
let currentSizePrice = 5000; // Mặc định size M (+5000)
let currentSizeName = "M";
let currentQty = 1;

// 1. HÀM MỞ MODAL
function openProductModal(product) {
  currentProduct = product;
  currentQty = 1;
  currentSizePrice = 5000; // Reset về mặc định
  currentSizeName = "M";

  // Reset giao diện
  document.getElementById("modal-img").src = product.img;
  document.getElementById("modal-name").innerText = product.name;
  document.getElementById("modal-desc").innerText =
    "Mô tả ngon lành cành đào cho món " + product.name;
  document.getElementById("modal-price").innerText = formatMoney(product.price);
  document.getElementById("modal-qty").innerText = "1";
  document.getElementById("modal-note").value = "";

  // Reset checkboxes
  document
    .querySelectorAll(".addon-checkbox")
    .forEach((cb) => (cb.checked = false));

  // Reset Size buttons (Set M active)
  document.querySelectorAll(".size-btn").forEach((btn) => {
    btn.classList.remove(
      "border-primary",
      "bg-green-50",
      "text-primary",
      "font-bold"
    );
    btn.classList.add("border-gray-200", "text-gray-600");
    if (btn.innerText === "Medium") {
      btn.classList.add(
        "border-primary",
        "bg-green-50",
        "text-primary",
        "font-bold"
      );
    }
  });

  // Tính giá lần đầu
  calculateModalPrice();

  // Hiện Modal
  const modal = document.getElementById("product-modal");
  const overlay = document.getElementById("modal-overlay");
  modal.classList.remove("hidden");
  overlay.classList.remove("hidden");
  // Animation fade in
  setTimeout(() => {
    modal.classList.remove("opacity-0");
    overlay.classList.remove("opacity-0");
  }, 10);
}

// 2. HÀM ĐÓNG MODAL
function closeModal() {
  const modal = document.getElementById("product-modal");
  const overlay = document.getElementById("modal-overlay");
  modal.classList.add("opacity-0");
  overlay.classList.add("opacity-0");
  setTimeout(() => {
    modal.classList.add("hidden");
    overlay.classList.add("hidden");
  }, 300);
}

// 3. CHỌN SIZE
function selectSize(size, price, btn) {
  currentSizeName = size;
  currentSizePrice = price;

  // Update UI active state
  document.querySelectorAll(".size-btn").forEach((b) => {
    b.classList.remove(
      "border-primary",
      "bg-green-50",
      "text-primary",
      "font-bold"
    );
    b.classList.add("border-gray-200", "text-gray-600");
  });
  btn.classList.remove("border-gray-200", "text-gray-600");
  btn.classList.add(
    "border-primary",
    "bg-green-50",
    "text-primary",
    "font-bold"
  );

  calculateModalPrice();
}

// 4. TĂNG GIẢM SỐ LƯỢNG
function updateModalQty(change) {
  currentQty += change;
  if (currentQty < 1) currentQty = 1;
  document.getElementById("modal-qty").innerText = currentQty;
  calculateModalPrice();
}

// 5. TÍNH TỔNG TIỀN (Real-time)
function calculateModalPrice() {
  let basePrice = currentProduct.price;

  // Cộng tiền Topping
  let toppingPrice = 0;
  document.querySelectorAll(".addon-checkbox:checked").forEach((cb) => {
    toppingPrice += parseInt(cb.value);
  });

  let unitPrice = basePrice + currentSizePrice + toppingPrice;
  let totalPrice = unitPrice * currentQty;

  document.getElementById("btn-total-price").innerText =
    formatMoney(totalPrice);
}

// Lắng nghe sự kiện click checkbox để tính lại tiền
document.addEventListener("change", (e) => {
  if (e.target.classList.contains("addon-checkbox")) {
    calculateModalPrice();
  }
});

// 6. THÊM VÀO GIỎ HÀNG (Gọi hàm addToCart gốc)
function addToCartFromModal() {
  // Thu thập tên Topping
  let toppings = [];
  let toppingPrice = 0;
  document.querySelectorAll(".addon-checkbox:checked").forEach((cb) => {
    toppings.push(cb.dataset.name);
    toppingPrice += parseInt(cb.value);
  });

  const note = document.getElementById("modal-note").value;

  // Tạo object sản phẩm đầy đủ
  const finalProduct = {
    id: currentProduct.id, // Lưu ý: Nếu muốn tách dòng trong giỏ hàng, id nên là: id_size_toppings
    name: `${currentProduct.name} (${currentSizeName})`,
    price: currentProduct.price + currentSizePrice + toppingPrice, // Giá đã cộng size + topping
    img: currentProduct.img,
    qty: currentQty,
    note: note + (toppings.length > 0 ? " - Thêm: " + toppings.join(", ") : ""),
  };

  // Gọi hàm addToCart trong cart.js
  addToCart(finalProduct);

  // Đóng modal
  closeModal();
}
