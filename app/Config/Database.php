<?php
class Database
{
    // Thông tin cấu hình
    private $host = "localhost";
    private $db_name = "drinky_db";
    private $username = "root";
    private $password = ""; // Mặc định XAMPP không có pass, nếu bạn cài pass thì điền vào đây
    public $conn;

    // Hàm kết nối
    public function getConnection()
    {
        $this->conn = null;

        try {
            // Chuỗi kết nối PDO (PHP Data Objects)
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8";

            $this->conn = new PDO($dsn, $this->username, $this->password);

            // Cấu hình chế độ báo lỗi (quan trọng để debug)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Lỗi kết nối Database: " . $exception->getMessage();
            die(); // Dừng chương trình nếu không kết nối được
        }

        return $this->conn;
    }
}
