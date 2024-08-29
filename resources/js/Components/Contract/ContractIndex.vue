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
            <th class="border border-gray-300 px-1">Is active</th>
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
                    class="btn btn_lightgray inline-flex items-center px-2 py-1 text-xs font-semibold"
                    :to="{ name: 'contract.show', params: { id: contract.id} }">
                    Edit
                </router-link>
            </td>
        </tr>
    </tbody>
    </table>
    <div class="mt-1">
        <!-- <button class="btn_xs btn_lightgray mr-1" @click="prevPage" :disabled="!pagination.prev_url"><<</button>
        <button class="btn_xs btn_lightgray ml-1" @click="nextPage" :disabled="!pagination.next_url">>></button> -->

        <ul class="pagination_list d-flex">
            <li class="btn_xs  btn_lightgray ml-1 mr-1 text-xs" v-for="link in pagination.links" :key="link.id" :class="{active: link.active, disabled: !link.url}">
                <a
                    v-html="link.label"
                    @click="getContractsFromLink(link.url)"
                >
                </a>
            </li>
         </ul>
    </div>
</div>
</template>
<script setup>
import { onMounted } from 'vue'
import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';
import useContracts from '@/composables/contracts/contracts.js'
import { formatBoolean,formatDate } from '@/helpers/functions'

const {
    contracts,
    pagination,
    prevPage, nextPage, getContracts, getContractsFromLink
} = useContracts();

onMounted( () =>

    getContracts()
);
</script>
