<template>
   <div class="breadcrump">
    <router-link
        class="items-center px-2 py-2 text-xs font-semibold"
        :to="{ name: 'page.dashboard' }">
        Home
    </router-link>|
    <span class="text-xs px-2 py-2 font-semibold">Parameters and options</span>
</div>

    <div class="space-y-6 rounded-md shadow-md mt_2 pl_1 pr_1 pb_1 pt_1">
    <StatusParametersIndex />
    </div>

    <div class=" space-y-6 rounded-md shadow-md mt_4 pl_1 pr_1 pb_1 pt_1">
    <ContractTypeIndex />
    </div>
</template>
<script setup>

import StatusParametersIndex from '@/Components/Parameters/StatusParametersIndex.vue'

import ContractTypeIndex from '@/Components/Parameters/ContractTypeIndex.vue';

</script>
