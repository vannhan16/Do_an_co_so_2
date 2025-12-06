<div id="add-user-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeUserModal()"></div>

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl relative z-10 transform transition-all scale-100">

            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h2 id="modal-title" class="text-2xl font-bold text-gray-900">Thêm nhân viên mới</h2>
                    <p id="modal-subtitle" class="text-sm text-gray-500 mt-1">Tạo tài khoản thu ngân và thiết lập trạng thái ban đầu.</p>
                </div>
                <button onclick="closeUserModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>

            <div class="p-8 max-h-[70vh] overflow-y-auto custom-scroll">

                <form action="index.php?page=store_user" method="POST" id="add-user-form" class="space-y-6">
                    <input type="hidden" id="user-id" name="id" value="">

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Họ và tên</label>
                        <input type="text" id="fullname" name="fullname" required placeholder="Ví dụ: Nguyễn Văn A" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email đăng nhập</label>
                        <input type="email" id="email" name="email" required placeholder="vidu@email.com" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Mật khẩu</label>
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu (để trống nếu không đổi)..." class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Vai trò</label>
                        <div class="relative">
                            <select id="role" name="role" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary outline-none appearance-none bg-white">
                                <option value="cashier">Thu ngân (Cashier)</option>
                                <option value="manager">Quản lý (Manager)</option>
                                <option value="admin">Quản trị viên (Admin)</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-gray-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <span class="text-sm font-bold text-gray-700">Trạng thái tài khoản</span>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500 font-medium">Vô hiệu hóa</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="status" name="status" value="active" checked class="sr-only peer">
                                <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary"></div>
                            </label>
                            <span class="text-sm font-bold text-primary">Hoạt động</span>
                        </div>
                    </div>

                </form>
            </div>

            <div class="px-8 py-6 border-t border-gray-100 flex justify-end gap-3 bg-gray-50 rounded-b-2xl">
                <button onclick="closeUserModal()" class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-100 transition-colors">
                    Hủy bỏ
                </button>

                <button type="submit" form="add-user-form" id="submit-btn" class="px-6 py-2.5 bg-primary text-white font-bold rounded-xl shadow-lg shadow-green-500/30 hover:bg-[#0ebc49] transition-all active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> <span id="submit-text">Thêm nhân viên</span>
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    let isEditMode = false;

    function openUserModal() {
        isEditMode = false;
        document.getElementById('add-user-form').action = 'index.php?page=store_user';
        document.getElementById('modal-title').innerText = 'Thêm nhân viên mới';
        document.getElementById('modal-subtitle').innerText = 'Tạo tài khoản thu ngân và thiết lập trạng thái ban đầu.';
        document.getElementById('password').required = true;
        document.getElementById('password').placeholder = 'Nhập mật khẩu...';
        document.getElementById('submit-text').innerText = 'Thêm nhân viên';
        document.getElementById('submit-btn').innerHTML = '<i class="fa-solid fa-plus"></i> <span id="submit-text">Thêm nhân viên</span>';

        // Reset form
        document.getElementById('add-user-form').reset();
        document.getElementById('user-id').value = '';

        const modal = document.getElementById('add-user-modal');
        if (modal) modal.classList.remove('hidden');
    }

    function openEditUser(user) {
        isEditMode = true;
        document.getElementById('add-user-form').action = 'index.php?page=update_user';
        document.getElementById('modal-title').innerText = 'Chỉnh sửa nhân viên';
        document.getElementById('modal-subtitle').innerText = 'Cập nhật thông tin tài khoản.';
        document.getElementById('password').required = false;
        document.getElementById('password').placeholder = 'Nhập mật khẩu (để trống nếu không đổi)...';
        document.getElementById('submit-text').innerText = 'Lưu thay đổi';
        document.getElementById('submit-btn').innerHTML = '<i class="fa-solid fa-floppy-disk"></i> <span id="submit-text">Lưu thay đổi</span>';

        // Điền dữ liệu
        document.getElementById('user-id').value = user.id;
        document.getElementById('fullname').value = user.fullname;
        document.getElementById('email').value = user.email;
        document.getElementById('role').value = user.role;
        document.getElementById('status').checked = (user.status === 'active');

        const modal = document.getElementById('add-user-modal');
        if (modal) modal.classList.remove('hidden');
    }

    function closeUserModal() {
        const modal = document.getElementById('add-user-modal');
        if (modal) modal.classList.add('hidden');
    }
</script>