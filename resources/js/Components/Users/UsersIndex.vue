<template>
<div class="breadcrump">
    <router-link
        class="items-center px-2 py-2 text-xs font-semibold"
        :to="{ name: 'page.dashboard' }">
        Home
    </router-link>|
    <span class="text-xs px-2 py-2 font-semibold">Users</span>
</div>

<div class="d-flex flex-direction_row justify_content_left_space_between align-items_center mb_1">
    <div class="page_title text-xl mb-2 mt-4">Users</div>
    <div class="d-flex justify_content_right">
            <router-link
                class="btn btn_blue inline-flex items-center px-4 py-2 mr-5 text-xs font-semibold"
                :to="{ name: 'users.store' }" >
                    Create
            </router-link>
        </div>

</div>

<div class="space-y-6 rounded-md shadow-md mt_2 pl_1 pr_1 pb_1 pt_1">
    <table class="min-w-full  border divide-y divide-gray-300 grid_table">
    <thead>
        <tr>
            <th class="pl_1">ID</th>
            <th class="pl_1">User</th>
            <th class="pl_1">Email</th>
            <th class="pl_1">Phone</th>
            <th class="pl_1">Active</th>
            <th class="pl_1">Role</th>
            <th class="pl_1"></th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="user in users" :key="user.id" class="greed_tr">
            <td class="pl_1 fbold">{{ user.id }}</td>
            <td class="pl_4 fbold">{{ user.name }}</td>
            <td class="pl_4">{{ user.email }}</td>
            <td class="pl_4">{{ user.phone }}</td>
            <td class="tx_center">{{ formatBoolean(user.is_active) }}</td>
            <td class="pl_4">{{ user.permission.role_name }}</td>
            <td class="tx_center">
                <router-link
                    class="btn btn_lightgray inline-flex items-center px-4 py-2 text-xs font-semibold"
                    :to="{ name: 'users.show', params: { id: user.id} }">
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

import useUsers from '@/composables/users'
import { formatBoolean } from '@/helpers/functions'

const {users, getUsers} = useUsers();

onMounted( () => getUsers() );


</script>
