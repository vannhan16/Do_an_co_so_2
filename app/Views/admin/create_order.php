<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo đơn hàng mới - DrinkAdmin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#13ec5b",
                        bgLight: "#f8f9fa"
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                },
            },
        }
    </script>
</head>

<body class="bg-bgLight text-gray-800 font-sans h-screen flex overflow-hidden">

    <?php include __DIR__ . '/../layouts/sidebar_admin.php'; ?>

    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <header class="bg-white border-b border-gray-200 h-16 flex items-center px-8 shrink-0">
            <h1 class="text-2xl font-extrabold text-gray-900">Tạo đơn hàng mới</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-8 custom-scroll">

            <form id="create-order-form" action="index.php?page=store_order" method="POST" class="flex flex-col lg:flex-row gap-6">

                <div class="flex-1 space-y-6">

                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Thông tin khách hàng</h2>

                        <div class="flex gap-4 mb-4">
                            <div class="relative flex-1">
                                <i class="fa-regular fa-user absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" placeholder="Tìm khách hàng cũ..." class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none">
                            </div>
                            <button type="button" class="text-primary font-bold text-sm hover:underline whitespace-nowrap">+ Khách mới</button>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Tên khách hàng</label>
                                <input type="text" name="customer_name" id="customer_name" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none" placeholder="Nhập tên...">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Email</label>
                                <input type="email" name="customer_email" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none" placeholder="email@example.com">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm min-h-[400px]">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Danh sách món</h2>

                        <div class="relative mb-6">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400"></i>
                            <input type="text" id="product-search" placeholder="Tìm món ăn (Gõ tên để chọn)..." class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary outline-none">

                            <div id="search-results" class="absolute top-full left-0 w-full bg-white border border-gray-200 rounded-xl shadow-xl mt-2 max-h-60 overflow-y-auto z-50 hidden">
                            </div>
                        </div>

                        <div id="cart-list" class="space-y-4">
                            <p class="text-center text-gray-400 py-4">Chưa có món nào được chọn.</p>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-96 shrink-0">
                    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm sticky top-4">
                        <h2 class="text-lg font-bold text-gray-900 mb-6">Tổng kết đơn hàng</h2>

                        <div class="space-y-3 pb-6 border-b border-gray-100">
                            <div class="flex justify-between text-gray-600 text-sm">
                                <span>Tạm tính</span>
                                <span class="font-medium" id="subtotal-display">0.00VNĐ</span>
                            </div>
                            <div class="flex justify-between text-gray-600 text-sm">
                                <span>Giảm giá</span>
                                <span class="font-medium text-red-500" id="discount-display">-0.00VNĐ</span>
                            </div>
                            <div class="flex justify-between text-gray-600 text-sm">
                                <span>Thuế (5%)</span>
                                <span class="font-medium" id="tax-display">0.00VNĐ</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center py-4">
                            <span class="text-lg font-bold text-gray-900">Tổng cộng</span>
                            <span class="text-2xl font-extrabold text-gray-900" id="total-display">0.00VNĐ</span>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-500 mb-2">Mã giảm giá</label>
                            <div class="flex gap-2">
                                <input type="text" placeholder="Vd: SAVE10" class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:border-primary">
                                <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-4 rounded-lg text-sm transition-colors">Áp dụng</button>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-500 mb-2">Ghi chú đơn hàng</label>
                            <textarea name="order_note" rows="3" placeholder="Vd: Thêm nhiều giấy ăn..." class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none focus:border-primary resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-primary hover:bg-[#0ebc49] text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-500/30 transition-all active:scale-95 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-check"></i> Tạo đơn hàng
                        </button>

                        <input type="hidden" name="cart_data" id="cart-data-input">
                        <input type="hidden" name="total_amount" id="total-amount-input">
                    </div>
                </div>

            </form>
        </div>
    </main>

    <script>
        // 1. Dữ liệu sản phẩm từ PHP (Để JS dùng tìm kiếm)
        const allProducts = <?= json_encode($products) ?>;

        // Hàm định dạng sang tiền Việt Nam (VND)
        function formatVND(amount) {
            // Nếu amount chưa phải số, chuyển sang số
            const num = Number(amount) || 0;
            // Làm tròn về đơn vị đồng (không hiển thị thập phân)
            return new Intl.NumberFormat('vi-VN').format(Math.round(num)) + 'đ';
        }

        let cart = []; // Giỏ hàng hiện tại

        // DOM Elements
        const searchInput = document.getElementById('product-search');
        const searchResults = document.getElementById('search-results');
        const cartList = document.getElementById('cart-list');

        // --- TÌM KIẾM SẢN PHẨM ---
        searchInput.addEventListener('input', function(e) {
            const keyword = e.target.value.toLowerCase();
            searchResults.innerHTML = '';

            if (keyword.length > 0) {
                const filtered = allProducts.filter(p => p.name.toLowerCase().includes(keyword));

                if (filtered.length > 0) {
                    searchResults.classList.remove('hidden');
                    filtered.forEach(p => {
                        const div = document.createElement('div');
                        div.className = 'flex items-center gap-3 p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-0';
                        div.innerHTML = `
                            <img src="${p.image}" class="w-10 h-10 rounded-lg object-cover">
                            <div>
                                <p class="font-bold text-sm text-gray-900">${p.name}</p>
                                <p class="text-xs text-gray-500">${formatVND(p.price)}</p>
                            </div>
                        `;
                        // Sự kiện chọn món
                        div.onclick = () => {
                            addToCart(p);
                            searchInput.value = '';
                            searchResults.classList.add('hidden');
                        };
                        searchResults.appendChild(div);
                    });
                } else {
                    searchResults.innerHTML = '<div class="p-3 text-sm text-gray-500 text-center">Không tìm thấy món nào</div>';
                    searchResults.classList.remove('hidden');
                }
            } else {
                searchResults.classList.add('hidden');
            }
        });

        // Ẩn dropdown khi click ra ngoài
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });

        // --- QUẢN LÝ GIỎ HÀNG ---
        function addToCart(product) {
            const existing = cart.find(item => item.id == product.id);
            if (existing) {
                existing.qty++;
            } else {
                cart.push({
                    ...product,
                    qty: 1
                });
            }
            renderCart();
        }

        function updateQty(index, change) {
            if (cart[index].qty + change > 0) {
                cart[index].qty += change;
            } else {
                if (confirm('Xóa món này?')) cart.splice(index, 1);
            }
            renderCart();
        }

        function removeItem(index) {
            cart.splice(index, 1);
            renderCart();
        }

        function renderCart() {
            cartList.innerHTML = '';
            let subtotal = 0;

            if (cart.length === 0) {
                cartList.innerHTML = '<p class="text-center text-gray-400 py-4">Chưa có món nào được chọn.</p>';
            } else {
                cart.forEach((item, index) => {
                    subtotal += item.price * item.qty;

                    const html = `
                    <div class="flex items-center gap-4 p-3 border border-gray-100 rounded-xl bg-white hover:border-green-200 transition-colors">
                        <img src="${item.image}" class="w-14 h-14 rounded-lg object-cover border border-gray-100">
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 text-sm">${item.name}</h4>
                            <p class="text-xs text-gray-500">${formatVND(item.price)}</p>
                        </div>
                        <div class="flex items-center gap-2 bg-gray-50 rounded-lg p-1">
                            <button type="button" onclick="updateQty(${index}, -1)" class="w-7 h-7 bg-white rounded shadow-sm text-gray-600 hover:text-primary"><i class="fa-solid fa-minus text-xs"></i></button>
                            <span class="text-sm font-bold w-6 text-center select-none">${item.qty}</span>
                            <button type="button" onclick="updateQty(${index}, 1)" class="w-7 h-7 bg-white rounded shadow-sm text-gray-600 hover:text-primary"><i class="fa-solid fa-plus text-xs"></i></button>
                        </div>
                        <div class="text-right w-20">
                            <p class="font-bold text-gray-900 text-sm">${formatVND(item.price * item.qty)}</p>
                        </div>
                        <button type="button" onclick="removeItem(${index})" class="text-gray-400 hover:text-red-500 p-2"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                    `;
                    cartList.innerHTML += html;
                });
            }

            // Tính toán tổng
            const tax = subtotal * 0.05; // 5%
            const discount = 0; // Tạm thời 0
            const total = subtotal + tax - discount;

            document.getElementById('subtotal-display').innerText = formatVND(subtotal);
            document.getElementById('tax-display').innerText = formatVND(tax);
            document.getElementById('total-display').innerText = formatVND(total);

            // Cập nhật input ẩn để gửi lên server
            document.getElementById('cart-data-input').value = JSON.stringify(cart);
            document.getElementById('total-amount-input').value = total;
        }
    </script>

</body>

</html>