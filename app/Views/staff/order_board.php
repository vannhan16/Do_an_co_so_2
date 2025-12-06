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
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
    </style>
</head>

<body class="bg-bgLight h-screen flex overflow-hidden text-gray-800">

    <aside class="w-20 bg-white border-r border-gray-200 flex flex-col items-center py-6 shrink-0 z-20">
        <div class="w-10 h-10 text-primary mb-8"><i class="fa-solid fa-mug-hot text-3xl"></i></div>

        <nav class="flex-1 space-y-6 w-full flex flex-col items-center">
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl bg-green-50 text-primary shadow-sm"><i class="fa-solid fa-border-all text-xl"></i></a>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 hover:bg-gray-50 hover:text-gray-900 transition-colors"><i class="fa-solid fa-clock-rotate-left text-xl"></i></a>
        </nav>

        <a href="index.php?page=logout" class="w-10 h-10 flex items-center justify-center rounded-xl text-red-400 hover:bg-red-50 hover:text-red-600 transition-colors" title="Đăng xuất">
            <i class="fa-solid fa-arrow-right-from-bracket text-xl"></i>
        </a>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 border-r border-gray-200 bg-white">
        <div class="h-16 border-b border-gray-200 flex items-center justify-between px-6 shrink-0">
            <h2 class="text-xl font-bold">Đơn hàng</h2>
            <div class="text-sm font-medium bg-gray-100 px-3 py-1 rounded-full text-gray-600"><?= count($orders) ?> đơn</div>
        </div>

        <div class="px-4 pt-4 border-b border-gray-100">
            <div class="flex gap-6">
                <?php
                // Hàm hỗ trợ style cho Tab active
                function activeTab($current, $target)
                {
                    if ($current === $target) {
                        return 'border-primary text-primary font-bold'; // Style khi được chọn
                    }
                    return 'border-transparent text-gray-500 hover:text-gray-800 font-medium'; // Style thường
                }
                ?>

                <a href="index.php?page=staff&status=all"
                    class="pb-3 border-b-2 text-sm transition-colors <?= activeTab($current_status, 'all') ?>">
                    Tất cả
                </a>

                <a href="index.php?page=staff&status=pending"
                    class="pb-3 border-b-2 text-sm transition-colors <?= activeTab($current_status, 'pending') ?>">
                    Chờ xử lý
                </a>

                <a href="index.php?page=staff&status=processing"
                    class="pb-3 border-b-2 text-sm transition-colors <?= activeTab($current_status, 'processing') ?>">
                    Đang pha
                </a>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scroll bg-gray-50">
            <?php foreach ($orders as $index => $o): ?>
                <?php
                // Màu sắc thẻ theo trạng thái
                $statusColor = 'bg-white border-l-4 border-l-yellow-400'; // Pending
                $badge = '<span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-bold rounded">Chờ xử lý</span>';

                if ($o['status'] == 'processing') {
                    $statusColor = 'bg-white border-l-4 border-l-blue-500';
                    $badge = '<span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded">Đang pha</span>';
                }
                if ($o['status'] == 'completed') {
                    $statusColor = 'bg-gray-50 border-l-4 border-l-green-500 opacity-70';
                    $badge = '<span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded">Hoàn thành</span>';
                }
                ?>

                <div onclick='selectOrder(<?= json_encode($o) ?>, this)'
                    class="order-card cursor-pointer p-4 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all <?= $statusColor ?>">

                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="font-bold text-gray-900">#<?= $o['id'] ?></span>
                            <span class="text-xs text-gray-500 ml-2"><?= date('H:i', strtotime($o['created_at'])) ?></span>
                        </div>
                        <?= $badge ?>
                    </div>

                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-sm font-bold text-gray-800"><?= $o['customer_name'] ?: 'Khách lẻ' ?></p>
                            <?php if ($o['table_name']): ?>
                                <p class="text-xs text-gray-500 mt-0.5"><i class="fa-solid fa-chair mr-1"></i> <?= $o['table_name'] ?></p>
                            <?php endif; ?>
                        </div>
                        <p class="font-bold text-primary"><?= number_format($o['total_amount'], 0, ',', '.') ?>đ</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <aside class="w-96 bg-white flex flex-col shrink-0 h-full shadow-xl z-10">
        <div id="empty-state" class="flex-1 flex flex-col items-center justify-center text-gray-400 p-8 text-center">
            <i class="fa-solid fa-receipt text-6xl mb-4 opacity-20"></i>
            <p>Chọn một đơn hàng để xem chi tiết và thao tác.</p>
        </div>

        <div id="detail-content" class="hidden flex-col h-full">

            <div class="h-16 border-b border-gray-200 flex items-center justify-between px-6 shrink-0 bg-gray-50">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg" id="detail-id">...</h3>
                    <p class="text-xs text-gray-500" id="detail-time">...</p>
                </div>
                <div id="detail-status-badge"></div>
            </div>

            <div class="px-6 py-4 border-b border-gray-100 bg-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500"><i class="fa-solid fa-user"></i></div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm" id="detail-customer">...</p>
                        <p class="text-xs text-gray-500" id="detail-note">...</p>
                    </div>
                </div>
            </div>

            <div id="detail-items" class="flex-1 overflow-y-auto p-6 space-y-4 custom-scroll">
            </div>

            <div class="p-6 border-t border-gray-100 bg-gray-50">
                <div class="flex justify-between text-lg font-bold text-gray-900 mb-4">
                    <span>Tổng cộng</span>
                    <span id="detail-total" class="text-primary">0đ</span>
                </div>

                <div id="action-buttons" class="grid gap-3">
                </div>
            </div>
        </div>
    </aside>

    <script>
        const formatMoney = (amount) => new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount);

        function selectOrder(order, card) {
            // 1. Highlight Card
            document.querySelectorAll('.order-card').forEach(c => c.classList.remove('ring-2', 'ring-primary', 'bg-green-50'));
            card.classList.add('ring-2', 'ring-primary', 'bg-green-50');

            // 2. Hiện khung chi tiết
            document.getElementById('empty-state').classList.add('hidden');
            document.getElementById('detail-content').classList.remove('hidden');
            document.getElementById('detail-content').classList.add('flex');

            // 3. Điền thông tin cơ bản
            document.getElementById('detail-id').innerText = '#' + order.id;
            document.getElementById('detail-time').innerText = order.created_at;
            document.getElementById('detail-customer').innerText = order.customer_name + (order.table_name ? ` (${order.table_name})` : '');
            document.getElementById('detail-note').innerText = order.note ? `Ghi chú: ${order.note}` : 'Không có ghi chú';
            document.getElementById('detail-total').innerText = formatMoney(order.total_amount);

            // 4. Lấy danh sách món (AJAX)
            const itemsContainer = document.getElementById('detail-items');
            itemsContainer.innerHTML = '<p class="text-center text-gray-400 text-sm">Đang tải món...</p>';

            fetch(`index.php?page=staff_get_detail&id=${order.id}`)
                .then(res => res.json())
                .then(items => {
                    let html = '';
                    items.forEach(item => {
                        html += `
                            <div class="flex justify-between items-start border-b border-gray-50 pb-2 last:border-0">
                                <div class="flex gap-3">
                                    <span class="font-bold text-gray-500 text-sm">${item.quantity}x</span>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">${item.product_name}</p>
                                        ${item.note ? `<p class="text-xs text-gray-400 italic">${item.note}</p>` : ''}
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-gray-700">${formatMoney(item.price * item.quantity)}</span>
                            </div>
                        `;
                    });
                    itemsContainer.innerHTML = html;
                });

            // 5. Cập nhật nút bấm theo trạng thái
            const btnContainer = document.getElementById('action-buttons');
            let btns = '';

            if (order.status == 'pending') {
                btns = `
                    <a href="index.php?page=staff_update_status&id=${order.id}&status=processing" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-center shadow-lg transition-colors">
                        <i class="fa-solid fa-fire-burner mr-2"></i> Bắt đầu pha chế
                    </a>
                    <a href="index.php?page=staff_update_status&id=${order.id}&status=cancelled" class="w-full py-3 bg-white border border-red-200 text-red-600 font-bold rounded-xl text-center hover:bg-red-50 transition-colors">
                        Hủy đơn
                    </a>
                `;
            } else if (order.status == 'processing') {
                btns = `
                    <a href="index.php?page=staff_update_status&id=${order.id}&status=completed" class="w-full py-3 bg-primary hover:bg-[#0ebc49] text-white font-bold rounded-xl text-center shadow-lg shadow-green-500/30 transition-colors">
                        <i class="fa-solid fa-check mr-2"></i> Hoàn thành & Thu tiền
                    </a>
                `;
            } else {
                btns = `
                    <button disabled class="w-full py-3 bg-gray-100 text-gray-400 font-bold rounded-xl text-center cursor-not-allowed">
                        Đơn đã hoàn tất
                    </button>
                `;
            }
            btnContainer.innerHTML = btns;
        }
    </script>
</body>

</html>