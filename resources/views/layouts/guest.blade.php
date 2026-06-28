<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ChatApp</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body class="min-h-screen bg-gradient-to-br from-[#4c7ea8] via-[#5B96F7] to-[#8eb8ff] flex items-center justify-center p-6">

<div class="w-full max-w-4xl min-h-[500px] bg-white rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

    <!-- LEFT -->
    <div class="hidden md:flex flex-col justify-center items-center bg-[#517DA2] text-white p-12">

        <div class="w-28 h-28 rounded-full bg-white text-[#517DA2] flex items-center justify-center text-5xl shadow-lg">

            <i class="fa-solid fa-comments"></i>

        </div>

        <h1 class="text-4xl font-bold mt-8">
            ChatApp
        </h1>

        <p class="text-center mt-5 text-blue-100 leading-8">
            Aplikasi Chat Realtime <br>
        </p>

    </div>

    <!-- RIGHT -->
    <div class="flex items-center justify-center p-8 md:p-10">

        <div class="w-full max-w-sm">

            <div class="text-center mb-8">

                <div class="w-20 h-20 mx-auto rounded-full bg-[#5B96F7] text-white flex items-center justify-center text-3xl shadow-lg">

                    <i class="fa-solid fa-user"></i>

                </div>

                <h2 class="text-3xl font-bold mt-5">
                    Selamat Datang
                </h2>

                <p class="text-gray-500 mt-2">
                    Silakan login untuk mulai chatting.
                </p>

            </div>

            {{ $slot }}

        </div>

    </div>

</div>

</body>
</html>