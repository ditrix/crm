<template>
    <nav  v-if="isAuthenticated">
    <ul>
        <!-- <li><router-link to="/">Home</router-link></li> -->
        <li><router-link to="/dashboard">Dashboard</router-link></li>
        <li><router-link to="/customers">Customers</router-link></li>
        <li><router-link to="/deals">Deals</router-link></li>
        <li><router-link to="/reports">Reports</router-link></li>
        <li><router-link to="/parameters">Parameters</router-link></li>
        <li><router-link to="/users">Users</router-link></li>
        <li><router-link to="/permissions">Permissions</router-link></li>
        <li><router-link to="/options">Options</router-link></li>
        <!-- <li v-if="!isAuthenticated"><router-link to="/login">Login</router-link></li> -->
        <!-- <li v-if="!isAuthenticated"><router-link to="/register">Register</router-link></li>
        <li v-if="isAuthenticated"><router-link to="/dashboard">Dashboard</router-link></li> -->
        <!-- <li v-if="isAuthenticated"><a @click.prevent="logout">Logout</a></li> -->
        </ul>
    </nav>
    </template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../Stores/AuthStore'
import { useRouter } from 'vue-router'
import { computed } from 'vue';

const authStore = useAuthStore()
// const isAuthenticated = ref(authStore.isAuthenticated)


const isAuthenticated = computed(() => authStore.isAuthenticated);


const router = useRouter()




const logout = async () => {
  await authStore.logout()
  isAuthenticated.value = false
  router.push('/login')
}
</script>


    <style scoped>
nav {

}
    </style>
