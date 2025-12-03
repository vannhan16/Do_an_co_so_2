<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo Doanh thu - DrinkAdmin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Báo cáo Doanh thu</h1>
                <p class="text-xs text-gray-500">Tổng hợp tình hình kinh doanh</p>
            </div>
            <button class="bg-white border border-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg text-sm hover:bg-gray-50">
                <i class="fa-solid fa-download mr-2"></i> Xuất Excel
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-8 custom-scroll">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-gray-500 text-sm font-medium">Tổng doanh thu</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-2">
                        <?= number_format($metrics['revenue'], 0, ',', '.') ?> ₫
                    </h3>
                    <span class="text-xs font-bold text-green-500 flex items-center gap-1 mt-1">
                        <i class="fa-solid fa-arrow-trend-up"></i> Tăng trưởng
                    </span>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-gray-500 text-sm font-medium">Tổng đơn hàng</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-2"><?= $metrics['transactions'] ?></h3>
                    <span class="text-xs font-bold text-green-500 flex items-center gap-1 mt-1">
                        <i class="fa-solid fa-check"></i> Đã hoàn thành
                    </span>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-gray-500 text-sm font-medium">Giá trị TB đơn</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-2">
                        <?= number_format($metrics['aov'], 0, ',', '.') ?> ₫
                    </h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-gray-500 text-sm font-medium">Khách hàng mới</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-2"><?= $metrics['new_customers'] ?></h3>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm mb-8">
                <form action="index.php" method="GET" class="flex flex-col md:flex-row items-center justify-between gap-4">

                    <input type="hidden" name="page" value="admin_reports">

                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-700">Từ:</span>
                            <input type="date" name="start" value="<?= $filter['start'] ?>"
                                class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none">
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-700">Đến:</span>
                            <input type="date" name="end" value="<?= $filter['end'] ?>"
                                class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none">
                        </div>
                    </div>

                    <div class="flex gap-3 w-full md:w-auto">
                        <button type="submit" class="bg-primary hover:bg-[#0ebc49] text-white font-bold py-2 px-6 rounded-lg transition-colors text-sm flex items-center gap-2">
                            <i class="fa-solid fa-filter"></i> Lọc dữ liệu
                        </button>

                        <a href="index.php?page=admin_reports" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-2 px-4 rounded-lg transition-colors text-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-rotate-right"></i> Mặc định
                        </a>
                    </div>

                </form>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
                <h3 class="font-bold text-gray-800 text-lg mb-6">
                    Xu hướng doanh thu
                    <span class="text-sm font-normal text-gray-500 ml-2">
                        (<?= date('d/m/Y', strtotime($filter['start'])) ?> - <?= date('d/m/Y', strtotime($filter['end'])) ?>)
                    </span>
                </h3>
                <div class="h-80 w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">Giao dịch gần đây</h3>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-bold">
                        <tr>
                            <th class="px-6 py-4">Mã đơn</th>
                            <th class="px-6 py-4">Ngày giờ</th>
                            <th class="px-6 py-4">Khách hàng</th>
                            <th class="px-6 py-4">Trạng thái</th>
                            <th class="px-6 py-4 text-right">Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <?php foreach ($transactions as $t): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-900">#<?= $t['id'] ?></td>
                                <td class="px-6 py-4 text-gray-500">
                                    <?= date('H:i d/m/Y', strtotime($t['created_at'])) ?>
                                </td>
                                <td class="px-6 py-4 text-gray-700"><?= $t['customer_name'] ?></td>
                                <td class="px-6 py-4">
                                    <?php
                                    $bg = 'bg-gray-100 text-gray-600';
                                    $status = 'Chờ xử lý';
                                    if ($t['status'] == 'completed') {
                                        $bg = 'bg-green-100 text-green-700';
                                        $status = 'Hoàn thành';
                                    }
                                    if ($t['status'] == 'cancelled') {
                                        $bg = 'bg-red-100 text-red-700';
                                        $status = 'Đã hủy';
                                    }
                                    if ($t['status'] == 'processing') {
                                        $bg = 'bg-blue-100 text-blue-700';
                                        $status = 'Đang pha';
                                    }
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold <?= $bg ?>"><?= $status ?></span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-gray-900">
                                    <?= number_format($t['total_amount'], 0, ',', '.') ?> ₫
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');

        // Tạo màu gradient xanh lá
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(19, 236, 91, 0.5)'); // Xanh đậm
        gradient.addColorStop(1, 'rgba(19, 236, 91, 0.0)'); // Nhạt dần

        // Dữ liệu từ PHP
        const labels = <?= json_encode($chartData['labels']) ?>;
        const data = <?= json_encode($chartData['values']) ?>;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: data,
                    borderColor: '#13ec5b', // Đường viền xanh lá
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointBackgroundColor: '#13ec5b',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true, // Tô màu dưới đường
                    tension: 0.4 // Đường cong mềm mại
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND'
                                }).format(value);
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>