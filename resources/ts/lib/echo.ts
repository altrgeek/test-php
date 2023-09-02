import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// eslint-disable-next-line no-underscore-dangle
if (!window.__cogni.__extra || !window.__cogni.__extra.initializeEcho) {
    window.Pusher = Pusher;

    const ECHO_TLS = (window.VITE_PUSHER_SCHEME ?? 'https') === 'https';

    /**
     * Echo exposes an expressive API for subscribing to channels and listening
     * for events that are broadcast by Laravel. Echo and event broadcasting
     * allows your team to easily build robust real-time web applications.
     */
    window.Echo = new Echo({
        broadcaster: 'pusher',
        host: window.VITE_PUSHER_HOST || window.location.hostname,
        key: window.VITE_PUSHER_APP_KEY,
        authorizer: (channel: { name: string }) => {
            return {
                // eslint-disable-next-line @typescript-eslint/ban-types
                authorize: (socketId: string, callback: Function) => {
                    sanctum('/api/broadcasting/auth', {
                        method: 'post',
                        baseURL: '/',
                        data: {
                            socket_id: socketId,
                            channel_name: channel.name
                        }
                    })
                        .then((response) => {
                            callback(null, response.data);
                        })
                        .catch((error) => {
                            callback(true, error);
                        });
                }
            };
        },
        wsHost: window.VITE_PUSHER_HOST || window.location.hostname,
        wsPort: window.VITE_PUSHER_PORT ?? 80,
        wssPort: window.VITE_PUSHER_PORT ?? 443,
        forceTLS: ECHO_TLS,
        enabledTransports: ECHO_TLS ? ['ws', 'wss'] : ['ws'],
        disableStats: true
    });
}

export default window.Echo;
