<template>
<div class="breadcrump">
    <router-link
        class="items-center px-2 py-2 text-xs font-semibold"
        :to="{ name: 'page.dashboard' }">
        Home
    </router-link>|
    <span class="text-xs px-2 py-2 font-semibold">Contracts</span>
</div>

<div class="content-wrapper" style="width: 100%;">
    <table class="min-w-full  border divide-y divide-gray-300 grid_table">
    <thead>
        <tr>
            <th class="pl_1">ID</th>
            <th class="pl_1">Code</th>
            <th class="pl_1">Title</th>
            <th class="pl_1">Is active</th>
            <th class="pl_1">Active from</th>
            <th class="pl_1">Active to</th>

        </tr>
    </thead>
    <tbody>
        <tr v-for="contract in contracts" :key="contract.id" class="greed_tr">
            <td class="pl_1">{{contract.id}}</td>
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

        <button class="btn_xs btn_lightgray mr-1" @click="prevPage" :disabled="!pagination.prev_url"><<</button>
        <button class="btn_xs btn_lightgray ml-1" @click="nextPage" :disabled="!pagination.next_url">>></button>

        <!-- <ul class="pagination_list d-flex">
            <li v-for="link in pagination.links" :key="link.url" :class="{active: link.active, disabled: !link.url, pagination_link}">
                <a
                    v-if="link.url"
                    :href="link.url"
                    v-html="link.label"
                     @click="getContractsFromLink(link.url)"
                >
                </a>
            </li>
         </ul> -->



    </div>
</div>
</template>
<script setup>
import { onMounted } from 'vue'
import useContracts from '@/composables/contracts/contracts.js'
import { formatBoolean,formatDate } from '@/helpers/functions'

const {
    contracts,
    pagination,
    prevPage, nextPage, getContracts, getContractsFromLink
} = useContracts();

onMounted( () => getContracts() );
</script>
