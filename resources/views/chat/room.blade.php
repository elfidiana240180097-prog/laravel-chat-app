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

        <!-- Profile -->
        <div class="bg-[#517DA2] text-white p-5">

        

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

        <!-- Search -->

        <div class="p-4 border-b">

            <input
                type="text"
                placeholder="Cari pengguna..."
                class="w-full rounded-full border border-gray-300 px-5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400">

        </div>

        <!-- User -->

        <div class="flex-1 overflow-y-auto">

            @foreach($users as $u)

            <a href="{{ route('chat.show',$u->id) }}"
               class="flex items-center gap-4 px-5 py-4 border-b transition hover:bg-blue-50">

                <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">

                    {{ strtoupper(substr($u->name,0,1)) }}

                </div>

                <div class="flex-1">

                    <div class="font-semibold">

                        {{ $u->name }}

                    </div>

                    <div class="text-green-600 text-sm">

                        ● Online

                    </div>

                </div>

            </a>

            @endforeach

        </div>

    </div>

    <!-- CHAT -->

    <div class="flex-1 flex flex-col bg-[#e7ebf0]">

        <!-- Header -->

        <div class="bg-white border-b px-6 py-4 flex justify-between items-center">

            <div class="flex items-center gap-4">

                <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-lg">

                    {{ strtoupper(substr($user->name,0,1)) }}

                </div>

                <div>

                    <div class="font-bold text-lg">

                        {{ $user->name }}

                    </div>

                    <div
                    id="typing-status"
                    class="text-sm text-green-600">

                    ● Online

                    </div>

                </div>

            </div>

            <div class="flex gap-6 text-gray-500 text-lg">

                <button class="hover:text-blue-500">

                    <i class="fa-solid fa-phone"></i>

                </button>

                <button class="hover:text-blue-500">

                    <i class="fa-solid fa-video"></i>

                </button>

                <button class="hover:text-blue-500">

                    <i class="fa-solid fa-ellipsis-vertical"></i>

                </button>

            </div>

        </div>

        <!-- CHAT BOX -->

        <div id="chat-box"
        class="flex-1 overflow-y-auto p-6 space-y-4">

        @forelse($messages as $message)

            @if($message->sender_id == auth()->id())

                <div class="flex justify-end">

                    <div class="max-w-md">

                        <div class="bg-[#5B96F7] text-white px-5 py-3 rounded-3xl shadow break-words">

                            {{ $message->message }}

                        </div>

                        <div class="text-right text-xs text-gray-500 mt-1">

                            {{ $message->created_at->format('H:i') }}

                        </div>

                    </div>

                </div>

            @else

                <div class="flex items-end gap-3">

                    <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">

                        {{ strtoupper(substr($user->name,0,1)) }}

                    </div>

                    <div class="max-w-md">

                        <div class="bg-white px-5 py-3 rounded-3xl shadow break-words">

                            {{ $message->message }}

                        </div>

                        <div class="text-xs text-gray-500 mt-1">

                            {{ $message->created_at->format('H:i') }}

                        </div>

                    </div>

                </div>

            @endif

        @empty

            <div class="text-center text-gray-500 mt-20">

                Belum ada percakapan.

            </div>

        @endforelse

        </div>

        <!-- INPUT -->

        <div class="bg-white border-t p-5">

            <form
            id="chatForm"
            action="{{ route('chat.store',$user->id) }}"
            method="POST">

                @csrf

                <div class="flex gap-3">

                    <input
                        id="messageInput"
                        name="message"
                        type="text"
                        placeholder="Ketik pesan..."
                        class="flex-1 rounded-full border border-gray-300 px-6 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>

                    <button
                        class="w-14 h-14 rounded-full bg-[#5B96F7] text-white hover:bg-blue-600 transition">

                        <i class="fa-solid fa-paper-plane"></i>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</div>

</body>
</html>

@vite('resources/js/app.js')

<script>
window.currentUser = {{ auth()->id() }};
window.chatUser = {{ $user->id }};
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const chatBox = document.getElementById('chat-box');
    const messageInput = document.getElementById('messageInput');

    chatBox.scrollTop = chatBox.scrollHeight;
    messageInput.focus();

    // Kirim event typing
    messageInput.addEventListener('input', () => {

        fetch('/typing/{{ $user->id }}', {

            method: 'POST',

            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }

        });

    });

    // Listener chat realtime
    window.startChatListener(function(message){

        if(message.sender_id != window.chatUser){
            return;
        }

        chatBox.innerHTML += `
        <div class="flex items-end gap-3">

            <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">

                {{ strtoupper(substr($user->name,0,1)) }}

            </div>

            <div class="max-w-md">

                <div class="bg-white px-5 py-3 rounded-3xl shadow break-words">

                    ${message.message}

                </div>

                <div class="text-xs text-gray-500 mt-1">

                    Baru saja

                </div>

            </div>

        </div>
        `;

        chatBox.scrollTop = chatBox.scrollHeight;

    });

    // Typing indicator
    window.showTyping = function(sender){

        if(sender != window.chatUser){
            return;
        }

        const status = document.getElementById('typing-status');

        status.innerHTML = 'Sedang mengetik...';
        status.className = 'text-sm text-blue-600';

        clearTimeout(window.typingTimer);

        window.typingTimer = setTimeout(() => {

            status.innerHTML = '● Online';
            status.className = 'text-sm text-green-600';

        }, 2000);

    };

});
</script>