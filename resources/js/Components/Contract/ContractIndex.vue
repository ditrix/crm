<template>

<Breadcrumbs title="Contracts" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard' } ] }" />

<div class="content-wrapper" style="width: 100%;">
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
        <tr v-for="contract in contracts" :key="contract.id" class="greed_tr">
            <td class="pl_1">{{contract.id}}</td>
            <td class="pl_1">{{contract.contract_status}}</td>
            <td class="pl_1">{{contract.code}}</td>
            <td class="pl_1">{{contract.title}}</td>
            <td class="tx_center">{{formatBoolean(contract.is_active)}}</td>
            <td class="pl_1">{{formatDate(contract.active_from)}}</td>
            <td class="pl_1">{{formatDate(contract.active_to)}}</td>
            <td>
                <router-link
                    class="btn btn_lightgray inline-flex items-center px-4 py-2 text-xs font-semibold"
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
