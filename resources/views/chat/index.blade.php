<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatApp</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="bg-[#eef2f5]">

<div class="h-screen p-5">

<div class="flex h-full rounded-2xl overflow-hidden shadow-2xl">

    <!-- SIDEBAR -->
    <div class="w-[340px] bg-white border-r flex flex-col">

        <!-- PROFILE -->
        <div class="bg-[#517DA2] text-white p-5">

            <div class="flex justify-end">

    <form method="POST" action="{{ route('logout') }}">

        @csrf

        <button
        class="text-white hover:text-gray-200">

            <i class="fa-solid fa-right-from-bracket"></i>

        </button>

    </form>

</div>

            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-full bg-white text-[#517DA2] flex items-center justify-center text-2xl font-bold">

                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}

                </div>

                <div>

                    <div class="font-bold text-lg">

                        {{ auth()->user()->name }}

                    </div>

                    <div class="text-blue-100 text-sm">

                        Online

                    </div>

                </div>

            </div>

        </div>

        <!-- SEARCH -->
        <div class="p-4 border-b">

            <input
                type="text"
                placeholder="Cari pengguna..."
                class="w-full rounded-full border border-gray-300 px-5 py-3 focus:ring-2 focus:ring-blue-400 focus:outline-none">

        </div>

        <!-- USER LIST -->
        <div class="flex-1 overflow-y-auto">

            @foreach($users as $user)

            <a href="{{ route('chat.show',$user->id) }}"
               class="flex items-center gap-4 px-5 py-4 border-b hover:bg-blue-50 transition">

                <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">

                    {{ strtoupper(substr($user->name,0,1)) }}

                </div>

                <div class="flex-1">

                    <div class="font-semibold">

                        {{ $user->name }}

                    </div>

                    <div class="text-green-600 text-sm">

                        ● Online

                    </div>

                </div>

            </a>

            @endforeach

        </div>

    </div>

    <!-- RIGHT -->
    <div class="flex-1 flex flex-col bg-[#e7ebf0]">

        <!-- HEADER -->
        <div class="bg-white border-b px-8 py-6">

            <h2 class="text-2xl font-bold text-gray-700">

                Telegram Chat

            </h2>

            <p class="text-sm text-gray-500 mt-1">

                {{ $users->count() }} Kontak

            </p>

        </div>

        <!-- BODY -->
        <div class="flex-1 flex flex-col items-center justify-center">

            <div class="w-28 h-28 rounded-full bg-blue-500 flex items-center justify-center text-white text-5xl">

                <i class="fa-solid fa-comments"></i>

            </div>

            <h2 class="text-3xl font-bold text-gray-700 mt-8">

                Selamat Datang

            </h2>

            <p class="text-gray-500 mt-3">

                Pilih salah satu kontak di sebelah kiri untuk mulai chatting.

            </p>

        </div>

    </div>

</div>

</div>

</body>
</html>