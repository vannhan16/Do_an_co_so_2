<?php
// Lấy trang hiện tại từ URL, mặc định là 'admin'
$current_page = isset($_GET['page']) ? $_GET['page'] : 'admin';

// Hàm hỗ trợ active menu (Code cho gọn)
function isActive($page_name, $current)
{
    if ($page_name === $current) {
        return 'bg-green-50 text-primary font-bold shadow-sm ring-1 ring-primary/20'; // Style khi đang chọn
    }
    return 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium'; // Style bình thường
}
?>

<aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col hidden md:flex h-screen sticky top-0">
    <div class="h-16 flex items-center px-6 border-b border-gray-100 shrink-0">
        <i class="fa-solid fa-martini-glass-citrus text-primary text-2xl mr-3"></i>
        <span class="text-xl font-bold text-gray-900">DrinkAdmin</span>
    </div>

    <nav class="flex-1 p-4 space-y-1 overflow-y-auto custom-scroll">

        <a href="index.php?page=admin" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= isActive('admin', $current_page) ?>">
            <i class="fa-solid fa-border-all w-5 text-center"></i> Tổng quan
        </a>

        <p class="px-4 mt-6 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Quản lý</p>

        <a href="index.php?page=admin_orders" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= isActive('admin_orders', $current_page) ?>">
            <i class="fa-solid fa-cart-shopping w-5 text-center"></i> Đơn hàng
        </a>

        <a href="index.php?page=admin_drinks" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= isActive('admin_drinks', $current_page) ?>">
            <i class="fa-solid fa-utensils w-5 text-center"></i> Thực đơn
        </a>

        <a href="index.php?page=admin_categories" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= isActive('admin_categories', $current_page) ?>">
            <i class="fa-solid fa-layer-group w-5 text-center"></i> Danh mục
        </a>

        <a href="index.php?page=admin_tables" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= isActive('admin_tables', $current_page) ?>">
            <i class="fa-solid fa-qrcode w-5 text-center"></i> Bàn & QR Code
        </a>

        <a href="index.php?page=admin_users" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= isActive('admin_users', $current_page) ?>">
            <i class="fa-solid fa-users w-5 text-center"></i> Nhân viên
        </a>

        <p class="px-4 mt-6 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Thống kê</p>

        <a href="index.php?page=admin_reports" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= isActive('admin_reports', $current_page) ?>">
            <i class="fa-solid fa-chart-simple w-5 text-center"></i> Doanh thu
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium">
            <i class="fa-solid fa-gear w-5 text-center"></i> Cài đặt
        </a>
    </nav>

    <div class="p-4 border-t border-gray-100 shrink-0">
        <a href="index.php?page=logout" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-red-500 font-medium transition-colors hover:bg-red-50 rounded-xl">
            <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i> Đăng xuất
        </a>
    </div>
</aside>