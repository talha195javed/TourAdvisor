import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/frontend/main.jsx'],
            refresh: true,
        }),
    ],
    esbuild: {
        loader: 'jsx',
        include: /resources\/frontend\/.*\.jsx?$/,
        exclude: [],
    },
    optimizeDeps: {
        esbuildOptions: {
            loader: {
                '.js': 'jsx',
                '.jsx': 'jsx',
            },
        },
    },
    resolve: {
        extensions: ['.js', '.jsx', '.json'],
    },
});
