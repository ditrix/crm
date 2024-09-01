<template>
    <div class="d-flex flex-direction_row justify_content_left_space_between align-items_center mb_1">
        <div class="page_title text-xl mb-2 mt-4">Contract types</div>
        <div class="d-flex justify_content_right">
                <router-link
                    class="btn btn_blue inline-flex items-center px-4 py-2 mr-5 text-xs font-semibold"
                    :to="{ name: 'contract_types.create' }" >
                        + Create
                </router-link>
            </div>

    </div>
<div class="content-wrapper" style="width: 100%;">
    <table class="table-auto border-collapse border text-xs width-100">
    <thead>
        <tr class="backdrop-filter backdrop-grayscale">
            <th class="border border-gray-300 px-1">Code</th>
            <th class="border border-gray-300 px-1">Title</th>
            <th class="border border-gray-300 px-1">Is active</th>
            <th class="border border-gray-300 px-1">Order</th>
            <th class="border border-gray-300 px-1"></th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="contract_type in contract_types" :key="contract_type.id" class="greed_tr">
            <td class="border border-gray-300 px-1">{{ contract_type.code }}</td>
            <td class="border border-gray-300 px-1">{{ contract_type.title }}</td>
            <td class="border border-gray-300 text-center">{{ formatBoolean(contract_type.is_active) }}</td>
            <td class="border border-gray-300 text-center">{{ contract_type.order_condition }}</td>
            <td class="border border-gray-300 text-center">
                <router-link
                    class="btn rounded-sm bg-blue-400  text-white inline-flex items-center px-2 py-1 text-xs hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    :to="{ name: 'contract_types.show', params: { id: contract_type.id} }">
                    <LabelEdit />
                </router-link>
                <button
                    class="btn rounded-sm bg-red-400 inline-flex items-center ml-1 px-2 py-1 text-xs font-semiboldtext-sm font-medium"
                    @click="deleteContractType(contract_type.id)" >
                    <LabelDelete />
                </button>
            </td>
        </tr>
    </tbody>
    </table>
</div>
</template>

<script setup>


import { onMounted } from 'vue'
import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';
import useContractTypes from '@/composables/parameters/contract_types.js'
import { formatBoolean } from '@/helpers/functions'

import LabelDelete from '@/Components/Controls/images/LabelDelete.vue';
import LabelEdit from '@/Components/Controls/images/LabelEdit.vue';


const {contract_types, getContractTypes, destroyContractType} = useContractTypes();

const deleteContractType = async (id) => {

    if (!window.confirm('You sure?')) {
        return
    }

    await destroyContractType(id)
    await getContractTypes();

}


onMounted( () => getContractTypes() );


</script>
