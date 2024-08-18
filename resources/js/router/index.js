import { createRouter, createWebHistory } from 'vue-router'

import Home from '@/Pages/Home.vue'
import Dashboard from '@/Pages/Dashboard.vue'
import Customers from '@/Pages/Customers.vue'
import Deals from '@/Pages/Deals.vue'
import Options from '@/Pages/Options.vue'
import Parameters from '@/Pages/Parameters.vue'
import Reports from '@/Pages/Reports.vue'
import Contracts from '@/Pages/Contracts.vue'

/* provide permissions for admin, top manager, manager */
import Permissions from '@/Pages/Permissions.vue'
import PermissionsShow from '@/Components/Permissions/PermissionsShow.vue'



/* provide users wth permissions */
import Users from '@/Pages/Users.vue'
import UsersShow from '@/Components/Users/UsersShow.vue'
import UsersCreate from '@/Components/Users/UsersCreate.vue'

/* status patameters */
import ContractStatusIndex from '@/Components/Parameters/ContractStatusIndex.vue'
import ContractStatusShow from '@/Components/Parameters/ContractStatusShow.vue'
import ContractStatusCreate from '@/Components/Parameters/ContractStatusCreate.vue'

/* contract's types*/
import ContractTypeIndex from '@/Components/Parameters/ContractTypeIndex.vue'
import ContractTypeShow from '@/Components/Parameters/ContractTypeShow.vue'
import ContractTypeCreate from '@/Components/Parameters/ContractTypeCreate.vue'


import Login from '../Pages/Auth/Login.vue'
// import Register from '../Pages/Auth/Register.vue'
// import Dashboard from '../Pages/Dashboard.vue'
import { useAuthStore } from '../Stores/AuthStore'

import CustomersIndex from '@/Components/Customers/CustomersIndex.vue'
import CustomersCreate from '@/Components/Customers/CustomersCreate.vue'
import CustomersShow from '@/Components/Customers/CustomersShow.vue'

import ContractIndex from '@/Components/Contract/ContractIndex.vue'
import ContractCreate from '@/Components/Contract/ContractCreate.vue'
import ContractShow from '@/Components/Contract/ContractShow.vue'





const routes = [
    { path: '/', component: Home, name: 'page.home' },
    // { path: '/dashboard', component: Dashboard, name: 'page.dasboard' },
    { path: '/dashboard',
        component: Dashboard,
        name: 'page.dashboard',
        props: route => ({ user: useAuthStore().user }),
    },
    { path: '/contracts', component: Contracts, name: 'contracts.page' },
    { path: '/customers', component: Customers, name: 'custmomers.page' },
    { path: '/deals', component: Deals },
    { path: '/reports', component: Reports },

    { path: '/login', component: Login, name: 'login' },


    { path: '/contracts', component: Contracts },


    {
        path: '/permissions',
        component: Permissions,
        name: 'permissions.index'
    },
    {
        path: '/permissions/:id/show',
        name: 'permissions.show',
        component: PermissionsShow,
        props: true,
    },

    { path: '/parameters',
        component: Parameters,
        name: 'parameters.index'
    },
    {
        path: '/contract_statuses',
        component: ContractStatusIndex,
        name: 'contract_statuses.index'
    },
    {
        path: '/contract_statuses/:id/show',
        component: ContractStatusShow,
        name: 'contract_statuses.show',
        props: true,
    },
    {
        path: '/contract_statuses/create',
        component: ContractStatusCreate,
        name: 'contract_statuses.create'
    },
    {
        path: '/contract_types',
        component: ContractTypeIndex,
        name: 'contract_types.index'
    },
    {
        path: '/contract_types/:id/show',
        component: ContractTypeShow,
        name: 'contract_types.show',
        props: true,
    },
    {
        path: '/contract_types/create',
        component: ContractTypeCreate,
        name: 'contract_types.create'
    },
    {
        path: '/users',
        component: Users,
        name: 'users.index'
    },
    {
        path: '/users/:id/show',
        component: UsersShow,
        name: 'users.show',
        props: true,
    },
    {
        path: '/users/create',
        component: UsersCreate,
        name: 'users.store',
    },

    {
        path: '/customers/index',
        component: CustomersIndex,
        name: 'customers.index'
    },

    {
        path: '/customers/:id/show',
        component: CustomersShow,
        name: 'customers.show',
        props: true,
    },
    {
        path: '/customers/create',
        component: CustomersCreate,
        name: 'customers.store',
    },
    { path: '/options', component: Options },
    {
        path: '/contracts/index',
        component: ContractIndex,
        name: 'contract.index'
    },
    {
        path: '/contract/:id/show',
        component: ContractShow,
        name: 'contract.show',
        props: true,
    },
    {
        path: '/contract/create',
        component: ContractCreate,
        name: 'contract.store',
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
    })


router.beforeEach((to, from, next) => {
const authStore = useAuthStore();
if (to.name !== 'login' && !authStore.isAuthenticated) {
    next({ name: 'login' });
} else {
    next();
}
});


export default router
