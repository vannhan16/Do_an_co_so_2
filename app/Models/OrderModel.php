<?php
require_once 'app/Models/BaseModel.php';

class OrderModel extends BaseModel
{
    /* ============================================================
        ORDER LIST + DETAILS
    ============================================================ */

    // 1. Lấy tất cả đơn hàng (Kèm tên bàn nếu có)
    public function getOrders()
    {
        $sql = "SELECT o.*, t.name as table_name 
                FROM orders o
                LEFT JOIN tables t ON o.table_id = t.id
                ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // Lấy tất cả đơn hàng cho Thu ngân (Trừ đơn đã hủy)
    // Lấy đơn hàng cho Thu ngân (Có hỗ trợ lọc)
    public function getActiveOrders($filter = 'all')
    {
        $sql = "SELECT o.*, t.name as table_name 
                FROM orders o
                LEFT JOIN tables t ON o.table_id = t.id
                WHERE o.status != 'cancelled'";

        $params = [];

        // Nếu có lọc theo trạng thái cụ thể
        if ($filter !== 'all') {
            $sql .= " AND o.status = :status";
            $params[':status'] = $filter;
        }

        // Sắp xếp: Ưu tiên đơn mới nhất lên đầu
        $sql .= " ORDER BY 
                    CASE 
                        WHEN o.status = 'pending' THEN 1 
                        WHEN o.status = 'processing' THEN 2 
                        WHEN o.status = 'completed' THEN 3 
                        ELSE 4 
                    END,
                    o.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }


    // 2. Lấy chi tiết món ăn trong đơn (Cho Modal xem chi tiết)
    public function getOrderItems($order_id)
    {
        $sql = "SELECT oi.*, p.name as product_name, p.image 
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = :order_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /* ============================================================
        UPDATE / DELETE
    ============================================================ */

    // 3. Cập nhật trạng thái đơn
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }

    // 4. Xóa đơn (Nếu cần)
    public function delete($id)
    {
        $sql = "DELETE FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /* ============================================================
        CREATE ORDER (TRANSACTION)
    ============================================================ */

    // --- HÀM TẠO ĐƠN HÀNG (QUAN TRỌNG) ---
    public function createOrder($userId, $customerName, $totalAmount, $note, $cartItems)
    {
        try {
            // 1. Bắt đầu giao dịch
            $this->conn->beginTransaction();

            // 2. Lưu thông tin chung vào bảng ORDERS
            $sqlOrder = "INSERT INTO orders (user_id, customer_name, total_amount, note, status, created_at) 
                         VALUES (:user_id, :name, :total, :note, 'pending', NOW())";

            $stmt = $this->conn->prepare($sqlOrder);
            $stmt->execute([
                ':user_id' => $userId, // Có thể là NULL nếu khách tự đặt
                ':name' => $customerName,
                ':total' => $totalAmount,
                ':note' => $note
            ]);

            // Lấy ID đơn hàng vừa tạo
            $orderId = $this->conn->lastInsertId();

            // 3. Lưu chi tiết vào bảng ORDER_ITEMS
            $sqlItem = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                        VALUES (:order_id, :product_id, :quantity, :price)";
            $stmtItem = $this->conn->prepare($sqlItem);

            foreach ($cartItems as $item) {
                $stmtItem->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $item['id'],
                    ':quantity' => $item['qty'],
                    ':price' => $item['price']
                ]);
            }

            // 4. Lưu thành công
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // 5. Nếu lỗi thì hoàn tác
            $this->conn->rollBack();
            return false;
        }
    }

    /* ============================================================
        DASHBOARD - REVENUE & STATS
    ============================================================ */

    // Tổng doanh thu (completed only)
    public function getTotalRevenue()
    {
        $sql = "SELECT SUM(total_amount) as total FROM orders WHERE status = 'completed'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    // Tổng số giao dịch hoàn tất
    public function getTotalTransactions()
    {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE status = 'completed'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    // 10 đơn gần nhất
    public function getRecentTransactions()
    {
        $sql = "SELECT * FROM orders ORDER BY created_at DESC LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Doanh thu hôm nay
    public function getTodayRevenue()
    {
        $sql = "SELECT SUM(total_amount) as total FROM orders 
                WHERE status = 'completed' 
                AND DATE(created_at) = CURDATE()";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    // Số đơn đang chờ
    public function countPendingOrders()
    {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE status IN ('pending', 'processing')";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    // Số khách mới hôm nay
    public function countNewCustomersToday()
    {
        $sql = "SELECT COUNT(DISTINCT customer_name) as total 
                FROM orders 
                WHERE DATE(created_at) = CURDATE()";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    // 5 đơn gần nhất
    public function getLatestOrders($limit = 5)
    {
        $sql = "SELECT * FROM orders ORDER BY id DESC LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /* ============================================================
        REVENUE CHART DATA
    ============================================================ */

    public function getRevenueChartData($startDate, $endDate)
    {
        // Lấy dữ liệu tổng hợp theo ngày
        $sql = "SELECT DATE(created_at) as date, SUM(total_amount) as total 
                FROM orders 
                WHERE status = 'completed' 
                AND DATE(created_at) BETWEEN :start AND :end
                GROUP BY DATE(created_at)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':start' => $startDate, ':end' => $endDate]);

        $results = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        // Lấp ngày trống
        $data = [];
        $current = new DateTime($startDate);
        $end     = new DateTime($endDate);

        while ($current <= $end) {
            $dateString = $current->format('Y-m-d');
            $label      = $current->format('d/m');

            $data[] = [
                'date'  => $label,
                'total' => $results[$dateString] ?? 0
            ];

            $current->modify('+1 day');
        }

        return $data;
    }
}
