import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
 
  // ▸ Plugins -----------------------------------------------------------------
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
    host: true, // escuche en 0.0.0.0 (todas las interfaces)
    port: 5173, // puedes cambiar si quiere,
    hmr:{
        host: '192.168.0.107',
    },
    }
});

