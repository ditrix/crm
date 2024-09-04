<template>

<Breadcrumbs title="User" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard'},{'title': 'users', 'name': 'users.index' } ] }" />

<div class="contanier">

     <!-- show errors block  -->
     <div v-if="errors">
        <div v-for="(v, k) in errors" :key="k" class="bg-red-400 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
            <p v-for="error in v" :key="error" class="text-sm">
                {{ error }}
            </p>
        </div>
    </div>

    <form class="show_form space-y-6 rounded-md shadow-md mt_2 p" v-on:submit.prevent="saveUser">

        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-red-900">User</h2>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-9">
                <div class="sm:col-span-4">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                    <div class="mt-2">
                        <input type="text" name="name" id="name" autocomplete="address-level2"
                        v-model="user.name"
                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                    <div class="mt-1">
                        <input type="text" name="email" id="email"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                v-model="user.email">
                        </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone</label>
                    <div class="mt-1">
                        <input type="text" name="phone" id="phone"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                v-model="user.phone">
                    </div>
                </div>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <label for="permission" class="block text-sm font-medium leading-6 text-gray-900">Permission</label>
                    <div class="mt-1">

                        <select id="permission" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" name="permission_id" v-model="user.permission_id">
                            <option v-for="permission in permissions" :value="permission.id">
                                {{ permission.role_name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="is_active" class="block text-sm font-medium leading-6 text-gray-900">Active</label>
                    <div class="mt-1">
                        <select name="is_active" id="is_active" v-model="user.is_active"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option value="1">-- Active --</option>
                            <option value="0">-- Inactive --</option>
                        </select>
                    </div>
                </div>



                <div class="sm:col-span-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input type="password" name="password" id="password"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="user.password"
                            placeholder="enter new password"
                            >
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
        <router-link
                class="text-sm font-semibold leading-6 text-gray-900"
                :to="{ name: 'users.index' }">
                Back
        </router-link>
        <button type="submit" class="rounded-md bg-blue-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
        </div>

    </form>

</div>

</template>



<script setup>

import { onMounted } from 'vue'

import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';

import useUsers from '@/composables/users'

const {user, permissions, errors, getUser, updateUser, getPermissions} = useUsers();

const props = defineProps({
    id: {
        required: true,
        type: String
    }
});


const  saveUser = async () => {
    await updateUser(props.id)

}

onMounted( () => {
    getUser(props.id);
    getPermissions();
});

</script>
