<?php
require_once 'app/Models/BaseModel.php';

class ProductModel extends BaseModel
{

    // Lấy danh sách món (Kèm tên danh mục)
    public function getProducts()
    {
        // JOIN bảng categories để lấy tên danh mục thay vì chỉ lấy ID
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Thêm món mới
    public function create($name, $price, $category_id, $description, $image)
    {
        try {
            $sql = "INSERT INTO products (name, price, category_id, description, image) 
                    VALUES (:name, :price, :category_id, :description, :image)";
            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':category_id' => $category_id,
                ':description' => $description,
                ':image' => $image
            ]);
        } catch (PDOException $e) {
            // IN RA LỖI ĐỂ BIẾT ĐƯỜNG SỬA
            echo "Lỗi SQL: " . $e->getMessage();
            die();
        }
    }

    // Cập nhật món
    public function update($id, $name, $price, $category_id, $description, $image)
    {
        $sql = "UPDATE products 
                SET name=:name, price=:price, category_id=:category_id, description=:description, image=:image 
                WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':category_id' => $category_id,
            ':description' => $description,
            ':image' => $image,
            ':id' => $id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
    public function searchProducts($keyword)
    {
        // Tìm theo Tên món HOẶC Mô tả HOẶC Tên danh mục
        // Sử dụng %keyword% để tìm kiếm tương đối
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.name LIKE :keyword 
                OR p.description LIKE :keyword
                OR c.name LIKE :keyword
                ORDER BY p.id DESC";

        $stmt = $this->conn->prepare($sql);
        $searchTerm = "%" . $keyword . "%";
        $stmt->bindParam(':keyword', $searchTerm);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    // Lấy món theo ID danh mục
    public function getProductsByCategoryId($categoryId)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = :cat_id 
                ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cat_id', $categoryId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
