<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Drinky Staff</title>
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

<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center px-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 sm:p-10 space-y-8">

        <div class="text-center">
            <div class="mx-auto w-12 h-12 text-primary mb-4">
                <i class="fa-solid fa-martini-glass-citrus text-5xl"></i>
            </div>

            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Cổng Nhân Viên & Quản Trị Viên</h2>
            <p class="mt-2 text-sm text-gray-500">Đăng nhập để quản lý hệ thống đặt đồ uống</p>
        </div>
        <?php if (!empty($error)): ?>
            <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg mb-4 border border-red-200 flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span><?= $error ?></span>
            </div>
        <?php endif; ?>


        <form class="space-y-6" action="index.php?page=login" method="POST">

            <div class="space-y-1">
                <label for="username" class="block text-sm font-medium text-gray-700">Tên đăng nhập hoặc Email</label>
                <input id="username" name="username" type="text" required
                    class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all sm:text-sm"
                    placeholder="Nhập tên đăng nhập hoặc email">
            </div>

            <div class="space-y-1">
                <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                <div class="relative">
                    <input id="password" name="password" type="password" required
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all sm:text-sm pr-10"
                        placeholder="Nhập mật khẩu của bạn">

                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer toggle-password" data-target="password">
                        <i class="fa-regular fa-eye text-gray-400 hover:text-gray-600 transition-colors"></i>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-start">
                <a href="#" class="text-sm font-medium text-gray-500 hover:text-primary hover:underline decoration-2 underline-offset-2 transition-all">
                    Quên mật khẩu?
                </a>
            </div>

            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent text-base font-bold rounded-lg text-white bg-primary hover:bg-[#0ebc49] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-lg shadow-green-500/30 transition-all active:scale-[0.98]">
                Đăng nhập
            </button>
        </form>

    </div>

    <div class="mt-8 text-center text-sm text-gray-500">
        <p>© 2025 Drinky Solutions. All rights reserved.</p>
    </div>

    <script src="public/assets/js/login.js"></script>
</body>

</html>