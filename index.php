<?php
session_start();
include('includes/db.php');

// Query untuk mengambil semua produk
$query = "SELECT * FROM produk";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query Produk Gagal: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda | Kadai Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Header -->
    <?php include 'includes/header.php' ?>

    <!-- Banner / Image Slider -->
    <?php include 'includes/slide.php' ?>

    <!-- Daftar Produk -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-10">Produk Kami</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <div class="bg-white border rounded-lg shadow-lg overflow-hidden">
                        <img src="assets/images/<?= $product['foto1']; ?>" alt="<?= $product['nama']; ?>" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold"><?= $product['nama']; ?></h3>
                            <p class="text-lg font-semibold mt-4">Rp <?= number_format($product['harga'], 2, ',', '.'); ?></p>
                            
                            <!-- Menambahkan Diskon jika ada -->
                            <?php if (!empty($product['diskon'])): ?>
                                <p class="text-lg text-red-500 mt-2">Diskon: <?= $product['diskon']; ?>%</p>
                            <?php endif; ?>

                            <!-- Menambahkan Deskripsi Produk -->
                            <?php if (!empty($product['detail'])): ?>
                                <p class="text-sm text-gray-600 mt-2"><?= substr($product['detail'], 0, 100); ?>...</p>
                            <?php endif; ?>

                            <a href="product_detail.php?id=<?= $product['idproduk']; ?>" class="block bg-gray-800 text-white text-center py-2 mt-4 rounded hover:bg-yellow-400">Lihat Detail</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Garis pemisah -->
    <!-- <hr class="my-12 border-t-2 border-gray-300"> -->

    <section class="py-16 bg-white border-t-4 border-gray-200">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-left mb-5">Nikmati Mudahnya Jualan Online di Tokopedia</h2>
        <p class="text-gray-700 text-base mb-6 text-justify">
        Tokopedia merupakan salah satu situs jual beli online di Indonesia yang perkembangannya 
        terhitung cepat dan memiliki tujuan untuk memudahkan setiap masyarakat di Indonesia, 
        agar dapat melakukan aneka transaksi jual beli secara online. Selain kamu dapat menikmati proses pembelian aneka produk lebih mudah dan efisien, 
        kamu para seller juga dapat melakukan jualan online di Tokopedia. 
        Kamu bisa bergabung dengan komunitas khusus Tokopedia Seller bagi kamu yang ingin memulai bisnis dan jualan online atau ingin memperluas bisnis 
        yang sedang kamu jalankan. Proses pendaftaran untuk menjadi Tokopedia Seller juga sangat mudah cukup dengan memasukkan data diri, nama toko, 
        alamat toko setelah itu kamu akan langsung terdaftar sebagai Tokopedia Seller. Kamu juga dapat melakukan upgrade akun toko kamu menjadi Power 
        Merchant untuk menjangkau pelanggan Tokopedia yang lebih luas lagi, sehingga bisnis online kamu semakin laris. Keuntungan Power Merchant adalah 
        kamu dapat memberikan fitur Bebas Ongkir sehingga dapat menarik lebih banyak lagi pelanggan, lalu kamu dapat menikmati fitur TopAds yang dapat 
        menjangkau masyarakat pengguna Tokopedia lebih banyak lagi dengan modal yang sangat minim mulai dari Rp 25 ribuan, hingga toko kamu akan tampil 
        lebih menarik lagi serta dapat meningkatkan kepercayaan pembeli. Ayo mulai jualan online di Tokopedia dan mulai kembangkan usahamu secara online 
        bersama Tokopedia.
        </p>
        <p class="text-gray-700 text-base mb-6 text-justify">
            Tokopedia merupakan salah satu e-commerce di Indonesia yang menawarkan berbagai macam produk dan menjadikannya sebagai marketplace pilihan bagi banyak masyarakat Indonesia. Tidak hanya itu, kehadiran Tokopedia membuat pengalaman belanja online para penggunanya menjadi lebih mudah, aman, dan efisien. Tersedia berbagai fitur dan metode pembayaran yang dapat Anda pilih, untuk memastikan kegiatan belanja Anda dapat dilakukan senyaman mungkin. Baik itu melalui transfer bank yang bisa dilakukan menggunakan rekening dari berbagai bank yang tersedia, uang elektronik seperti OVO, hingga cicilan. Sistem berbelanja di Tokopedia terintegrasi pula dengan sistem beberapa jasa ekspedisi. Kerjasama yang dijalin ini memungkinkan Tokopedia untuk memberikan penawaran pengiriman gratis, dan memungkinkan pengguna yang berbelanja untuk terus melacak status pengiriman produk yang mereka beli. Jadi, produk apapun yang dibeli di Tokopedia baik itu pakaian bayi, aksesoris mobil, aksesoris kamera, celana, jam, hingga peralatan elektronik seperti kabel dan peralatan gaming, atau makanan sekali pun dapat terus Anda lacak keberadaannya untuk memastikan akan sampai dengan aman. Data pribadi dan seluruh transaksi yang sudah maupun yang akan Anda lakukan di Tokopedia dilindungi oleh kebijakan privasi Tokopedia, sehingga tak perlu khawatir data Anda akan jatuh ke pihak yang tidak bertanggungjawab dan/atau disalahgunakan. Karena faktor-faktor tersebut lah, Tokopedia menjadi solusi untuk belanja online dengan mudah dan aman.
        </p>

        <h2 class="text-2xl font-bold text-left mb-5">Belanja Produk-produk Original Di Tokopedia Official Store</h2>
        <p class="text-gray-700 text-base mb-6 text-justify">
            Tokopedia merupakan platform digital dimana kamu dapat berbelanja setiap kebutuhan pokok kamu sehari-hari dengan cukup menggunakan aplikasi serta koneksi Internet. Kemudahan berbelanja secara online yang disediakan oleh Tokopedia akan sangat membantu kamu menghemat waktu serta tenaga tanpa harus menjalani antrian yang sangat panjang hanya untuk melakukan pembelian produk-produk kebutuhan kamu. Akan tetapi, masih banyak sekali masyarakat yang masih kurang percaya terhadap produk-produk yang disediakan secara online, mulai dari takut ditipu, hingga produk yang tidak original. Kamu tidak perlu takut saat berbelanja di Tokopedia, demi meningkatkan kepercayaan masyarakat, Tokopedia menghadirkan Official Store, yang menyediakan aneka produk-produk dengan kualitas original serta mendapatkan garansi resmi 7 hari dari Tokopedia! Kamu bisa mendapatkan produk kebutuhan pokok di Tokopedia Official Store seperti produk pakaian seperti dari toko Berrybenka yang menyediakan pakaian Outerwear (Cardigan, Blazer), Blouse, Scarf Wanita, Dress & Jumpsuit, hingga Basic Shirt yang cocok digunakan untuk wanita.
        </p>

        <h2 class="text-2xl font-bold text-left mb-5">Kerjasama Tokopedia Dengan Berbagai Penjual Lokal dan Brand Ternama</h2>
        <p class="text-gray-700 text-base mb-6 text-justify">
        Tokopedia termasuk toko online yang banyak diminati masyarakat karena produk yang ditawarkan begitu banyak, penjualnya pun tersedia dari berbagai daerah di seluruh Indonesia. Dengan begini, Tokopedia tidak hanya memudahkan para konsumen dan pengguna yang memiliki kebutuhan untuk berbelanja, tetapi juga banyak penjual di Indonesia yang memiliki keinginan untuk mengembangkan bisnis mereka. Memanfaatkan toko online seperti Tokopedia tidak hanya membuat usaha para penjual lebih berkembang, tetapi juga menghubungkan penjual dengan lebih banyak konsumen dari berbagai lapisan dan daerah melalui cara yang sangat mudah dan sederhana. Selain dengan pemilik usaha pribadi, mulai tahun 2019 ini Tokopedia juga menjalin kerjasama bersama dengan banyak brand agar mereka memiliki official store mereka masing-masing secara resmi. Beberapa official store yang sudah bergabung saat ini ada Samsung, Xiaomi, Gramedia, Wardah, dan masih banyak lagi. Membeli produk resmi langsung dari official store-nya tentu saja dapat dijamin keaslian produknya dan juga kualitas yang ditawarkan. Belanja online dari official store juga dapat memberikan Anda jaminan garansi dan tawaran harga terbaik, karena para brand yang menawarkan voucher dan diskon terbaik bagi pembelinya. Ada pula brand sepatu lokal yang sedang diminati masyarakat Indonesia saat ini yaitu Sepatu Compass, yang menjual produk sneakers andalannya seperti sepatu compass gazelle dan sepatu compass vintage 98 secara eksklusif di Tokopedia melalui official store sepatu compass. Membeli produk resmi langsung dari official store-nya tentu saja dapat dijamin keaslian produknya dan juga kualitas yang ditawarkan. Belanja online dari official store juga dapat memberikan Anda jaminan garansi dan tawaran harga terbaik, karena para brand yang menawarkan voucher dan diskon terbaik bagi pembelinya.
        </p>
        <p class="text-gray-700 text-base mb-6 text-justify">
        Sebagai situs jual beli online yang sangat terpercaya dan memiliki produk terlengkap di Indonesia. Tokopedia menjadi salah satu toko online dengan banyak peminat dari berbagai kalangan usia di masyarakat. Selain karena lengkap, produk-produk yang dijual di Tokopedia juga sangat terjamin kualitasnya. Karena dijual oleh para seller online yang terpercaya yang berada di lokasi terdekat dan tersebar di berbagai daerah di Indonesia. Sehingga, para konsumen setia Tokopedia bisa dengan mudah menikmati kepraktisan berbelanja secara online. Mudahnya berbelanja di situs jual beli terlengkap ini juga didukung lewat ekspansi atau perluasan kerjasama. Karena kini di Tokopedia, hadir secara online official store dengan aneka brand agar kenyamanan dan kepuasan berbelanja para konsumen semakin terjamin. Dan dikategorikan berdasarkan brand sesuai dengan bentuk produk yang dijualnya. Seperti salah satu brand ternama yang menjual aneka produk pakaian dan pernak pernik lucu Miniso, yang sudah sangat dikenal oleh masyarakat Indonesia. Saat ini, sudah tersedia banyak sekali brand ternama yang hadir di Tokopedia sebagai official store secara variatif. Tidak hanya pakaian, karena kini kamu bisa mendapatkan berbagai jenis perangkat elektronik yang canggih dan terbaru melalui hadirnya berbagai official store produsen gadget-gadget canggih. Baik yang berupa smartphone, maupun produk laptop untuk menunjang berbagai aktivitas.
        </p>
        <p class="text-gray-700 text-base mb-6 text-justify">
        Mulai dari Oppo sebagai salah satu merk atau brand smartphone ternama yang saat ini memiliki banyak peminat di Indonesia. Sebagai brand yang berasal dari negeri Tiongkok ini, pamornya di Indonesia mulai membayangi produsen-produsen smartphone lainnya. Hal ini disebabkan oleh harganya yang sangat terjangkau dan juga kualitasnya yang mampu bersaing di pasaran dengan sangat kompetitif. Masyarakat Indonesia juga seringkali menjadikan produk smartphone Oppo sebagai alternatif dari produk smartphone dengan spesifikasi serupa merk lain yang harganya bisa jauh di atas harga smartphone keluaran Oppo. Produsen yang hadir di Indonesia sejak April 2013 ini memang sudah memperkenalkan diri di Indonesia melalui produk Oppo Find 5 saat itu. Jika saat itu smartphone produksi Tiongkok sedang trend dengan spesifikasi seadanya yang terkesan copy-paste, Oppo hadir dengan desain yang elegan dan fitur-fitur menarik. Sampai saat ini, anda bisa mendapatkan berbagai produk smartphone keluaran Oppo dengan keaslian dan kualitas yang terjamin. Tentunya melalui online official store produsen ternama ini di Tokopedia.
        </p>
    </div>
    </div>
</section>

    <!-- Fitur Kami -->
    <?php include 'includes/newsSlide.php' ?>


    <!-- Footer -->
    <?php include 'includes/footer.php' ?>

</body>
</html>

<script>
// JavaScript untuk mengendalikan slider otomatis dan manual

let currentIndex = 0;
const slides = document.querySelectorAll('#slider img');
const totalSlides = slides.length;

function showSlide(index) {
    // Menentukan pergeseran gambar dengan menggunakan transform
    const slider = document.getElementById('slider');
    const offset = -index * 100; // Setiap gambar akan bergerak 100% lebar ke kiri
    slider.style.transform = `translateX(${offset}%)`;
}

function nextSlide() {
    currentIndex = (currentIndex + 1) % totalSlides;
    showSlide(currentIndex);
}

function prevSlide() {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    showSlide(currentIndex);
}

// Otomatis bergeser setiap 5 detik
setInterval(nextSlide, 5000);
</script>
