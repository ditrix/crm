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

            <div class="form-input_group_inline d-flex justify-between">

                <!-- customer -->
                <div class="form-item">
                    <label for="customer" class="block text-sm font-medium text-gray-700">Customer</label>
                    <div class="mt-1">
                        <span id="customer"><b>{{ customer.name }}</b></span>
                    </div>
                    <input type="hidden" v-model="form.customer_id" />
                </div>

                <!-- contract type  -->
                <div class="form-item">
                    <label for="contract_type" class="block text-sm font-medium text-gray-700">Contract type</label>
                    <select name="contract_type" v-model="form.contract_type_id" class="short_select_widget px-4 py-3 rounded-full w_10">
                        <option v-for="contract_type in contract_types" :key="contract_type.id" :value="contract_type.id">
                        {{ contract_type.title }}
                        </option>
                    </select>
                </div>

<!-- manager  -->
                <div class="form-item">
                    <label for="created_at" class="block text-sm font-medium text-gray-700 mr-4 pt-1">Created at</label>
                    <span>{{ formatDate(contract.created_at) }}</span>
                </div>

                <div class="form-item">
                    <label for="updated_at" class="block text-sm font-medium text-gray-700 mr-4 pt-1">Updated at</label>
                    <span>{{ formatDate(contract.updated_at) }}</span>
                </div>

                <!-- manager  -->
                <div class="form-item">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mr-4 pt-1">Manager</label>
                    <span>{{ user.name }}</span>
                </div>
            </div>
            <div class="form-input_group_inline d-flex justify-between">
                <!-- contract status  -->
                <div class="form-item">
                    <label for="contract_status" class="block text-sm font-medium text-gray-700">Contract status</label>
                    <select name="contract_status_id" v-model="form.contract_status_id" class="short_select_widget px-4 py-3 rounded-full w_10">
                        <option v-for="contract_status in contract_statuses" :key="contract_status.id" :value="contract_status.id">
                        {{ contract_status.name }}
                        </option>
                    </select>
                </div>



            </div>



            <div class="form-input_group_inline d-flex justify-between">
                <!-- code  -->
                <div class="form-item">
                    <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                    <div class="mt-1">
                        <input type="text" name="title" id="code"
                                class="block w_10 mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.code">
                    </div>
                </div>

                <!-- title -->
                <div class="form-item">
                        <label for="title" class="block text-sm font-medium text-gray-700">Contract</label>
                        <div class="mt-1">
                            <input type="text" name="title" id="title"
                                    class="block w_30 mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="form.title">
                        </div>
                </div>
                <!-- active -->
                <div class="form-item ">
                    <label for="is_active" class="block text-sm font-medium text-gray-700">Active</label>
                    <div class="mt-1">
                        <select class="short_select_widget px-4 py-3 rounded-full w_10" name="is_active" v-model="form.is_active">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <!-- summ  -->
                <div class="form-item">
                    <label for="summ" class="block text-sm font-medium text-gray-700">Summ</label>
                    <div class="mt-1">
                        <input type="number" name="summ" id="summ"
                            class="block w_10 mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.summ">
                    </div>
                </div>

            </div>



            <!-- controls -->

            <div class="form-controll">
                <button
                    type="submit"
                    class="btn btn_blue  inline-flex items-center mr_1  pl_1 pr_1 font-semiboldtext-sm font-medium mt_2">
                    Save
                </button>

                <router-link
                    class="btn btn_lightgray inline-flex items-center px-4 py-2 text-xs font-semibold"
                    :to="{ name: 'customers.show', params: { id: props.customer_id} }">
                    Back
                </router-link>

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
