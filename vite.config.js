import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'sass/app.scss', // <--- Cambia esto para decirle que está en la raíz, no en resources
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});