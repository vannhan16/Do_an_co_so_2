<?php
require_once 'app/Models/UserModel.php';
class AuthController
{

    // 1. XỬ LÝ ĐĂNG NHẬP
    // 1. XỬ LÝ ĐĂNG NHẬP
    public function login()
    {
        $error = '';

        // Nếu người dùng đã đăng nhập rồi thì đá về trang tương ứng luôn
        if (isset($_SESSION['user_id'])) {
            $this->redirectUser($_SESSION['role']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['username']); // Trong form name là "username" nhưng ta nhập email
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);

            if ($user) {
                // Kiểm tra mật khẩu (So sánh pass nhập vào với hash trong DB)
                // Hoặc kiểm tra active/inactive
                if ($user['status'] === 'inactive') {
                    $error = "Tài khoản này đã bị khóa!";
                } elseif (password_verify($password, $user['password'])) {
                    // --- ĐĂNG NHẬP THÀNH CÔNG ---
                    // Lưu thông tin vào Session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['fullname'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['avatar'] = $user['avatar'];

                    // Chuyển hướng dựa trên vai trò
                    $this->redirectUser($user['role']);
                } else {
                    $error = "Mật khẩu không chính xác!";
                }
            } else {
                $error = "Email không tồn tại trong hệ thống!";
            }
        }

        $this->loadView('auth/login', ['error' => $error]);
    }

    // 2. XỬ LÝ ĐĂNG XUẤT
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        // Quay về trang login
        header('Location: index.php?page=login');
        exit;
    }

    // XỬ LÝ ĐĂNG KÝ
    public function register()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $fullname = trim($_POST['fullname']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $role = $_POST['role'];

            // 1. Validate cơ bản
            if (empty($fullname) || empty($email) || empty($password)) {
                $error = "Vui lòng điền đầy đủ thông tin!";
            }
            // 2. Kiểm tra mật khẩu nhập lại
            elseif ($password !== $confirm_password) {
                $error = "Mật khẩu xác nhận không khớp!";
            }
            // 3. Kiểm tra độ dài mật khẩu (Tùy chọn)
            elseif (strlen($password) < 6) {
                $error = "Mật khẩu phải có ít nhất 6 ký tự!";
            } else {
                // 4. Kiểm tra Email trùng
                $userModel = new UserModel();
                if ($userModel->checkEmailExists($email)) {
                    $error = "Email này đã được sử dụng!";
                } else {
                    // 5. Lưu vào Database
                    if ($userModel->create($fullname, $email, $password, $role)) {
                        // Đăng ký thành công -> Chuyển hướng sang Login
                        echo "<script>
                                alert('Đăng ký thành công! Vui lòng đăng nhập.');
                                window.location.href='index.php?page=login';
                              </script>";
                        exit;
                    } else {
                        $error = "Đã có lỗi xảy ra, vui lòng thử lại!";
                    }
                }
            }
        }

        // Load View kèm thông báo lỗi (nếu có)
        $this->loadView('auth/register', ['error' => $error]);
    }
    // --- HÀM PHỤ TRỢ ---

    // Hàm chuyển hướng dựa trên quyền
    private function redirectUser($role)
    {
        if ($role === 'admin' || $role === 'manager') {
            header('Location: index.php?page=admin');
        } else {
            header('Location: index.php?page=staff'); // Thu ngân
        }
        exit;
    }
    // --- HÀM HỖ TRỢ LOAD VIEW ---
    private function loadView($viewPath, $data = [])
    {
        extract($data);
        include "app/Views/$viewPath.php";
    }
}
