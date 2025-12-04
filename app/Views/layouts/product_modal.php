<div id="modal-overlay" class="fixed inset-0 bg-black/60 z-[80] hidden transition-opacity duration-300 opacity-0 backdrop-blur-sm" onclick="closeModal()"></div>

<div id="product-modal" class="fixed inset-0 z-[90] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300 pointer-events-none">

    <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row h-[85vh] pointer-events-auto relative">

        <div class="w-full md:w-1/2 h-40 md:h-auto bg-gray-100 relative shrink-0">
            <img id="modal-img" src="" alt="Product" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/400x400?text=Mon+An'">
            <button onclick="closeModal()" class="md:hidden absolute top-3 right-3 bg-white/90 p-2 rounded-full text-gray-800 shadow-sm z-10 active:bg-gray-200">
                <i class="fa-solid fa-xmark text-xl w-6 h-6 flex items-center justify-center"></i>
            </button>
        </div>

        <div class="w-full md:w-1/2 flex flex-col flex-1 bg-white relative overflow-hidden">

            <div class="hidden md:flex justify-end p-4 pb-0 shrink-0">
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 rounded-lg p-1 hover:bg-gray-100">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-5 space-y-5 custom-scrollbar">

                <div>
                    <h2 id="modal-name" class="text-2xl font-bold text-gray-900 leading-tight">Tên món</h2>
                    <p id="modal-price" class="text-xl font-bold text-primary mt-1">0đ</p>
                    <p id="modal-desc" class="text-gray-500 text-sm mt-2 leading-relaxed">Mô tả...</p>
                </div>

                <div>
                    <h3 class="font-bold text-gray-900 mb-2 text-xs uppercase tracking-wider text-gray-500">Chọn Size</h3>
                    <div class="flex gap-2">
                        <button onclick="selectSize('S', 0, this)" class="size-btn flex-1 py-2.5 rounded-lg border border-gray-200 text-sm font-medium hover:border-primary transition-all">S</button>
                        <button onclick="selectSize('M', 5000, this)" class="size-btn flex-1 py-2.5 rounded-lg border border-primary bg-green-50 text-primary font-bold text-sm transition-all">M</button>
                        <button onclick="selectSize('L', 10000, this)" class="size-btn flex-1 py-2.5 rounded-lg border border-gray-200 text-sm font-medium hover:border-primary transition-all">L</button>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-gray-900 mb-2 text-xs uppercase tracking-wider text-gray-500">Topping</h3>
                    <div class="space-y-2">
                        <label class="flex items-center justify-between p-3 border border-gray-100 rounded-lg active:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="addon-checkbox w-5 h-5 text-primary rounded focus:ring-primary" value="5000" data-name="Trân châu đen">
                                <span class="text-sm font-medium text-gray-700">Trân châu đen</span>
                            </div>
                            <span class="text-sm text-gray-500">+5k</span>
                        </label>
                        <label class="flex items-center justify-between p-3 border border-gray-100 rounded-lg active:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="addon-checkbox w-5 h-5 text-primary rounded focus:ring-primary" value="5000" data-name="Thạch dừa">
                                <span class="text-sm font-medium text-gray-700">Thạch dừa</span>
                            </div>
                            <span class="text-sm text-gray-500">+5k</span>
                        </label>
                        <label class="flex items-center justify-between p-3 border border-gray-100 rounded-lg active:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="addon-checkbox w-5 h-5 text-primary rounded focus:ring-primary" value="10000" data-name="Kem Cheese">
                                <span class="text-sm font-medium text-gray-700">Kem Cheese</span>
                            </div>
                            <span class="text-sm text-gray-500">+10k</span>
                        </label>
                    </div>
                </div>

                <div class="pb-2">
                    <h3 class="font-bold text-gray-900 mb-2 text-xs uppercase tracking-wider text-gray-500">Ghi chú</h3>
                    <textarea id="modal-note" rows="2" class="w-full border-gray-200 rounded-lg p-3 text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Ít đá, nhiều đường..."></textarea>
                </div>
            </div>

            <div class="p-4 border-t border-gray-100 bg-gray-50 shrink-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="flex items-center bg-white rounded-xl border border-gray-200 h-11 shadow-sm">
                        <button onclick="updateModalQty(-1)" class="w-10 h-full flex items-center justify-center text-gray-500 active:text-primary"><i class="fa-solid fa-minus text-xs"></i></button>
                        <span id="modal-qty" class="w-6 text-center font-bold text-gray-900 text-sm">1</span>
                        <button onclick="updateModalQty(1)" class="w-10 h-full flex items-center justify-center text-gray-500 active:text-primary"><i class="fa-solid fa-plus text-xs"></i></button>
                    </div>

                    <button onclick="addToCartFromModal()" class="flex-1 bg-primary text-white font-bold h-11 rounded-xl shadow-lg shadow-green-500/30 active:scale-95 flex items-center justify-center gap-2 transition-transform">
                        <span class="text-sm">Thêm vào giỏ</span>
                        <span class="w-1 h-1 bg-white/50 rounded-full"></span>
                        <span id="btn-total-price" class="text-sm">0đ</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>