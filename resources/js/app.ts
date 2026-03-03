import { createInertiaApp } from '@inertiajs/vue3';
import Aura from '@primeuix/themes/aura';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import PrimeVue from 'primevue/config';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import '../scss/app.scss';
import { definePreset } from '@primevue/themes';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

export const BootstrapTheme = definePreset(Aura, {
    semantic: {
        primary: {
            50: '#e7f1ff',
            100: '#cfe2ff',
            200: '#9ec5fe',
            300: '#6ea8fe',
            400: '#3d8bfd',
            500: '#0d6efd',
            600: '#0b5ed7',
            700: '#0a58ca',
            800: '#084298',
            900: '#052c65',
        },
    },
});

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, {
                theme: {
                    preset: BootstrapTheme,
                    options: {
                        darkModeSelector: '',
                    },
                },
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
