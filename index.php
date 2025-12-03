<?php
// FILE: index.php - BỘ ĐIỀU HƯỚNG TRUNG TÂM

// 1. Khởi động Session (Để lưu trạng thái đăng nhập)
session_start();

// 2. Lấy tham số 'page' từ URL (Mặc định vào trang 'menu')
$page = isset($_GET['page']) ? $_GET['page'] : 'menu';

// 3. Xử lý điều hướng (Router)
switch ($page) {

    // ====================================================
    // KHU VỰC 1: AUTH (ĐĂNG NHẬP / ĐĂNG KÝ / ĐĂNG XUẤT)
    // ====================================================
    case 'login':
        require_once 'app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'logout':
        require_once 'app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'register':
        require_once 'app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;


    // ====================================================
    // KHU VỰC 2: ADMIN (QUẢN TRỊ VIÊN)
    // ====================================================

    // 2.1. Dashboard Tổng quát
    case 'admin':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->index();
        break;

    case 'admin_orders':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->orders();
        break;
    // API lấy chi tiết (Dùng cho Modal)
    case 'api_order_details':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->get_order_details();
        break;

    case 'update_order_status':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->update_order_status();
        break;

    case 'delete_order':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->delete_order();
        break;
    case 'store_order':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->store_order();
        break;
    case 'admin_create_order': // Router sẽ bắt chữ này
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->create_order();
        break;

    // 2.2. Quản lý Đồ uống
    case 'admin_drinks':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->drinks();
        break;
    case 'store_drink':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->store_drink();
        break;

    case 'update_drink':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->update_drink();
        break;

    case 'delete_drink':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->delete_drink();
        break;

    // 2.3. Quản lý Danh mục
    case 'admin_categories':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->categories();
        break;
    // --- CHỨC NĂNG XỬ LÝ (ACTION) ---
    case 'store_category': // Xử lý thêm
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->store_category();
        break;

    case 'delete_category': // Xử lý xóa
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->delete_category();
        break;
    case 'update_category': // Case mới
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->update_category();
        break;
    // 2.4. Quản lý Bàn & QR
    case 'admin_tables':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->tables();
        break;
    case 'store_table':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->store_table();
        break;

    case 'delete_table':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->delete_table();
        break;
    case 'update_table':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->update_table();
        break;

    // 2.5. Quản lý Nhân viên
    case 'admin_users':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->users();
        break;
    case 'store_user':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->store_user();
        break;

    case 'update_user':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->update_user();
        break;

    case 'delete_user':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->delete_user();
        break;

    // 2.6. Báo cáo Doanh thu
    case 'admin_reports':
        require_once 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->reports();
        break;


    // ====================================================
    // KHU VỰC 3: STAFF (THU NGÂN)
    // ====================================================
    case 'staff':
        require_once 'app/Controllers/StaffController.php';
        $controller = new StaffController();
        $controller->index();
        break;


    // ====================================================
    // KHU VỰC 4: CLIENT (KHÁCH HÀNG)
    // ====================================================
    case 'tracking':
        require_once 'app/Controllers/TrackingController.php';
        $controller = new TrackingController();
        $controller->index();
        break;

    case 'menu':
    default: // Nếu không tìm thấy trang nào thì về Menu
        require_once 'app/Controllers/MenuController.php';
        $controller = new MenuController();
        $controller->index();
        break;
}
