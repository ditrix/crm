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
            <!-- <th class="border border-gray-300 px-1" >ID</th> -->
            <th class="border border-gray-300 px-1">status</th>
            <th class="border border-gray-300 px-1">Name</th>
            <th class="border border-gray-300 px-1">Email</th>
            <th class="border border-gray-300 px-1">Phone</th>
            <th class="border border-gray-300 px-1">Legal</th>
            <th class="border border-gray-300 px-1">Active</th>
            <th class="border border-gray-300 px-1">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="customer in customers" :key="customer.id" class="greed_tr">
            <!-- <td class="border border-gray-300 px-1">{{customer.id}}</td> -->
            <td class="border border-gray-300 px-1">{{customer.status_name}}</td>
            <td class="border border-gray-300 px-1">{{ customer.name }}</td>
            <td class="border border-gray-300 px-1">{{ customer.email }}</td>
            <td class="border border-gray-300 px-1">{{ customer.phone }}</td>
            <td class="border border-gray-300 px-1 tx_center">{{ formatBoolean(customer.is_legal) }}</td>
            <td class="border border-gray-300 px-1 tx_center">{{ formatBoolean(customer.is_active) }}</td>
            <td class="border border-gray-300 px-1">
                <router-link
                    class="btn btn_lightgray inline-flex items-center px-2 py-1 text-xs font-semibold"
                    :to="{ name: 'customers.show', params: { id: customer.id} }"
                    title="edit record"
                    >
                    V
                </router-link>
                <button
                    class="btn btn_red inline-flex items-center ml-1 px-2 py-1 text-xs font-semiboldtext-sm font-medium"
                    title="delete row"
                    @click="deleteCustomer(customer.id)" >
                    X
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
            <td class="tx_center">{{ formatBoolean(customer.is_legal) }}</td>
            <td class="tx_center">{{ formatBoolean(customer.is_active) }}</td>
            <td class="tx_center">
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
