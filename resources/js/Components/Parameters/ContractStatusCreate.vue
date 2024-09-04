<template>

    <Breadcrumbs title="Create status" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard'},{'title': 'parameters and options', 'name': 'parameters.index' } ] }" />
     <!-- show errors block  -->
     <div v-if="errors">
        <div v-for="(v, k) in errors" :key="k" class="bg-red-400 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
            <p v-for="error in v" :key="error" class="text-sm">
                {{ error }}
            </p>
        </div>
    </div>

    <form class="show_form space-y-6 rounded-md shadow-md mt_2 p" v-on:submit.prevent="createContractStatus">

        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-red-900">Create contract status</h2>
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                    <div class="mt-2">
                        <input type="text" name="name" id="name" autocomplete="address-level2"
                        v-model="form.name"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>

                </div>
                <div class="sm:col-span-4">
                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                    <div class="mt-2">
                        <input type="text" name="description" id="description" autocomplete="address-level2"
                                v-model="form.description"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
            </div>
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <label for="is_active" class="block text-sm font-medium leading-6 text-gray-900">Active</label>
                    <div class="mt-1">
                        <select name="is_active" id="is_active" v-model="form.is_active"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option value="1">-- Active --</option>
                            <option value="0">-- Inactive --</option>
                        </select>
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="order_condition" class="block text-sm font-medium leading-6 text-gray-900">Order position</label>
                    <div class="mt-2">
                        <input type="number" name="order_condition" id="order_condition" autocomplete="address-level2"
                        v-model="form.order_condition"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="page_title text-xl mb-2">Contract status</div> -->

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <router-link
                    class="text-sm font-semibold leading-6 text-gray-900"
                    :to="{ name: 'parameters.index' }">
                    Back
            </router-link>
            <button type="submit" class="rounded-md bg-blue-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
        </div>
    </form>

</template>
<script setup>

import { reactive } from 'vue'
import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';

import useContractStatuses from '@/composables/parameters/contract_statuses'

const {errors, storeContractStatus} = useContractStatuses();

const form = reactive({
    'name': '',
    'description': '',
    'is_active': '',
    'order_condition': '',
})

const createContractStatus = async () => {
    await storeContractStatus({...form})
}


</script>
