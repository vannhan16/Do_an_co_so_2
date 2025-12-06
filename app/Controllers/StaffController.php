<?php
require_once 'app/Models/OrderModel.php';
class StaffController
{
    // 1. HIỂN THỊ GIAO DIỆN CHÍNH
    public function index()
    {
        // Kiểm tra quyền (nếu cần)
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $orderModel = new OrderModel();
        // 1. Lấy trạng thái từ URL (Mặc định là 'all')
        $current_status = isset($_GET['status']) ? $_GET['status'] : 'all';

        // 2. Gọi Model với tham số lọc
        $orders = $orderModel->getActiveOrders($current_status);

        // 3. Gửi dữ liệu sang View (Kèm biến $current_status để tô màu Tab)
        $data = [
            'orders' => $orders,
            'current_status' => $current_status
        ];
        $this->loadView('staff/order_board', $data);
    }

    // 2. API LẤY CHI TIẾT ĐƠN (AJAX)
    public function get_order_detail()
    {
        $id = $_GET['id'] ?? 0;
        $orderModel = new OrderModel();
        $items = $orderModel->getOrderItems($id);

        header('Content-Type: application/json');
        echo json_encode($items);
        exit;
    }

    // 3. CẬP NHẬT TRẠNG THÁI
    public function update_status()
    {
        $id = $_GET['id'];
        $status = $_GET['status']; // pending, processing, completed, cancelled

        $orderModel = new OrderModel();
        $orderModel->updateStatus($id, $status);

        // Quay lại trang Staff
        header('Location: index.php?page=staff');
        exit;
    }

    private function loadView($viewPath, $data = [])
    {
        extract($data);
        include "app/Views/$viewPath.php";
    }
}
