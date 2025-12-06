<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Danh mục - DrinkAdmin</title>
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
                        bgLight: "#f8f9fa",
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                },
            },
        }
    </script>
</head>

<body class="bg-bgLight text-gray-800 font-sans">

    <div class="flex h-screen overflow-hidden">

        <?php include __DIR__ . '/../layouts/sidebar_admin.php'; ?>
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 shrink-0">
                <h2 class="text-xl font-bold text-gray-800">Danh mục</h2>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-gray-900"><?= $_SESSION['user_name'] ?? 'Admin' ?></p>
                        <p class="text-xs text-gray-500">Quản trị viên</p>
                    </div>
                    <img src="<?= $_SESSION['avatar'] ?? 'https://ui-avatars.com/api/?name=Admin' ?>" class="w-9 h-9 rounded-full border border-gray-200">
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8">

                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-900">Quản lý Danh mục</h2>
                    <button onclick="openCategoryModal()" class="bg-primary hover:bg-[#0ebc49] text-white font-bold py-2.5 px-5 rounded-lg shadow-lg shadow-green-500/30 flex items-center gap-2 transition-all active:scale-95">
                        <i class="fa-solid fa-plus"></i> Thêm danh mục mới
                    </button>
                </div>

                <div class="space-y-4">
                    <?php foreach ($categories as $cat): ?>
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow group">

                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-50 text-gray-600 rounded-lg flex items-center justify-center text-xl group-hover:bg-green-50 group-hover:text-primary transition-colors">
                                    <i class="fa-solid <?= $cat['icon'] ?>"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg"><?= $cat['name'] ?></h3>
                                    <p class="text-xs text-gray-400"><?= $cat['count'] ?> sản phẩm</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 pr-2">
                                <button onclick='openEditModal(<?= json_encode($cat['id']) ?>, <?= json_encode($cat['name']) ?>, <?= json_encode($cat['icon']) ?>)'
                                    class="w-9 h-9 flex items-center justify-center rounded-full text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-colors"
                                    title="Sửa">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <a href="index.php?page=delete_category&id=<?= $cat['id'] ?>"
                                    class="w-9 h-9 flex items-center justify-center rounded-full text-gray-400 hover:bg-red-50 hover:text-red-500 transition-colors"
                                    title="Xóa"
                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </main>
    </div>
    <?php include __DIR__ . '/components/add_category_modal.php'; ?>
</body>

</html>