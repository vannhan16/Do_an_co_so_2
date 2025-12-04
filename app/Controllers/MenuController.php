<?php
// app/Controllers/MenuController.php
require_once 'app/Models/ProductModel.php';
require_once 'app/Models/CategoryModel.php';
require_once 'app/Models/OrderModel.php';

class MenuController
{

    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        // --- LOGIC MỚI: BẮT SỐ BÀN TỪ QR CODE ---
        // Nếu trên URL có tham số 'table_name' (do quét QR)
        if (isset($_GET['table_name']) && !empty($_GET['table_name'])) {
            // Lưu vào Session để dùng xuyên suốt phiên làm việc
            $_SESSION['current_table'] = urldecode($_GET['table_name']);
        }

        // 1. LẤY DANH MỤC
        $categories = $categoryModel->getCategories();

        // 2. XỬ LÝ LỌC & TÌM KIẾM
        $categoryId = $_GET['category_id'] ?? 'all';
        $keyword = $_GET['q'] ?? '';
        $page = $_GET['page_no'] ?? 1;

        $products = [];

        if (!empty($keyword)) {
            // Tìm kiếm
            $products = $productModel->searchProducts($keyword);
        } elseif ($categoryId !== 'all') {
            // Lọc theo danh mục
            $products = $productModel->getProductsByCategoryId($categoryId);
        } else {
            // Lấy tất cả
            $products = $productModel->getProducts();
        }

        // 3. PHÂN TRANG (8 món/trang)
        $itemsPerPage = 8;
        $totalItems = count($products);
        $totalPages = ceil($totalItems / $itemsPerPage);

        // Cắt mảng cho trang hiện tại
        $offset = ($page - 1) * $itemsPerPage;
        $displayProducts = array_slice($products, $offset, $itemsPerPage);

        // 4. GỬI SANG VIEW
        $data = [
            'categories' => $categories,
            'products' => $displayProducts,
            'current_category' => $categoryId,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'keyword' => $keyword,
            'table_name' => $_SESSION['current_table'] ?? ''
        ];

        $this->loadView('client/menu', $data);
    }
    // --- HÀM MỚI: NHẬN DỮ LIỆU THANH TOÁN (AJAX) ---
    public function checkout_submit()
    {
        // 1. Nhận dữ liệu JSON
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        header('Content-Type: application/json');

        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Dữ liệu rỗng']);
            exit;
        }

        // 2. Lấy thông tin
        // Nếu khách tự đặt thì user_id = NULL, nếu nhân viên đặt hộ thì lấy ID nhân viên
        $userId = $_SESSION['user_id'] ?? null;

        $customerName = $data['customer_name'];
        $note = $data['note'];
        $totalAmount = $data['total_amount'];
        $cartItems = $data['cart_items'];

        // 3. Gọi Model
        $orderModel = new OrderModel();
        $result = $orderModel->createOrder($userId, $customerName, $totalAmount, $note, $cartItems);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi Database']);
        }
        exit;
    }

    private function loadView($viewPath, $data = [])
    {
        extract($data);
        ob_start();
        include "app/Views/$viewPath.php";
        $content = ob_get_clean();
        include "app/Views/layouts/main.php";
    }
}
