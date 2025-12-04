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
        <header class="bg-white border-b border-gray-200 px-8 py-5 shrink-0 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Quản lý Đồ uống</h1>
                <p class="text-sm text-gray-500">Danh sách thực đơn hiện tại</p>
            </div>
            <button onclick="openAddModal()" class="bg-primary hover:bg-[#0ebc49] text-white font-bold py-2.5 px-6 rounded-lg shadow-lg shadow-green-500/30 flex items-center gap-2 transition-all active:scale-95 shrink-0">
                <i class="fa-solid fa-plus"></i> Thêm món mới
            </button>
        </header>

        <div class="px-8 pt-6">
            <form action="index.php" method="GET" class="relative max-w-full">
                <input type="hidden" name="page" value="admin_drinks">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400 text-lg"></i>
                <input type="text" name="q" value="<?= isset($keyword) ? htmlspecialchars($keyword) : '' ?>" placeholder="Tìm kiếm đồ uống theo tên..." class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none shadow-sm transition-all text-base">
            </form>
        </div>

        <div class="flex-1 overflow-y-auto p-8 custom-scroll">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php if (!empty($drinks)): ?>
                    <?php foreach ($drinks as $d): ?>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden group relative">

                            <div class="h-48 overflow-hidden relative bg-gray-100">
                                <img src="<?= $d['image'] ?>" alt="<?= $d['name'] ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" onerror="this.src='https://via.placeholder.com/300'">

                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button onclick='openEditModal(<?= json_encode($d) ?>)' class="w-10 h-10 bg-white text-blue-600 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors shadow-lg" title="Sửa">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>

                                    <a href="index.php?page=delete_drink&id=<?= $d['id'] ?>" onclick="return confirm('Xóa món này?')" class="w-10 h-10 bg-white text-red-500 rounded-full flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors shadow-lg" title="Xóa">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="p-5">
                                <h3 class="font-bold text-gray-900 text-lg mb-1"><?= $d['name'] ?></h3>
                                <p class="text-xs text-gray-500 mb-2 font-semibold uppercase tracking-wide">
                                    <?= isset($d['category_name']) ? $d['category_name'] : 'Chưa phân loại' ?>
                                </p>
                                <p class="text-sm text-gray-500 line-clamp-2 h-10 mb-3"><?= $d['description'] ?></p>

                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-gray-900 text-xl"><?= number_format($d['price'], 0, ',', '.') ?>đ</span>
                                    <span class="text-xs font-bold px-2 py-1 bg-green-100 text-green-700 rounded-lg">Đang bán</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-3 text-center py-10">
                        <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Chưa có món nào. Hãy thêm mới!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/components/add_drink_modal.php'; ?>

    <script>
        const modal = document.getElementById('add-drink-modal'); // Sử dụng chung modal thêm
        // Lưu ý: Đảm bảo file add_drink_modal.php có ID là 'add-drink-modal'
        // Hoặc bạn có thể dùng file riêng, nhưng ở bài trước chúng ta đã làm modal chung.

        // Cần đảm bảo các ID trong form khớp với code bên dưới
        // Ví dụ form id="drink-form", input id="drink-name"...

        function openEditModal(data) {
            // Hiển thị modal
            const modalEl = document.getElementById('add-drink-modal');
            modalEl.classList.remove('hidden');
            setTimeout(() => {
                modalEl.firstElementChild.classList.remove('opacity-0');
                modalEl.lastElementChild.firstElementChild.classList.remove('scale-95', 'opacity-0');
            }, 10);

            // Đổi tiêu đề và action
            // Lưu ý: Các ID dưới đây phải có trong file components/add_drink_modal.php
            // Nếu chưa có, bạn cần vào file đó thêm ID vào các thẻ input tương ứng
            // Ví dụ: <input name="name" id="drink-name">

            // Ở đây tôi giả định bạn đã thêm ID vào file component hoặc tôi sẽ cung cấp file component chuẩn ngay dưới đây.

            // Cách đơn giản nhất: Điền dữ liệu vào form
            const form = document.querySelector('#add-drink-modal form');
            form.action = "index.php?page=update_drink";

            // Thêm input ID ẩn nếu chưa có
            let idInput = form.querySelector('input[name="id"]');
            if (!idInput) {
                idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'id';
                form.appendChild(idInput);
            }
            idInput.value = data.id;

            // Điền các trường
            if (form.querySelector('input[name="name"]')) form.querySelector('input[name="name"]').value = data.name;
            if (form.querySelector('textarea')) form.querySelector('textarea').value = data.description; // Sửa desc -> description
            if (form.querySelector('input[name="price"]')) form.querySelector('input[name="price"]').value = data.price;
            if (form.querySelector('select')) form.querySelector('select').value = data.category_id;

            // Xử lý ảnh cũ
            let oldImgInput = form.querySelector('input[name="current_image"]');
            if (!oldImgInput) {
                oldImgInput = document.createElement('input');
                oldImgInput.type = 'hidden';
                oldImgInput.name = 'current_image';
                form.appendChild(oldImgInput);
            }
            oldImgInput.value = data.image; // Sửa img -> image

            // Hiển thị preview
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('upload-placeholder');
            if (preview && placeholder) {
                preview.src = data.image;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
        }
    </script>
</body>

</html>