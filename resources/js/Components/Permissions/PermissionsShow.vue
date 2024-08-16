<template>

 <div class="breadcrump">
    <router-link
        class="items-center px-2 py-2 text-xs font-semibold"
        :to="{ name: 'page.home' }">
        Home
    </router-link>|
    <router-link
        class="items-center px-2 py-2 text-xs font-semibold"
        :to="{ name: 'permissions.index' }">
        permissions
    </router-link>|
    <span class="text-xs px-2 py-2 font-semibold">Permission</span>
</div>

<div class="contanier">

    <div class="page_title text-xl mb-2 mt-4">Permission {{ permission.role_name }}</div>

        <form class="show_form space-y-6 rounded-md shadow-md mt_2 p" v-on:submit.prevent="SavePermission">
            <div class="form-input_group_inline">

                <div class="form-item input-inline">
                    <label for="rw_own_customer" class="block text-sm font-medium text-gray-700">R/W own customer</label>
                    <div class="mt-1">
                        <select class="rounded-full border-gray-300" style="width: 100%;" name="rw_own_customer" v-model="permission.rw_own_customer">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <div class="form-item input-inline" >
                    <label for="rw_customer" class="block text-sm font-medium text-gray-700">R/W all customer</label>
                    <div class="mt-1">
                        <select class="rounded-full border-gray-300" style="width: 100%;" name="rw_customer" v-model="permission.rw_customer">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <div class="form-item input-inline">
                    <label for="rw_own_deals" class="block text-sm font-medium text-gray-700">R/W own deals</label>
                    <div class="mt-1">
                        <select class="rounded-full border-gray-300" style="width: 100%;" name="rw_own_deals" v-model="permission.rw_own_deals">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <div class="form-item input-inline">
                    <label for="rw_deals" class="block text-sm font-medium text-gray-700">R/W all deals</label>
                    <div class="mt-1">
                        <select class="rounded-full border-gray-300" style="width: 100%;" name="rw_deals" v-model="permission.rw_deals">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="form-input_group_inline">

                <div class="form-item input-inline">
                    <label for="rw_own_reports" class="block text-sm font-medium text-gray-700">R/W own reports</label>
                    <div class="mt-1">
                        <select class="rounded-full border-gray-300" style="width: 100%;" name="rw_own_reports" v-model="permission.rw_own_reports">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <div class="form-item input-inline">
                    <label for="rw_reports" class="block text-sm font-medium text-gray-700">R/W all reports</label>
                    <div class="mt-1">
                        <select class="rounded-full border-gray-300" style="width: 100%;" name="rw_reports" v-model="permission.rw_reports">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <div class="form-item input-inline">
                    <label for="rw_options" class="block text-sm font-medium text-gray-700">R/W options</label>
                    <div class="mt-1">
                        <select class="rounded-full border-gray-300" style="width: 100%;" name="rw_options" v-model="permission.rw_options">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <div class="form-item input-inline">
                    <label for="rw_parameters" class="block text-sm font-medium text-gray-700">R/W parameters</label>
                    <div class="mt-1">
                        <select class="rounded-full border-gray-300" style="width: 100%;" name="rw_parameters" v-model="permission.rw_parameters">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <div class="form-item input-inline">
                    <label for="rw_users" class="block text-sm font-medium text-gray-700">R/W users</label>
                    <div class="mt-1">
                        <select class="rounded-full border-gray-300" style="width: 100%;" name="rw_users" v-model="permission.rw_users">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
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
                    :to="{ name: 'permissions.index' }">
                    Cancel
                </router-link>
            </div>

    </form>
</div>
</template>
<script setup>
    import { ref, onMounted } from 'vue';

    /* TODO deleteme */
    import axios from 'axios'

    import usePermissions from '@/composables/permissions'

    const {permission, getPermission, updatePermission} = usePermissions()

    const props = defineProps({
        id: {
            required: true,
            type: String
        }
    });

    const SavePermission = async () => {
        await updatePermission(props.id)
    }

    onMounted(
        () => getPermission(props.id)
    )


</script>
