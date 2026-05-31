import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { createApp } from 'vue';
import SalesFunnel from './components/SalesFunnel.vue';

// Mount Vue components on elements with data-vue attribute
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-vue="sales-funnel"]').forEach(el => {
        const stages   = JSON.parse(el.dataset.stages || '[]');
        const darkMode = document.documentElement.classList.contains('dark');

        createApp(SalesFunnel, { stages, darkMode }).mount(el);
    });
});
