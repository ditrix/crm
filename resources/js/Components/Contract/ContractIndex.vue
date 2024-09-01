<template>

<Breadcrumbs title="Contracts" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard' } ] }" />

<div class="d-flex flex-direction_row justify_content_left_space_between align-items_center mb_1">
    <div class="page_title text-xl mb-2 mt-4">Contracts</div>
</div>


<div class="content-wrapper" style="width: 100%;">
    <table class="table-auto border-collapse border text-xs width-100">
    <thead>
        <tr class="backdrop-filter backdrop-grayscale">
            <th class="border border-gray-300 px-1">ID</th>
            <th class="border border-gray-300 px-1">Status</th>
            <th class="border border-gray-300 px-1">Code</th>
            <th class="border border-gray-300 px-1">Title</th>
            <th class="border border-gray-300 px-1">Active</th>
            <th class="border border-gray-300 px-1">Active from</th>
            <th class="border border-gray-300 px-1">Active to</th>
            <th class="border border-gray-300 px-1">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="contract in contracts" :key="contract.id" class="greed_tr">
            <td class="border border-gray-300 px-1">{{contract.id}}</td>
            <td class="border border-gray-300 px-1">{{contract.contract_status}}</td>
            <td class="border border-gray-300 px-1">{{contract.code}}</td>
            <td class="border border-gray-300 px-1">{{contract.title}}</td>
            <td class="border border-gray-300 text-center">{{formatBoolean(contract.is_active)}}</td>
            <td class="border border-gray-300 text-center">{{formatDate(contract.active_from)}}</td>
            <td class="border border-gray-300 text-center">{{formatDate(contract.active_to)}}</td>
            <td class="border border-gray-300 text-center">
                <router-link
                    class="btn rounded-sm bg-blue-400  text-white inline-flex items-center px-2 py-1 text-xs hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    :to="{ name: 'contract.show', params: { id: contract.id} }">
                    <LabelEdit />
                </router-link>
            </td>
        </tr>
    </tbody>
    </table>
    <!-- Pagination -->
        <ul class="flex row pagination-list mt-4">
            <li type="button"
            class="min-h-[38px] min-w-[38px] flex justify-center items-center border border-gray-200 text-gray-800  py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                v-for="link in pagination.links" :key="link.id" :class="{active: link.active, disabled: !link.url}" >
                <a v-html="link.label"
                    @click="getPaginateData(link.url)"
                >
                </a>
            </li>
    </ul>
    <!-- End Pagination -->
</div>
</template>
<script setup>
import { onMounted } from 'vue'
import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';
import useContracts from '@/composables/contracts/contracts.js'
import { formatBoolean,formatDate } from '@/helpers/functions'

import LabelEdit from '@/Components/Controls/images/LabelEdit.vue';

const {
    contracts,
    pagination,
    getContracts, getPaginateData
} = useContracts();

onMounted( () =>

    getContracts()
);
</script>
