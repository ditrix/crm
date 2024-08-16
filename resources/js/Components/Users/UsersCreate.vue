<template>
<div class="breadcrump">
    <router-link
        class="items-center px-2 py-2 text-xs font-semibold"
        :to="{ name: 'page.home' }">
        Home
    </router-link>|
    <router-link
        class="items-center px-2 py-2 text-xs font-semibold"
        :to="{ name: 'users.index' }">
        users
    </router-link>| <span class="text-xs px-2 py-2 font-semibold">Create user</span>
</div>


<div class="contanier">

     <!-- show errors block  -->
    <div v-if="errors">
        <div v-for="(v, k) in errors" :key="k" class="bg-red-400 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
            <p v-for="error in v" :key="error" class="text-sm">
                {{ error }}
            </p>
        </div>
    </div>

    <form class="show_form space-y-6 rounded-md shadow-md mt_2 p" v-on:submit.prevent="createUser">

        <div class="page_title text-xl mb-2">User {{ form.id }}</div>

        <div class="form-input_group_inline">

            <div class="form-item input-inline widget_50">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.name">
                </div>
            </div>
            <div class="form-item input-inline widget_30">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <input type="text" name="name" id="email"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.email">
                </div>

            </div>
            <div class="form-item input-inline">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <div class="mt-1">
                    <input type="text" name="phone" id="phone"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.phone">
                </div>
            </div>
        </div>


        <div class="form-input_group_inline">

            <div class="form-item input-inline widget_30">
                <label for="permission" class="block text-sm font-medium text-gray-700">Permission</label>
                <div class="mt-1">
                    <select id="permission" class="rounded-full border-gray-300" style="width: 100%;" name="permission_id" v-model="form.permission_id">
                        <option value="0">-- select role ---</option>
                        <option v-for="permission in permissions" :value="permission.id">
                            {{ permission.role_name }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-item input-inline widget_10">
                <label for="is_active" class="block text-sm font-medium text-gray-700">Active</label>
                <div class="mt-1">
                    <select id="is_active" class="rounded-full border-gray-300" style="width: 100%;" name="is_active" v-model="form.is_active">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>


            <div class="form-item input-inline">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1">
                    <input type="password" name="password" id="password"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.password">
                </div>
            </div>

        </div>

        <div  class="form-controll">
                <button
                    type="submit"
                    class="btn btn_blue inline-flex items-center ml-1  font-semiboldtext-sm font-medium mt_2">
                    Save
                </button>

                <router-link
                    class="btn btn_lightgray ml-2 inline-flex items-center  font-semibold ml_2"
                    :to="{ name: 'users.index' }">
                    Cancel
                </router-link>
            </div>
    </form>

</div>

</template>

<script setup>
import { onMounted } from 'vue'
import useUsers from '@/composables/users'

import {reactive} from 'vue';

const { permissions, errors, storeUser, getPermissions} = useUsers();

const form = reactive({
    'name': '',
    'email': '',
    'phone': '',
    'is_active': '',
    'permission_id': '',
    'password': '',
});

const createUser = async () => {
    await storeUser({ ...form });

}

onMounted(() =>
  getPermissions()
);

</script>
