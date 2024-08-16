<template>
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
      <h1>Login</h1>
      <form @submit.prevent="submit">
        <div>
          <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
          <input
            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            id="email" v-model="form.email" type="email" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
          <input
             class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
             id="password" v-model="form.password" type="password" />
        </div>
        <button
            class="btn btn_blue inline-flex items-center ml-1  font-semiboldtext-sm font-medium mt_2"
            type="submit">Login</button>
      </form>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'
  import { useAuthStore } from '../../Stores/AuthStore'
  import { useRouter } from 'vue-router'

  const form = ref({
    email: '',
    password: ''
  })

  const authStore = useAuthStore()
  const router = useRouter()

  const submit = async () => {
    await authStore.login(form.value)
    if (authStore.isAuthenticated) {
      router.push('/dashboard')
    }
  }
  </script>

  <style scoped>
  /* Стили для страницы входа */
  </style>
