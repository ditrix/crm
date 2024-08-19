<template>
    <div class="breadcrump">
        <router-link
            class="items-center px-2 py-2 text-xs font-semibold"
            :to="{ name: 'page.dashboard' }">
            Home
        </router-link>|
        <router-link
            class="items-center px-2 py-2 text-xs font-semibold"
            :to="{ name: 'contract.index' }">
            contracts
        </router-link>|
        <span class="text-xs px-2 py-2 font-semibold">Contract</span>
    </div>
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

            <div class="d-flex">
                <div class="form-item">
                    <label for="customer" class="block text-sm font-medium text-gray-700">Contract type</label>
                    <div class="mt-1">
                        <span id="customer"><b>{{ contract.type }}</b></span>
                    </div>
                </div>

                <div class="form-item ml-10">
                    <label for="customer" class="block text-sm font-medium text-gray-700">Customer</label>
                    <div class="mt-1">
                        <span id="customer"><b>{{ contract.customer }}</b></span>
                    </div>
                </div>
            </div>


        </div>
        <div class="form-item d-flex justify_content_right align-items_center">
            <!-- <label for="user_id" class="block text-sm font-medium text-gray-700 mr-4 pt-1">Manager</label>
                <select name="user_id" v-model="customer.user_id" class="short_select_widget px-4 py-3 rounded-full widget_20">
                    <option v-for="user in customer.users" :key="user.id" :value="user.id">
                    {{ user.name }}
                </option>
                </select> -->
        </div>
        <div class="form-input_group_inline d-flex justify-between">

            <!-- code -->
            <div class="form-item">
                <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                <div class="mt-1">
                    <input type="text" name="title" id="code"
                            class="block w_10 mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="contract.code">
                </div>
            </div>

            <!-- title -->
            <div class="form-item">
                <label for="title" class="block text-sm font-medium text-gray-700">Contract</label>
                <div class="mt-1">
                    <input type="text" name="title" id="title"
                            class="block w_30 mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="contract.title">
                </div>
            </div>

            <!-- active -->
            <div class="form-item ">
                <label for="is_active" class="block text-sm font-medium text-gray-700">Active</label>
                <div class="mt-1">
                    <select class="short_select_widget px-4 py-3 rounded-full w_10" name="is_active" v-model="contract.is_active">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>

            <div class="form-item">
                <label for="contract_status_id" class="d-bock text-sm font-medium text-gray-700 mr-4 pt-1">Status</label>
                <div class="mt-1 d-bock">
                    <select name="contract_status_id" v-model="contract.contract_status_id" class="short_select_widget px-4 py-3 rounded-full w_10">
                        <option v-for="contract_status in contract.statuses" :key="contract_status.id" :value="contract_status.id">
                        {{ contract_status.name }}
                    </option>
                    </select>
                </div>
            </div>

        </div>
        <div class="form-item">
            <label for="summ" class="block text-sm font-medium text-gray-700">Summ</label>
            <div class="mt-1">
                <input type="number" name="summ" id="summ"
                        class="block w_10 mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="contract.summ">
            </div>
        </div>

        <div class="form-controll">
            <button
                type="submit"
                class="btn btn_blue  inline-flex items-center mr_1  pl_1 pr_1 font-semiboldtext-sm font-medium mt_2">
                Save
            </button>

            <router-link
                class="btn btn_lightgray  inline-flex items-center mr_1  pl_1 pr_1 font-semiboldtext-sm font-medium mt_2"
                :to="{ name: 'contract.index' }">
                Back
            </router-link>
        </div>
    </form>


</template>
<script setup>
import { onMounted } from 'vue'
import useContracts from '@/composables/contracts/contracts.js'
import { formatBoolean,formatDate } from '@/helpers/functions'

const {
    contract,
    getContract,
    updateContract,
} = useContracts();

const props = defineProps({
    id: {
        required: true,
        type: String
    }
});

const saveContract = async () => {
    await updateContract(props.id)
}

onMounted( () => getContract(props.id) );
</script>
