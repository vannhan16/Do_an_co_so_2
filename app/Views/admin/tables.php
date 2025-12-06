<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Bàn & QR - DrinkAdmin</title>
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
                <h1 class="text-2xl font-bold text-gray-900">Quản lý Bàn & Mã QR</h1>
                <p class="text-sm text-gray-500">Thiết lập bàn ăn và in mã QR gọi món</p>
            </div>
            <button onclick="openTableModal()" class="bg-primary hover:bg-[#0ebc49] text-white font-bold py-2.5 px-5 rounded-lg shadow-lg flex items-center gap-2 transition-all active:scale-95">
                <i class="fa-solid fa-plus"></i> Thêm bàn mới
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-8 custom-scroll">

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                <form action="index.php" method="GET" class="relative w-full md:w-96">
                    <input type="hidden" name="page" value="admin_tables">
                    <input type="hidden" name="filter" value="<?= isset($filter) ? $filter : 'all' ?>">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" name="q" value="<?= isset($keyword) ? htmlspecialchars($keyword) : '' ?>" placeholder="Tìm theo tên bàn hoặc khu vực..." class="w-full pl-10 pr-20 py-2.5 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary outline-none shadow-sm">
                    <?php if (!empty($keyword)): ?>
                        <a href="index.php?page=admin_tables" class="absolute right-3 top-3 text-gray-400 hover:text-red-500"><i class="fa-solid fa-xmark"></i></a>
                    <?php endif; ?>
                </form>

                <div class="flex bg-gray-100 p-1 rounded-lg">
                    <?php
                    $filter = isset($filter) ? $filter : 'all';
                    function activeFilter($c, $t)
                    {
                        return $c === $t ? 'bg-white text-gray-800 shadow-sm font-bold' : 'text-gray-500 hover:text-gray-800 font-medium hover:bg-gray-200';
                    }
                    ?>
                    <a href="index.php?page=admin_tables&filter=all" class="px-4 py-1.5 rounded text-sm transition-all <?= activeFilter($filter, 'all') ?>">Tất cả</a>
                    <a href="index.php?page=admin_tables&filter=active" class="px-4 py-1.5 rounded text-sm transition-all <?= activeFilter($filter, 'active') ?>">Đã có QR</a>
                    <a href="index.php?page=admin_tables&filter=missing" class="px-4 py-1.5 rounded text-sm transition-all <?= activeFilter($filter, 'missing') ?>">Chưa có QR</a>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-bold">
                        <tr>
                            <th class="px-6 py-4">Tên bàn</th>
                            <th class="px-6 py-4">Sức chứa</th>
                            <th class="px-6 py-4">Khu vực</th>
                            <th class="px-6 py-4">Trạng thái QR</th>
                            <th class="px-6 py-4 text-right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <?php if (!empty($tables)): ?>
                            <?php foreach ($tables as $t): ?>
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-6 py-4 font-bold text-gray-900"><?= $t['name'] ?></td>
                                    <td class="px-6 py-4 text-gray-600"><?= $t['capacity'] ?> người</td>
                                    <td class="px-6 py-4 text-gray-600"><?= $t['section'] ?></td>
                                    <td class="px-6 py-4">
                                        <?php if (!empty($t['qr_code'])): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700"><i class="fa-solid fa-check-circle"></i> Đã gán</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700"><i class="fa-solid fa-triangle-exclamation"></i> Thiếu QR</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <button onclick='openQRModal(<?= json_encode(["id" => $t["id"], "name" => $t["name"], "qr_code" => $t["qr_code"]]) ?>)' class="text-gray-400 hover:text-gray-800 transition-colors">
                                                <i class="fa-solid fa-qrcode"></i>
                                            </button>

                                            <button onclick='openEditTable(<?= json_encode($t, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)' class="text-gray-400 hover:text-blue-600"><i class="fa-solid fa-pen"></i></button>

                                            <a href="index.php?page=delete_table&id=<?= $t['id'] ?>" onclick="return confirm('Xóa bàn này?')" class="text-gray-400 hover:text-red-500"><i class="fa-solid fa-trash-can"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">Chưa có bàn nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/components/add_table_modal.php'; ?>

    <?php include __DIR__ . '/components/update_table_modal.php'; ?>

    <!-- Modal hiển thị QR Code -->
    <div id="qr-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeQRModal()"></div>
        <div class="bg-white rounded-2xl shadow-2xl p-8 relative z-10 max-w-md w-full">
            <button onclick="closeQRModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h2 class="text-2xl font-bold text-gray-900 mb-2" id="qr-modal-title">Mã QR - Bàn</h2>
            <p class="text-gray-500 text-sm mb-6" id="qr-modal-subtitle">Quét QR để gọi món tại bàn này</p>

            <div class="flex flex-col items-center gap-6">
                <div class="bg-gray-100 p-4 rounded-xl">
                    <img id="qr-image" src="" alt="QR Code" class="w-64 h-64 object-contain">
                </div>

                <button onclick="downloadQR()" class="w-full bg-primary hover:bg-[#0ebc49] text-white font-bold py-3 rounded-xl shadow-lg shadow-green-500/30 transition-all active:scale-95 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-download"></i> Tải xuống
                </button>
            </div>
        </div>
    </div>

    <script>
        function openQRModal(table) {
            if (!table.qr_code) {
                alert('Bàn này chưa có mã QR');
                return;
            }

            const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=${encodeURIComponent(table.qr_code)}`;
            document.getElementById('qr-image').src = qrUrl;
            document.getElementById('qr-modal-title').innerText = `Mã QR - ${table.name}`;
            document.getElementById('qr-modal').classList.remove('hidden');

            // Lưu URL để dùng trong download
            window.currentQRUrl = qrUrl;
            window.currentTableName = table.name;
        }

        function closeQRModal() {
            document.getElementById('qr-modal').classList.add('hidden');
        }

        function downloadQR() {
            if (!window.currentQRUrl) return;

            const link = document.createElement('a');
            link.href = window.currentQRUrl;
            link.download = `QR_${window.currentTableName || 'Ban'}.png`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Đóng modal khi bấm ngoài
        document.getElementById('qr-modal')?.addEventListener('click', function(e) {
            if (e.target === this) closeQRModal();
        });
    </script>
</body>

</html>