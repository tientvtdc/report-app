import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                'resources/js/app.js',
                'resources/js/add-standard.js',
                'resources/js/add-evidence.js',
                'resources/js/download-pdf.js',
                'resources/js/load-more-activity.js',
            ],
            refresh: true,
        }),
    ],
});
