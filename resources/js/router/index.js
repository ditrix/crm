import { createRouter, createWebHistory } from 'vue-router'

import Home from '@/Pages/Home.vue'
import Dashboard from '@/Pages/Dashboard.vue'
import Customers from '@/Pages/Customers.vue'
import Deals from '@/Pages/Deals.vue'
import Options from '@/Pages/Options.vue'
import Parameters from '@/Pages/Parameters.vue'
import Reports from '@/Pages/Reports.vue'

/* provide permissions for admin, top manager, manager */
import Permissions from '@/Pages/Permissions.vue'
import PermissionsShow from '@/Components/Permissions/PermissionsShow.vue'

/* provide users wth permissions */
import Users from '@/Pages/Users.vue'
import UsersShow from '@/Components/Users/UsersShow.vue'
import UsersCreate from '@/Components/Users/UsersCreate.vue'

/* status patameters */
import StatusParametersIndex from '@/Components/Parameters/StatusParametersIndex.vue'
import StatusParameterShow from '@/Components/Parameters/StatusParameterShow.vue'
import StatusParameterCreate from '@/Components/Parameters/StatusParameterCreate.vue'

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


const routes = [
    { path: '/', component: Home, name: 'page.home' },
    // { path: '/dashboard', component: Dashboard, name: 'page.dasboard' },
    { path: '/dashboard',
        component: Dashboard,
        name: 'page.dashboard',
        props: route => ({ user: useAuthStore().user }),
    },
    { path: '/customers', component: Customers, name: 'custmomers.page' },
    { path: '/deals', component: Deals },
    { path: '/reports', component: Reports },

    { path: '/login', component: Login, name: 'login' },


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
        path: '/status_parameters',
        component: StatusParametersIndex,
        name: 'status_parameters.index'
    },
    {
        path: '/status_parameters/:id/show',
        component: StatusParameterShow,
        name: 'status_parameters.show',
        props: true,
    },
    {
        path: '/status_parameters/create',
        component: StatusParameterCreate,
        name: 'status_parameters.create'
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
        path: '/customers',
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
