<template>

    <Breadcrumbs title="Customer" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard'},{'title': 'customers', 'name': 'customers.index' } ] }" />

    <ErrorMessage :errors="errors.value" />

    <form class="show_form rounded-md shadow-md mt_2" v-on:submit.prevent="saveCustomer">
        <div class="form-item d-flex justify_content_right align-items_center">
            <label for="user_id" class="block text-sm font-medium text-gray-700 mr-4 pt-1">Manager</label>
                <select name="user_id" v-model="customer.user_id" class="short_select_widget px-4  rounded-full widget_20">
                    <option v-for="user in customer.users" :key="user.id" :value="user.id">
                    {{ user.name }}
                </option>
                </select>
        </div>

        <!-- common customer data  -->

        <div class="form-block">
            <div class="form-input_group_inline d-flex justify-between">
                <div class="form-item widget_50">
                    Status
                    <select class="short_select_widget px-4 w_20 rounded-full" name="status" v-model="customer.status">
                            <option value="potencial">potencial</option>
                            <option value="current">current</option>
                            <option value="former">former</option>
                    </select>
                </div>
            </div>

            <div class="form-input_group_inline d-flex justify-between">
                <div class="form-item widget_50">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="customer.name">
                    </div>
                </div>

                <div class="form-item widget_30">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input type="text" name="email" id="email"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="customer.email">
                    </div>
                </div>
            </div>

            <div class="form-input_group_inline d-flex justify-between">
                <div class="form-item widget_50">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <div class="mt-1">
                        <input type="text" name="address" id="address"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="customer.address">
                    </div>
                </div>
                <div class="form-item widget_30">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <div class="mt-1">
                        <input type="text" name="phone" id="phone"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="customer.phone">
                    </div>
                </div>
            </div>

            <div class="form-input_group_inline d-flex justify-between">
                <div class="form-item w_10" >
                    <label for="is_legal" class="block text-sm font-medium text-gray-700">Status</label>
                    <div class="mt-1">
                        <select class="short_select_widget px-4 w_20  rounded-full" name="is_legal" v-model="customer.is_legal">
                            <option value="0">-- Person --</option>
                            <option value="1">-- Legal person --</option>
                        </select>
                    </div>
                </div>
                <div class="form-item ">
                    <label for="is_active" class="block text-sm font-medium text-gray-700">Active</label>
                    <div class="mt-1">
                        <select class="short_select_widget px-4 w_20 rounded-full" name="is_active" v-model="customer.is_active">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="customer.is_legal == 1">
            <div class="form-input_group_inline d-flex justify-start">
                <div class="form-item mr-2 ml-2 w_10">
                    <label for="code" class="block text-sm font-medium text-gray-700">VAT code</label>
                    <div class="mt-1">
                        <input type="text" name="code" id="code"
                                class="block  mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="customer.code">
                    </div>
                </div>

                <div class="form-item ml_5 w_50">
                    <label for="contact_name" class="block text-sm font-medium text-gray-700">Contact</label>
                    <div class="mt-1">
                        <input type="text" name="contact_name" id="contact_name"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="customer.contact_name">
                    </div>
                </div>

            </div>

            <div class="form-input_group_inline d-flex justify-start">
                <div class="form-item ml-2 mr-2">
                    <label for="contact_email" class="block text-sm font-medium text-gray-700">Contact email</label>
                    <div class="mt-1">
                        <input type="text" name="contact_email" id="contact_email"
                                class="block mt-1 w_20 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="customer.contact_email">
                    </div>
                </div>
                <div class="form-item mr-2 ml-2">
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700">Contact phone</label>
                    <div class="mt-1">
                        <input type="text" name="contact_phone" id="contact_phone"
                                class="block mt-1  w_20 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="customer.contact_phone">
                    </div>
                </div>
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
                :to="{ name: 'customers.index' }">
                Back
            </router-link>
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

        <table class="min-w-full  border divide-y divide-gray-300 grid_table">
        <thead>
            <tr>
                <th class="pl_1">ID</th>
                <th class="pl_1">Status</th>
                <th class="pl_1">Code</th>
                <th class="pl_1">Title</th>
                <th class="pl_1">Is active</th>
                <th class="pl_1">Active from</th>
                <th class="pl_1">Active to</th>
                <th class="pl-1">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="contract in customer.contracts" :key="contract.id" class="greed_tr">
                <td class="pl_1">{{contract.id}}</td>
                <td class="pl_1">{{contract.contract_status}}</td>
                <td class="pl_1">{{contract.code}}</td>
                <td class="pl_1">{{contract.title}}</td>
                <td class="tx_center">{{formatBoolean(contract.is_active)}}</td>
                <td class="pl_1">{{formatDate(contract.updated_at)}}</td>
                <td class="pl_1">{{formatDate(contract.created_at)}}</td>
                <td>
                    <router-link
                        class="btn btn_lightgray inline-flex items-center px-4 py-2 text-xs font-semibold"
                        :to="{ name: 'contract.show', params: { id: contract.id } }">
                        Edit
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
