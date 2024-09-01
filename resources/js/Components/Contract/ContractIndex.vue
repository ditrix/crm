<template>

<Breadcrumbs title="Contracts" :links="{ routes: [{ 'title': 'Home', 'name': 'page.dashboard' } ] }" />

<div class="d-flex flex-direction_row justify_content_left_space_between align-items_center mb_1">
    <div class="page_title text-xl mb-2 mt-4">Contracts</div>
</div>


<div class="content-wrapper" style="width: 100%;">
    <table class="table-auto border-collapse border text-xs width-100">
    <thead>
        <tr class="backdrop-filter backdrop-grayscale">
            <th class="border border-gray-300 px-1">ID</th>
            <th class="border border-gray-300 px-1">Status</th>
            <th class="border border-gray-300 px-1">Code</th>
            <th class="border border-gray-300 px-1">Title</th>
            <th class="border border-gray-300 px-1">Active</th>
            <th class="border border-gray-300 px-1">Active from</th>
            <th class="border border-gray-300 px-1">Active to</th>
            <th class="border border-gray-300 px-1">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="contract in contracts" :key="contract.id" class="greed_tr">
            <td class="border border-gray-300 px-1">{{contract.id}}</td>
            <td class="border border-gray-300 px-1">{{contract.contract_status}}</td>
            <td class="border border-gray-300 px-1">{{contract.code}}</td>
            <td class="border border-gray-300 px-1">{{contract.title}}</td>
            <td class="border border-gray-300 text-center">{{formatBoolean(contract.is_active)}}</td>
            <td class="border border-gray-300 text-center">{{formatDate(contract.active_from)}}</td>
            <td class="border border-gray-300 text-center">{{formatDate(contract.active_to)}}</td>
            <td class="border border-gray-300 text-center">
                <router-link
                    class="btn rounded-sm bg-blue-400  text-white inline-flex items-center px-2 py-1 text-xs hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    :to="{ name: 'contract.show', params: { id: contract.id} }">
                    <svg fill="#ffffff" height="0.8rem" width="0.8rem" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
	                    viewBox="0 0 348.882 348.882" xml:space="preserve"><g><path d="M333.988,11.758l-0.42-0.383C325.538,4.04,315.129,0,304.258,0c-12.187,0-23.888,5.159-32.104,14.153L116.803,184.231
                                c-1.416,1.55-2.49,3.379-3.154,5.37l-18.267,54.762c-2.112,6.331-1.052,13.333,2.835,18.729c3.918,5.438,10.23,8.685,16.886,8.685
                                c0,0,0.001,0,0.001,0c2.879,0,5.693-0.592,8.362-1.76l52.89-23.138c1.923-0.841,3.648-2.076,5.063-3.626L336.771,73.176
                                C352.937,55.479,351.69,27.929,333.988,11.758z M130.381,234.247l10.719-32.134l0.904-0.99l20.316,18.556l-0.904,0.99
                                L130.381,234.247z M314.621,52.943L182.553,197.53l-20.316-18.556L294.305,34.386c2.583-2.828,6.118-4.386,9.954-4.386
                                c3.365,0,6.588,1.252,9.082,3.53l0.419,0.383C319.244,38.922,319.63,47.459,314.621,52.943z"/>
                            <path d="M303.85,138.388c-8.284,0-15,6.716-15,15v127.347c0,21.034-17.113,38.147-38.147,38.147H68.904
                                c-21.035,0-38.147-17.113-38.147-38.147V100.413c0-21.034,17.113-38.147,38.147-38.147h131.587c8.284,0,15-6.716,15-15
                                s-6.716-15-15-15H68.904c-37.577,0-68.147,30.571-68.147,68.147v180.321c0,37.576,30.571,68.147,68.147,68.147h181.798
                                c37.576,0,68.147-30.571,68.147-68.147V153.388C318.85,145.104,312.134,138.388,303.85,138.388z"/></g>
                    </svg>
                </router-link>
            </td>
        </tr>
    </tbody>
    </table>
    <div class="mt-1">
        <!-- <button class="btn_xs btn_lightgray mr-1" @click="prevPage" :disabled="!pagination.prev_url"><<</button>
        <button class="btn_xs btn_lightgray ml-1" @click="nextPage" :disabled="!pagination.next_url">>></button> -->

        <ul class="pagination_list d-flex">
            <li class="btn_xs  btn_lightgray ml-1 mr-1 text-xs" v-for="link in pagination.links" :key="link.id" :class="{active: link.active, disabled: !link.url}">
                <a
                    v-html="link.label"
                    @click="getContractsFromLink(link.url)"
                >
                </a>
            </li>
         </ul>
    </div>
    <div>

        <!-- Paginations -->
<!-- <nav class="flex items-center -space-x-px" aria-label="Pagination">
  <button type="button" class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm first:rounded-s-lg last:rounded-e-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" aria-label="Previous">
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m15 18-6-6 6-6"></path>
    </svg>
    <span class="hidden sm:block">Previous</span>
  </button>
  <button type="button" class="min-h-[38px] min-w-[38px] flex justify-center items-center bg-gray-200 text-gray-800 border border-gray-200 py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-none focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none" aria-current="page">1</button>
  <button type="button" class="min-h-[38px] min-w-[38px] flex justify-center items-center border border-gray-200 text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">2</button>
  <button type="button" class="min-h-[38px] min-w-[38px] flex justify-center items-center border border-gray-200 text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm first:rounded-s-lg last:rounded-e-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">3</button>
  <button type="button" class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm first:rounded-s-lg last:rounded-e-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" aria-label="Next">
    <span class="hidden sm:block">Next</span>
    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="m9 18 6-6-6-6"></path>
    </svg>
  </button>
</nav>


<div class="flex row">
  <button
    class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg rounded-r-none border border-r-0 border-gray-900 text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
    type="button">
    <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
        aria-hidden="true" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
      </svg>
    </span>
  </button>
  <button
    class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg rounded-r-none rounded-l-none border border-r-0 border-gray-900 bg-gray-100 text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
    type="button">
    <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
      1
    </span>
  </button>
  <button
    class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg rounded-r-none rounded-l-none border border-r-0 border-gray-900 text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
    type="button">
    <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
      2
    </span>
  </button>
  <button
    class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg rounded-r-none rounded-l-none border border-r-0 border-gray-900 text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
    type="button">
    <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
      3
    </span>
  </button>
  <button
    class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg rounded-r-none rounded-l-none border border-r-0 border-gray-900 text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
    type="button">
    <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
      4
    </span>
  </button>
  <button
    class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg rounded-r-none rounded-l-none border border-r-0 border-gray-900 text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
    type="button">
    <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
      5
    </span>
  </button>
  <button
    class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg rounded-l-none border border-gray-900 text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:opacity-75 focus:ring focus:ring-gray-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
    type="button">
    <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
        aria-hidden="true" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
      </svg>
    </span>
  </button>
</div> -->
<!-- End Pagination -->
    </div>
</div>
</template>
<script setup>
import { onMounted } from 'vue'
import Breadcrumbs from '@/Components/Controls/Breadrumbs.vue';
import useContracts from '@/composables/contracts/contracts.js'
import { formatBoolean,formatDate } from '@/helpers/functions'

const {
    contracts,
    pagination,
    prevPage, nextPage, getContracts, getContractsFromLink
} = useContracts();

onMounted( () =>

    getContracts()
);
</script>
