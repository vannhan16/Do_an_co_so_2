<header class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <div class="flex items-center gap-4">
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <a href="index.php" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 text-primary group-hover:scale-110 transition-transform">
                        <svg fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M44 11.27C44 14.01 39.84 16.4 33.69 17.64C39.84 18.88 44 21.26 44 24C44 26.74 39.84 29.12 33.69 30.36C39.84 31.6 44 34 44 36.73C44 40.74 35.05 44 24 44C12.95 44 4 40.74 4 36.73C4 34 8.16 31.6 14.31 30.36C8.16 29.12 4 26.74 4 24C4 21.26 8.16 18.88 14.31 17.64C8.16 16.4 4 14.01 4 11.27C4 7.26 12.95 4 24 4C35.0457 4 44 7.25611 44 11.2727Z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Drinky</span>
                </a>
            </div>

            <nav class="hidden md:flex items-center gap-8 mx-6">
                <a href="index.php?page=menu" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary transition-colors">Thực đơn</a>
                <a href="index.php?page=tracking" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary transition-colors">Theo dõi đơn</a>
                <a href="#" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary transition-colors">Khuyến mãi</a>
            </nav>

            <div class="hidden md:flex flex-1 max-w-xs">
                <form action="index.php" method="GET" class="relative w-full">
                    <input type="hidden" name="page" value="menu">
                    <span class="absolute left-3 top-2.5 text-gray-400 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="q" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>"
                        class="w-full pl-10 pr-4 py-2 rounded-full bg-gray-100 dark:bg-gray-800 border-none focus:ring-2 focus:ring-primary text-sm transition-all placeholder-gray-500 text-gray-900 dark:text-white"
                        placeholder="Tìm món...">
                </form>
            </div>

            <div class="flex items-center gap-3 ml-4">

                <button id="mobile-search-btn" class="md:hidden p-2 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <button onclick="toggleCart()" class="relative p-2 text-gray-600 dark:text-gray-300 hover:text-primary transition-colors group">
                    <i class="fa-solid fa-cart-shopping text-xl group-hover:scale-110 transition-transform"></i>
                    <span id="cart-count" class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full hidden shadow-sm">0</span>
                </button>


            </div>
        </div>
    </div>

    <div id="mobile-search-bar" class="hidden md:hidden px-4 pb-4 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900 animate-fade-in-down">
        <form action="index.php" method="GET" class="relative mt-3">
            <input type="hidden" name="page" value="menu">
            <input type="text" name="q" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>"
                class="w-full pl-4 pr-12 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 border-none focus:ring-2 focus:ring-primary text-sm text-gray-900 dark:text-white"
                placeholder="Nhập tên món ăn...">

            <button type="submit" class="absolute right-2 top-1.5 p-1.5 bg-primary text-white rounded-lg hover:bg-green-600 transition-colors">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 absolute w-full left-0 shadow-lg z-40">
        <div class="px-4 pt-2 pb-4 space-y-1">
            <a href="index.php?page=menu" class="block px-3 py-3 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary">
                <i class="fa-solid fa-mug-hot w-6 text-center"></i> Thực đơn
            </a>
            <a href="index.php?page=tracking" class="block px-3 py-3 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary">
                <i class="fa-solid fa-clock-rotate-left w-6 text-center"></i> Theo dõi đơn
            </a>
            <a href="#" class="block px-3 py-3 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary">
                <i class="fa-solid fa-tags w-6 text-center"></i> Khuyến mãi
            </a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?page=logout" class="block px-3 py-3 rounded-md text-base font-medium text-red-600 hover:bg-red-50">
                    <i class="fa-solid fa-arrow-right-from-bracket w-6 text-center"></i> Đăng xuất
                </a>
            <?php else: ?>
                <a href="index.php?page=login" class="block px-3 py-3 rounded-md text-base font-medium text-primary hover:bg-green-50">
                    <i class="fa-solid fa-user w-6 text-center"></i> Đăng nhập
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Toggle Mobile Menu
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                // Đóng search bar nếu đang mở cho đỡ rối
                document.getElementById('mobile-search-bar').classList.add('hidden');
            });
        }

        // 2. Toggle Mobile Search (MỚI)
        const searchBtn = document.getElementById('mobile-search-btn');
        const searchBar = document.getElementById('mobile-search-bar');

        if (searchBtn && searchBar) {
            searchBtn.addEventListener('click', () => {
                searchBar.classList.toggle('hidden');
                // Tự động focus vào ô input khi mở
                if (!searchBar.classList.contains('hidden')) {
                    searchBar.querySelector('input[name="q"]').focus();
                    // Đóng menu nếu đang mở
                    document.getElementById('mobile-menu').classList.add('hidden');
                }
            });
        }
    });
</script>