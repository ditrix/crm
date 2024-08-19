import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'


export default function useContracts() {


    const router = useRouter();

    const errors = '';

    const contracts = ref([]);

    const contract = ref({status:{}, statuses:{}});

    const pagination = ref({});

    // TODO: move to config
    axios.defaults.baseURL = 'http://localhost/api';



    const setPaginationData = (data) => {

        pagination.value = {

            first_url: data.links.first,
            last_url: data.links.last,
            next_url: data.links.next,
            prev_url: data.links.prev,
            last_page: data.meta.last_page,
            links: data.meta.links,
            total: data.meta.total
        }
    }

    const getContract = async (id) => {
        if (!id) {
            console.warn('ID is missing');
            return
        }

        //console.log('getContract')
        try {
            let response = await axios.get(`contracts/${id}`)
            contract.value = response.data.data;
            console.log(response.data)
        } catch (error) {
            console.log('get contract error: ', error.message)
        }
    }

    const getContracts = async (page = 1) => {

//        console.log(process.env.VUE_APP_API_BASE_URL);

        try {

       //let response = await axios.get('/api/contracts');

       let response = await axios.get(`contracts?page=${page}`);
        contracts.value =  response.data.data;
        setPaginationData(response.data)
        } catch(error) {
            console.log('get data error: ', error.message)
        }

    }

    const getContractsFromLink = async (url) => {
        if(!url) {
            return;
        }
        try {
          let response = await axios.get(url);
          contracts.value = response.data.data;
          pagination.value = response.data;
          setPaginationData(response.data)
        } catch (error) {
          console.error('get data error: ', error);
        }
      }

    const updateContract = async (id) => {

        //axios.defaults.baseURL = 'http://localhost/api';
        //axios.defaults.baseURL = process.env.VUE_APP_API_BASE_URL

        try {

            let response = await axios.put(`contracts/${id}`,contract.value);
            console.log(response);

        } catch(error) {
             console.log('get data error: ', error.message)
            // if (error.response.status === 422) {
            //     for (const key in error.response.data.errors) {
            //         errors.value = error.response.data.errors
            //     }
            // } else {
            //     console.log('get data error: ', error.message)
            // }
        }

    }


    const nextPage = () => {

        if (pagination.value.next_url) {
            getContracts(pagination.value.current_page + 1);
        }
      };

      const prevPage = () => {
        if (pagination.value.prev_url) {
            getContracts(pagination.value.current_page - 1);
        }
      };

    return {
        pagination,
        contracts,
        contract,
        nextPage,
        prevPage,
        getContracts,
        getContract,
        getContractsFromLink,
        updateContract,
    }

}
