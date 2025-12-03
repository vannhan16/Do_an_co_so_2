<div id="add-category-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeCategoryModal()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl relative z-10 transform transition-all scale-100">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Thêm danh mục mới</h2>
                <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <div class="p-6">
                <form action="index.php?page=store_category" method="POST" id="add-category-form" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tên danh mục</label>
                        <input type="text" name="name" required placeholder="Ví dụ: Sinh tố..." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none">
                    </div>

                    <input type="hidden" name="category_icon" id="add-icon-input" value="fa-martini-glass">
                    <div class="grid grid-cols-6 gap-3">

                        <!-- Đồ uống chung -->
                        <div onclick="selectIconAdd(this, 'fa-martini-glass')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 cursor-pointer transition-all border-primary bg-green-50 text-primary">
                            <i class="fa-solid fa-martini-glass text-lg"></i>
                        </div>

                        <!-- Cà phê -->
                        <div onclick="selectIconAdd(this, 'fa-mug-hot')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-mug-hot text-lg"></i>
                        </div>
                        <div onclick="selectIconAdd(this, 'fa-coffee')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-coffee text-lg"></i>
                        </div>

                        <!-- Trà sữa / Đồ ngọt -->
                        <div onclick="selectIconAdd(this, 'fa-cookie-bite')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-cookie-bite text-lg"></i>
                        </div>
                        <div onclick="selectIconAdd(this, 'fa-jar')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-jar text-lg"></i>
                        </div>

                        <!-- Trà trái cây -->
                        <div onclick="selectIconAdd(this, 'fa-lemon')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-lemon text-lg"></i>
                        </div>
                        <div onclick="selectIconAdd(this, 'fa-seedling')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-seedling text-lg"></i>
                        </div>

                        <!-- Nước ép -->
                        <div onclick="selectIconAdd(this, 'fa-layer-group')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-layer-group text-lg"></i>
                        </div>
                        <div onclick="selectIconAdd(this, 'fa-blender')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-blender text-lg"></i>
                        </div>

                        <!-- Sinh tố -->
                        <div onclick="selectIconAdd(this, 'fa-blender-phone')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-blender-phone text-lg"></i>
                        </div>
                        <div onclick="selectIconAdd(this, 'fa-ice-cream')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-ice-cream text-lg"></i>
                        </div>

                        <!-- Đá xay -->
                        <div onclick="selectIconAdd(this, 'fa-snowflake')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-snowflake text-lg"></i>
                        </div>

                        <!-- Soda -->
                        <div onclick="selectIconAdd(this, 'fa-bottle-water')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-bottle-water text-lg"></i>
                        </div>
                        <div onclick="selectIconAdd(this, 'fa-bubbles')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-bubbles text-lg"></i>
                        </div>

                        <!-- Đồ nóng -->
                        <div onclick="selectIconAdd(this, 'fa-mug-saucer')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-mug-saucer text-lg"></i>
                        </div>

                        <!-- Sữa chua -->
                        <div onclick="selectIconAdd(this, 'fa-bowl-food')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-bowl-food text-lg"></i>
                        </div>

                        <!-- Topping -->
                        <div onclick="selectIconAdd(this, 'fa-cubes-stacked')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-cubes-stacked text-lg"></i>
                        </div>

                        <!-- Rượu / đồ có cồn (tùy chọn) -->
                        <div onclick="selectIconAdd(this, 'fa-wine-glass')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-wine-glass text-lg"></i>
                        </div>
                        <div onclick="selectIconAdd(this, 'fa-beer-mug-empty')" class="icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                            <i class="fa-solid fa-beer-mug-empty text-lg"></i>
                        </div>

                    </div>

                </form>
            </div>
            <div class="px-6 py-5 border-t border-gray-100 flex justify-end gap-3 bg-gray-50 rounded-b-2xl">
                <button onclick="closeCategoryModal()" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300">Hủy</button>
                <button type="submit" form="add-category-form" class="px-5 py-2.5 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-[#0ebc49]">Lưu</button>
            </div>
        </div>
    </div>
</div>

<div id="edit-category-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl relative z-10 transform transition-all scale-100">

            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Chỉnh sửa danh mục</h2>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <div class="p-6">
                <form action="index.php?page=update_category" method="POST" id="edit-category-form" class="space-y-6">

                    <input type="hidden" name="id" id="edit-category-id">

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tên danh mục</label>
                        <input type="text" name="name" id="edit-category-name" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Chọn Icon</label>
                        <input type="hidden" name="category_icon" id="edit-icon-input">

                        <div class="grid grid-cols-6 gap-3">

                            <!-- Đồ uống chung -->
                            <div onclick="selectIconEdit(this, 'fa-martini-glass')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 cursor-pointer transition-all border-primary bg-green-50 text-primary">
                                <i class="fa-solid fa-martini-glass text-lg"></i>
                            </div>

                            <!-- Cà phê -->
                            <div onclick="selectIconEdit(this, 'fa-mug-hot')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-mug-hot text-lg"></i>
                            </div>
                            <div onclick="selectIconEdit(this, 'fa-coffee')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-coffee text-lg"></i>
                            </div>

                            <!-- Trà sữa / Đồ ngọt -->
                            <div onclick="selectIconEdit(this, 'fa-cookie-bite')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-cookie-bite text-lg"></i>
                            </div>
                            <div onclick="selectIconEdit(this, 'fa-jar')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-jar text-lg"></i>
                            </div>

                            <!-- Trà trái cây -->
                            <div onclick="selectIconEdit(this, 'fa-lemon')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-lemon text-lg"></i>
                            </div>
                            <div onclick="selectIconEdit(this, 'fa-seedling')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-seedling text-lg"></i>
                            </div>

                            <!-- Nước ép -->
                            <div onclick="selectIconEdit(this, 'fa-layer-group')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-layer-group text-lg"></i>
                            </div>
                            <div onclick="selectIconEdit(this, 'fa-blender')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-blender text-lg"></i>
                            </div>

                            <!-- Sinh tố -->
                            <div onclick="selectIconEdit(this, 'fa-blender-phone')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-blender-phone text-lg"></i>
                            </div>
                            <div onclick="selectIconEdit(this, 'fa-ice-cream')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-ice-cream text-lg"></i>
                            </div>

                            <!-- Đá xay -->
                            <div onclick="selectIconEdit(this, 'fa-snowflake')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-snowflake text-lg"></i>
                            </div>

                            <!-- Soda -->
                            <div onclick="selectIconEdit(this, 'fa-bottle-water')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-bottle-water text-lg"></i>
                            </div>
                            <div onclick="selectIconEdit(this, 'fa-bubbles')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-bubbles text-lg"></i>
                            </div>

                            <!-- Đồ nóng -->
                            <div onclick="selectIconEdit(this, 'fa-mug-saucer')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-mug-saucer text-lg"></i>
                            </div>

                            <!-- Sữa chua -->
                            <div onclick="selectIconEdit(this, 'fa-bowl-food')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-bowl-food text-lg"></i>
                            </div>

                            <!-- Topping -->
                            <div onclick="selectIconEdit(this, 'fa-cubes-stacked')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-cubes-stacked text-lg"></i>
                            </div>

                            <!-- Rượu / đồ có cồn (tùy chọn) -->
                            <div onclick="selectIconEdit(this, 'fa-wine-glass')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-wine-glass text-lg"></i>
                            </div>
                            <div onclick="selectIconEdit(this, 'fa-beer-mug-empty')" class="icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all">
                                <i class="fa-solid fa-beer-mug-empty text-lg"></i>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
            <div class="px-6 py-5 border-t border-gray-100 flex justify-end gap-3 bg-gray-50 rounded-b-2xl">
                <button onclick="closeEditModal()" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300">Hủy</button>
                <button type="submit" form="edit-category-form" class="px-5 py-2.5 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-[#0ebc49]">Cập nhật</button>
            </div>
        </div>
    </div>
</div>

<script>
    // --- LOGIC THÊM MỚI ---
    function openCategoryModal() {
        document.getElementById('add-category-modal').classList.remove('hidden');
    }

    function closeCategoryModal() {
        document.getElementById('add-category-modal').classList.add('hidden');
    }

    function selectIconAdd(element, iconClass) {
        document.querySelectorAll('.icon-option-add').forEach(el => {
            el.className = 'icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all';
        });
        element.className = 'icon-option-add w-12 h-12 flex items-center justify-center rounded-lg border-2 border-primary bg-green-50 text-primary cursor-pointer transition-all scale-110';
        document.getElementById('add-icon-input').value = iconClass;
    }

    // --- LOGIC SỬA (EDIT) ---
    function openEditModal(id, name, icon) {
        // 1. Điền dữ liệu cũ vào Form
        document.getElementById('edit-category-id').value = id;
        document.getElementById('edit-category-name').value = name;
        document.getElementById('edit-icon-input').value = icon;

        // 2. Highlight Icon tương ứng
        document.querySelectorAll('.icon-option-edit').forEach(el => {
            // Reset style
            el.className = 'icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all';
            // Kiểm tra xem icon này có phải icon đang chọn không
            if (el.innerHTML.includes(icon)) {
                el.className = 'icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-primary bg-green-50 text-primary cursor-pointer transition-all scale-110';
            }
        });

        // 3. Hiện Modal
        document.getElementById('edit-category-modal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('edit-category-modal').classList.add('hidden');
    }

    function selectIconEdit(element, iconClass) {
        document.querySelectorAll('.icon-option-edit').forEach(el => {
            el.className = 'icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-gray-100 text-gray-500 hover:bg-gray-50 cursor-pointer transition-all';
        });
        element.className = 'icon-option-edit w-12 h-12 flex items-center justify-center rounded-lg border-2 border-primary bg-green-50 text-primary cursor-pointer transition-all scale-110';
        document.getElementById('edit-icon-input').value = iconClass;
    }
</script>