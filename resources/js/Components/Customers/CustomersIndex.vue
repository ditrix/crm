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
                    <LabelEdit />
                </router-link>
                <button
                    class="btn rounded-sm bg-red-400 inline-flex items-center ml-1 px-2 py-1 text-xs font-semiboldtext-sm font-medium"
                    title="delete row"
                    @click="deleteCustomer(customer.id)" >
                    <LabelDelete/>
                </button>
            </td>
        </tr>
    </tbody>
</table>
    <!-- Pagination -->
    <ul class="flex row pagination-list mt-4">
            <li type="button"
            class="min-h-[38px] min-w-[38px] flex justify-center items-center border border-gray-200 text-gray-800  py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                v-for="link in pagination.links" :key="link.id" :class="{active: link.active, disabled: !link.url}" >
                <a v-html="link.label"
                    @click="getPaginateData(link.url)"
                >
                </a>
            </li>
    </ul>
</template>
<script setup>
import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';
import { onMounted } from 'vue'

import useCustomers from '@/composables/customers/customers.js'
import { formatBoolean } from '@/helpers/functions'

import LabelDelete from '@/Components/Controls/images/LabelDelete.vue';
import LabelEdit from '@/Components/Controls/images/LabelEdit.vue';

const {
    customers,
    pagination,
    getCustomers,
    destroyCustomer,
    getPaginateData,
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
