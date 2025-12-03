<?php
// app/Controllers/MenuController.php
require_once 'app/Models/ProductModel.php';
require_once 'app/Models/CategoryModel.php';

class MenuController
{

    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        // 1. LẤY DANH MỤC (Cho thanh Tabs)
        $categories_data = $categoryModel->getCategories();
        // Chuyển đổi format để khớp với View cũ (nếu cần) hoặc dùng trực tiếp
        // Ở đây mình sẽ dùng trực tiếp trong View cho tối ưu

        // 2. LẤY SẢN PHẨM TỪ DATABASE
        // Kiểm tra xem có đang lọc theo danh mục không?
        $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 'all';
        $keyword = isset($_GET['q']) ? $_GET['q'] : '';

        // Nếu có từ khóa tìm kiếm
        if (!empty($keyword)) {
            $all_products = $productModel->searchProducts($keyword);
        }
        // Nếu lọc theo danh mục (ID)
        elseif ($category_id !== 'all') {
            // Chúng ta cần thêm hàm getProductsByCategory vào Model sau này
            // Tạm thời lấy tất cả rồi lọc bằng PHP (hoặc viết thêm hàm trong Model thì tốt hơn)
            $all_products = $productModel->getProductsByCategoryId($category_id);
        }
        // Lấy tất cả
        else {
            $all_products = $productModel->getProducts();
        }

        // 3. PHÂN TRANG (PAGINATION)
        $current_page = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
        $items_per_page = 8; // Số món trên 1 trang
        $total_items = count($all_products);
        $total_pages = ceil($total_items / $items_per_page);

        // Đảm bảo trang hợp lệ
        if ($current_page < 1) $current_page = 1;
        if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;

        // Cắt mảng dữ liệu
        $offset = ($current_page - 1) * $items_per_page;
        $display_products = array_slice($all_products, $offset, $items_per_page);

        // 4. GỬI DỮ LIỆU SANG VIEW
        $data = [
            'categories' => $categories_data,
            'products' => $display_products, // Danh sách món trang hiện tại
            'current_category' => $category_id,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'keyword' => $keyword
        ];

        $this->loadView('client/menu', $data);
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
