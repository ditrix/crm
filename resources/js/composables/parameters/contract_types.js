import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useContractTypes() {

    const router = useRouter();

    const errors = ref('');

    const contract_types = ref([]);

    const contract_type = ref([]);

    const getContractTypes = async () => {

        let response = await axios.get('/api/contract_type');

        contract_types.value = response.data.data;


    }

    const getContractType = async (id) => {

            if (!id) {
                console.warn('ID is missing');
                return
            }

           try {
                const response = await axios.get(`/api/contract_type/${id}`);

                contract_type.value = response.data.data;

            } catch (error) {
                console.error('error fetch data: ',error)
            }

    }

    const updateContractType = async  (id) => {

        if (!id) {
            console.warn('ID is missing');
            return
        }

        errors.value = ''

        try {

            await axios.put(`/api/contract_type/${id}`,contract_type.value)
        }
        catch(error) {

            if (error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value = error.response.data.errors
                }
            }
        }

    }

    const storeContractType = async (data) => {
        errors.value = ''

        try {
            let response = await axios.post(`/api/contract_type`, data);
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

    const destroyContractType = async (id) => {

        let response = await axios.delete(`/api/contract_type/${id}`);

    }


    return {
        errors,
        contract_types,
        contract_type,
        getContractTypes,
        getContractType,
        updateContractType,
        storeContractType,
        destroyContractType,
    }

}
