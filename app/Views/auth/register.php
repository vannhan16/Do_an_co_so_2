<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Tài Khoản - DrinkSys</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#13ec5b",
                        secondary: "#102216",
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                },
            },
        }
    </script>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 space-y-6">

        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">Tạo tài khoản</h2>
            <p class="mt-2 text-sm text-gray-600">Dành cho Quản trị viên và Thu ngân</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg border border-red-200 flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span><?= $error ?></span>
            </div>
        <?php endif; ?>

        <form class="space-y-5" action="index.php?page=register" method="POST">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                <input name="fullname" type="text" required class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary outline-none sm:text-sm" placeholder="Nhập họ tên đầy đủ">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ Email</label>
                <input name="email" type="email" required class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary outline-none sm:text-sm" placeholder="Nhập email công việc">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                <div class="relative">
                    <input id="password" name="password" type="password" required class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary outline-none sm:text-sm pr-10" placeholder="Nhập mật khẩu">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer toggle-password" data-target="password">
                        <i class="fa-regular fa-eye text-gray-400 hover:text-gray-600"></i>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nhập lại mật khẩu</label>
                <div class="relative">
                    <input id="confirm_password" name="confirm_password" type="password" required class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary outline-none sm:text-sm pr-10" placeholder="Xác nhận mật khẩu">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer toggle-password" data-target="confirm_password">
                        <i class="fa-regular fa-eye text-gray-400 hover:text-gray-600"></i>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vai trò</label>
                <div class="relative">
                    <select name="role" class="block w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary outline-none bg-white sm:text-sm appearance-none">
                        <option value="admin">Quản trị viên (Administrator)</option>
                        <option value="cashier">Thu ngân (Cashier)</option>
                        <option value="manager">Quản lý (Manager)</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-gray-500 pointer-events-none text-xs"></i>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3 px-4 text-sm font-bold rounded-lg text-white bg-primary hover:bg-[#0ebc49] shadow-lg shadow-green-500/30 transition-all active:scale-95">
                    Đăng ký tài khoản
                </button>
            </div>

            <div class="text-center text-sm">
                <span class="text-gray-600">Đã có tài khoản?</span>
                <a href="index.php?page=login" class="font-medium text-primary hover:underline">Đăng nhập</a>
            </div>
        </form>
    </div>

    <script src="public/assets/js/register.js"></script>
</body>

</html>