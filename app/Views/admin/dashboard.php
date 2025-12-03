<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - DrinkAdmin</title>

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

            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 sm:px-8">
                <h2 class="text-xl font-bold text-gray-800">Tổng quan</h2>

                <div class="flex items-center gap-4">
                    <div class="relative hidden sm:block">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-gray-400"></i>
                        <input type="text" placeholder="Tìm kiếm..." class="pl-10 pr-4 py-2 bg-gray-100 rounded-full text-sm border-none focus:ring-2 focus:ring-primary w-64">
                    </div>

                    <button class="relative p-2 text-gray-400 hover:text-gray-600">
                        <i class="fa-regular fa-bell text-xl"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-gray-900">Admin User</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=Admin&background=13ec5b&color=fff" class="w-9 h-9 rounded-full border border-gray-200">
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-6 sm:p-8">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Doanh thu hôm nay</p>
                            <h3 class="text-2xl font-bold text-gray-900">$<?= number_format($stats['sales']['value'], 2) ?></h3>
                            <p class="text-xs font-bold text-green-500 mt-2 flex items-center gap-1">
                                <i class="fa-solid fa-arrow-trend-up"></i> <?= $stats['sales']['trend'] ?> <span class="text-gray-400 font-normal">so với hôm qua</span>
                            </p>
                        </div>
                        <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-lg">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Đơn đang mở</p>
                            <h3 class="text-2xl font-bold text-gray-900"><?= $stats['orders']['value'] ?></h3>
                            <p class="text-xs text-gray-400 mt-2"><?= $stats['orders']['sub'] ?></p>
                        </div>
                        <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-lg">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Khách mới</p>
                            <h3 class="text-2xl font-bold text-gray-900"><?= $stats['customers']['value'] ?></h3>
                            <p class="text-xs font-bold text-green-500 mt-2 flex items-center gap-1">
                                <i class="fa-solid fa-arrow-trend-up"></i> <?= $stats['customers']['trend'] ?> <span class="text-gray-400 font-normal">giờ qua</span>
                            </p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-lg">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tổng món</p>
                            <h3 class="text-2xl font-bold text-gray-900"><?= $stats['drinks']['value'] ?></h3>
                            <p class="text-xs text-gray-400 mt-2"><?= $stats['drinks']['sub'] ?></p>
                        </div>
                        <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-lg">
                            <i class="fa-solid fa-martini-glass"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-gray-800 text-lg">Doanh thu tuần này</h3>
                            <button class="text-xs bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-lg text-gray-600">
                                <i class="fa-regular fa-calendar mr-1"></i> 7 ngày qua
                            </button>
                        </div>
                        <div class="relative w-full h-80 bg-slate-900 rounded-xl p-4 flex items-center justify-center">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>

                    <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 text-lg mb-6">Đơn gần đây</h3>

                        <div class="space-y-6">
                            <?php foreach ($recent_orders as $order): ?>
                                <?php
                                // Logic màu sắc trạng thái
                                $statusClass = 'bg-gray-100 text-gray-600';
                                if ($order['status'] == 'Paid') $statusClass = 'bg-green-100 text-green-700';
                                if ($order['status'] == 'Pending') $statusClass = 'bg-orange-100 text-orange-700';
                                if ($order['status'] == 'Cancelled') $statusClass = 'bg-red-100 text-red-700';
                                ?>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                                            <i class="fa-solid fa-bag-shopping"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 text-sm"><?= $order['id'] ?></p>
                                            <p class="text-xs text-gray-500"><?= $order['name'] ?></p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900 text-sm">$<?= number_format($order['total'], 2) ?></p>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full <?= $statusClass ?>">
                                            <?= $order['status'] ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button class="w-full mt-6 py-2 text-sm font-bold text-primary border border-primary rounded-lg hover:bg-green-50 transition-colors">
                            Xem tất cả
                        </button>
                    </div>

                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-8">

                    <a href="index.php?page=admin_drinks" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:shadow-md transition-shadow group cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-green-50 text-primary flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-cart-plus"></i>
                        </div>
                        <span class="font-bold text-gray-700">Thêm món mới</span>
                    </a>

                    <a href="index.php?page=admin_orders" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:shadow-md transition-shadow group cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-green-50 text-primary flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <span class="font-bold text-gray-700">Xem tất cả đơn</span>
                    </a>

                    <a href="index.php?page=admin_tables" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3 hover:shadow-md transition-shadow group cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-green-50 text-primary flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-qrcode"></i>
                        </div>
                        <span class="font-bold text-gray-700">Tạo mã QR</span>
                    </a>

                </div>

            </div>
        </main>
    </div>

    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');

        // Tạo gradient màu xanh cho cột
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, '#13ec5b'); // Xanh lá sáng
        gradient.addColorStop(1, '#0b8a36'); // Xanh lá đậm

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Doanh thu ($)',
                    data: [1200, 1900, 3000, 5000, 2300, 3400, 4100],
                    backgroundColor: '#60a5fa', // Màu xanh dương nhạt giống ảnh
                    hoverBackgroundColor: '#13ec5b', // Hover màu xanh lá
                    borderRadius: 4,
                    barThickness: 15,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    } // Ẩn chú thích
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#334155'
                        }, // Màu lưới tối
                        ticks: {
                            color: '#94a3b8'
                        } // Màu chữ trục Y
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8'
                        } // Màu chữ trục X
                    }
                }
            }
        });
    </script>
</body>

</html>