import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tsConfigPaths from 'vite-tsconfig-paths';

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost'
        }
    },
    plugins: [
        laravel({
            input: ['resources/ts/main.ts', 'resources/ts/index.tsx', 'resources/css/tailwind.css'],
            refresh: true
        }),
        react({
            fastRefresh: true,
            include: 'resources/ts/index.tsx'
        }),
        tsConfigPaths()
    ]
});
