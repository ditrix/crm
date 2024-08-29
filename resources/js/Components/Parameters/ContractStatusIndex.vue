<template>
    <div class="d-flex flex-direction_row justify_content_left_space_between align-items_center mb_1">
        <div class="page_title text-xl mb-2 mt-4">Contract statuses</div>
        <div class="d-flex justify_content_right">
                <router-link
                    class="btn btn_blue inline-flex items-center px-4 py-2 mr-5 text-xs font-semibold"
                    :to="{ name: 'contract_statuses.create' }" >
                        + Create
                </router-link>
            </div>

    </div>

    <div class="content-wrapper" style="width: 100%;">
        <table class="table-auto border-collapse border text-xs width-100">
        <thead>
            <tr class="backdrop-filter backdrop-grayscale">
                <th class="border border-gray-300 px-1">Status</th>
                <th class="border border-gray-300 px-1">Desctiption</th>
                <th class="border border-gray-300 px-1">Is active</th>
                <th class="border border-gray-300 px-1">Order</th>
                <th class="border border-gray-300 px-1"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="contract_status in contract_statuses" :key="contract_status.id" class="greed_tr">
                <td class="border border-gray-300 px-1">{{ contract_status.name }}</td>
                <td class="border border-gray-300 px-1">{{ contract_status.description }}</td>
                <td class="border border-gray-300 tx_center">{{ formatBoolean(contract_status.is_active) }}</td>
                <td class="border border-gray-300 tx_center">{{ contract_status.order_condition }}</td>
                <td class="border border-gray-300 tx_center">
                    <router-link
                        class="btn btn_lightgray inline-flex items-center px-2 py-1 text-xs font-semibold"
                        :to="{ name: 'contract_statuses.show', params: { id: contract_status.id} }">
                        Edit
                    </router-link>
                    <button
                        class="btn btn_red inline-flex items-center ml-1 px-2 py-1 text-xs font-semiboldtext-sm font-medium"
                        @click="deleteContractStatus(contract_status.id)" >
                        X
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
    import useContractStatuses from '@/composables/parameters/contract_statuses'
    import { formatBoolean } from '@/helpers/functions'

    const {contract_statuses, getContractStatuses, destroyContractStatus} = useContractStatuses();

    const deleteContractStatus = async (id) => {

        if (!window.confirm('You sure?')) {
            return
        }

        await destroyContractStatus(id)
        await getContractStatuses();

    }


    onMounted( () => getContractStatuses() );


</script>

