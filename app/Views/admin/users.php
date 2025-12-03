<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Nhân viên - DrinkAdmin</title>
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
                        bgLight: "#f8f9fa"
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                },
            },
        }
    </script>
</head>

<body class="bg-bgLight text-gray-800 font-sans h-screen flex overflow-hidden">

    <?php include __DIR__ . '/../layouts/sidebar_admin.php'; ?>

    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Quản lý Nhân viên</h1>
                <p class="text-sm text-gray-500">Quản lý tài khoản truy cập hệ thống</p>
            </div>
            <button onclick="openUserModal()" class="bg-primary hover:bg-[#0ebc49] text-white font-bold py-2.5 px-5 rounded-lg shadow-lg flex items-center gap-2 transition-all active:scale-95">
                <i class="fa-solid fa-user-plus"></i> Thêm nhân viên
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-8 custom-scroll">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-bold">
                        <tr>
                            <th class="px-6 py-4">Nhân viên</th>
                            <th class="px-6 py-4">Vai trò</th>
                            <th class="px-6 py-4">Trạng thái</th>
                            <th class="px-6 py-4 text-right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $u): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="<?= $u['avatar'] ?>" class="w-10 h-10 rounded-full border border-gray-200">
                                            <div>
                                                <p class="font-bold text-gray-900"><?= $u['fullname'] ?></p>
                                                <p class="text-xs text-gray-500"><?= $u['email'] ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase">
                                            <?= $u['role'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if ($u['status'] == 'active'): ?>
                                            <span class="flex items-center gap-1.5 text-green-600 font-bold text-xs"><span class="w-2 h-2 rounded-full bg-green-500"></span> Hoạt động</span>
                                        <?php else: ?>
                                            <span class="flex items-center gap-1.5 text-gray-500 font-bold text-xs"><span class="w-2 h-2 rounded-full bg-gray-400"></span> Đã khóa</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button onclick='openEditUser(<?= json_encode($u) ?>)' class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <a href="index.php?page=delete_user&id=<?= $u['id'] ?>" onclick="return confirm('Xóa tài khoản này?')" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Chưa có nhân viên nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/components/add_user_modal.php'; ?>



</body>

</html>