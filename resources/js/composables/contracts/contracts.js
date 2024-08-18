import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useContracts() {

    const router = useRouter();

    const contracts = ref([]);

    // TODO: для связанных объектов создать пустышки

    const getContracts = async () => {

        console.log('getContracts');

        let response = await axios.get('api/contracts');

        contracts.value =  response.data.data;
        console.log(contracts.value);
    }

    return {
        contracts,
        getContracts
    }

}
