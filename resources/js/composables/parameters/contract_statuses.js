import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useContractStatuses() {

    const router = useRouter();

    const errors = ref('');

    const contract_statuses = ref([]);

    const contract_status = ref([]);

    const getContractStatuses = async () => {


        let response = await axios.get('contract_status');

        contract_statuses.value = response.data.data;

    }

    const getContractStatus = async (id) => {

            if (!id) {
                console.warn('ID is missing');
                return
            }

           try {
                const response = await axios.get(`contract_status/${id}`);

                contract_status.value = response.data.data;

            } catch (error) {
                console.error('error fetch data: ',error)
            }

    }

    const updateContractStatus = async  (id) => {

        if (!id) {
            console.warn('ID is missing');
            return
        }

        errors.value = ''

        try {

            await axios.put(`contract_status/${id}`,contract_status.value)
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

    const storeContractStatus = async (data) => {
        errors.value = ''

        try {
            let response = await axios.post(`contract_status`, data);
            await router.push({ name: 'contract_statuses.index' });

        } catch(error) {
            console.error('error post data',error);
            if (error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value = error.response.data.errors
                }
            }
        }
    }

    const destroyContractStatus = async (id) => {

        let response = await axios.delete(`contract_status/${id}`);

    }


    return {
        errors,
        contract_statuses,
        contract_status,
        getContractStatuses,
        getContractStatus,
        updateContractStatus,
        storeContractStatus,
        destroyContractStatus,
    }

}
