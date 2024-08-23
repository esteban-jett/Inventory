import { createRouter, createWebHistory } from 'vue-router';
import Inventory from './Pages/Inventory.vue';

const routes = [
    {
        path: '/inventory',
        name: 'Inventory',
        component: Inventory,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
