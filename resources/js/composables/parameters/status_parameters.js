import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useStatusParameters() {

    const router = useRouter();

    const errors = ref('');

    const status_parameters = ref([]);

    const status_parameter = ref([]);

    const getStatusParameters = async () => {


        let response = await axios.get('/api/parameter_status');

        status_parameters.value = response.data.data;

    }

    const getStatusParameter = async (id) => {

            if (!id) {
                console.warn('ID is missing');
                return
            }

           try {
                const response = await axios.get(`/api/parameter_status/${id}`);

                status_parameter.value = response.data.data;

            } catch (error) {
                console.error('error fetch data: ',error)
            }

    }

    const updateStatusParameter = async  (id) => {

        if (!id) {
            console.warn('ID is missing');
            return
        }

        errors.value = ''

        try {

            await axios.put(`/api/parameter_status/${id}`,status_parameter.value)
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

    const storeParameter = async (data) => {
        errors.value = ''

        try {
            let response = await axios.post(`/api/parameter_status`, data);
            await router.push({ name: 'parameters.index' });

        } catch(error) {
            console.error('error post data',error);
            if (error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value = error.response.data.errors
                }
            }
        }
    }

    const destroyStatusParameter = async (id) => {

        let response = await axios.delete(`/api/parameter_status/${id}`);

    }


    return {
        errors,
        status_parameters,
        status_parameter,
        getStatusParameters,
        getStatusParameter,
        updateStatusParameter,
        storeParameter,
        destroyStatusParameter,
    }

}
