<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đơn hàng - DrinkAdmin</title>
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
                        bgLight: "#f8f9fa",
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                },
            },
        }
    </script>
</head>

<body class="bg-bgLight text-gray-800 font-sans">

    <div class="flex h-screen overflow-hidden">

        <?php include __DIR__ . '/../layouts/sidebar_admin.php'; ?>

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 shrink-0">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Quản lý Đơn hàng</h1>
                    <p class="text-sm text-gray-500">Theo dõi và xử lý đơn hàng</p>
                </div>
                <a href="index.php?page=admin_create_order" class="bg-primary hover:bg-[#0ebc49] text-white font-bold py-2.5 px-6 rounded-lg shadow-lg flex items-center gap-2 transition-all active:scale-95">
                    <i class="fa-solid fa-plus"></i> Tạo đơn mới
                </a>
            </header>

            <div class="flex-1 overflow-y-auto p-8 custom-scroll">

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-bold">
                            <tr>
                                <th class="px-6 py-4">Mã đơn</th>
                                <th class="px-6 py-4">Khách hàng / Bàn</th>
                                <th class="px-6 py-4">Thời gian</th>
                                <th class="px-6 py-4">Tổng tiền</th>
                                <th class="px-6 py-4">Trạng thái</th>
                                <th class="px-6 py-4 text-right">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $o): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-gray-900">#<?= $o['id'] ?></td>
                                        <td class="px-6 py-4 text-gray-700">
                                            <?= $o['customer_name'] ?: 'Khách vãng lai' ?>
                                            <?php if ($o['table_name']): ?>
                                                <span class="ml-2 px-2 py-0.5 bg-gray-100 rounded text-xs font-bold text-gray-600"><?= $o['table_name'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500"><?= date('H:i d/m/Y', strtotime($o['created_at'])) ?></td>
                                        <td class="px-6 py-4 font-bold text-gray-900"><?= number_format($o['total_amount'], 0, ',', '.') ?>đ</td>
                                        <td class="px-6 py-4">
                                            <?php
                                            $stt = $o['status'];
                                            $color = 'bg-gray-100 text-gray-600';
                                            $label = 'Chờ xử lý';

                                            if ($stt == 'processing') {
                                                $color = 'bg-blue-100 text-blue-700';
                                                $label = 'Đang pha';
                                            }
                                            if ($stt == 'completed') {
                                                $color = 'bg-green-100 text-green-700';
                                                $label = 'Hoàn thành';
                                            }
                                            if ($stt == 'cancelled') {
                                                $color = 'bg-red-100 text-red-700';
                                                $label = 'Đã hủy';
                                            }
                                            ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold <?= $color ?>"><?= $label ?></span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <button onclick="viewOrderDetails(<?= $o['id'] ?>)" class="text-gray-400 hover:text-blue-600" title="Xem chi tiết">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>

                                                <?php if ($stt == 'pending'): ?>
                                                    <a href="index.php?page=update_order_status&id=<?= $o['id'] ?>&status=processing" class="text-gray-400 hover:text-green-600" title="Nhận đơn"><i class="fa-solid fa-circle-play"></i></a>
                                                <?php elseif ($stt == 'processing'): ?>
                                                    <a href="index.php?page=update_order_status&id=<?= $o['id'] ?>&status=completed" class="text-gray-400 hover:text-green-600" title="Hoàn thành"><i class="fa-solid fa-circle-check"></i></a>
                                                <?php endif; ?>

                                                <a href="index.php?page=delete_order&id=<?= $o['id'] ?>" onclick="return confirm('Xóa đơn này?')" class="text-gray-400 hover:text-red-500"><i class="fa-solid fa-trash-can"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Chưa có đơn hàng nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>

</html>