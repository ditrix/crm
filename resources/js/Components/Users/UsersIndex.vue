<template>
<Breadcrumbs title="Users" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard' } ] }" />

<div class="d-flex flex-direction_row justify_content_left_space_between align-items_center mb_1">
    <div class="page_title text-xl mb-2 mt-4">Users</div>
    <div class="d-flex justify_content_right">
            <router-link
                class="btn btn_blue inline-flex items-center px-4 py-2 mr-5 text-xs font-semibold"
                :to="{ name: 'users.store' }" >
                    + Create
            </router-link>
        </div>
</div>

<div class="space-y-6 rounded-md shadow-md mt_2 pl_1 pr_1 pb_1 pt_1">
    <table class="table-auto border-collapse border text-xs width-100">
    <thead>
        <tr class="backdrop-filter backdrop-grayscale">
            <th class="border border-gray-300 px-1">ID</th>
            <th class="border border-gray-300 px-1">User</th>
            <th class="border border-gray-300 px-1">Email</th>
            <th class="border border-gray-300 px-1">Phone</th>
            <th class="border border-gray-300 px-1">Active</th>
            <th class="border border-gray-300 px-1">Role</th>
            <th class="border border-gray-300 px-1">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="user in users" :key="user.id" class="greed_tr">
            <td class="border border-gray-300 px-1">{{ user.id }}</td>
            <td class="border border-gray-300 px-1">{{ user.name }}</td>
            <td class="border border-gray-300 px-1">{{ user.email }}</td>
            <td class="border border-gray-300 px-1">{{ user.phone }}</td>
            <td class="border border-gray-300 text-center">{{ formatBoolean(user.is_active) }}</td>
            <td class="border border-gray-300 px-1">{{ user.permission.role_name }}</td>
            <td class="border border-gray-300 text-center">
                <router-link
                    class="btn rounded-sm bg-blue-400  text-white inline-flex items-center px-2 py-1 text-xs hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    :to="{ name: 'users.show', params: { id: user.id} }">
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
import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';
import LabelEdit from '@/Components/Controls/images/LabelEdit.vue';

import useUsers from '@/composables/users'
import { formatBoolean } from '@/helpers/functions'

const {users, getUsers} = useUsers();

onMounted( () => getUsers() );


</script>
