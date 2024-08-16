<template>
<div class="breadcrump">
    <router-link
        class="items-center px-2 py-2 text-xs font-semibold"
        :to="{ name: 'page.dashboard' }">
        Home
    </router-link>|
    <router-link
        class="items-center px-2 py-2 text-xs font-semibold"
        :to="{ name: 'parameters.index' }">
        parameters and options
    </router-link>| <span class="text-xs px-2 py-2 font-semibold">Status patameter</span>
</div>
     <!-- show errors block  -->
     <div v-if="errors">
        <div v-for="(v, k) in errors" :key="k" class="bg-red-400 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
            <p v-for="error in v" :key="error" class="text-sm">
                {{ error }}
            </p>
        </div>
    </div>

    <form class="show_form space-y-6 rounded-md shadow-md mt_2 p" v-on:submit.prevent="saveStatusParameter">

        <div class="page_title text-xl mb-2">Status patameter</div>
        <div class="form-input_group">

            <div class="form-item input-inline widget_30">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="status_parameter.name">
                </div>
            </div>
            <div class="form-item input-inline widget_30">
                <label for="name" class="block text-sm font-medium text-gray-700">Descriptipion</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="status_parameter.description">
                </div>
            </div>

        </div>
        <div class="form-input_group_inline pl_1">
            <div class="form-item input-inline w_10">
                <label for="is_active" class="block text-sm font-medium text-gray-700">Active</label>
                <div class="mt-1">
                    <select id="is_active" class="rounded-full border-gray-300" style="width: 100%;" name="is_active" v-model="status_parameter.is_active">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>

            <div class="form-item input-inline  w_10">
                <label for="order_condition" class="block text-sm font-medium text-gray-700">Order position</label>
                <div class="mt-1">
                    <input type="number" name="order_condition" id="order_condition"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="status_parameter.order_condition">
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
                    :to="{ name: 'parameters.index' }">
                    Cancel
                </router-link>
        </div>
    </form>

</template>




<script setup>

import { onMounted } from 'vue'
import useStatusParameters from '@/composables/parameters/status_parameters'

const {status_parameter, getStatusParameter, updateStatusParameter} = useStatusParameters();

const saveStatusParameter = async () => {
    await updateStatusParameter(props.id)
    console.log('saveStatusParameter')

}

const props = defineProps({
    id: {
        required: true,
        type: String
    }
})

onMounted( () => getStatusParameter(props.id) );

</script>
