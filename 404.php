<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            /* Setting background seperti yang diminta */
            background-color: white;
            background: linear-gradient(to right, #80808033 1px, transparent 1px), linear-gradient(to bottom, #80808033 1px, transparent 1px);
            background-size: 70px 70px;
        }
    </style>
</head>

<body class="bg-white text-white flex items-center justify-center min-h-screen">
    <div class="text-center">
        <!-- Tempat untuk GIF -->
        <img src="assets/images/clickbait/cat.gif" alt="404 Gif" class="w-3/5 mx-auto mb-6 animate__animated animate__fadeInUp rounded-lg">

        <!-- Animated Heading -->
        <h1 class="text-9xl mb-10 font-extrabold text-yellow-400 animate__animated animate__fadeInDown">404</h1>
        
        <!-- Error Message -->
        <p class="text-gray-800 text-xl mb-10 animate__animated animate__fadeIn animate__delay-1s">
            Ngapain? Mau nakal ya? xixixi
        </p>

        <!-- Button to Home -->
        <a href="/" class="inline-block px-6 py-3 bg-teal-500 text-gray-800 font-semibold rounded-lg text-lg transform hover:bg-teal-400">
            Home
        </a>
    </div>

    <!-- Include Tailwind's animate library -->
    <script src="https://cdn.jsdelivr.net/npm/animate.css@4.1.1"></script>

    <!-- Musik Latar tanpa kontrol dan autoplay -->
    <audio id="background-audio" autoplay loop>
        <source src="/assets/sound/cat_haha.mp3" type="audio/mpeg">
        <source src="/assets/sound/cat_haha.ogg" type="audio/ogg">
        <source src="/assets/sound/cat_haha.wav" type="audio/wav">
        Your browser does not support the audio element.
    </audio>

    <!-- Script untuk cek status audio -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var audio = document.getElementById('background-audio');
            audio.muted = true; // Set muted untuk tes autoplay
            audio.play().then(() => {
                console.log("Audio is playing");
            }).catch(error => {
                console.error("Audio play failed:", error);
            });
        });
    </script>
</body>

</html>