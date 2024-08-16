<template>
    <div class="container top--menu flex justify-between">

            <div class="px-6">
                <div class="page_title text-xl mb-2 mt-4">SPA Crm</div>
            </div>
            <ul class="px-6">
                <li v-if="isAuthenticated" class="py-4">
                    <a @click.prevent="logout">
                        <span class="text-md px-2 py-2 font-semibold">Logout</span>
                    </a>
                </li>
            </ul>

    </div>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '../Stores/AuthStore'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()


const router = useRouter()

const isAuthenticated = computed(() => authStore.isAuthenticated);

//const userEmail = computed(() => authStore.user ? authStore.user.email : '');

const logout = async () => {
  await authStore.logout()
  isAuthenticated.value = false
  router.push('/login')
}
</script>

