<div id="cart-overlay" onclick="toggleCart()" class="fixed inset-0 bg-black/50 z-[60] hidden transition-opacity duration-300 opacity-0 backdrop-blur-sm"></div>

<div id="cart-drawer" class="fixed top-0 right-0 h-full w-full max-w-[400px] bg-white z-[70] transform translate-x-full transition-transform duration-300 ease-out shadow-2xl flex flex-col">

    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white">
        <div class="flex items-center gap-2">
            <span class="text-xl font-bold text-gray-800">Giỏ hàng</span>
            <span id="drawer-count" class="bg-primary text-white text-xs font-bold px-2 py-0.5 rounded-full">0</span>
        </div>
        <button onclick="toggleCart()" class="p-2 text-gray-400 hover:text-red-500 transition-colors rounded-full hover:bg-gray-100">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <div id="cart-items-list" class="flex-1 overflow-y-auto p-5 space-y-4">
    </div>

    <div class="border-t border-gray-100 p-6 bg-gray-50 space-y-4">

        <div class="space-y-3">
            <input type="text" id="cust-name" placeholder="Tên của bạn (VD: Minh)" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm outline-none focus:border-primary">
            <?php
            // Kiểm tra xem có số bàn trong Session không
            $detectedTable = isset($_SESSION['current_table']) ? $_SESSION['current_table'] : '';

            // Nếu có bàn -> Readonly (Không cho sửa) + Nền xám
            // Nếu không có -> Cho nhập tay
            $readonlyState = $detectedTable ? 'readonly class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-200 text-gray-600 cursor-not-allowed"' : 'class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary outline-none"';
            ?>
            <div class="relative">
                <input type="text" id="cust-table"
                    value="<?= $detectedTable ?>"
                    placeholder="Số bàn (Quét QR để tự điền)"
                    <?= $readonlyState ?>>

                <?php if ($detectedTable): ?>
                    <i class="fa-solid fa-lock absolute right-3 top-3 text-gray-400"></i>
                <?php endif; ?>
            </div>
            <textarea id="cust-note" rows="1" placeholder="Ghi chú (Ít đường...)" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary outline-none resize-none"></textarea>

        </div>

        <div class="flex justify-between items-end pt-2 border-t border-gray-200">
            <span class="text-gray-500 text-sm font-medium">Tổng cộng</span>
            <span id="drawer-total" class="text-2xl font-bold text-gray-900">0 ₫</span>
        </div>

        <button onclick="processCheckout()" class="w-full bg-primary hover:bg-[#0ebc49] text-white font-bold py-3.5 rounded-xl shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2">
            <span>Đặt đơn ngay</span>
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </div>
</div>