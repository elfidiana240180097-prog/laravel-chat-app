<x-guest-layout>

<div class="text-center mb-8">

    <div class="w-20 h-20 mx-auto rounded-full bg-[#5B96F7] text-white flex items-center justify-center text-4xl shadow-lg">

        <i class="fa-solid fa-paper-plane"></i>

    </div>

    <h1 class="text-3xl font-bold text-gray-800 mt-5">

        ChatApp

    </h1>

    <p class="text-gray-500 mt-2">

        Login untuk mulai chatting

    </p>

</div>

<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}">

    @csrf

    <div>

        <label class="block mb-2 text-gray-700 font-semibold">

            Email

        </label>

        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
            autocomplete="username"
            placeholder="Masukkan email"
            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">

        <x-input-error :messages="$errors->get('email')" class="mt-2" />

    </div>

    <div class="mt-5">

        <label class="block mb-2 text-gray-700 font-semibold">

            Password

        </label>

        <input
            id="password"
            type="password"
            name="password"
            required
            autocomplete="current-password"
            placeholder="Masukkan password"
            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">

        <x-input-error :messages="$errors->get('password')" class="mt-2" />

    </div>

    <div class="flex items-center justify-between mt-5">

        <label class="flex items-center gap-2">

            <input
                type="checkbox"
                name="remember"
                class="rounded border-gray-300 text-blue-600">

            <span class="text-sm text-gray-600">

                Ingat Saya

            </span>

        </label>

        @if(Route::has('password.request'))

        <a href="{{ route('password.request') }}"
        class="text-sm text-blue-600 hover:underline">

            Lupa Password?

        </a>

        @endif

    </div>

    <button
        type="submit"
        class="w-full mt-7 bg-[#5B96F7] hover:bg-blue-600 text-white py-3 rounded-xl font-semibold shadow-lg transition">

        <i class="fa-solid fa-right-to-bracket mr-2"></i>

        Masuk

    </button>

</form>

<div class="text-center mt-8 text-gray-400 text-sm">

    Laravel Realtime Chat • 2026

</div>

</x-guest-layout>