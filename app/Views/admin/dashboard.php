<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DrinkAdmin</title>
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
            <h2 class="text-xl font-bold text-gray-800">Tổng quan</h2>
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-900"><?= $_SESSION['user_name'] ?? 'Admin' ?></p>
                    <p class="text-xs text-gray-500">Quản trị viên</p>
                </div>
                <img src="<?= $_SESSION['avatar'] ?? 'https://ui-avatars.com/api/?name=Admin' ?>" class="w-9 h-9 rounded-full border border-gray-200">
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 custom-scroll">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Doanh thu hôm nay</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?= number_format($stats['sales']['value'], 0, ',', '.') ?> ₫</h3>
                        <p class="text-xs font-bold text-green-500 mt-2"><i class="fa-solid fa-calendar-day"></i> <?= $stats['sales']['trend'] ?></p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-lg"><i class="fa-solid fa-sack-dollar"></i></div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Đơn đang chờ</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?= $stats['orders']['value'] ?></h3>
                        <p class="text-xs text-orange-500 mt-2"><?= $stats['orders']['sub'] ?></p>
                    </div>
                    <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-lg"><i class="fa-solid fa-clock"></i></div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Khách mới</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?= $stats['customers']['value'] ?></h3>
                        <p class="text-xs text-blue-500 mt-2"><?= $stats['customers']['trend'] ?></p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-lg"><i class="fa-solid fa-user-plus"></i></div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tổng món</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?= $stats['drinks']['value'] ?></h3>
                        <p class="text-xs text-gray-400 mt-2"><?= $stats['drinks']['sub'] ?></p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-lg"><i class="fa-solid fa-martini-glass-citrus"></i></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-lg mb-6">Doanh thu tuần qua</h3>
                    <div class="h-80 relative">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-lg mb-6">Đơn mới nhất</h3>
                    <div class="space-y-4">
                        <?php foreach ($recent_orders as $o): ?>
                            <div class="flex items-center justify-between p-3 border border-gray-50 rounded-xl hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center font-bold text-xs">
                                        #<?= $o['id'] ?>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-sm"><?= $o['customer_name'] ?: 'Khách lẻ' ?></p>
                                        <p class="text-xs text-gray-500"><?= date('H:i', strtotime($o['created_at'])) ?></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900 text-sm"><?= number_format($o['total_amount'], 0, ',', '.') ?>đ</p>

                                    <?php
                                    $stt = $o['status'];
                                    $color = ($stt == 'completed') ? 'text-green-600' : (($stt == 'cancelled') ? 'text-red-600' : 'text-orange-600');
                                    $label = ($stt == 'completed') ? 'Hoàn thành' : (($stt == 'cancelled') ? 'Đã hủy' : 'Chờ xử lý');
                                    ?>
                                    <span class="text-[10px] font-bold <?= $color ?>"><?= $label ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="index.php?page=admin_orders" class="block text-center mt-6 text-sm font-bold text-primary hover:underline">Xem tất cả đơn</a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-8">
                <a href="index.php?page=admin_drinks" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:shadow-md transition-all group">
                    <div class="w-12 h-12 rounded-full bg-green-50 text-primary flex items-center justify-center text-xl group-hover:scale-110 transition-transform"><i class="fa-solid fa-plus"></i></div>
                    <span class="font-bold text-gray-700">Thêm món mới</span>
                </a>
                <a href="index.php?page=admin_orders" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:shadow-md transition-all group">
                    <div class="w-12 h-12 rounded-full bg-green-50 text-primary flex items-center justify-center text-xl group-hover:scale-110 transition-transform"><i class="fa-solid fa-list-check"></i></div>
                    <span class="font-bold text-gray-700">Quản lý đơn</span>
                </a>
                <a href="index.php?page=admin_tables" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:shadow-md transition-all group">
                    <div class="w-12 h-12 rounded-full bg-green-50 text-primary flex items-center justify-center text-xl group-hover:scale-110 transition-transform"><i class="fa-solid fa-qrcode"></i></div>
                    <span class="font-bold text-gray-700">Tạo mã QR</span>
                </a>
            </div>

        </div>
    </main>

    <script>
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(19, 236, 91, 0.5)');
        gradient.addColorStop(1, 'rgba(19, 236, 91, 0.0)');

        const labels = <?= json_encode($chartData['labels']) ?>;
        const data = <?= json_encode($chartData['values']) ?>;

        new Chart(ctx, {
            type: 'line', // Dạng biểu đồ đường
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: data,
                    borderColor: '#13ec5b',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#13ec5b',
                    pointRadius: 6,
                    fill: true,
                    tension: 0.4
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
                                return new Intl.NumberFormat('vi-VN').format(value);
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