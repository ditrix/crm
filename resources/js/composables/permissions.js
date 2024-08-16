import { ref } from 'vue'
import axios from 'axios'
import { useRouter, useRoute } from 'vue-router'

export default function usePermisiions() {

    const router = useRouter();

    const permissions = ref([]);
    const permission = ref([]);

    const getPermissions = async () => {

        try {

            let response = await axios.get('api/permissions');
            permissions.value = response.data.data;

        } catch(error) {
            console.error('error fetch data: ',error)
        }

    }

    const getPermission = async (id) => {

        if (!id) {
            console.warn('ID is missing');
            return
        }

        try {
            const response = await axios.get(`/api/permissions/${id}`)
            permission.value = response.data.data

        }
        catch(error) {
            console.log('error fetch data: ',error)
        }

    }

    const updatePermission = async  (id) => {

        if (!id) {
            console.warn('ID is missing');
            return
        }

        try {

            await axios.put(`/api/permissions/${id}`,permission.value)
        }
        catch(error) {
            console.log('error put data: ',error)
        }

    }

    return {
        permissions,
        permission,
        getPermission,
        getPermissions,
        updatePermission,
    }

}
