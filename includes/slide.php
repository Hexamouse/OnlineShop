<section class="relative bg-gray-200 py-4 text-center">
        <div class="container mx-auto">
            <!-- Slider Images -->
            <div class="relative w-full h-96 overflow-hidden rounded-lg shadow-lg">
                <!-- Gambar Slider -->
                <div class="absolute inset-0 flex transition-all duration-700 ease-in-out transform" id="slider">
                    <img src="assets/images/banner/banner1.jpg" alt="Banner 1" class="w-full h-full object-cover">
                    <img src="assets/images/banner/banner2.jpg" alt="Banner 2" class="w-full h-full object-cover">
                </div>

                <!-- Tombol navigasi kiri dan kanan -->
                <button onclick="prevSlide()" class="absolute top-1/2 left-0 transform -translate-y-1/2 p-4 bg-black bg-opacity-50 text-white rounded-full hover:bg-opacity-75 focus:outline-none">
                    &lt;
                </button>
                <button onclick="nextSlide()" class="absolute top-1/2 right-0 transform -translate-y-1/2 p-4 bg-black bg-opacity-50 text-white rounded-full hover:bg-opacity-75 focus:outline-none">
                    &gt;
                </button>
            </div>
        </div>
    </section>