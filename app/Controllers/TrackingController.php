<?php
// app/Controllers/TrackingController.php

class TrackingController
{

    public function index()
    {
        // 1. GIẢ LẬP DỮ LIỆU ĐƠN HÀNG (Tại bàn)
        // Sau này bạn sẽ lấy từ Database bằng ID đơn hàng
        $order = [
            'id' => 'Order #08',   // Mã đơn
            'table_number' => 12,  // Số bàn
            'status_code' => 2,    // Trạng thái hiện tại: 1=Đã gửi, 2=Đang pha, 3=Đang ra, 4=Xong
            'created_at' => '09:30 AM',
            'subtotal' => 55000,
            'total' => 55000
        ];

        // 2. DỮ LIỆU TIMELINE (Quy trình phục vụ)
        $timeline = [
            1 => [
                'title' => 'Đã gửi order',
                'desc' => 'Bếp đã nhận được yêu cầu',
                'icon' => 'fa-file-pen'
            ],
            2 => [
                'title' => 'Đang pha chế',
                'desc' => 'Bartender đang thực hiện',
                'icon' => 'fa-blender'
            ],
            3 => [
                'title' => 'Đang ra món',
                'desc' => 'Nhân viên đang mang tới bàn',
                'icon' => 'fa-bell-concierge'
            ],
            4 => [
                'title' => 'Thưởng thức',
                'desc' => 'Chúc quý khách ngon miệng',
                'icon' => 'fa-mug-hot'
            ]
        ];

        // 3. DANH SÁCH MÓN ĂN TRONG ĐƠN
        $items = [
            [
                'name' => 'Trà Sữa Truyền Thống',
                'qty' => 1,
                'price' => 25000,
                'img' => 'public/assets/images/tra_sua_truyen_thong.jpg'
            ],
            [
                'name' => 'Sữa Tươi Trân Châu',
                'qty' => 1,
                'price' => 30000,
                'img' => 'public/assets/images/sua-tuoi-tran-chau-duong-den.jpg'
            ]
        ];

        // Đóng gói dữ liệu để gửi sang View
        $data = [
            'order' => $order,
            'timeline' => $timeline,
            'items' => $items
        ];

        // 4. GỌI VIEW (ĐÃ SỬA LỖI CÚ PHÁP TẠI ĐÂY)
        // Không dùng "viewPath:" hay "data:" nữa, chỉ truyền biến vào thôi.
        $this->loadView('client/tracking', $data);
    }

    // Hàm hỗ trợ load view và layout
    private function loadView($viewPath, $data = [])
    {
        // Giải nén mảng data thành các biến (VD: $data['order'] thành biến $order)
        extract($data);

        // Bắt đầu bộ nhớ đệm để lấy nội dung view con
        ob_start();
        include "app/Views/$viewPath.php";
        $content = ob_get_clean();

        // Load khung layout chính (Header + Footer)
        include "app/Views/layouts/main.php";
    }
}
