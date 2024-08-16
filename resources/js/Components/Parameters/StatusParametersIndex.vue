<template>
    <div class="d-flex flex-direction_row justify_content_left_space_between align-items_center mb_1">
        <div class="page_title text-xl mb-2 mt-4">Status parameters</div>
        <div class="d-flex justify_content_right">
                <router-link
                    class="btn btn_blue inline-flex items-center px-4 py-2 mr-5 text-xs font-semibold"
                    :to="{ name: 'status_parameters.create' }" >
                        Create
                </router-link>
            </div>

    </div>

    <div class="content-wrapper" style="width: 100%;">
        <table class="min-w-full  border divide-y divide-gray-300 grid_table">
        <thead>
            <tr>
                <th class="pl_1">Parameter</th>
                <th class="pl_1">Desctiption</th>
                <th class="pl_1">Is active</th>
                <th class="pl_1">Order</th>
                <th class="pl_1"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="status_parameter in status_parameters" :key="status_parameter.id" class="greed_tr">
                <td class="pl_4 fbold">{{ status_parameter.name }}</td>
                <td class="pl_4">{{ status_parameter.description }}</td>
                <td class="tx_center">{{ formatBoolean(status_parameter.is_active) }}</td>
                <td class="tx_center">{{ status_parameter.order_condition }}</td>
                <td class="tx_center">
                    <router-link
                        class="btn btn_lightgray inline-flex items-center px-4 py-2 text-xs font-semibold"
                        :to="{ name: 'status_parameters.show', params: { id: status_parameter.id} }">
                        Edit
                    </router-link>
                    <button
                        class="btn btn_red inline-flex items-center ml-1 px-4 py-2 text-xs font-semiboldtext-sm font-medium"
                        @click="deleteStatusParameter(status_parameter.id)" >
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

    import useStatusParameters from '@/composables/parameters/status_parameters'
    import { formatBoolean } from '@/helpers/functions'

    const {status_parameters, getStatusParameters, destroyStatusParameter} = useStatusParameters();

    const deleteStatusParameter = async (id) => {

        if (!window.confirm('You sure?')) {
            return
        }

        await destroyStatusParameter(id)
        await getStatusParameters();

    }


    onMounted( () => getStatusParameters() );


</script>

