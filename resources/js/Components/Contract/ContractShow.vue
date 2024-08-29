<template>

    <Breadcrumbs title="Contract" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard'},{'title': 'contracts', 'name': 'contract.index' } ] }" />

    <ErrorMessage :errors="{errors: [{'errors': 'errors'}]}" />

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
      <h2 class="text-base font-semibold leading-7 text-red-900">Contract information</h2>

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
                <div class="mt-1">
                    <select name="user_id" v-model="contract.user_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                        <option v-for="user in contract.users" :key="contract.id" :value="user.id">
                                {{ user.name }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="contract_type" class="block text-sm font-medium leading-6 text-gray-900">Contract type</label>
                <div class="mt-1">
                    <span class="text-base font-semibold leading-7 text-gray-900">{{ contract.type }}</span>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="customer" class="block text-sm font-medium leading-6 text-gray-900">Customer</label>
                <div class="mt-1">
                    <span id="customer" class="text-base font-semibold leading-7 text-gray-900">{{ contract.customer }}</span>
                </div>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-2 sm:col-start-1">
                <label for="code" class="block text-sm font-medium leading-6 text-gray-900">Code</label>
                <div class="mt-2">
                    <input type="text" name="code" id="code" autocomplete="address-level2"
                    v-model="contract.code"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-1">
                <label for="summ" class="block text-sm font-medium leading-6 text-gray-900">Summ</label>
                <div class="mt-2">
                    <input type="number" name="summ" id="summ" autocomplete="address-level2"
                    v-model="contract.summ"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="contract_status_id" class="block text-sm font-medium leading-6 text-gray-900">Status</label>
                <div class="mt-2">
                    <select id="contract_status_id" name="contract_status_id" v-model="contract.contract_status_id" autocomplete="contract_status_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                        <option v-for="contract_status in contract.statuses" :key="contract_status.id" :value="contract_status.id">
                                {{ contract_status.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="sm:col-span-1">
                <label for="is_active" class="block text-sm font-medium leading-6 text-gray-900">Active</label>
                <div class="mt-2">
                    <select id="contract_status_id" name="is_active" v-model="contract.is_active" autocomplete="contract_status_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="col-span-full">
                <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Contract title</label>
                <div class="mt-2">
                    <input type="text" v-model="contract.title" name="title" id="title" autocomplete="title" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
        </div>
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="col-span-full ">
            <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Comment</label>
            <div class="mt-2">
                <textarea id="comment" name="comment" rows="4" v-model="contract.comment" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
            </div>
            </div>
        </div>

    </div>
    <div class="mt-6 flex items-center justify-end gap-x-6">
        <router-link
                class="text-sm font-semibold leading-6 text-gray-900"
                :to="{ name: 'contract.index' }">
                Contracts
        </router-link>

        <router-link
                class="text-sm font-semibold leading-6 text-gray-900"
                :to="{ name: 'customers.show', params: {id: contract.customer_id} }">
                Customer
        </router-link>
        <button type="submit" class="rounded-md bg-blue-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
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
