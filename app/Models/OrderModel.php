<?php
require_once 'app/Models/BaseModel.php';

class OrderModel extends BaseModel
{

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
        // Xóa order_items trước (Do ràng buộc khóa ngoại) - Tuy nhiên nếu setup DB ON DELETE CASCADE thì chỉ cần xóa orders
        $sql = "DELETE FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    public function createOrder($userId, $customerName, $customerEmail, $totalAmount, $note, $cartItems)
    {
        try {
            // 1. Bắt đầu giao dịch (Transaction)
            $this->conn->beginTransaction();

            // 2. Lưu vào bảng ORDERS trước
            $sqlOrder = "INSERT INTO orders (user_id, customer_name, customer_email, total_amount, note, status, created_at) 
                         VALUES (:user_id, :name, :email, :total, :note, 'pending', NOW())";

            $stmt = $this->conn->prepare($sqlOrder);
            $stmt->execute([
                ':user_id' => $userId,
                ':name' => $customerName,
                ':email' => $customerEmail,
                ':total' => $totalAmount,
                ':note' => $note
            ]);

            // Lấy ID của đơn hàng vừa tạo
            $orderId = $this->conn->lastInsertId();

            // 3. Lưu chi tiết vào bảng ORDER_ITEMS
            $sqlItem = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price) 
                        VALUES (:order_id, :product_id, :product_name, :quantity, :price)";
            $stmtItem = $this->conn->prepare($sqlItem);

            foreach ($cartItems as $item) {
                $stmtItem->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $item['id'],
                    ':product_name' => $item['name'],
                    ':quantity' => $item['qty'],
                    ':price' => $item['price']
                ]);
            }

            // 4. Nếu mọi thứ Ok -> Lưu chính thức (Commit)
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // 5. Nếu có lỗi -> Hủy bỏ toàn bộ (Rollback)
            $this->conn->rollBack();
            // Ghi log lỗi để debug (tùy chọn)
            // error_log($e->getMessage());
            return false;
        }
    }
    public function getTotalRevenue()
    {
        $sql = "SELECT SUM(total_amount) as total FROM orders WHERE status = 'completed'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    // 2. Lấy tổng số giao dịch
    public function getTotalTransactions()
    {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE status = 'completed'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
    // 4. Lấy 10 giao dịch gần nhất
    public function getRecentTransactions()
    {
        $sql = "SELECT * FROM orders ORDER BY created_at DESC LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getRevenueChartData($startDate, $endDate)
    {
        // 1. Lấy dữ liệu thô từ Database (Gộp theo ngày)
        $sql = "SELECT DATE(created_at) as date, SUM(total_amount) as total 
                FROM orders 
                WHERE status = 'completed' 
                AND DATE(created_at) BETWEEN :start AND :end
                GROUP BY DATE(created_at)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':start' => $startDate, ':end' => $endDate]);
        $results = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // Trả về dạng ['2023-10-01' => 150000, ...]

        // 2. Lấp đầy các ngày còn thiếu (để biểu đồ không bị đứt đoạn)
        $data = [];
        $current = new DateTime($startDate);
        $end = new DateTime($endDate);

        // Vòng lặp từ ngày bắt đầu đến ngày kết thúc
        while ($current <= $end) {
            $dateString = $current->format('Y-m-d');
            $label = $current->format('d/m'); // Nhãn hiển thị (05/12)

            $data[] = [
                'date' => $label,
                // Nếu ngày đó có trong DB thì lấy, không thì bằng 0
                'total' => $results[$dateString] ?? 0
            ];

            $current->modify('+1 day'); // Tăng thêm 1 ngày
        }

        return $data;
    }
}
