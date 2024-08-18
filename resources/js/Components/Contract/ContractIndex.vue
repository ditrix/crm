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
</div>
</template>
<script setup>
import { onMounted } from 'vue'
import useContracts from '@/composables/contracts/contracts.js'
import { formatBoolean,formatDate } from '@/helpers/functions'

const {contracts, getContracts} = useContracts();

onMounted( () => getContracts() );
</script>
