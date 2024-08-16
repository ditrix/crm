<template>
    <div>
     dashboard
    </div>
  </template>

  <script setup>
  import { computed } from 'vue'
  import { useAuthStore } from '../Stores/AuthStore'

  const authStore = useAuthStore()
//  const user = computed(() => authStore.user)

  const props = defineProps({
  user: {
    type: Object,
    required: true
  }

})


  </script>

  <style scoped>
  /* Стили для компонента профиля пользователя */
  </style>
