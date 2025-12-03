<?php
require_once 'app/Models/BaseModel.php';

class CategoryModel extends BaseModel
{

    public function getCategories()
    {
        // SQL: Lấy tất cả cột bảng categories (c.*) 
        // và đếm id của bảng products (COUNT(p.id))
        // LEFT JOIN: Để lấy cả những danh mục chưa có sản phẩm nào (số lượng = 0)
        $sql = "SELECT c.*, COUNT(p.id) as product_count 
                FROM categories c 
                LEFT JOIN products p ON c.id = p.category_id 
                GROUP BY c.id 
                ORDER BY c.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($name, $icon)
    {
        try {
            // Câu lệnh SQL chuẩn
            $sql = "INSERT INTO categories (name, icon) VALUES (:name, :icon)";
            $stmt = $this->conn->prepare($sql);

            // Gán dữ liệu
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':icon', $icon);

            // Thực thi
            return $stmt->execute();
        } catch (PDOException $e) {
            // Nếu lỗi, in ra màn hình để biết đường sửa
            echo "Lỗi SQL Model: " . $e->getMessage();
            die();
        }
    }
    // --- HÀM MỚI: CẬP NHẬT DANH MỤC ---
    public function update($id, $name, $icon)
    {
        $sql = "UPDATE categories SET name = :name, icon = :icon WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':icon', $icon);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
