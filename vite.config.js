import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js'
            ],
            refresh: true,
            // Dile a Vite cuál es tu nueva carpeta pública
            publicDirectory: 'public_html', 
        }),
    ],
    build: {
        // Dile a Vite dónde guardar los assets compilados
        outDir: 'public_html/build', 
        emptyOutDir: true,
    }
});