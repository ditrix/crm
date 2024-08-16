<template>
    <div class="breadcrump">
    <router-link
        class="items-center px-2 py-2 text-xs font-semibold"
        :to="{ name: 'page.dashboard' }">
        Home
    </router-link>|
    <router-link
        class="items-center px-2 py-2 text-xs font-semibold"
        :to="{ name: 'customers.index' }">
        customers
    </router-link>|
        <span class="text-xs px-2 py-2 font-semibold">Customer</span>
        <!-- <div>{{ customer.id }}</div> -->
    </div>

    <div class="contanier">
        <div v-if="errors">
            <div v-for="(v, k) in errors" :key="k" class="bg-red-400 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
                <p v-for="error in v" :key="error" class="text-sm">
                    {{ error }}
                </p>
            </div>
        </div>
    </div>

    <form class="show_form space-y-6 rounded-md shadow-md mt_2 p" v-on:submit.prevent="saveCustomer">

        <!-- common customer data  -->
        <div class="form-block">
            <div class="form-item">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.name">
                </div>
            </div>

            <div class="form-item">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <input type="text" name="email" id="email"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.email">
                </div>
            </div>
            <div class="form-item">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <div class="mt-1">
                    <input type="text" name="phone" id="phone"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.phone">
                </div>
            </div>
            <div class="form-item">
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <div class="mt-1">
                    <input type="text" name="address" id="address"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.address">
                </div>
            </div>
            <div class="form-item">
                <label for="is_legal" class="block text-sm font-medium text-gray-700">Status</label>
                <div class="mt-1">
                    <select class="short_select_widget px-4 py-3 rounded-full" name="is_legal" v-model="form.is_legal">
                        <option value="0">-- Person --</option>
                        <option value="1">-- Legal person --</option>
                    </select>
                </div>
            </div>
            <div class="form-item ">
                <label for="is_active" class="block text-sm font-medium text-gray-700">Avtive</label>
                <div class="mt-1">
                    <select class="short_select_widget px-4 py-3 rounded-full widget_20" name="is_active" v-model="form.is_active">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
        </div>

<!-- legal customer data  -->
        <div v-if="customer.is_legal == 1">
            <div class="form-item">
                <label for="code" class="block text-sm font-medium text-gray-700">VAT code</label>
                <div class="mt-1">
                    <input type="text" name="code" id="code"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.code">
                </div>
            </div>

            <div class="form-item">
                <label for="contact_name" class="block text-sm font-medium text-gray-700">Contact</label>
                <div class="mt-1">
                    <input type="text" name="contact_name" id="contact_name"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.contact_name">
                </div>
            </div>

            <div class="form-item">
                <label for="contact_email" class="block text-sm font-medium text-gray-700">Contact email</label>
                <div class="mt-1">
                    <input type="text" name="contact_email" id="contact_email"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.contact_email">
                </div>
            </div>

            <div class="form-item">
                <label for="contact_phone" class="block text-sm font-medium text-gray-700">Contact phone</label>
                <div class="mt-1">
                    <input type="text" name="contact_phone" id="contact_phone"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.contact_phone">
                </div>
            </div>

        </div>

        <div class="form-controll">
            <button
                type="submit"
                class="btn btn_blue inline-flex items-center ml-1  font-semiboldtext-sm font-medium mt_2">
                Save
            </button>

            <router-link
                class="btn btn_lightgray ml-2 inline-flex items-center  font-semibold ml_2"
                :to="{ name: 'customers.index' }">
                Cancel
            </router-link>
        </div>
    </form>

</template>
<script setup>
import useCustomers from '@/composables/customers/customers';

import {reactive} from 'vue';

const { storeCustomer, customer} = useCustomers();

const form = reactive({
    'name': '',
    'email': '',
    'phone': '',
    'address': '',
    'is_legal': '',
    'code': '',
    'contact_name': '',
    'contact_email': '',
    'contact_phone': '',
});

const saveCustomer = async () => {
    await storeCustomer({ ...form });

}

</script>
