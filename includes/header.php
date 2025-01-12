<!-- header.php -->
<header class="bg-gradient-to-r from-gray-800 via-gray-900 to-black text-white py-4 shadow-lg">
    <div class="container mx-auto flex justify-between items-center px-8 max-w-screen-xl">
        <!-- Nama Toko -->
        <h1 class="text-3xl font-bold tracking-wide text-yellow-400 hover:text-yellow-500 cursor-pointer transition-all duration-300">
            Kadai Online
        </h1>
        
        <!-- Navigasi -->
        <nav>
            <ul class="flex space-x-4 text-base items-center">
                <!-- Login Button -->
                <li class="flex items-center space-x-2">
                    <a href="../buyer/auth/login.php" class="inline-flex items-center space-x-2 py-1 px-3 bg-transparent border-2 border-white rounded-lg hover:bg-yellow-400 hover:text-gray-900 transition-all duration-300">
                        <!-- SVG Icon for Login -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5.25V18.75M5.25 12h13.5" />
                        </svg>
                        <!-- Teks Login -->
                        <span>Login</span>
                    </a>
                </li>
                <!-- Register Button -->
                <li class="flex items-center space-x-2">
                    <a href="buyer/auth/register.php" class="inline-flex items-center space-x-2 py-1 px-3 bg-transparent border-2 border-white rounded-lg hover:bg-yellow-400 hover:text-gray-900 transition-all duration-300">
                        <!-- SVG Icon for Register -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                        </svg>
                        <!-- Teks Register -->
                        <span>Register</span>
                    </a>
                </li>
                <!-- Keranjang (Cart Button) -->
                <li class="relative">
                    <a href="cart.php" class="inline-flex items-center space-x-2 py-1 px-3 bg-transparent">
                        <!-- SVG Icon for Cart -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <!-- Cart Badge (optional) -->
                        <!-- <span class="absolute top-0 right-0 text-xs bg-yellow-400 text-black rounded-full w-4 h-4 flex items-center justify-center">3</span> -->
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
