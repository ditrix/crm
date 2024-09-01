<template>

    <Breadcrumbs title="Customers" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard' } ] }" />

<div class="d-flex flex-direction_row justify_content_left_space_between align-items_center mb_1">
    <div class="page_title text-xl mb-2 mt-4">Customers</div>
    <div class="d-flex justify_content_right">
        <router-link
            class="btn btn_blue inline-flex items-center px-4 py-2 mr-5 text-xs font-semibold"
            :to="{ name: 'customers.store' }" >
                +Create
        </router-link>
    </div>

</div>

<table class="table-auto border-collapse border text-xs width-100">
    <thead>
        <tr class="backdrop-filter backdrop-grayscale">
            <th class="border border-gray-300 px-1" >ID</th>
            <th class="border border-gray-300 px-1">status</th>
            <th class="border border-gray-300 px-1">Name</th>
            <th class="border border-gray-300 px-1">Email</th>
            <th class="border border-gray-300 px-1">Phone</th>
            <th class="border border-gray-300 px-1">Active</th>
            <th class="border border-gray-300 px-1">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="customer in customers" :key="customer.id" class="greed_tr">
            <td class="border border-gray-300 px-1">{{customer.id}}</td>
            <td class="border border-gray-300 px-1 text-gray-900">{{customer.status_name}}</td>
            <td class="border border-gray-300 px-1 text-gray-900">{{ customer.name }}</td>
            <td class="border border-gray-300 px-1 text-gray-900">{{ customer.email }}</td>
            <td class="border border-gray-300 px-1 text-gray-900">{{ customer.phone }}</td>
            <td class="border border-gray-300 text-center text-gray-900">{{ formatBoolean(customer.is_active) }}</td>
            <td class="border border-gray-300 text-center text-gray-900">
                <router-link
                    class="btn rounded-sm bg-blue-400  text-white inline-flex items-center px-2 py-1 text-xs hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    :to="{ name: 'customers.show', params: { id: customer.id} }"
                    title="edit record"
                    >
                    <svg fill="#ffffff" height="0.8rem" width="0.8rem" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
	                    viewBox="0 0 348.882 348.882" xml:space="preserve"><g><path d="M333.988,11.758l-0.42-0.383C325.538,4.04,315.129,0,304.258,0c-12.187,0-23.888,5.159-32.104,14.153L116.803,184.231
                                c-1.416,1.55-2.49,3.379-3.154,5.37l-18.267,54.762c-2.112,6.331-1.052,13.333,2.835,18.729c3.918,5.438,10.23,8.685,16.886,8.685
                                c0,0,0.001,0,0.001,0c2.879,0,5.693-0.592,8.362-1.76l52.89-23.138c1.923-0.841,3.648-2.076,5.063-3.626L336.771,73.176
                                C352.937,55.479,351.69,27.929,333.988,11.758z M130.381,234.247l10.719-32.134l0.904-0.99l20.316,18.556l-0.904,0.99
                                L130.381,234.247z M314.621,52.943L182.553,197.53l-20.316-18.556L294.305,34.386c2.583-2.828,6.118-4.386,9.954-4.386
                                c3.365,0,6.588,1.252,9.082,3.53l0.419,0.383C319.244,38.922,319.63,47.459,314.621,52.943z"/>
                            <path d="M303.85,138.388c-8.284,0-15,6.716-15,15v127.347c0,21.034-17.113,38.147-38.147,38.147H68.904
                                c-21.035,0-38.147-17.113-38.147-38.147V100.413c0-21.034,17.113-38.147,38.147-38.147h131.587c8.284,0,15-6.716,15-15
                                s-6.716-15-15-15H68.904c-37.577,0-68.147,30.571-68.147,68.147v180.321c0,37.576,30.571,68.147,68.147,68.147h181.798
                                c37.576,0,68.147-30.571,68.147-68.147V153.388C318.85,145.104,312.134,138.388,303.85,138.388z"/></g>
                    </svg>
                </router-link>
                <button
                    class="btn rounded-sm bg-red-400 inline-flex items-center ml-1 px-2 py-1 text-xs font-semiboldtext-sm font-medium"
                    title="delete row"
                    @click="deleteCustomer(customer.id)" >
                    <svg width="0.8rem" height="0.8rem" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"><path fill="#ffffff" d="M160 256H96a32 32 0 0 1 0-64h256V95.936a32 32 0 0 1 32-32h256a32 32 0 0 1 32 32V192h256a32 32 0 1 1 0 64h-64v672a32 32 0 0 1-32 32H192a32 32 0 0 1-32-32V256zm448-64v-64H416v64h192zM224 896h576V256H224v640zm192-128a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32zm192 0a32 32 0 0 1-32-32V416a32 32 0 0 1 64 0v320a32 32 0 0 1-32 32z"/></svg>
                </button>
            </td>
        </tr>
    </tbody>
</table>
<div>

</div>


    <!-- <div class="content-wrapper" style="width: 100%;"> -->
    <!-- <table class="min-w-full  border divide-y divide-gray-300 grid_table">
    <thead>
        <tr>
            <th class="pl_1">status</th>
            <th class="pl_1">Name</th>
            <th class="pl_1">Email</th>
            <th class="pl_1">Phone</th>
            <th class="pl_1">Legal</th>
            <th class="pl_1">Active</th>

        </tr>
    </thead>
    <tbody>
        <tr v-for="customer in customers" :key="customer.id" class="greed_tr">
            <td class="pl_1">{{customer.status_name}}</td>
            <td class="pl_4">{{ customer.name }}</td>
            <td class="pl_4">{{ customer.email }}</td>
            <td class="pl_4">{{ customer.phone }}</td>
            <td class="text-center">{{ formatBoolean(customer.is_legal) }}</td>
            <td class="text-center">{{ formatBoolean(customer.is_active) }}</td>
            <td class="text-center">
                <router-link
                    class="btn btn_lightgray inline-flex items-center px-4 py-2 text-xs font-semibold"
                    :to="{ name: 'customers.show', params: { id: customer.id} }">
                    Edit
                </router-link>
                <button
                    class="btn btn_red inline-flex items-center ml-1 px-4 py-2 text-xs font-semiboldtext-sm font-medium"
                    @click="deleteCustomer(customer.id)" >
                    X
                </button>
            </td>
        </tr>
    </tbody>
    </table> -->
    <div class="mt-1">
        <ul class="pagination_list d-flex">
            <li class="btn_xs  btn_lightgray ml-1 mr-1 text-xs" v-for="link in pagination.links" :key="link.id" :class="{active: link.active, disabled: !link.url}">
                <a
                    v-html="link.label"
                    @click="getCistomersFromLink(link.url)"
                >
                </a>
            </li>
         </ul>
    </div>
<!-- </div> -->

</template>
<script setup>
import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';
import { onMounted } from 'vue'

import useCustomers from '@/composables/customers/customers.js'
import { formatBoolean } from '@/helpers/functions'

const {
    customers,
    pagination,
    getCustomers,
    destroyCustomer,
    getCistomersFromLink,
} = useCustomers();

const deleteCustomer = async (id) => {

if (!window.confirm('You sure?')) {
    return
}

    await destroyCustomer(id)
    await getCustomers();
}

onMounted(
    () => {
        getCustomers();
        console.log('pagination',pagination.value)
    }
);

</script>
