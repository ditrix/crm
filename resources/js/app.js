import './bootstrap';
import '../css/app.css';

// import { createApp, h } from 'vue';
// import { createInertiaApp } from '@inertiajs/vue3';
// import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
// import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
//     setup({ el, App, props, plugin }) {
//         return createApp({ render: () => h(App, props) })
//             .use(plugin)
//             .use(ZiggyVue)
//             .mount(el);
//     },
//     progress: {
//         color: '#4B5563',
//     },
// });
import { createPinia } from 'pinia'
import { useAuthStore } from './Stores/AuthStore'
import { createApp } from 'vue'
import App from './Components/App.vue'
import router from './router'

const app = createApp(App)
const pinia = createPinia()


app.use(router)
app.use(pinia)

// createApp(App).use(router).mount('#app')


const authStore = useAuthStore()

authStore.checkAuth();
//authStore.checkAuth().then(() => {
  app.mount('#app')
//})


//createApp(App).use(router).mount('#app')


