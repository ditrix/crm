import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useUsers() {

    const router = useRouter();

    const errors = ref('');

    const message = ref('');

    const users = ref([]);

    const user = ref([]);

    const permissions = ref([]);

    const getUsers = async () => {

        try {

            let response = await axios.get('api/users');

            users.value = response.data.data;

        } catch(error) {
            console.error('error fetch data: ',error)
        }
    }

    const getUser = async (id) => {

        if (!id) {
            console.warn('ID is missing');
            return
        }

        try {
            const response = await axios.get(`/api/users/${id}`);
            user.value = response.data.data;

        } catch (error) {
            console.error('error fetch data: ',error)
        }

    }

    const updateUser = async  (id) => {

        if (!id) {
            console.warn('ID is missing');
            return
        }

        errors.value = ''

        try {

            await axios.put(`/api/users/${id}`,user.value)
        }
        catch(error) {
            console.error('error put data: ',error)
            if (error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value = error.response.data.errors
                }
            }
        }

    }

    const storeUser = async (data) => {
        errors.value = ''

        try {


            let response = await axios.post(`/api/users`, data);
            await router.push({ name: 'users.index' });

        } catch(error) {
            console.error('error post data',error);
            if (error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value = error.response.data.errors
                }
            }
        }
    }

    const getPermissions = async () => {

        try {
            const permissionsResponse = await axios.get('/api/permissions');
            permissions.value = permissionsResponse.data.data;

        } catch(error) {
            console.error('error fetch data: ',error)
        }

    }

    return {
        errors,
        users,
        user,
        permissions,
        getUsers,
        getUser,
        updateUser,
        storeUser,
        getPermissions,
    }

}
