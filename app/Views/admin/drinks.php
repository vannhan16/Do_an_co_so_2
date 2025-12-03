<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đồ uống - DrinkAdmin</title>
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

<body class="bg-bgLight text-gray-800 font-sans h-screen flex overflow-hidden">

    <?php include __DIR__ . '/../layouts/sidebar_admin.php'; ?>
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <header class="bg-white border-b border-gray-200 px-8 py-5 shrink-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Quản lý Đồ uống</h1>
                <p class="text-sm text-gray-500 mt-1">Thêm, sửa và xóa món trong thực đơn của bạn.</p>
            </div>
            <button onclick="openAddModal()" class="bg-primary hover:bg-[#0ebc49] text-white font-bold py-2.5 px-6 rounded-lg shadow-lg shadow-green-500/30 flex items-center gap-2 transition-all active:scale-95 shrink-0">
                <i class="fa-solid fa-plus"></i> Thêm món mới
            </button>
        </header>

        <div class="px-8 pt-6">
            <form action="index.php" method="GET" class="relative max-w-full">

                <input type="hidden" name="page" value="admin_drinks">

                <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400 text-lg"></i>

                <input type="text"
                    name="q"
                    value="<?= isset($keyword) ? htmlspecialchars($keyword) : '' ?>"
                    placeholder="Tìm kiếm đồ uống theo tên, mô tả..."
                    class="w-full pl-12 pr-28 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none shadow-sm transition-all text-base">

                <button type="submit" class="absolute right-2 top-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-1.5 px-4 rounded-lg text-sm transition-colors">
                    Tìm
                </button>

                <?php if (!empty($keyword)): ?>
                    <a href="index.php?page=admin_drinks" class="absolute right-20 top-2.5 text-gray-400 hover:text-red-500" title="Xóa tìm kiếm">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </a>
                <?php endif; ?>

            </form>
        </div>

        <div class="flex-1 overflow-y-auto p-8 custom-scroll">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($drinks as $d): ?>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden group relative">

                        <div class="h-48 overflow-hidden relative">
                            <img src="<?= $d['image'] ?>" alt="<?= $d['name'] ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <button onclick='openEditModal(<?= json_encode([
                                                                    'id' => $d['id'],
                                                                    'name' => $d['name'],
                                                                    'price' => $d['price'],
                                                                    'description' => $d['desc'] ?? ($d['description'] ?? ''),
                                                                    'category_id' => $d['category_id'] ?? '',
                                                                    'image' => $d['image'] ?? ($d['image'] ?? '')
                                                                ]) ?>)'
                                    class="w-10 h-10 bg-white text-gray-700 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-colors shadow-lg" title="Chỉnh sửa">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <a href="index.php?page=delete_drink&id=<?= $d['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                                    class="w-10 h-10 bg-white text-red-500 rounded-full flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors shadow-lg"
                                    title="Xóa">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </div>

                        <div class="p-5">
                            <h3 class="font-bold text-gray-900 text-lg mb-1"><?= $d['name'] ?></h3>
                            <p class="text-sm text-gray-500 line-clamp-2 h-10 mb-3"><?= $d['description'] ?></p>
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-900 text-xl"><?= number_format($d['price'], 0, ',', '.') ?>đ</span>
                                <span class="text-xs font-bold px-2 py-1 bg-green-100 text-green-700 rounded-lg">Đang bán</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="flex justify-center mt-10 gap-2">
                <button class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-200 text-gray-600"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-primary text-white font-bold shadow-md shadow-green-500/30">1</button>
                <button class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-200 text-gray-600">2</button>
                <button class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-200 text-gray-600">3</button>
                <span class="w-9 h-9 flex items-center justify-center text-gray-400">...</span>
                <button class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-200 text-gray-600">8</button>
                <button class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-200 text-gray-600"><i class="fa-solid fa-chevron-right"></i></button>
            </div>

        </div>
    </main>
    <?php include __DIR__ . '/components/add_drink_modal.php'; ?>


</body>

</html>