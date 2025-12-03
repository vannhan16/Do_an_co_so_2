<div id="add-table-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeTableModal()"></div>

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl relative z-10 transform transition-all scale-100">

            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Thêm bàn mới</h2>
                    <p class="text-sm text-gray-500 mt-1">Nhập thông tin chi tiết cho bàn mới.</p>
                </div>
                <button onclick="closeTableModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>

            <div class="p-8">
                <form action="index.php?page=store_table" method="POST" id="add-table-form" class="space-y-6">

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tên bàn</label>
                        <input type="text" name="name" required placeholder="Ví dụ: Bàn 1, Bàn VIP A..." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Sức chứa</label>
                            <input type="number" name="capacity" value="4" min="1" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Khu vực</label>
                            <div class="relative">
                                <select name="section" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none appearance-none bg-white">
                                    <option value="Patio">Sân thượng (Patio)</option>
                                    <option value="Indoors">Trong nhà (Indoors)</option>
                                    <option value="Bar">Quầy Bar</option>
                                    <option value="VIP">Phòng VIP</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Mã QR</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors group">
                                <input type="radio" name="qr_option" value="auto" checked class="w-5 h-5 text-primary focus:ring-primary border-gray-300">
                                <div class="ml-3">
                                    <span class="block text-sm font-bold text-gray-800">Tạo mã QR tự động</span>
                                </div>
                                <i class="fa-solid fa-qrcode ml-auto text-gray-400 group-hover:text-primary"></i>
                            </label>

                            <label class="flex items-center p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors group">
                                <input type="radio" name="qr_option" value="manual" class="w-5 h-5 text-primary focus:ring-primary border-gray-300">
                                <div class="ml-3">
                                    <span class="block text-sm font-bold text-gray-800">Gán mã QR thủ công</span>
                                </div>
                                <i class="fa-regular fa-pen-to-square ml-auto text-gray-400 group-hover:text-gray-600"></i>
                            </label>
                        </div>
                    </div>

                </form>
            </div>

            <div class="px-8 py-6 border-t border-gray-100 flex justify-end gap-3 bg-gray-50 rounded-b-2xl">
                <button onclick="closeTableModal()" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-100 transition-colors">
                    Hủy bỏ
                </button>
                <button type="submit" form="add-table-form" class="px-6 py-2.5 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-[#0ebc49] transition-all">
                    Lưu bàn
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    function openTableModal() {
        const modal = document.getElementById('add-table-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.firstElementChild.classList.remove('opacity-0');
            modal.lastElementChild.firstElementChild.classList.remove('scale-95', 'opacity-0');
        }, 10);
    }

    function closeTableModal() {
        const modal = document.getElementById('add-table-modal');
        modal.classList.add('hidden');
    }
</script>