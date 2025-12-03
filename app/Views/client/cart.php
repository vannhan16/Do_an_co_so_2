<div id="cart-overlay" onclick="closeCart()" class="fixed inset-0 bg-black/50 z-[60] hidden transition-opacity duration-300 opacity-0"></div>

<div id="cart-sidebar" class="fixed top-0 right-0 h-full w-full max-w-md bg-white z-[70] transform translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex flex-col">

    <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">Giỏ hàng của bạn</h2>
        <button onclick="closeCart()" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <div id="cart-items-container" class="flex-1 overflow-y-auto p-6">
    </div>

    <div class="border-t border-gray-100 p-6 bg-white space-y-4 shadow-[0_-5px_15px_rgba(0,0,0,0.05)]">
        <div class="space-y-2 pt-2">
            <div class="flex justify-between text-gray-600 text-sm">
                <span>Tạm tính</span>
                <span id="cart-subtotal" class="font-medium">$0.00</span>
            </div>
            <div class="flex justify-between text-gray-600 text-sm">
                <span>Thuế (8%)</span>
                <span id="cart-tax" class="font-medium">$0.00</span>
            </div>
            <div class="flex justify-between text-gray-900 text-lg font-bold pt-2 border-t border-gray-50">
                <span>Tổng cộng</span>
                <span id="cart-total">$0.00</span>
            </div>
        </div>

        <button class="w-full bg-primary hover:bg-[#0fb645] text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-500/30 transition-all active:scale-[0.98]">
            Thanh toán • <span id="btn-checkout-total">$0.00</span>
        </button>
    </div>
</div>