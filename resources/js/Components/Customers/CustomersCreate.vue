<template>

    <Breadcrumbs title="Create customer" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard'},{'title': 'customers', 'name': 'customers.index' } ] }" />

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

        <div class="page_title text-xl mb-2">Create customer</div>

        <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4 sm:col-start-1"></div>
            <div class="sm:col-span-2">
                <label for="user_id" class="block text-sm font-medium leading-6 text-gray-900">Manager</label>
                <div class="mt-1">
                    <select name="user_id" v-model="customer.user_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                        <option v-for="user in customer.users" :key="customer.id" :value="user.id">
                                {{ user.name }}
                        </option>
                    </select>
                </div>
            </div>
        </div>



        <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-2 sm:col-start-1">
                <label for="user_id" class="block text-sm font-medium leading-6 text-gray-900">Status of customer</label>
                <div class="mt-1">
                    <select name="status" v-model="form.status" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                        <option value="potencial">potencial</option>
                        <option value="current">current</option>
                        <option value="former">former</option>

                    </select>
                </div>
            </div>
            <div class="sm:col-span-2"></div>
            <div class="sm:col-span-2">
            <label for="is_active" class="block text-sm font-medium leading-6 text-gray-900">Active</label>
                <div class="mt-1">
                    <select name="is_active" id="is_active" v-model="form.is_active"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                        <option value="1">-- Active --</option>
                        <option value="0">-- Inactive --</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4 sm:col-start-1">
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                <div class="mt-2">
                    <input type="text" name="code" id="name" autocomplete="address-level2"
                    v-model="form.name"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                <div class="mt-2">
                    <input type="text" name="email" id="email" autocomplete="address-level2"
                    v-model="form.email"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
        </div>

        <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4 sm:col-start-1">
                <label for="address" class="block text-sm font-medium leading-6 text-gray-900">Address</label>
                <div class="mt-2">
                    <input type="text" name="address" id="address" autocomplete="address-level2"
                    v-model="form.address"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone</label>
                <div class="mt-2">
                    <input type="text" name="phone" id="phone" autocomplete="address-level2"
                    v-model="form.phone"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
        </div>

        <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-2">
                <label for="is_legal" class="block text-sm font-medium leading-6 text-gray-900">Personal status</label>
                    <div class="mt-1">
                        <select name="is_legal" v-model="form.is_legal"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option value="0">-- Person --</option>
                            <option value="1">-- Company --</option>
                        </select>
                    </div>
            </div>
            <div class="sm:col-span-2" v-if="form.is_legal == 1">
                <label for="code" class="block text-sm font-medium leading-6 text-gray-900">VAT code</label>
                <div class="mt-2">
                    <input type="text" name="code" id="code" autocomplete="address-level2"
                    v-model="form.code"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-2" v-if="form.is_legal == 1">
                <label for="contact_email" class="block text-sm font-medium leading-6 text-gray-900">Contact email</label>
                <div class="mt-2">
                    <input type="text" name="contact_email" id="contact_email" autocomplete="address-level2"
                    v-model="form.contact_email"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

        </div>


        <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div v-if="form.is_legal == 1" class="sm:col-span-4">
                <label for="contact_name" class="block text-sm font-medium leading-6 text-gray-900">Contact</label>
                <div class="mt-2">
                    <input type="text" name="contact_name" id="contact_name" autocomplete="address-level2"
                    v-model="form.contact_name"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div v-if="form.is_legal == 1" class="sm:col-span-2">
                <label for="contact_phone" class="block text-sm font-medium leading-6 text-gray-900">Contact phone</label>
                <div class="mt-2">
                    <input type="text" name="contact_phone" id="contact_phone" autocomplete="address-level2"
                    v-model="form.contact_phone"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

        </div>


        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="col-span-full ">
                <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
               <div class="mt-2">
                <textarea id="description" name="description" rows="4" v-model="form.description" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
               </div>
            </div>
        </div>

        <hr>
        <div class="mt-6 flex items-center justify-end gap-x-6">
        <router-link
                class="text-sm font-semibold leading-6 text-gray-900"
                :to="{ name: 'customers.index'}">
                Back
        </router-link>
        <button type="submit" class="rounded-md bg-blue-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
        </div>


    </form>

</template>
<script setup>
import useCustomers from '@/composables/customers/customers';
import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';
import {reactive} from 'vue';

const { storeCustomer, customer, errors} = useCustomers();

const form = reactive({
    'user_id': '',
    'status': '',
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
