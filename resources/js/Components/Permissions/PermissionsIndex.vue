<template>

    <Breadcrumbs title="Permissions" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard' } ] }" />

<hr>
    <div class="page_title text-xl mb-2 mt-4">Permissions</div>

    <div class="space-y-6 rounded-md shadow-md mt_2 pl_1 pr_1 pb_1 pt_1">
        <table class="table-auto border-collapse border text-xs width-100">
        <thead>
            <tr class="backdrop-filter backdrop-grayscale">
                <th class="border border-gray-300 px-1">role</th>
                <th class="border border-gray-300 px-1">r/w own customer</th>
                <th class="border border-gray-300 px-1">r/w own deals</th>
                <th class="border border-gray-300 px-1">r/w own reports</th>
                <th class="border border-gray-300 px-1">r/w customer</th>
                <th class="border border-gray-300 px-1">r/w deals</th>
                <th class="border border-gray-300 px-1">r/w reports</th>
                <th class="border border-gray-300 px-1">r/w options</th>
                <th class="border border-gray-300 px-1">r/w parameters</th>
                <th class="border border-gray-300 px-1">r/w users</th>
                <th class="border border-gray-300 px-1">actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="permission in permissions" :key="permission.id" class="greed_tr">
                <td class="border border-gray-300 px-1">{{ permission.role_name }}</td>
                <td class="border border-gray-300 text-center">{{ formatBoolean(permission.rw_own_customer) }}</td>
                <td class="border border-gray-300 text-center">{{ formatBoolean(permission.rw_own_deals) }}</td>
                <td class="border border-gray-300 text-center">{{ formatBoolean(permission.rw_own_reports) }}</td>
                <td class="border border-gray-300 text-center">{{ formatBoolean(permission.rw_customer) }}</td>
                <td class="border border-gray-300 text-center">{{ formatBoolean(permission.rw_deals) }}</td>
                <td class="border border-gray-300 text-center">{{ formatBoolean(permission.rw_reports) }}</td>
                <td class="border border-gray-300 text-center">{{ formatBoolean(permission.rw_options) }}</td>
                <td class="border border-gray-300 text-center">{{ formatBoolean(permission.rw_parameters) }}</td>
                <td class="border border-gray-300 text-center">{{ formatBoolean(permission.rw_users) }}</td>
                <td class="border border-gray-300 text-center">
                    <router-link
                        class="btn rounded-sm bg-blue-400  text-white inline-flex items-center px-2 py-1 text-xs hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        :to="{ name: 'permissions.show', params: { id: permission.id} }">
                        <LabelEdit />
                    </router-link>
                </td>
            </tr>
        </tbody>
        </table>
    </div>


</template>

<script setup>
import { onMounted } from 'vue'
import { formatBoolean } from '@/helpers/functions'

import usePermissions from '@/composables/permissions'

import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';
import LabelEdit from '@/Components/Controls/images/LabelEdit.vue';

const {permissions, getPermissions} = usePermissions()




/*
Передача ссылки на функцию:
В onMounted следует передавать ссылку на функцию getPermissions, чтобы она вызывалась после монтирования компонента.
Когда вы пишете onMounted(getPermissions()), вы вызываете функцию немедленно и передаете результат вызова (а не саму функцию) в onMounted.
Правильный способ — передать саму функцию getPermissions в onMounted, чтобы она была вызвана в нужный момент.
*/

  onMounted(
    () => getPermissions()

    )

</script>

