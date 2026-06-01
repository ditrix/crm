import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;

Alpine.data('crmTable', () => ({
    search: '',
    sortField: '',
    sortDir: 'asc',
    visibleCount: -1,

    init() {
        this.visibleCount = this.$refs.tbody
            ? this.$refs.tbody.querySelectorAll('tr[data-search]').length
            : 0;
        this.$watch('search', () => this.filterRows());
    },

    filterRows() {
        const q = this.search.toLowerCase().trim();
        const rows = this.$refs.tbody
            ? this.$refs.tbody.querySelectorAll('tr[data-search]')
            : [];
        let visible = 0;
        rows.forEach(row => {
            const show = !q || row.dataset.search.includes(q);
            row.style.display = show ? '' : 'none';
            if (show) { visible++; }
        });
        this.visibleCount = visible;
    },

    sort(field) {
        if (this.sortField === field) {
            this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortField = field;
            this.sortDir = 'asc';
        }
        this.applySort();
    },

    applySort() {
        if (!this.sortField || !this.$refs.tbody) { return; }
        const tbody = this.$refs.tbody;
        const rows = Array.from(tbody.querySelectorAll('tr[data-search]'));
        rows.sort((a, b) => {
            const va = (a.dataset[this.sortField] || '').toLowerCase();
            const vb = (b.dataset[this.sortField] || '').toLowerCase();
            const cmp = va.localeCompare(vb, undefined, { numeric: true });
            return this.sortDir === 'asc' ? cmp : -cmp;
        });
        rows.forEach(row => tbody.appendChild(row));
        this.filterRows();
    },

    toggleArchive() {
        const url = new URL(window.location.href);
        if (url.searchParams.has('archived')) {
            url.searchParams.delete('archived');
        } else {
            url.searchParams.set('archived', '1');
        }
        url.searchParams.delete('page');
        window.location.href = url.toString();
    },

    updateFilter(key, value) {
        const url = new URL(window.location.href);
        if (value) {
            url.searchParams.set(key, value);
        } else {
            url.searchParams.delete(key);
        }
        url.searchParams.delete('page');
        window.location.href = url.toString();
    },
}));

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
