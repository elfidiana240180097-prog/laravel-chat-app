import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws','wss'],
});

// =======================
// CHAT PERSONAL
// =======================
window.startChatListener = function(onMessage){

    window.Echo.private(`chat.${window.currentUser}`)

    .listen('.message.sent',(e)=>{
        onMessage(e.message);
    })

    .listen('.user.typing',(e)=>{

        if(window.showTyping){
            window.showTyping(e.sender_id);
        }

    });

}

// =======================
// CHAT GROUP
// =======================
window.startGroupListener = function(onMessage){

    window.Echo.private(`group.${window.currentGroup}`)

    .listen('.group.message.sent',(e)=>{

        onMessage(e.message);

    });

}