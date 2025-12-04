<main class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 min-h-[600px]">

    <div class="mb-8">
        <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
            <a href="index.php?page=menu&category_id=all"
                class="whitespace-nowrap px-6 py-2 rounded-full text-sm font-bold transition-all 
               <?= ($current_category == 'all') ? 'bg-primary text-white shadow-lg shadow-green-500/30' : 'bg-white text-gray-600 hover:bg-gray-100' ?>">
                Tất cả
            </a>

            <?php foreach ($categories as $cat): ?>
                <?php
                $isActive = ($current_category == $cat['id']);
                $cls = $isActive ? 'bg-primary text-white shadow-lg shadow-green-500/30' : 'bg-white text-gray-600 hover:bg-gray-100';
                ?>
                <a href="index.php?page=menu&category_id=<?= $cat['id'] ?>"
                    class="whitespace-nowrap px-6 py-2 rounded-full text-sm font-bold transition-all <?= $cls ?>">
                    <i class="fa-solid <?= $cat['icon'] ?> mr-2"></i> <?= $cat['name'] ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (count($products) > 0): ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            <?php foreach ($products as $p): ?>
                <div class="group bg-white rounded-2xl p-3 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full">

                    <div class="relative w-full aspect-[4/5] rounded-xl overflow-hidden mb-3 bg-gray-100">
                        <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            onerror="this.src='https://via.placeholder.com/300?text=No+Image'">

                        <button class="absolute bottom-2 right-2 w-10 h-10 bg-white text-primary rounded-full shadow-lg flex items-center justify-center hover:bg-primary hover:text-white transition-colors z-10"
                            onclick='openProductModal(<?= json_encode([
                                                            "id" => $p["id"],
                                                            "name" => $p["name"],
                                                            "price" => (int)$p["price"],
                                                            "img" => $p["image"], // Chú ý: trong DB là image hay img? Sửa cho khớp
                                                            "description" => $p["description"] // Chú ý: trong DB là description hay desc?
                                                        ]) ?>)'>
                            <i class="fa-solid fa-plus text-lg pointer-events-none"></i>
                        </button>
                    </div>

                    <div class="mt-auto">
                        <h3 class="font-bold text-gray-800 text-sm md:text-base line-clamp-1 mb-1" title="<?= $p['name'] ?>">
                            <?= $p['name'] ?>
                        </h3>
                        <div class="flex items-center justify-between">
                            <span class="text-primary font-extrabold text-sm md:text-lg">
                                <?= number_format($p['price'], 0, ',', '.') ?>đ
                            </span>
                            <div class="flex text-yellow-400 text-xs">
                                <i class="fa-solid fa-star"></i>
                                <span class="text-gray-400 ml-1">5.0</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="flex flex-col items-center justify-center py-20 text-gray-400">
            <i class="fa-solid fa-mug-hot text-6xl mb-4 opacity-20"></i>
            <p class="text-lg">Không tìm thấy món nào.</p>
            <a href="index.php?page=menu" class="text-primary hover:underline mt-2 font-medium">Xem tất cả thực đơn</a>
        </div>
    <?php endif; ?>

    <?php if ($total_pages > 1): ?>
        <div class="flex justify-center mt-10 gap-2">
            <?php
            // Hàm tạo link
            function pageLink($p, $cat, $kw)
            {
                $link = "index.php?page=menu&page_no=$p";
                if ($cat != 'all') $link .= "&category_id=$cat";
                if (!empty($kw)) $link .= "&q=$kw";
                return $link;
            }
            ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="<?= pageLink($i, $current_category, $keyword) ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-lg font-bold transition-all 
                   <?= ($i == $current_page) ? 'bg-primary text-white shadow-lg shadow-green-500/30' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</main>