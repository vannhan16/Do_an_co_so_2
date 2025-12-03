<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thu Ngân - Drinky POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#13ec5b",
                        secondary: "#102216",
                        bgLight: "#f3f4f6"
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                },
            },
        }
    </script>
    <style>
        /* Tùy chỉnh thanh cuộn cho gọn */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
    </style>
</head>

<body class="bg-bgLight h-screen flex overflow-hidden text-gray-800">

    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between shrink-0">
        <div>
            <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-100">
                <div class="w-8 h-8 text-primary bg-green-50 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-mug-hot"></i>
                </div>
                <div>
                    <h1 class="font-bold text-gray-900">Drinky POS</h1>
                    <p class="text-xs text-gray-500">Thu Ngân</p>
                </div>
            </div>

            <nav class="p-4 space-y-1">
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-green-50 text-primary font-medium rounded-xl">
                    <i class="fa-solid fa-border-all text-lg"></i> Tổng quan
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium rounded-xl transition-colors">
                    <i class="fa-solid fa-clock-rotate-left text-lg"></i> Lịch sử đơn
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium rounded-xl transition-colors">
                    <i class="fa-solid fa-gear text-lg"></i> Cài đặt
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-gray-100">
            <a href="index.php?page=logout" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-red-500 font-medium transition-colors">
                <i class="fa-solid fa-arrow-right-from-bracket text-lg"></i> Đăng xuất
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 border-r border-gray-200 bg-white">
        <div class="h-16 border-b border-gray-200 flex items-center justify-between px-6 shrink-0">
            <h2 class="text-xl font-bold">Đơn hàng</h2>
            <div class="text-sm text-gray-500"><?= date('d/m/Y') ?></div>
        </div>

        <div class="p-4 border-b border-gray-100 space-y-4">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
                <input type="text" placeholder="Tìm theo mã đơn hoặc tên khách..." class="w-full pl-10 pr-4 py-2.5 bg-gray-100 border-none rounded-lg focus:ring-2 focus:ring-primary text-sm">
            </div>
            <div class="flex gap-6 border-b border-gray-100">
                <button class="pb-2 border-b-2 border-primary text-primary font-bold text-sm">Mới (3)</button>
                <button class="pb-2 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium text-sm">Đang pha (1)</button>
                <button class="pb-2 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium text-sm">Sẵn sàng (0)</button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scroll">
            <?php foreach ($orders as $index => $order): ?>
                <div onclick="selectOrder(<?= htmlspecialchars(json_encode($order)) ?>, this)"
                    class="order-card p-4 rounded-xl border-2 cursor-pointer transition-all hover:shadow-md 
                     <?= $index === 0 ? 'border-primary bg-green-50' : 'border-gray-100 bg-white hover:border-green-200' ?>">

                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="font-bold text-gray-900 text-lg">#<?= $order['id'] ?></span>
                            <p class="text-sm text-gray-500"><?= $order['customer'] ?></p>
                        </div>
                        <span class="px-2 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded">Mới</span>
                    </div>

                    <div class="flex justify-between items-end mt-4">
                        <p class="text-sm text-gray-500"><?= $order['items_count'] ?> món</p>
                        <p class="font-bold text-lg text-gray-900"><?= number_format($order['total']) ?>đ</p>
                    </div>
                    <p class="text-xs text-right text-gray-400 mt-1"><?= $order['time'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <aside class="w-96 bg-white flex flex-col shrink-0">
        <div class="h-16 border-b border-gray-200 flex items-center justify-between px-6 shrink-0 bg-gray-50">
            <div>
                <h3 class="font-bold text-gray-900" id="detail-id">Chọn đơn hàng</h3>
                <p class="text-xs text-gray-500" id="detail-customer">...</p>
            </div>
            <button class="p-2 bg-white rounded-full shadow-sm text-gray-400 hover:text-gray-600"><i class="fa-solid fa-ellipsis-vertical"></i></button>
        </div>

        <div id="detail-items" class="flex-1 overflow-y-auto p-6 space-y-6 custom-scroll">
            <div class="text-center text-gray-400 mt-10">
                <i class="fa-solid fa-basket-shopping text-4xl mb-2"></i>
                <p>Vui lòng chọn đơn hàng bên trái</p>
            </div>
        </div>

        <div class="p-6 border-t border-gray-100 bg-gray-50">
            <div class="space-y-3 mb-6">
                <div class="flex justify-between text-gray-600">
                    <span>Tổng tiền hàng</span>
                    <span class="font-medium" id="detail-subtotal">0đ</span>
                </div>
                <div class="flex justify-between text-xl font-bold text-gray-900">
                    <span>Thanh toán</span>
                    <span id="detail-total">0đ</span>
                </div>
                <div class="flex justify-between items-center bg-white p-2 rounded-lg border border-gray-200">
                    <span class="text-xs text-gray-500 uppercase font-bold">Trạng thái</span>
                    <span class="text-sm font-bold text-green-600 flex items-center gap-1" id="detail-payment">
                        <i class="fa-solid fa-circle-check"></i> ...
                    </span>
                </div>
            </div>

            <button class="w-full py-3.5 bg-primary text-white font-bold rounded-xl shadow-lg shadow-green-500/30 hover:bg-[#0ebc49] transition-all active:scale-95 flex items-center justify-center gap-2">
                <i class="fa-solid fa-check"></i> Xác nhận đơn hàng
            </button>

            <div class="grid grid-cols-2 gap-3 mt-3">
                <button class="py-2.5 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    <i class="fa-solid fa-truck-fast mr-1"></i> Cập nhật
                </button>
                <button class="py-2.5 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    <i class="fa-solid fa-print mr-1"></i> In hóa đơn
                </button>
            </div>
        </div>
    </aside>

    <script>
        // Hàm format tiền tệ
        const formatMoney = (amount) => {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
        };

        // Hàm chọn đơn hàng
        function selectOrder(orderData, cardElement) {
            // 1. Highlight thẻ được chọn
            document.querySelectorAll('.order-card').forEach(c => {
                c.classList.remove('border-primary', 'bg-green-50');
                c.classList.add('border-gray-100', 'bg-white');
            });
            cardElement.classList.remove('border-gray-100', 'bg-white');
            cardElement.classList.add('border-primary', 'bg-green-50');

            // 2. Điền dữ liệu vào cột phải
            document.getElementById('detail-id').innerText = 'Đơn #' + orderData.id;
            document.getElementById('detail-customer').innerText = 'Khách: ' + orderData.customer;
            document.getElementById('detail-subtotal').innerText = formatMoney(orderData.total);
            document.getElementById('detail-total').innerText = formatMoney(orderData.total);
            document.getElementById('detail-payment').innerHTML = `<i class="fa-solid fa-circle-check"></i> ${orderData.payment_status}`;

            // 3. Render danh sách món
            const itemsContainer = document.getElementById('detail-items');
            itemsContainer.innerHTML = '';

            orderData.items.forEach(item => {
                itemsContainer.innerHTML += `
                    <div class="flex justify-between items-start">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-sm shrink-0">
                                ${item.qty}x
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">${item.name}</h4>
                                ${item.note ? `<p class="text-xs text-gray-500 italic">Note: ${item.note}</p>` : ''}
                            </div>
                        </div>
                        <span class="font-medium text-gray-900">${formatMoney(item.price * item.qty)}</span>
                    </div>
                `;
            });
        }

        // Tự động chọn đơn đầu tiên khi vào trang
        document.addEventListener('DOMContentLoaded', () => {
            const firstCard = document.querySelector('.order-card');
            if (firstCard) firstCard.click();
        });
    </script>
</body>

</html>