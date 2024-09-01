<template>

<Breadcrumbs title="Create contract" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard'},{'title': 'contracts', 'name': 'contract.index' } ] }" />

<!-- добавить роут с параметром напр.  :to="{ name: 'customers.show', params: { id: customer.id} } -->
<!-- <Breadcrumbs title="Create contract" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard'},{'title': 'customers', 'name': 'customers.index'},
     {'title': 'customer', 'name': 'customer.show'} ] }" /> -->


    <div class="contanier">
        <div v-if="errors">
            <div v-for="(v, k) in errors" :key="k" class="bg-red-400 text-white rounded font-bold mb-2 shadow-lg py-2 px-4 pr-0">
                <p v-for="error in v" :key="error" class="text-sm">
                    {{ error }}
                </p>
            </div>
        </div>
    </div>

    <form class="show_form space-y-6 rounded-md shadow-md mt_2 p" v-on:submit.prevent="saveContract">

        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-red-900">Create Contract</h2>

            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-2 sm:col-start-1">
                    <label for="city" class="block text-sm font-medium leading-6 text-gray-900">Created</label>
                    <div class="mt-2">
                        <span class="text-sm text-gray-900">{{ formatDate(contract.created_at) }}</span>
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="region" class="block text-sm font-medium leading-6 text-gray-900">Updated</label>
                    <div class="mt-2">
                        <span class="text-sm text-gray-900">{{ formatDate(contract.updated_at) }}</span>
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="user_id" class="block text-sm font-medium leading-6 text-gray-900">Manager</label>
                    <div class="mt-2">
                        <span class="text-sm text-gray-900">{{ user.name }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">

                        <label for="customer" class="block text-sm font-medium leading-6 text-gray-900">Customer</label>
                        <div class="mt-2">
                        <span id="customer"  class="text-sm text-gray-900">{{ customer.name }}</span>
                    </div>
                    <input type="hidden" v-model="form.customer_id" />
                </div>
                <div class="sm:col-span-3">

                        <label for="contract_type" class="block text-sm font-medium text-gray-700">Contract type</label>
                        <div class="mt-2">
                        <select name="contract_type" v-model="form.contract_type_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option v-for="contract_type in contract_types" :key="contract_type.id" :value="contract_type.id">
                            {{ contract_type.title }}
                            </option>
                    </select>
                    </div>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <!-- code -->
                <div class="sm:col-span-2">

                        <label for="code" class="block text-sm font-medium leading-6 text-gray-900">Code</label>
                    <div class="mt-2">
                        <input type="text" name="title" id="code"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                v-model="form.code">
                    </div>

                </div>

                <!-- summ -->
                <div class="sm:col-span-1">
                    <label for="summ" class="block text-sm font-medium text-gray-700">Summ</label>
                    <div class="mt-2">
                        <input type="number" name="summ" id="summ"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            v-model="form.summ">

                    </div>
                </div>
                <!-- status -->
                <div class="sm:col-span-2">
                    <label for="contract_status" class="block text-sm font-medium text-gray-700">Contract status</label>
                    <div class="mt-2">
                        <select name="contract_status_id" v-model="form.contract_status_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option v-for="contract_status in contract_statuses" :key="contract_status.id" :value="contract_status.id">
                            {{ contract_status.name }}
                            </option>
                        </select>
                    </div>

                </div>
                <!-- active -->
                <div class="sm:col-span-1">
                    <label for="is_active" class="block text-sm font-medium text-gray-700">Active</label>
                    <div class="mt-2">
                        <select name="is_active" v-model="form.is_active" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option value="0">-- Inactive --</option>
                            <option value="1">-- Active --</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="col-span-full">
                <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Contract title</label>
                <div class="mt-2">
                    <input type="text" v-model="form.title" name="title" id="title" autocomplete="title" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>


            </div>


            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="col-span-full ">
                <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Comment</label>
                    <div class="mt-2">
                        <textarea id="comment" name="comment" rows="4" v-model="form.comment" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                    </div>
                </div>
            </div>



        </div>
         <div class="mt-6 flex items-center justify-end gap-x-6">
            <!-- <router-link
                    class="text-sm font-semibold leading-6 text-gray-900"
                    :to="{ name: 'contract.index' }">
                    Contracts
            </router-link> -->
            <!-- <router-link
                class="text-sm font-semibold leading-6 text-gray-900"
                :to="{ name: 'customers.show', params: {id: contract.customer_id} }">
                Customer
            </router-link> -->


            <router-link
                    class="text-sm font-semibold leading-6 text-gray-900"
                    :to="{ name: 'customers.show', params: { id: props.customer_id} }">
                    Back
                </router-link>
                <button
                    type="submit"
                    class="rounded-md bg-blue-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Save
                </button>
            <!-- <button type="submit" class="rounded-md bg-blue-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button> -->
        </div>
    </form>



</template>
<script setup>

import { onMounted } from 'vue'
import {reactive} from 'vue';
import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';
import { formatBoolean,formatDate } from '@/helpers/functions'
import useContracts from '@/composables/contracts/contracts.js'
import useCustomers from '@/composables/customers/customers.js'
import useContractTypes from '@/composables/parameters/contract_types.js'
import useContractStatuses from '@/composables/parameters/contract_statuses.js'
import useUsers from '@/composables/users'



const props = defineProps({
    customer_id: {
        required: true,
        type: String
    },
    user_id:  {
        required: true,
        type: String
    },
});

const {customer, getCustomer} = useCustomers();

const {errors,contract, storeContract} = useContracts();

const {
    users,
    user,
    getUsers,
    getUser
    } = useUsers();

const {
    contract_statuses,
    contract_status,
    getContractStatuses,
    getContractStatus} = useContractStatuses();

const {
    contract_types,
    contract_type,
    getContractTypes,
    getContractType } = useContractTypes();


const form = reactive({
    'user_id': props.user_id,
    'customer_id': props.customer_id,
    'contract_type_id': '',
    'contract_status_id': '',
    'code': '',
    'title': '',
    'comment': '',
    'summ': '',
    'is_active': '',
})

onMounted( async () => {
        await getCustomer(props.customer_id);
//        form.customer_id = customer.value.id;
        await getContractTypes();
        await getContractStatuses();
        await getUsers();
        await getUser(1);
});

const saveContract = async () => {
    await storeContract({...form});
}



</script>
