<?php
require_once __DIR__ . '/../Config/Database.php';


class BaseModel
{
    protected $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Hàm lấy tất cả dữ liệu (Reusable)
    public function getAll($table)
    {
        $query = "SELECT * FROM " . $table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Hàm lấy 1 dòng theo ID
    public function getById($table, $id)
    {
        $query = "SELECT * FROM " . $table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
