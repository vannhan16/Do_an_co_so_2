<?php
class StaffController
{
    public function index()
    {
        // 1. GIẢ LẬP DỮ LIỆU ĐƠN HÀNG (Sau này lấy từ DB)
        $orders = [
            [
                'id' => '12345',
                'customer' => 'Nguyễn Văn A',
                'time' => '2 phút trước',
                'status' => 'new', // new, preparing, ready
                'items_count' => 3,
                'total' => 125000,
                'payment_status' => 'Đã thanh toán (Thẻ)',
                'items' => [
                    ['name' => 'Cà phê sữa đá', 'note' => 'Ít sữa, nhiều đá', 'qty' => 1, 'price' => 25000],
                    ['name' => 'Trà đào cam sả', 'note' => '', 'qty' => 2, 'price' => 50000]
                ]
            ],
            [
                'id' => '12344',
                'customer' => 'Trần Thị B',
                'time' => '5 phút trước',
                'status' => 'new',
                'items_count' => 1,
                'total' => 45000,
                'payment_status' => 'Chưa thanh toán',
                'items' => [
                    ['name' => 'Matcha Đá Xay', 'note' => 'Thêm kem', 'qty' => 1, 'price' => 45000]
                ]
            ],
            [
                'id' => '12343',
                'customer' => 'Lê Văn C',
                'time' => '8 phút trước',
                'status' => 'new',
                'items_count' => 2,
                'total' => 60000,
                'payment_status' => 'Đã thanh toán (Momo)',
                'items' => [
                    ['name' => 'Bạc xỉu', 'note' => '', 'qty' => 2, 'price' => 30000]
                ]
            ]
        ];

        // Gửi dữ liệu sang View
        $this->loadView('staff/order_board', ['orders' => $orders]);
    }

    private function loadView($viewPath, $data = [])
    {
        extract($data);
        // Dùng layout riêng cho nhân viên, không dùng main.php
        include "app/Views/$viewPath.php";
    }
}
