<div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Trạng thái đơn hàng</h1>
        <p class="text-gray-500">Cảm ơn bạn đã chờ đợi, đồ uống sắp sẵn sàng!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">

        <div class="md:col-span-7 space-y-6">

            <div class="bg-gradient-to-r from-primary to-green-600 rounded-2xl p-6 text-white shadow-lg shadow-green-500/20 flex items-center justify-between relative overflow-hidden">
                <i class="fa-solid fa-mug-hot absolute -bottom-4 -right-4 text-9xl opacity-10 rotate-12"></i>

                <div>
                    <p class="text-green-100 text-sm font-medium uppercase tracking-wider mb-1">Đơn hàng của bạn</p>
                    <h2 class="text-3xl font-bold"><?= $order['id'] ?></h2>
                    <p class="text-sm text-green-50 mt-1"><i class="fa-regular fa-clock mr-1"></i> Đặt lúc: <?= $order['created_at'] ?></p>
                </div>

                <div class="text-right z-10">
                    <p class="text-green-100 text-sm font-medium uppercase tracking-wider">Bàn số</p>
                    <div class="text-5xl font-black"><?= $order['table_number'] ?></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="font-bold text-gray-800">Chi tiết món</h3>
                </div>
                <div class="p-6 space-y-6">
                    <?php foreach ($items as $item): ?>
                        <div class="flex gap-4 items-center">
                            <div class="w-16 h-16 rounded-lg border border-gray-100 overflow-hidden shrink-0">
                                <img src="<?= $item['img'] ?>" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/100'">
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900"><?= $item['name'] ?></h4>
                                <p class="text-sm text-gray-500">Số lượng: <?= $item['qty'] ?></p>
                            </div>
                            <span class="font-bold text-gray-900"><?= number_format($item['price'], 0, ',', '.') ?>đ</span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="bg-gray-50 p-6 flex justify-between items-center border-t border-gray-100">
                    <span class="text-gray-600 font-medium">Tổng cộng</span>
                    <span class="text-xl font-bold text-primary"><?= number_format($order['total'], 0, ',', '.') ?>đ</span>
                </div>
            </div>
        </div>

        <div class="md:col-span-5">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 h-full">
                <h3 class="font-bold text-gray-800 mb-6">Tiến độ phục vụ</h3>

                <div class="relative pl-2">
                    <div class="absolute top-3 left-[19px] w-0.5 h-[85%] bg-gray-100"></div>

                    <div class="space-y-8">
                        <?php foreach ($timeline as $step => $info): ?>
                            <?php
                            $isDone = $step <= $order['status_code'];
                            $isCurrent = $step == $order['status_code'];

                            // Màu sắc
                            $iconBg = $isDone ? 'bg-primary text-white shadow-lg shadow-green-500/30' : 'bg-gray-100 text-gray-300';
                            $textColor = $isDone ? 'text-gray-900' : 'text-gray-400';
                            $descColor = $isDone ? 'text-gray-500' : 'text-gray-300';

                            // Hiệu ứng Pulse cho bước hiện tại
                            $pulseClass = $isCurrent ? 'animate-pulse ring-4 ring-green-100' : '';
                            ?>

                            <div class="relative flex gap-4 z-10">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 transition-all duration-500 <?= $iconBg ?> <?= $pulseClass ?>">
                                    <i class="fa-solid <?= $info['icon'] ?> text-sm"></i>
                                </div>

                                <div class="pt-1">
                                    <h4 class="font-bold text-sm <?= $textColor ?>"><?= $info['title'] ?></h4>
                                    <p class="text-xs mt-0.5 <?= $descColor ?>"><?= $info['desc'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mt-10 p-4 bg-yellow-50 rounded-xl border border-yellow-100 text-center">
                    <p class="text-yellow-800 text-sm mb-2"><i class="fa-solid fa-bell mr-1"></i> Bạn cần hỗ trợ thêm?</p>
                    <button class="text-xs font-bold bg-white border border-yellow-200 text-yellow-700 py-2 px-4 rounded-lg hover:bg-yellow-100 transition-colors">
                        Gọi nhân viên
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>