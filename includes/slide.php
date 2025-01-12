<section class="relative bg-gray-200 py-4 text-center">
    <div class="container mx-auto">
        <!-- Slider Images -->
        <div class="relative w-full h-96 overflow-hidden rounded-lg shadow-lg">
            <!-- Gambar Slider -->
            <div class="absolute inset-0 flex transition-all duration-700 ease-in-out transform" id="slider">
                <img src="assets/images/banner/banner1.jpg" alt="Banner 1" class="w-full h-full object-cover">
                <img src="assets/images/banner/banner2.jpg" alt="Banner 2" class="w-full h-full object-cover">
                <img src="assets/images/banner/shopee1.png" alt="Banner 2" class="w-full h-full object-cover">
            </div>

            <!-- Tombol navigasi kiri dan kanan -->
            <button onclick="prevSlide()" class="absolute top-1/2 left-3 transform -translate-y-1/2 w-12 h-12 p-3 bg-black bg-opacity-50 text-white rounded-full hover:bg-opacity-75 focus:outline-none">
                <!-- SVG untuk panah kiri -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button onclick="nextSlide()" class="absolute top-1/2 right-3 transform -translate-y-1/2 w-12 h-12 p-3 bg-black bg-opacity-50 text-white rounded-full hover:bg-opacity-75 focus:outline-none">
                <!-- SVG untuk panah kanan -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

        </div>
    </div>
</section>
