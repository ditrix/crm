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
  //  import axios from 'axios'
    import TopMenu from './TopMenu.vue'
    import Menu from './Menu.vue'
    import Login from './Login.vue'

    import { useAuthStore } from '../Stores/AuthStore'
import { useRouter } from 'vue-router'
import { computed } from 'vue';

axios.defaults.baseURL = 'http://localhost/api';

const authStore = useAuthStore()


const isAuthenticated = computed(() => authStore.isAuthenticated);


const router = useRouter()



</script>
<style scoped>
    /* Стили для основного компонента */
</style>
