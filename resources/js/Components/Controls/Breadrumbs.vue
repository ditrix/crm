<template>
<div class="breadcrump">
    <ul>
        <li class="inline" v-for="route in props.links.routes" :key="route.name">
            <router-link
                class="items-center px-2 py-2 text-xs font-semibold"
                :to="{name: route.name }">
                {{route.title}} &nbsp;|
            </router-link>
        </li>
    </ul>
    <span class="inline text-xs py-1 font-semibold">{{ props.title }}</span>
</div>
</template>

<script setup>
const props = defineProps({
    title: {
        required: false,
        type: String
    },
    links: {
        required: true,
        type: Object,
    }
});
</script>
