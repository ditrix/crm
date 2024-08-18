import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useContracts() {

    const router = useRouter();

    const contracts = ref([]);

    const pagination = ref({});

    const setPaginationData = (data) => {
        console.log(data.meta.links)
        pagination.value = {
            current_page: data.meta.current_page,
            first_url: data.links.first,
            last_url: data.links.last,
            next_url: data.links.next,
            prev_url: data.links.prev,
            last_page: data.meta.last_page,
            links: data.meta.links,
            total: data.meta.total
        }
    }

    const getContracts = async (page = 1) => {

        try {
        let response = await axios.get(`api/contracts?page=${page}`);
        contracts.value =  response.data.data;
        setPaginationData(response.data)
        } catch(error) {
            console.log('get data error: ', error.message)
        }

    }


    const getContractsFromLink = async (url) => {
        if (!url) return;
        console.log(url);
        return;
        try {
          const response = await axios.get(url);
          contracts.value = response.data.data;
          pagination.value = response.data;
        } catch (error) {
          console.error('Ошибка при получении данных:', error);
        }
      };


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
        nextPage,
        prevPage,
        getContracts,
        getContractsFromLink,
    }

}
