<header class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <div class="flex items-center gap-4">
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
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
                <a href="index.php?page=menu" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition-colors">
                    Thực đơn
                </a>
                <a href="index.php?page=tracking" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition-colors">
                    Theo dõi đơn
                </a>
                <a href="#" class="text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition-colors">
                    Khuyến mãi
                </a>
            </nav>

            <div class="hidden md:flex flex-1 max-w-xs">
                <div class="relative w-full">
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text"
                        class="w-full pl-10 pr-4 py-2 rounded-full bg-gray-100 dark:bg-gray-800 border-none focus:ring-2 focus:ring-primary text-sm transition-all placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white"
                        placeholder="Tìm món...">
                </div>
            </div>

            <div class="flex items-center gap-3 ml-4">
                <button class="md:hidden p-2 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <button onclick="toggleCart()" class="relative p-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors group">
                    <i class="fa-solid fa-cart-shopping text-xl group-hover:scale-110 transition-transform"></i>
                    <span id="cart-count" class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full hidden shadow-sm">0</span>
                </button>

                <button class="w-8 h-8 rounded-full overflow-hidden border border-gray-200 dark:border-gray-700 ml-2">
                    <img src="https://ui-avatars.com/api/?name=User&background=random" alt="User" class="w-full h-full object-cover">
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 absolute w-full left-0 top-16 shadow-lg">
        <div class="px-4 pt-2 pb-4 space-y-1">
            <a href="index.php?page=menu" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary">
                <i class="fa-solid fa-mug-hot w-6"></i> Thực đơn
            </a>
            <a href="index.php?page=tracking" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary">
                <i class="fa-solid fa-clock-rotate-left w-6"></i> Theo dõi đơn
            </a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary">
                <i class="fa-solid fa-tags w-6"></i> Khuyến mãi
            </a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary">
                <i class="fa-solid fa-phone w-6"></i> Liên hệ
            </a>
        </div>
    </div>
</header>