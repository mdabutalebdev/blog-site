<!-- Top Announcement Bar -->
<div class="relative overflow-hidden bg-gray-900 text-white text-xs sm:text-sm py-2 shadow-inner">
    <!-- Animated gradient background -->
    <div class="absolute inset-0 opacity-40 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-[length:200%_auto] animate-gradient-x"></div>
    
    <div class="container mx-auto px-4 relative z-10 flex justify-center sm:justify-between items-center">
        <!-- Left: Animated announcement -->
        <div class="flex items-center gap-3">
            <span class="flex h-2 w-2 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
            </span>
            <span class="font-medium tracking-wide">
                <span class="text-gray-200">New Feature:</span> 
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-white to-blue-200 animate-pulse ml-1">Write your blogs with the brand new markdown editor! 🎉</span>
            </span>
        </div>
        
        <!-- Right: Socials/Links -->
        <div class="hidden sm:flex items-center gap-5 font-semibold text-gray-300">
            <a href="#" class="hover:text-white transition flex items-center gap-1.5 group">
                <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                Twitter
            </a>
            <div class="w-px h-3 bg-gray-600"></div>
            <a href="#" class="hover:text-white transition flex items-center gap-1.5 group">
                <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.418 3.582 8.07 8 8.07.4 0 .53-.106.53-.386 0-.19-.007-.693-.01-1.36-2.78.604-3.367-1.343-3.367-1.343-.364-.924-.888-1.17-.888-1.17-.726-.497.055-.487.055-.487.803.056 1.225.824 1.225.824.714 1.223 1.872.87 2.328.665.072-.517.279-.87.508-1.07-2.219-.253-4.554-1.11-4.554-4.943 0-1.09.39-1.982 1.029-2.68-.103-.253-.446-1.268.098-2.64 0 0 .84-.269 2.75 1.023A9.578 9.578 0 0112 6.836c.85.004 1.705.115 2.504.337 1.909-1.293 2.747-1.023 2.747-1.023.546 1.373.203 2.388.1 2.64.64.698 1.028 1.59 1.028 2.68 0 3.842-2.339 4.687-4.566 4.935.287.247.543.735.543 1.481 0 1.07-.01 1.932-.01 2.195 0 .282.128.39.535.385C19.605 19.266 24 15.617 24 12c0-5.523-4.477-10-10-10z"/></svg>
                GitHub
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes gradient-x {
        0%, 100% {
            background-size: 200% 200%;
            background-position: left center;
        }
        50% {
            background-size: 200% 200%;
            background-position: right center;
        }
    }
    .animate-gradient-x {
        animation: gradient-x 3s ease infinite;
    }
</style>

<nav class="bg-white shadow-sm sticky top-0 z-50 glass">
    <div class="container mx-auto px-4 h-16 flex items-center justify-between">
        <!-- Logo (Left) -->
        <div class="flex items-center md:w-48">
            <a href="/" class="text-2xl font-bold text-blue-600">BlogSite</a>
        </div>
        
        <!-- Menus (Center) -->
        <div class="hidden md:flex flex-1 justify-center gap-8">
            <a href="/" class="text-gray-600 hover:text-blue-600 font-medium transition">Home</a>
            <a href="/books" class="text-gray-600 hover:text-blue-600 font-medium transition">Books</a>
        </div>

        <!-- Actions (Right) -->
        <div class="flex items-center justify-end gap-4 md:w-48">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/post/create" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full font-semibold transition shadow-sm hover:shadow text-sm">Write Blog</a>
                
                <!-- Profile Dropdown -->
                <div class="relative ml-2">
                    <button type="button" id="profile-menu-btn" class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 border-2 border-white shadow-sm flex items-center justify-center font-bold text-blue-700 overflow-hidden ring-2 ring-transparent hover:ring-blue-100 transition focus:outline-none">
                        <?php if(!empty($_SESSION['user_avatar'])): ?>
                            <img src="<?= e($_SESSION['user_avatar']) ?>" alt="Avatar" class="w-full h-full object-cover">
                        <?php else: ?>
                            <?= substr($_SESSION['user_name'] ?? 'U', 0, 1) ?>
                        <?php endif; ?>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="profile-dropdown" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] py-2 hidden border border-gray-100/50 transform transition duration-200 origin-top-right z-50">
                        <div class="px-4 py-3 border-b border-gray-50 mb-1">
                            <p class="text-sm font-bold text-gray-900 truncate"><?= e($_SESSION['user_name'] ?? 'User') ?></p>
                            <p class="text-xs text-gray-500 truncate"><?= e($_SESSION['user_email'] ?? '') ?></p>
                        </div>
                        <a href="/profile" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50/50 hover:text-blue-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profile Settings
                        </a>
                        <a href="/my-blogs" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50/50 hover:text-blue-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            My Blogs
                        </a>
                        <div class="h-px bg-gray-50 my-1"></div>
                        <a href="/logout" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50/50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Sign Out
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="/login" class="text-gray-600 hover:text-blue-600 font-medium transition text-sm">Log In</a>
                <a href="/register" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2 rounded-full font-semibold transition shadow-sm hover:shadow text-sm">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
