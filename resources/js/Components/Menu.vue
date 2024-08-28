<template>
    <nav  v-if="isAuthenticated">
    <ul class="text-sm">
         <li>
            <div class="px-6">
                <div class="page_title text-xl mb-2 mt-4">SPA Crm</div>
            </div>
        </li>
        <li><router-link to="/dashboard">Dashboard</router-link></li>
        <li><router-link to="/customers">Customers</router-link></li>
        <li><router-link to="/contracts">Contracts</router-link></li>
        <li><router-link to="/reports">Reports</router-link></li>
        <li><router-link to="/parameters">Parameters</router-link></li>
        <li><router-link to="/users">Users</router-link></li>
        <li><router-link to="/permissions">Permissions</router-link></li>
        <li><router-link to="/settings">Settings</router-link></li>
        <!-- <li v-if="!isAuthenticated"><router-link to="/login">Login</router-link></li> -->
        <!-- <li v-if="!isAuthenticated"><router-link to="/register">Register</router-link></li>
        <li v-if="isAuthenticated"><router-link to="/dashboard">Dashboard</router-link></li> -->
        <li v-if="isAuthenticated" class="py-2"><a class="btn_red px-2 py-1 border" @click.prevent="logout">Logout</a></li>
        </ul>
    </nav>
    </template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../Stores/AuthStore'
import { useRouter } from 'vue-router'
import { computed } from 'vue';

const authStore = useAuthStore()

const isAuthenticated = computed(() => authStore.isAuthenticated);

const router = useRouter()




const logout = async () => {
  await authStore.logout()
  isAuthenticated.value = false
  router.push('/login')
}
</script>

