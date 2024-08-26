<template>

    <Breadcrumbs title="Contract" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard'},{'title': 'contracts', 'name': 'contract.index' } ] }" />

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


        <div class="form-item d-flex justify_content_right align-items_right">
            <div class="form-item widget_20">
                    <label for="created_at" class="block text-sm font-medium text-gray-700 mr-4 pt-1">Created at</label>
                    <span>{{ formatDate(contract.created_at) }}</span>
                </div>

                <div class="form-item widget_20">
                    <label for="updated_at" class="block text-sm font-medium text-gray-700 mr-4 pt-1">Updated at</label>
                    <span>{{ formatDate(contract.updated_at) }}</span>
                </div>

                <div class="form-item  w_100">
                <label for="user_id" class="block text-sm font-medium text-gray-700 mr-4 pt-1">Manager</label>
                    <select name="user_id" v-model="contract.user_id" class="short_select_widget px-4 rounded-full widget_20">
                        <option v-for="user in contract.users" :key="contract.id" :value="user.id">
                            {{ user.name }}
                        </option>
                    </select>
                </div>

        </div>
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
                Contracts
            </router-link>

            <router-link
                class="btn btn_lightgray  inline-flex items-center mr_1  pl_1 pr_1 font-semiboldtext-sm font-medium mt_2"
                :to="{ name: 'customers.show', params: {id: contract.customer_id} }">
                Customer
            </router-link>

            <!-- <FormButtons :backRouteType="backRouteType" :contract="contract"/> -->
        </div>
    </form>


</template>
<script setup>
import { onMounted, computed } from 'vue'
import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';
import useContracts from '@/composables/contracts/contracts.js'
import { formatBoolean,formatDate } from '@/helpers/functions'
import FormButtons from '@/Components/Controls/FormButtons.vue'
import  {useRoute} from 'vue-router'


const {
    errors,
    contract,
    getContract,
    updateContract,
} = useContracts();

const props = defineProps({
    id: {
        required: true,
        type: String
    },
    from: {
        required: true,
        type: String
    }
});

//const backRouteType = computed ( () => { route.params.from === 'customer' ? 'customer' : 'contract'  } );

const backRoute = computed(() => {
    return { name: 'customers.show', params: {id: contract.customer_id} }

//     if(route.props.from == null) {
//         return { name: 'contract.index' }
//     }
//     if(route.props.from === 'customer') {
//         return { name: 'customers.show', params: { id: contract.customer_id } }
//     }
//     if(props.from === 'contract') {
//         return { name: 'contract.index' }
//     }

//   return backRouteType.value === 'customer'
//     ? { name: 'customers.show', params: { id: contract.customer_id } }
//     : { name: 'contract.index' };
});


const saveContract = async () => {
    await updateContract(props.id)
}

onMounted(
    () => {
        getContract(props.id);
        console.log('props.id',props.id);
        console.log('props.from',props.from);
    }

);
</script>
