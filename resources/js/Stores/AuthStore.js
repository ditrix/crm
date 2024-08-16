    import { defineStore } from 'pinia'
    import axios from 'axios'

    export const useAuthStore = defineStore('auth', {
    state: () => ({

        user: null,
        isAuthenticated: !!localStorage.getItem('user'),
        //user: JSON.parse(sessionStorage.getItem('user')) || null,
    // isAuthenticated: !!sessionStorage.getItem('user'),

    }),

    actions: {
        async login(credentials) {
        try {
            await axios.get('/sanctum/csrf-cookie')
            const response = await axios.post('/login', credentials)

            this.user = response.data.user
            this.isAuthenticated = true
        //  sessionStorage.setItem('user', JSON.stringify(this.user))
            localStorage.setItem('user', JSON.stringify(this.user))


        } catch (error) {
            console.error('Login failed:', error)
            this.isAuthenticated = false
        }
        },
        async logout() {
        try {
            await axios.post('/logout')
            this.user = null
            this.isAuthenticated = false
            localStorage.removeItem('user')
            //sessionStorage.removeItem('user')

        } catch (error) {

            console.error('Logout failed:', error)
        }
        },

        async checkAuth() {
        try {
            await axios.get('/sanctum/csrf-cookie')
            const response = await axios.get('/api/user')
            this.user = response.data
            this.isAuthenticated = true

            localStorage.setItem('user', JSON.stringify(this.user))
            //sessionStorage.setItem('user', JSON.stringify(this.user))

        } catch (error) {

            if (error.response && error.response.status === 401) {
                // Ожидаемый случай - пользователь не авторизован
                console.log('User not authenticated, proceeding to login form.');
             } else {
                console.error('Failed to check authentication:', error)
             }

            this.isAuthenticated = false
            localStorage.removeItem('user')
            //sessionStorage.removeItem('user')
            }
        }
    }
    })
