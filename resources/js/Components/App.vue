<template>

    <div v-if="!isAuthenticated">
        <Login />
    </div>
    <div v-else>
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
