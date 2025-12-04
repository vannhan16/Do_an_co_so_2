<div class="w-full max-w-3xl mx-auto px-3 sm:px-6 lg:px-8 py-4 md:py-10 overflow-x-hidden">

    <?php if (isset($order) && !empty($order)): ?>

        <div class="text-center mb-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-50 border border-green-100 text-primary font-bold text-xs rounded-full mb-3">
                <i class="fa-solid fa-receipt"></i>
                <span>#<?= $order['id'] ?></span>
            </div>

            <h1 class="text-2xl md:text-4xl font-extrabold text-gray-900 mb-2 leading-tight">
                <?php
                if ($order['status'] == 'pending') echo "Đã nhận đơn!";
                elseif ($order['status'] == 'processing') echo "Đang pha chế...";
                elseif ($order['status'] == 'completed') echo "Hoàn tất!";
                else echo "Đã hủy";
                ?>
            </h1>
            <p class="text-sm text-gray-500">Vui lòng đợi trong giây lát nhé.</p>
        </div>

        <div class="flex flex-col gap-5">

            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-5 text-white shadow-lg relative overflow-hidden">
                <i class="fa-solid fa-mug-hot absolute -bottom-2 -right-4 text-8xl opacity-20 rotate-12 pointer-events-none"></i>

                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <p class="text-green-100 text-xs font-medium uppercase tracking-wider mb-1">Vị trí bàn</p>
                        <div class="text-4xl font-black">
                            <?= strpos($order['customer_name'], 'Bàn') !== false ? str_replace(['(', ')'], '', substr($order['customer_name'], strpos($order['customer_name'], 'Bàn'))) : 'Tại quán' ?>
                        </div>
                        <div class="mt-2 flex items-center gap-1 text-green-50 text-xs">
                            <i class="fa-regular fa-clock"></i>
                            <span><?= date('H:i', strtotime($order['created_at'])) ?> hôm nay</span>
                        </div>
                    </div>

                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center border border-white/30">
                        <i class="fa-solid fa-location-dot text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-bold text-gray-800 mb-5 text-base">Tiến độ phục vụ</h3>

                <?php
                $step = 1;
                if ($order['status'] == 'processing') $step = 2;
                if ($order['status'] == 'completed') $step = 3;
                if ($order['status'] == 'cancelled') $step = 0;

                // Khai báo Icon ở đây
                $timeline = [
                    1 => [
                        'label' => 'Đã nhận đơn',
                        'time' => 'Bếp đã xác nhận',
                        'icon' => 'fa-file-invoice' // Icon Hóa đơn
                    ],
                    2 => [
                        'label' => 'Đang pha chế',
                        'time' => 'Bartender đang làm',
                        'icon' => 'fa-blender' // Icon Máy xay
                    ],
                    3 => [
                        'label' => 'Hoàn tất',
                        'time' => 'Mời bạn thưởng thức',
                        'icon' => 'fa-mug-hot' // Icon Ly nước
                    ]
                ];
                ?>

                <div class="relative pl-2">
                    <div class="absolute top-2 left-[19px] w-0.5 h-[80%] bg-gray-100"></div>

                    <div class="space-y-6">
                        <?php foreach ($timeline as $key => $info): ?>
                            <?php
                            $isActive = ($step >= $key); // Đã qua bước này chưa
                            $isCurrent = ($step == $key); // Đang ở bước này

                            // Màu nền Icon
                            $bg = $isActive ? 'bg-primary text-white shadow-md shadow-green-500/30' : 'bg-gray-100 text-gray-300';

                            // Màu chữ
                            $text = $isActive ? 'text-gray-900' : 'text-gray-400';

                            // Hiệu ứng nhịp đập (Pulse) cho bước hiện tại
                            $anim = $isCurrent ? 'animate-pulse ring-4 ring-green-100' : '';
                            ?>

                            <div class="relative flex gap-4 z-10">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 transition-all duration-500 <?= $bg ?> <?= $anim ?>">
                                    <i class="fa-solid <?= $info['icon'] ?> text-sm"></i>
                                </div>

                                <div class="pt-1">
                                    <h4 class="font-bold text-sm <?= $text ?>"><?= $info['label'] ?></h4>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= $info['time'] ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-sm">Chi tiết món</h3>
                    <span class="text-xs bg-white border border-gray-200 px-2 py-0.5 rounded text-gray-500 font-medium">
                        <?= count($items) ?> món
                    </span>
                </div>

                <div class="p-4 space-y-4">
                    <?php foreach ($items as $item): ?>
                        <div class="flex gap-3">
                            <div class="w-12 h-12 rounded-lg border border-gray-100 overflow-hidden shrink-0">
                                <img src="<?= $item['image'] ?>" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/100'">
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-gray-900 text-sm line-clamp-1 pr-2">
                                        <span class="text-primary mr-1">x<?= $item['quantity'] ?></span>
                                        <?= $item['product_name'] ?>
                                    </h4>
                                    <span class="font-bold text-gray-900 text-sm whitespace-nowrap">
                                        <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                                    </span>
                                </div>

                                <?php if (isset($item['note']) && !empty($item['note'])): ?>
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-1 italic">
                                        Note: <?= $item['note'] ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="bg-gray-50 p-4 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-600">Thanh toán</span>
                    <span class="text-xl font-extrabold text-primary"><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 pb-4">
                <a href="index.php?page=menu" class="flex items-center justify-center gap-2 py-3 bg-white border border-gray-200 text-gray-700 font-bold text-sm rounded-xl hover:bg-gray-50">
                    <i class="fa-solid fa-plus"></i> Thêm món
                </a>
                <button onclick="alert('Đã gọi phục vụ!')" class="flex items-center justify-center gap-2 py-3 bg-yellow-100 text-yellow-700 font-bold text-sm rounded-xl hover:bg-yellow-200">
                    <i class="fa-solid fa-bell"></i> Gọi hỗ trợ
                </button>
            </div>

        </div>

    <?php else: ?>
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fa-solid fa-clipboard-list text-3xl text-gray-400"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-900">Chưa có đơn hàng</h2>
            <a href="index.php?page=menu" class="mt-4 bg-primary text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-green-500/30 text-sm">
                Gọi món ngay
            </a>
        </div>
    <?php endif; ?>

</div>