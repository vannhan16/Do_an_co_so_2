<div id="drink-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl relative z-10 transform transition-all scale-100">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <h2 id="modal-title" class="text-2xl font-bold text-gray-900">Thêm món mới</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-2xl"></i></button>
            </div>

            <div class="p-8 max-h-[70vh] overflow-y-auto custom-scroll">
                <form id="drink-form" action="index.php?page=store_drink" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <input type="hidden" name="id" id="drink-id">
                    <input type="hidden" name="current_image" id="drink-current-image">

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tên món</label>
                        <input type="text" name="name" id="drink-name" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Mô tả</label>
                        <textarea name="description" id="drink-desc" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Giá (VNĐ)</label>
                            <input type="number" name="price" id="drink-price" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Danh mục</label>
                            <div class="relative">
                                <select name="category_id" id="drink-category" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none appearance-none bg-white">
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Hình ảnh</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:bg-gray-50 relative">
                            <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(this)">
                            <div id="upload-placeholder">
                                <i class="fa-regular fa-image text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">Tải ảnh lên</p>
                            </div>
                            <img id="image-preview" src="" class="hidden h-32 mx-auto rounded-lg object-contain mt-2">
                        </div>
                    </div>
                </form>
            </div>

            <div class="px-8 py-6 border-t border-gray-100 flex justify-end gap-3 bg-gray-50 rounded-b-2xl">
                <button onclick="closeModal()" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-100">Hủy</button>
                <button type="submit" form="drink-form" class="px-6 py-2.5 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-[#0ebc49]">Lưu</button>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('drink-modal');
    const form = document.getElementById('drink-form');
    const title = document.getElementById('modal-title');

    function openAddModal() {
        modal.classList.remove('hidden');
        title.innerText = "Thêm món mới";
        form.action = "index.php?page=store_drink";
        form.reset();
        document.getElementById('image-preview').classList.add('hidden');
        document.getElementById('upload-placeholder').classList.remove('hidden');
    }

    function openEditModal(data) {
        modal.classList.remove('hidden');
        title.innerText = "Chỉnh sửa món";
        form.action = "index.php?page=update_drink";

        // Điền dữ liệu cũ
        document.getElementById('drink-id').value = data.id;
        document.getElementById('drink-name').value = data.name;
        document.getElementById('drink-price').value = data.price;

        // SỬA Ở ĐÂY: data.description thay vì data.desc
        document.getElementById('drink-desc').value = data.description;

        document.getElementById('drink-category').value = data.category_id;

        // SỬA Ở ĐÂY: data.image thay vì data.img
        document.getElementById('drink-current-image').value = data.image;

        // Preview ảnh cũ
        const preview = document.getElementById('image-preview');

        // SỬA Ở ĐÂY: data.image
        preview.src = data.image;

        preview.classList.remove('hidden');
        document.getElementById('upload-placeholder').classList.add('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image-preview');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                document.getElementById('upload-placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>