import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '127.0.0.1',
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/animate.css',
                'resources/css/flatpickr.min.css',
                'resources/css/nice-select.css',
                'resources/css/select2.css',
                'resources/css/font-awesome.min.css',
                'resources/css/noui-slider.css',
                'resources/css/simple-datatables.css',
                'resources/css/dragndrop.css',
                'resources/css/fullcalendar.css',
                'resources/css/nouislider.min.css',
                'resources/css/sweetalert.css',
                'resources/css/easymde.min.css',
                'resources/css/fullcalendar.min.css',
                'resources/css/perfect-scrollbar.min.css',
                'resources/css/swiper-bundle.min.css',
                'resources/css/fancybox.css',
                'resources/css/highlight.min.css',
                'resources/css/quill-editor.css',
                'resources/css/swiper.css',
                'resources/css/file-upload-preview.css',
                'resources/css/markdown-editor.css',
                'resources/css/quill.snow.css',
                'resources/css/tippy.css',
                'resources/css/flatpickr.css',
                'resources/css/nice-select2.css',
                'resources/css/scrumboard.css',
            ],
            refresh: true,
        }),
    ],
});
