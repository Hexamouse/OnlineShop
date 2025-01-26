<!-- Tidak perlu lagi session_start() di sini jika sudah ada di file lain -->
<header class="bg-transparent text-gray-800 py-4 shadow-lg border-b-4 border-gray-800 sticky top-0 z-50 transition-all duration-300" id="header">
    <div class="container mx-auto flex justify-between items-center px-8 max-w-screen-xl">
        <!-- Nama Toko -->
        <h1 class="text-3xl font-bold tracking-wide text-gray-800 cursor-pointer">
            <a href="/index.php">KadaiPedia</a>
        </h1>
        
        <!-- Navigasi -->
        <nav>
            <ul class="flex space-x-4 text-base items-center">
            <?php if (isset($_SESSION['iduser'])): ?>
    <!-- Menampilkan nama pengguna setelah login -->
    <li class="flex items-center space-x-2">
        <a href="../buyer/auth/profile.php" class="inline-flex items-center space-x-2 py-1 px-3 bg-transparent border-2 border-gray-800 rounded-lg hover:bg-yellow-400 hover:text-gray-900 transition-all duration-300">
            <!-- SVG Icon for Account -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
            </svg>
            <!-- Teks Akun -->
            <span>Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </a>
    </li>
    <!-- Logout Button -->
    <li class="flex items-center space-x-2">
        <a href="logout.php" class="inline-flex items-center space-x-2 py-1 px-3 bg-transparent border-2 border-gray-800 rounded-lg hover:bg-yellow-400 hover:text-gray-900 transition-all duration-300">
            <!-- SVG Icon for Logout -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M16.5 3.75a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5h-6a1.5 1.5 0 0 1-1.5-1.5V15a.75.75 0 0 0-1.5 0v3.75a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V5.25a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3V9A.75.75 0 1 0 9 9V5.25a1.5 1.5 0 0 1 1.5-1.5h6ZM5.78 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 0 0 0 1.06l3 3a.75.75 0 0 0 1.06-1.06l-1.72-1.72H15a.75.75 0 0 0 0-1.5H4.06l1.72-1.72a.75.75 0 0 0 0-1.06Z" clip-rule="evenodd" />
            </svg>
            <!-- Teks Logout -->
            <span>Logout</span>
        </a>
    </li>
<?php else: ?>
    <!-- Login Button jika belum login -->
    <li class="flex items-center space-x-2">
        <a href="../buyer/auth/login.php" class="inline-flex items-center space-x-2 py-1 px-3 bg-transparent border-2 border-gray-800 rounded-lg hover:bg-yellow-400 hover:text-gray-900 transition-all duration-300">
            <!-- SVG Icon for Login -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
            </svg>
            <!-- Teks Login -->
            <span>Login</span>
        </a>
    </li>
    <!-- Register Button jika belum login -->
    <li class="flex items-center space-x-2">
        <a href="buyer/auth/register.php" class="inline-flex items-center space-x-2 py-1 px-3 bg-transparent border-2 border-gray-800 rounded-lg hover:bg-yellow-400 hover:text-gray-900 transition-all duration-300">
            <!-- SVG Icon for Register -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
            </svg>
            <!-- Teks Register -->
            <span>Register</span>
        </a>
    </li>
<?php endif; ?>
                
                <!-- Keranjang (Cart Button) -->
                <li class="relative">
                    <a href="../../cart.php" class="inline-flex items-center space-x-2 py-1 px-3 bg-transparent">
                        <!-- SVG Icon for Cart -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

<!-- Categories List Below the Header -->
<div class="bg-white py-2">
    <div class="container mx-auto px-8 max-w-screen-xl">
        <ul class="flex space-x-6 text-sm text-gray-800">
            <li><a href="#" class="hover:text-yellow-500">Televisi</a></li>
            <li><a href="#" class="hover:text-yellow-500">Smartphone</a></li>
            <li><a href="#" class="hover:text-yellow-500">Kulkas</a></li>
            <li><a href="#" class="hover:text-yellow-500">Beauty</a></li>
            <li><a href="#" class="hover:text-yellow-500">Sports</a></li>
            <li><a href="#" class="hover:text-yellow-500">Toys</a></li>
        </ul>
    </div>
</div>

<!-- Add JavaScript to Detect Scroll and Apply Glassmorphism Effect -->
<script>
    window.addEventListener("scroll", function() {
        const header = document.getElementById("header");
        if (window.scrollY > 0) {
            header.classList.add("bg-white/50", "backdrop-blur-md");
        } else {
            header.classList.remove("bg-white/50", "backdrop-blur-md");
        }
    });
</script>
