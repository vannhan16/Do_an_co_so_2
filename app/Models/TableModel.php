<?php
require_once 'app/Models/BaseModel.php';

class TableModel extends BaseModel
{

    public function getTables()
    {
        $sql = "SELECT * FROM tables ORDER BY id DESC"; // Sắp xếp mới nhất lên đầu
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($name, $capacity, $section, $qr_option)
    {
        // 1. Tạo đường link cho bàn (Ví dụ: localhost/.../?page=menu&table=Bàn_1)
        // Đây là nội dung sẽ được mã hóa vào QR Code
        $qr_content = "";

        if ($qr_option == 'auto') {
            // Lấy tên miền hiện tại (localhost/project-tra-sua)
            $baseUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
            // Tạo link: Khách quét QR này sẽ vào thẳng menu của bàn này
            $qr_content = $baseUrl . "/index.php?page=menu&table_name=" . urlencode($name);
        }

        // 2. Lưu vào Database
        $sql = "INSERT INTO tables (name, capacity, section, qr_code, status) 
                VALUES (:name, :capacity, :section, :qr_code, 'active')";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':capacity' => $capacity,
            ':section' => $section,
            ':qr_code' => $qr_content // Lưu đường link vào cột qr_code
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM tables WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function update($id, $name, $capacity, $section, $qr_action)
    {
        // 1. Chuẩn bị câu lệnh SQL cơ bản
        $sql = "UPDATE tables SET name=:name, capacity=:capacity, section=:section";
        $params = [
            ':name' => $name,
            ':capacity' => $capacity,
            ':section' => $section,
            ':id' => $id
        ];

        // 2. Xử lý logic QR Code dựa trên lựa chọn
        if ($qr_action == 'auto') {
            // Tạo lại QR mới (theo tên mới)
            $baseUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
            $qr_content = $baseUrl . "/index.php?page=menu&table_name=" . urlencode($name);

            $sql .= ", qr_code=:qr_code";
            $params[':qr_code'] = $qr_content;
        } elseif ($qr_action == 'remove') {
            // Xóa QR
            $sql .= ", qr_code=''";
        }
        // Nếu $qr_action == 'keep' thì không làm gì (giữ nguyên mã cũ)

        $sql .= " WHERE id=:id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // Hàm Lấy danh sách (Có hỗ trợ Tìm kiếm & Lọc)
    public function getList($keyword = '', $filter = 'all')
    {
        $sql = "SELECT * FROM tables WHERE 1=1"; // 1=1 là kỹ thuật để dễ nối chuỗi AND
        $params = [];

        // 1. Xử lý Tìm kiếm (Nếu có từ khóa)
        if (!empty($keyword)) {
            $sql .= " AND (name LIKE :keyword OR section LIKE :keyword)";
            $params[':keyword'] = "%" . $keyword . "%";
        }

        // 2. Xử lý Lọc (Filter)
        if ($filter === 'active') {
            // Lọc bàn ĐÃ CÓ mã QR (Không rỗng và không NULL)
            $sql .= " AND qr_code IS NOT NULL AND qr_code != ''";
        } elseif ($filter === 'missing') {
            // Lọc bàn CHƯA CÓ mã QR (Là NULL hoặc rỗng)
            $sql .= " AND (qr_code IS NULL OR qr_code = '')";
        }

        $sql .= " ORDER BY id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
