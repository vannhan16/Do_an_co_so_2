<main class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 min-h-[600px]">

    <div class="mb-8">
        <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">

            <a href="index.php?page=menu&category_id=all"
                class="whitespace-nowrap px-6 py-2 rounded-full text-sm font-bold capitalize transition-all 
               <?= ($current_category === 'all') ? 'bg-primary text-white shadow-lg shadow-green-500/30' : 'bg-white text-gray-600 hover:bg-gray-100' ?>">
                Tất cả
            </a>

            <?php foreach ($categories as $cat): ?>
                <?php
                $isActive = ($current_category == $cat['id']); // So sánh ID
                $activeClass = "bg-primary text-white shadow-lg shadow-green-500/30";
                $inactiveClass = "bg-white text-gray-600 hover:bg-gray-100";
                ?>
                <a href="index.php?page=menu&category_id=<?= $cat['id'] ?>"
                    class="whitespace-nowrap px-6 py-2 rounded-full text-sm font-bold capitalize transition-all <?= $isActive ? $activeClass : $inactiveClass ?>">

                    <?= $cat['name'] ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (count($products) > 0): ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            <?php foreach ($products as $p): ?>
                <div class="group bg-white rounded-2xl p-3 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col">

                    <div class="relative w-full aspect-[4/5] rounded-xl overflow-hidden mb-3 bg-gray-100">
                        <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            onerror="this.src='https://via.placeholder.com/300x400?text=No+Image'">

                        <button class="btn-cart absolute bottom-2 right-2 text-white"
                            onclick="openProductModal({
                                id: '<?= $p['id'] ?>',
                                name: '<?= htmlspecialchars($p['name']) ?>',
                                price: <?= $p['price'] ?>, 
                                img: '<?= $p['image'] ?>'
                            })">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>

                    <div class="mt-auto">
                        <h3 class="font-bold text-gray-800 text-sm md:text-base line-clamp-1 mb-1" title="<?= $p['name'] ?>">
                            <?= $p['name'] ?>
                        </h3>
                        <div class="flex items-center justify-between">
                            <span class="text-primary font-bold text-sm md:text-lg">
                                <?= number_format($p['price'], 0, ',', '.') ?>đ
                            </span>
                            <?php if (isset($p['category_name'])): ?>
                                <span class="text-[10px] text-gray-400 uppercase font-semibold tracking-wider"><?= $p['category_name'] ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-20">
            <i class="fa-solid fa-mug-hot text-6xl text-gray-200 mb-4"></i>
            <p class="text-gray-500 text-lg">Chưa có món nào trong danh mục này.</p>
            <a href="index.php?page=menu" class="text-primary hover:underline mt-2 inline-block">Xem tất cả menu</a>
        </div>
    <?php endif; ?>

    <?php if ($total_pages > 1): ?>
        <div class="flex justify-center mt-10 gap-2">
            <?php
            // Hàm tạo link giữ nguyên tham số category
            function getLink($page, $cat)
            {
                return "index.php?page=menu&category_id=$cat&page_no=$page";
            }
            ?>

            <?php if ($current_page > 1): ?>
                <a href="<?= getLink($current_page - 1, $current_category) ?>" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-200 text-gray-600">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="<?= getLink($i, $current_category) ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-lg font-bold transition-colors <?= ($i == $current_page) ? 'bg-primary text-white shadow-lg shadow-green-500/30' : 'hover:bg-gray-200 text-gray-600' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <a href="<?= getLink($current_page + 1, $current_category) ?>" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-200 text-gray-600">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>