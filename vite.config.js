import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    hmr: {
            host: '0.0.0.0',   // ip 
            port: 5173,
            protocol: 'ws'         // WebSocket para HMR
        },
});
