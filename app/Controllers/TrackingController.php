<?php
// app/Controllers/TrackingController.php
require_once 'app/Models/OrderModel.php';
class TrackingController
{

    public function index()
    {
        // 1. Kiểm tra xem khách có đơn hàng nào vừa đặt không?
        // (Trong thực tế sẽ lưu ID đơn hàng vào Session khi đặt xong)
        // Ở đây ta tạm lấy đơn hàng mới nhất của hệ thống để demo

        $orderModel = new OrderModel();

        // Lấy đơn mới nhất (Hoặc lấy theo Session nếu bạn đã lưu order_id vào session)
        // $orderId = $_SESSION['latest_order_id'] ?? 0;

        // Để demo: Lấy đơn mới nhất trong bảng orders
        $latestOrder = $orderModel->getLatestOrders(1);

        if (empty($latestOrder)) {
            // Nếu chưa có đơn nào
            $data = ['order' => null];
        } else {
            $order = $latestOrder[0]; // Lấy đơn đầu tiên

            // Lấy chi tiết món ăn của đơn đó
            $items = $orderModel->getOrderItems($order['id']);

            $data = [
                'order' => $order,
                'items' => $items
            ];
        }

        $this->loadView('client/tracking', $data);
    }

    private function loadView($viewPath, $data = [])
    {
        extract($data);
        ob_start();
        include "app/Views/$viewPath.php";
        $content = ob_get_clean();
        include "app/Views/layouts/main.php";
    }
}
