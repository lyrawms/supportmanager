import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy';
import {renderApp} from '@inertiaui/modal-vue'
import momentPlugin from "./plugins/moment";
import Vue3ColorPicker from "vue3-colorpicker";
import "vue3-colorpicker/style.css";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    setup({el, App, props, plugin}) {
        return createApp({render: renderApp(App, props)})
            .use(plugin)
            .use(momentPlugin)
            .use(Vue3ColorPicker)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
    resolve: async (name) => {
        const [domain, ...page] = name.split('/');
        const pagePath = page.join('/');

        try {
            // Try to resolve from domain-specific folders
            return await resolvePageComponent(
                `../../app/Domains/${domain}/Views/${pagePath}.vue`,
                import.meta.glob('../../app/Domains/**/Views/**/*.vue')
            );
        } catch (e) {
            return await resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob('./Pages/**/*.vue')
            );

        }
    },
});
