<template>

    <div v-if="!isAuthenticated">
        <Login />
    </div>
    <div v-else>
    <TopMenu />
    <div class="container">
        <div class="navbar">
            <Menu />
        </div>
        <div class="content">
            <router-view />
        </div>
    </div>
    </div>
</template>
<script setup>
    import TopMenu from './TopMenu.vue'
    import Menu from './Menu.vue'
    import Login from './Login.vue'

    import { useAuthStore } from '../Stores/AuthStore'
import { useRouter } from 'vue-router'
import { computed } from 'vue';

const authStore = useAuthStore()
// const isAuthenticated = ref(authStore.isAuthenticated)


const isAuthenticated = computed(() => authStore.isAuthenticated);


const router = useRouter()



</script>
<style scoped>
    /* Стили для основного компонента */
</style>
