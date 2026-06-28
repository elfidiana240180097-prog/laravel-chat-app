<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $group->name }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="bg-[#eef2f5]">

<div class="h-screen flex flex-col">

    <!-- HEADER -->
    <div class="bg-[#517DA2] text-white px-6 py-4 flex items-center justify-between">

        <div class="flex items-center gap-4">

            <a href="{{ route('dashboard') }}">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>

            <div class="w-12 h-12 rounded-full bg-white text-[#517DA2] flex items-center justify-center">

                <i class="fa-solid fa-users"></i>

            </div>

            <div>

            <div class="font-bold text-lg">
            {{ $group->name }}
            </div>

            <div class="text-sm text-blue-100">
            {{ $memberCount }} anggota
            </div>

        </div>

        </div>

    </div>

    <!-- CHAT -->
    <div
    id="chat-box"
    class="flex-1 overflow-y-auto p-6 space-y-4 bg-[#e7ebf0]">

        @foreach($messages as $message)

            @if($message->user_id==auth()->id())

                <div class="flex justify-end">

                    <div>

                        <div class="bg-[#5B96F7] text-white rounded-3xl px-5 py-3">

                            {{ $message->message }}

                        </div>

                        <div class="text-right text-xs mt-1">

                            {{ $message->created_at->format('H:i') }}

                        </div>

                    </div>

                </div>

            @else

                <div>

                    <div class="text-sm font-bold text-gray-700 mb-1">

                        {{ $message->user->name }}

                    </div>

                    <div class="bg-white inline-block rounded-3xl px-5 py-3">

                        {{ $message->message }}

                    </div>

                    <div class="text-xs mt-1">

                        {{ $message->created_at->format('H:i') }}

                    </div>

                </div>

            @endif

        @endforeach

    </div>

    <!-- INPUT -->
    <div class="bg-white p-5 border-t">

        <form
        id="groupForm"
        action="{{ route('group.store',$group->id) }}"
        method="POST">

            @csrf

            <div class="flex gap-3">

                <input
                id="groupMessage"
                name="message"
                autocomplete="off"
                required
                class="flex-1 border rounded-full px-5 py-3"
                placeholder="Ketik pesan grup...">

                <button
                class="bg-[#5B96F7] text-white w-14 rounded-full">

                    <i class="fa-solid fa-paper-plane"></i>

                </button>

            </div>

        </form>

    </div>

</div>

<script>

window.currentGroup = {{ $group->id }};
window.currentUser = {{ auth()->id() }};

</script>

<script>

document.addEventListener('DOMContentLoaded', () => {

    const box = document.getElementById('chat-box');

    box.scrollTop = box.scrollHeight;

    window.startGroupListener(function(message){

        let html = '';

        // Kalau pesan milik saya
        if(message.user_id == window.currentUser){

            html = `
            <div class="flex justify-end">

                <div>

                    <div class="bg-[#5B96F7] text-white rounded-3xl px-5 py-3">

                        ${message.message}

                    </div>

                    <div class="text-right text-xs mt-1">

                        Baru saja

                    </div>

                </div>

            </div>
            `;

        }else{

            // Pesan orang lain

            html = `
            <div>

                <div class="text-sm font-bold text-gray-700 mb-1">

                    ${message.user.name}

                </div>

                <div class="bg-white inline-block rounded-3xl px-5 py-3">

                    ${message.message}

                </div>

                <div class="text-xs mt-1">

                    Baru saja

                </div>

            </div>
            `;

        }

        box.insertAdjacentHTML('beforeend', html);

        box.scrollTop = box.scrollHeight;

    });

});

</script>

</body>
</html>