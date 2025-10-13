import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/frontend/main.jsx'],
            refresh: true,
        }),
        react({
            jsxRuntime: 'automatic',
            babel: {
                plugins: [],
            },
        }),
    ],
    server: {
        host: 'localhost',
        port: 5173,
    },
    esbuild: {
        loader: 'jsx',
        include: /resources\/frontend\/.*\.jsx?$/,
        exclude: [],
    },
    optimizeDeps: {
        esbuildOptions: {
            loader: {
                '.js': 'jsx',
            },
        },
    },
});
