<template>

    <Breadcrumbs title="Customer" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard'},{'title': 'customers', 'name': 'customers.index' } ] }" />

    <ErrorMessage :errors="errors.value" />

    <form class="show_form rounded-md shadow-md mt_2" v-on:submit.prevent="saveCustomer">

        <h2 class="text-base font-semibold leading-7 text-red-900">Customer information</h2>

        <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

            <div class="sm:col-span-2 sm:col-start-1">
                <label for="city" class="block text-sm font-medium leading-6 text-gray-900">Created</label>
                <div class="mt-2">
                    <span class="text-sm text-gray-900">{{ formatDate(customer.created_at) }}</span>
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="region" class="block text-sm font-medium leading-6 text-gray-900">Updated</label>
                <div class="mt-2">
                    <span class="text-sm text-gray-900">{{ formatDate(customer.updated_at) }}</span>
                </div>
            </div>

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
 <!-- status  -->
        <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-2 sm:col-start-1">
                <label for="user_id" class="block text-sm font-medium leading-6 text-gray-900">Status of customer</label>
                <div class="mt-1">
                    <select name="user_id" v-model="customer.status" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
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
                    <select name="is_active" id="is_active" v-model="customer.is_active"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
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
                    v-model="customer.name"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                <div class="mt-2">
                    <input type="text" name="email" id="email" autocomplete="address-level2"
                    v-model="customer.email"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
        </div>



        <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4 sm:col-start-1">
                <label for="address" class="block text-sm font-medium leading-6 text-gray-900">Address</label>
                <div class="mt-2">
                    <input type="text" name="address" id="address" autocomplete="address-level2"
                    v-model="customer.address"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone</label>
                <div class="mt-2">
                    <input type="text" name="phone" id="phone" autocomplete="address-level2"
                    v-model="customer.phone"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
        </div>


        <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

            <div class="sm:col-span-2">
                <label for="is_legal" class="block text-sm font-medium leading-6 text-gray-900">Personal status</label>
                    <div class="mt-1">
                        <select name="is_legal" v-model="customer.is_legal"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option value="0">-- Person --</option>
                            <option value="1">-- Company --</option>
                        </select>
                    </div>
            </div>

            <div class="sm:col-span-2" v-if="customer.is_legal == 1">
                <label for="code" class="block text-sm font-medium leading-6 text-gray-900">VAT code</label>
                <div class="mt-2">
                    <input type="text" name="code" id="code" autocomplete="address-level2"
                    v-model="customer.code"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-2" v-if="customer.is_legal == 1">
                <label for="contact_email" class="block text-sm font-medium leading-6 text-gray-900">Contact email</label>
                <div class="mt-2">
                    <input type="text" name="contact_email" id="contact_email" autocomplete="address-level2"
                    v-model="customer.contact_email"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

        </div>


        <div class="mt-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div v-if="customer.is_legal == 1" class="sm:col-span-4">
                <label for="contact_name" class="block text-sm font-medium leading-6 text-gray-900">Contact</label>
                <div class="mt-2">
                    <input type="text" name="contact_name" id="contact_name" autocomplete="address-level2"
                    v-model="customer.contact_name"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div v-if="customer.is_legal == 1" class="sm:col-span-2">
                <label for="contact_phone" class="block text-sm font-medium leading-6 text-gray-900">Contact phone</label>
                <div class="mt-2">
                    <input type="text" name="contact_phone" id="contact_phone" autocomplete="address-level2"
                    v-model="customer.contact_phone"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

        </div>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="col-span-full ">
                <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
               <div class="mt-2">
                <textarea id="description" name="description" rows="4" v-model="customer.description" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
               </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
        <router-link
                class="text-sm font-semibold leading-6 text-gray-900"
                :to="{ name: 'customers.index'}">
                Back
        </router-link>
        <button type="submit" class="rounded-md bg-blue-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
        </div>
    </form>
    <hr>

<div class="content-wrapper" style="width: 100%;">
    <div class="space-y-6 rounded-md shadow-md mt_2 pl_1 pr_1 pb_1 pt_1">
        <div class="d-flex flex-direction_row justify_content_left_space_between align-items_center mb_1">
    <div class="page_title text-xl mb-2 mt-4">Contracts</div>
    <div class="d-flex justify_content_right">
        <router-link
            class="btn btn_blue inline-flex items-center px-4 py-2 mr-5 text-xs font-semibold"
            :to="{ name: 'contracts.new', params: { customer_id: props.id } }" >
                +Create
        </router-link>
    </div>
</div>

        <table class="table-auto border-collapse border text-xs width-100">
        <thead>
            <tr  class="backdrop-filter backdrop-grayscale">
                <th class="border border-gray-300">ID</th>
                <th class="border border-gray-300">Status</th>
                <th class="border border-gray-300">Code</th>
                <th class="border border-gray-300">Title</th>
                <th class="border border-gray-300">Is active</th>
                <th class="border border-gray-300">Active from</th>
                <th class="border border-gray-300">Active to</th>
                <th class="border border-gray-300">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="contract in customer.contracts" :key="contract.id" class="greed_tr">
                <td class="border border-gray-300 px-1">{{contract.id}}</td>
                <td class="border border-gray-300 px-1">{{contract.contract_status}}</td>
                <td class="border border-gray-300 px-1">{{contract.code}}</td>
                <td class="border border-gray-300 px-1">{{contract.title}}</td>
                <td class="border border-gray-300 px-1 tx_center">{{formatBoolean(contract.is_active)}}</td>
                <td class="border border-gray-300 px-1">{{formatDate(contract.updated_at)}}</td>
                <td class="border border-gray-300 px-1">{{formatDate(contract.created_at)}}</td>
                <td>
                    <router-link
                        class="btn rounded-sm bg-blue-400  text-white inline-flex items-center px-2 py-1 text-xs hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        :to="{ name: 'contract.show', params: { id: contract.id } }">
                        <LabelEdit />
                    </router-link>
<!--                                                                    новый параметр:   vvvvvvvvvvvvvvvvv -->
                    <!-- <router-link :to="{ name: 'contract.show', params: { id: contract.id, from: 'customer' } }">
                        Edit 1
                    </router-link> -->
                </td>
            </tr>
        </tbody>
        </table>
        <div class="mt-1">

            <!-- <button class="btn_xs btn_lightgray mr-1" @click="prevPage" :disabled="!pagination.prev_url"><<</button>
            <button class="btn_xs btn_lightgray ml-1" @click="nextPage" :disabled="!pagination.next_url">>></button> -->

            <!-- <ul class="pagination_list d-flex">
                <li class="btn_xs  btn_lightgray ml-1 mr-1 text-xs" v-for="link in pagination.links" :key="link.id" :class="{active: link.active, disabled: !link.url}">
                    <a
                        v-html="link.label"
                        @click="getContractsFromLink(link.url)"
                    >
                    </a>
                </li>
            </ul>
    -->



    </div>
    </div>
</div>

</template>
<script setup>
import { onMounted } from 'vue'
import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';
import LabelEdit from '@/Components/Controls/images/LabelEdit.vue';

import useCustomers from '@/composables/customers/customers.js'
import useContracts from '@/composables/contracts/contracts.js'
import { formatBoolean,formatDate } from '@/helpers/functions'

const {customer, getCustomer, updateCustomer, errors } = useCustomers()



const props = defineProps({
    id: {
        required: true,
        type: String
    }
});

const  saveCustomer = async () => {
    await updateCustomer(props.id)

}

onMounted( () => {
        getCustomer(props.id);
});



</script>
