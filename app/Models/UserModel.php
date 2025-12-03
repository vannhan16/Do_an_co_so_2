<?php
require_once 'app/Models/BaseModel.php';

class
UserModel extends BaseModel
{
    // 1. Kiểm tra email đã tồn tại chưa
    public function checkEmailExists($email)
    {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0; // Trả về true nếu đã có
    }

    // 2. Tạo tài khoản mới
    public function create($fullname, $email, $password, $role)
    {
        // Mã hóa mật khẩu (Bắt buộc)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Tạo avatar ngẫu nhiên
        $avatar = "https://ui-avatars.com/api/?name=" . urlencode($fullname) . "&background=random";

        $sql = "INSERT INTO users (fullname, email, password, role, status, avatar) 
                VALUES (:fullname, :email, :password, :role, 'active', :avatar)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':fullname' => $fullname,
            ':email' => $email,
            ':password' => $hashed_password,
            ':role' => $role,
            ':avatar' => $avatar
        ]);
    }


    // Lấy danh sách nhân viên
    public function getUsers()
    {
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // Cập nhật nhân viên
    public function update($id, $fullname, $email, $password, $role, $status)
    {
        // Nếu có nhập mật khẩu mới thì cập nhật, không thì giữ nguyên
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET fullname=:fullname, email=:email, password=:password, role=:role, status=:status WHERE id=:id";
            $params = [
                ':fullname' => $fullname,
                ':email' => $email,
                ':password' => $hashed_password,
                ':role' => $role,
                ':status' => $status,
                ':id' => $id
            ];
        } else {
            $sql = "UPDATE users SET fullname=:fullname, email=:email, role=:role, status=:status WHERE id=:id";
            $params = [
                ':fullname' => $fullname,
                ':email' => $email,
                ':role' => $role,
                ':status' => $status,
                ':id' => $id
            ];
        }

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // Xóa nhân viên
    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    // --- HÀM MỚI: LẤY THÔNG TIN USER QUA EMAIL ---
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(); // Trả về mảng thông tin user hoặc false
    }
}
