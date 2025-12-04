<?php
require_once __DIR__ . '/../Models/CategoryModel.php';
require_once __DIR__ . '/../Models/ProductModel.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/TableModel.php';
require_once __DIR__ . '/../Models/OrderModel.php';
class AdminController
{
    // 1. TRANG DASHBOARD (TỔNG QUAN)
    public function index()
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();

        // 1. LẤY SỐ LIỆU THẺ (CARDS)
        $todayRevenue = $orderModel->getTodayRevenue();
        $pendingOrders = $orderModel->countPendingOrders();
        $newCustomers = $orderModel->countNewCustomersToday();
        $totalDrinks = $productModel->countTotalProducts();

        $stats = [
            'sales' => ['value' => $todayRevenue, 'trend' => 'Hôm nay'],
            'orders' => ['value' => $pendingOrders, 'sub' => 'Đang chờ xử lý'],
            'customers' => ['value' => $newCustomers, 'trend' => 'Hôm nay'],
            'drinks' => ['value' => $totalDrinks, 'sub' => 'Món trong menu']
        ];

        // 2. LẤY DỮ LIỆU BIỂU ĐỒ (7 ngày qua)
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-d', strtotime('-6 days'));
        $chartRaw = $orderModel->getRevenueChartData($startDate, $endDate);

        $chartData = [
            'labels' => array_column($chartRaw, 'label'), // ['01/12', '02/12'...]
            'values' => array_column($chartRaw, 'value')  // [150000, 200000...]
        ];

        // 3. LẤY ĐƠN HÀNG GẦN ĐÂY
        $recent_orders = $orderModel->getLatestOrders(5);

        // Gửi sang View
        $data = [
            'stats' => $stats,
            'recent_orders' => $recent_orders,
            'chartData' => $chartData
        ];

        $this->loadView('admin/dashboard', $data);
    }
    // 2. HIỂN THỊ DANH SÁCH ĐƠN HÀNG
    public function orders()
    {
        $orderModel = new OrderModel();
        $orders = $orderModel->getOrders();

        $data = ['orders' => $orders];
        $this->loadView('admin/orders', $data);
    }

    // 2.1. API LẤY CHI TIẾT ĐƠN (Trả về JSON cho Javascript)
    public function get_order_details()
    {
        if (isset($_GET['id'])) {
            $orderModel = new OrderModel();
            $items = $orderModel->getOrderItems($_GET['id']);

            // Trả về JSON
            header('Content-Type: application/json');
            echo json_encode($items);
            exit;
        }
    }

    // 2.2. CẬP NHẬT TRẠNG THÁI
    public function update_order_status()
    {
        if (isset($_GET['id']) && isset($_GET['status'])) {
            $orderModel = new OrderModel();
            $orderModel->updateStatus($_GET['id'], $_GET['status']);
        }
        header('Location: index.php?page=admin_orders');
    }

    // 2.3. XÓA ĐƠN
    public function delete_order()
    {
        if (isset($_GET['id'])) {
            $orderModel = new OrderModel();
            $orderModel->delete($_GET['id']);
        }
        header('Location: index.php?page=admin_orders');
    }
    public function create_order()
    {
        // 1. Lấy danh sách sản phẩm để tìm kiếm
        $productModel = new ProductModel();
        $products = $productModel->getProducts(); // Lấy tất cả món

        // 2. Gửi sang View
        $data = ['products' => $products];
        $this->loadView('admin/create_order', $data);
    }
    public function store_order()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Lấy dữ liệu từ Form
            $customerName = $_POST['customer_name'] ?? 'Khách vãng lai';
            $customerEmail = $_POST['customer_email'] ?? '';
            $note = $_POST['order_note'] ?? '';

            // Dữ liệu giỏ hàng (JSON string -> Array)
            $cartJson = $_POST['cart_data'] ?? '[]';
            $cartItems = json_decode($cartJson, true); // Chuyển về mảng PHP

            $totalAmount = $_POST['total_amount'] ?? 0;

            // Lấy ID nhân viên đang đăng nhập (để biết ai tạo đơn)
            $userId = $_SESSION['user_id'] ?? 1; // Mặc định 1 nếu chưa login

            // 2. Validate cơ bản
            if (empty($cartItems)) {
                echo "<script>alert('Giỏ hàng đang trống!'); window.history.back();</script>";
                exit;
            }

            // 3. Gọi Model lưu
            $orderModel = new OrderModel();
            if ($orderModel->createOrder($userId, $customerName, $customerEmail, $totalAmount, $note, $cartItems)) {
                // Thành công -> Chuyển về trang danh sách đơn
                header('Location: index.php?page=admin_orders');
                exit;
            } else {
                echo "<script>alert('Lỗi: Không thể tạo đơn hàng. Vui lòng thử lại!'); window.history.back();</script>";
                exit;
            }
        }
        // Nếu không phải POST, quay về trang tạo đơn
        header('Location: index.php?page=admin_create_order');
        exit;
    }

    // 3. TRANG QUẢN LÝ ĐỒ UỐNG
    // 3.1. HIỂN THỊ DANH SÁCH MÓN
    public function drinks()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        // Lấy danh sách món và danh sách danh mục (để hiện trong dropdown chọn)
        $drinks = $productModel->getProducts();
        $categories = $categoryModel->getCategories();

        $data = [
            'drinks' => $drinks,
            'categories' => $categories
        ];
        // 1. Kiểm tra xem có từ khóa tìm kiếm không?
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (!empty($keyword)) {
            // Nếu có từ khóa -> Gọi hàm tìm kiếm
            $drinks = $productModel->searchProducts($keyword);
        } else {
            // Nếu không -> Lấy tất cả như bình thường
            $drinks = $productModel->getProducts();
        }

        $categories = $categoryModel->getCategories();

        $data = [
            'drinks' => $drinks,
            'categories' => $categories,
            'keyword' => $keyword // Truyền lại từ khóa để hiện trong ô input
        ];
        $this->loadView('admin/drinks', $data);
    }


    // 3.2. XỬ LÝ THÊM MÓN
    public function store_drink()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý upload ảnh
            $imagePath = 'https://via.placeholder.com/150'; // Ảnh mặc định
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "public/uploads/";
                // Tạo thư mục nếu chưa có
                if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

                $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $fileName;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $imagePath = $target_file;
                }
            }

            $productModel = new ProductModel();
            $productModel->create(
                $_POST['name'],
                $_POST['price'],
                $_POST['category_id'],
                $_POST['description'],
                $imagePath
            );
        }
        header('Location: index.php?page=admin_drinks');
    }

    // 3.3. XỬ LÝ SỬA MÓN
    public function update_drink()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $imagePath = $_POST['current_image']; // Lấy ảnh cũ

            // Nếu có upload ảnh mới thì thay thế
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "public/uploads/";
                $fileName = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $fileName;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $imagePath = $target_file;
                }
            }

            $productModel = new ProductModel();
            $productModel->update(
                $id,
                $_POST['name'],
                $_POST['price'],
                $_POST['category_id'],
                $_POST['description'],
                $imagePath
            );
        }
        header('Location: index.php?page=admin_drinks');
    }

    // 3.4. XỬ LÝ XÓA MÓN
    public function delete_drink()
    {
        if (isset($_GET['id'])) {
            $productModel = new ProductModel();
            $productModel->delete($_GET['id']);
        }
        header('Location: index.php?page=admin_drinks');
    }




    // 4. TRANG QUẢN LÝ DANH MỤC
    public function categories()
    {
        // KHỞI TẠO MODEL
        $categoryModel = new CategoryModel();

        // LẤY DỮ LIỆU TỪ DATABASE
        $categories_data = $categoryModel->getCategories();

        // CHUẨN HÓA DỮ LIỆU (Để khớp với view cũ của bạn)
        // Vì DB chưa có cột 'count', ta tạm gán cứng hoặc join bảng sau này
        $categories = [];
        foreach ($categories_data as $cat) {
            $categories[] = [
                'id' => $cat['id'],
                'name' => $cat['name'],
                'icon' => $cat['icon'],
                'count' => $cat['product_count'] // Số lượng món trong danh mục
            ];
        }
        $data = ['categories' => $categories];
        $this->loadView('admin/categories', $data);
    }
    // --- HÀM XỬ LÝ LƯU DANH MỤC ---
    public function store_category()
    {
        // Kiểm tra xem có phải người dùng bấm nút Submit không
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $icon = $_POST['category_icon'] ?? 'fa-martini-glass';

            if (!empty($name)) {
                // Gọi Model để lưu
                $categoryModel = new CategoryModel();

                // Thêm dòng kiểm tra lỗi này
                if ($categoryModel->create($name, $icon)) {
                    // Nếu lưu thành công -> Quay về trang danh sách
                    header('Location: index.php?page=admin_categories');
                    exit;
                } else {
                    // Nếu lỗi -> Hiện thông báo
                    die("Lỗi: Không thể lưu vào Database. Kiểm tra lại Model hoặc Kết nối.");
                }
            }
        }

        // Nếu không có dữ liệu post, quay về
        header('Location: index.php?page=admin_categories');
        exit;
    }

    // 2. XỬ LÝ XÓA DANH MỤC (Khi bấm nút Thùng rác)
    public function delete_category()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $categoryModel = new CategoryModel();
            $categoryModel->delete($id);
        }
        // Xóa xong quay lại trang danh sách
        header('Location: index.php?page=admin_categories');
        exit;
    }
    // --- HÀM XỬ LÝ SỬA DANH MỤC ---
    public function update_category()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $icon = $_POST['category_icon'] ?? 'fa-martini-glass';

            if (!empty($id) && !empty($name)) {
                $categoryModel = new CategoryModel();
                $categoryModel->update($id, $name, $icon);
            }
        }
        // Sửa xong quay về trang danh sách
        header('Location: index.php?page=admin_categories');
        exit;
    }
    // 5. TRANG QUẢN LÝ BÀN ---
    public function tables()
    {
        $tableModel = new TableModel();

        // 1. Lấy tham số từ URL
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $filter  = isset($_GET['filter']) ? $_GET['filter'] : 'all'; // Mặc định là 'all'

        // 2. Gọi hàm getList mới trong Model
        $tables = $tableModel->getList($keyword, $filter);

        // 3. Gửi dữ liệu sang View
        $data = [
            'tables' => $tables,
            'keyword' => $keyword,
            'filter' => $filter // Gửi biến này để View biết đang lọc cái gì mà tô màu nút
        ];

        $this->loadView('admin/tables', $data);
    }

    // 2. XỬ LÝ THÊM BÀN
    public function store_table()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $capacity = $_POST['capacity'];
            $section = $_POST['section'];
            $qr_option = $_POST['qr_option']; // 'auto' hoặc 'manual'

            $tableModel = new TableModel();

            // Gọi hàm create, nếu thành công thì reload trang
            if ($tableModel->create($name, $capacity, $section, $qr_option)) {
                header('Location: index.php?page=admin_tables');
                exit;
            } else {
                echo "Lỗi: Không thể thêm bàn.";
                die();
            }
        }
        // Nếu không phải POST thì quay về
        header('Location: index.php?page=admin_tables');
    }

    // 3. XỬ LÝ XÓA BÀN
    public function delete_table()
    {
        if (isset($_GET['id'])) {
            $tableModel = new TableModel();
            $tableModel->delete($_GET['id']);
        }
        header('Location: index.php?page=admin_tables');
    }
    public function update_table()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $capacity = $_POST['capacity'];
            $section = $_POST['section'];

            // Lấy hành động QR: keep (giữ), auto (tạo lại), remove (xóa)
            $qr_action = $_POST['qr_action'] ?? 'keep';

            $tableModel = new TableModel();
            $tableModel->update($id, $name, $capacity, $section, $qr_action);
        }
        header('Location: index.php?page=admin_tables');
    }


    // 6. TRANG QUẢN LÝ NHÂN VIÊN
    public function users()
    {
        $userModel = new UserModel();
        $users = $userModel->getUsers();

        $data = ['users' => $users];
        $this->loadView('admin/users', $data);
    }

    // 6.1. XỬ LÝ THÊM NHÂN VIÊN
    public function store_user()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role']; // cashier, admin...
            // Checkbox: nếu tích là 'active', không tích là 'inactive'
            $status = isset($_POST['status']) ? 'active' : 'inactive';

            $userModel = new UserModel();
            $userModel->create($fullname, $email, $password, $role, $status);
        }
        header('Location: index.php?page=admin_users');
    }

    // 6.2. XỬ LÝ CẬP NHẬT NHÂN VIÊN
    public function update_user()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password']; // Có thể rỗng
            $role = $_POST['role'];
            $status = isset($_POST['status']) ? 'active' : 'inactive';

            $userModel = new UserModel();
            $userModel->update($id, $fullname, $email, $password, $role, $status);
        }
        header('Location: index.php?page=admin_users');
    }

    // 6.3. XỬ LÝ XÓA NHÂN VIÊN
    public function delete_user()
    {
        if (isset($_GET['id'])) {
            $userModel = new UserModel();
            $userModel->delete($_GET['id']);
        }
        header('Location: index.php?page=admin_users');
    }

    // --- HÀM MỚI: BÁO CÁO DOANH THU ---
    public function reports()
    {
        $orderModel = new OrderModel();

        // 1. Nhận ngày từ URL (Mặc định là 7 ngày gần nhất)
        $startDate = $_GET['start'] ?? date('Y-m-d', strtotime('-6 days'));
        $endDate   = $_GET['end']   ?? date('Y-m-d');

        // 2. Gọi Model với khoảng ngày này
        $chartRaw = $orderModel->getRevenueChartData($startDate, $endDate);

        // Chuẩn bị dữ liệu cho Chart.js
        $chartData = [
            'labels' => array_column($chartRaw, 'date'),
            'values' => array_column($chartRaw, 'total')
        ];

        // Các thống kê khác (giữ nguyên hoặc lọc theo ngày tùy bạn)
        $metrics = [
            'revenue' => $orderModel->getTotalRevenue(), // Có thể nâng cấp hàm này để lọc theo ngày luôn
            'transactions' => $orderModel->getTotalTransactions(),
            'aov' => 0,
            'new_customers' => 15
        ];
        if ($metrics['transactions'] > 0)
            $metrics['aov'] = $metrics['revenue'] / $metrics['transactions'];

        // Gửi dữ liệu sang View (Kèm ngày đã chọn để điền lại vào ô input)
        $data = [
            'metrics' => $metrics,
            'chartData' => $chartData,
            'transactions' => $orderModel->getRecentTransactions(),
            'filter' => [
                'start' => $startDate,
                'end' => $endDate
            ]
        ];

        $this->loadView('admin/reports', $data);
    }

    // 4. CÁC TRANG CHƯA LÀM (Placeholder)
    public function products()
    {
        echo "Trang quản lý món (Đang phát triển)";
    }

    // --- HÀM HỖ TRỢ (QUAN TRỌNG: CHỈ KHAI BÁO 1 LẦN DUY NHẤT) ---
    private function loadView($viewPath, $data = [])
    {
        extract($data);
        include "app/Views/$viewPath.php";
    }
}
