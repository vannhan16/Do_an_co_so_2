<div id="edit-table-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeEditTable()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl relative z-10 transform transition-all scale-100">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900">Chỉnh sửa bàn</h2>
                <button onclick="closeEditTable()" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-2xl"></i></button>
            </div>
            <div class="p-8">
                <form action="index.php?page=update_table" method="POST" id="edit-table-form" class="space-y-6">
                    <input type="hidden" name="id" id="edit-id">

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tên bàn</label>
                        <input type="text" name="name" id="edit-name" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Sức chứa</label>
                            <input type="number" name="capacity" id="edit-capacity" min="1" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Khu vực</label>
                            <div class="relative">
                                <select name="section" id="edit-section" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none appearance-none bg-white">
                                    <option value="Patio">Sân thượng</option>
                                    <option value="Indoors">Trong nhà</option>
                                    <option value="Bar">Quầy Bar</option>
                                    <option value="VIP">Phòng VIP</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <label class="block text-sm font-bold text-blue-800 mb-3">Cập nhật Mã QR?</label>
                        <div class="space-y-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="qr_action" value="keep" checked class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Giữ nguyên (Không đổi)</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="qr_action" value="auto" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Tạo lại QR mới (theo tên mới)</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="qr_action" value="remove" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-red-600">Xóa mã QR hiện tại</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="px-8 py-6 border-t border-gray-100 flex justify-end gap-3 bg-gray-50 rounded-b-2xl">
                <button onclick="closeEditTable()" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-100">Hủy</button>
                <button type="submit" form="edit-table-form" class="px-6 py-2.5 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-[#0ebc49]">Cập nhật</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditTable(data) {
        document.getElementById('edit-table-modal').classList.remove('hidden');

        // Điền dữ liệu cũ
        document.getElementById('edit-id').value = data.id;
        document.getElementById('edit-name').value = data.name;
        document.getElementById('edit-capacity').value = data.capacity;
        document.getElementById('edit-section').value = data.section;

        // Reset radio về 'keep'
        document.querySelector('input[name="qr_action"][value="keep"]').checked = true;
    }

    function closeEditTable() {
        document.getElementById('edit-table-modal').classList.add('hidden');
    }
</script>