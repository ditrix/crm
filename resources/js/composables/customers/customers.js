import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

export default function useCustomers() {

    const router = useRouter();

    const errors = ref('');

    const customers = ref([]);

    const pagination = ref({});

    // для связанных объектов создаем пустышки
    const customer = ref({user:{}, users: {}});

    const getCustomers = async (page = 1) => {

        let response = await axios.get(`customers?page=${page}`);
        setPaginationData(response.data)
        customers.value = response.data.data;


    }


    const getCustomer = async (id) => {

            if (!id) {
                console.warn('ID is missing');
                return
            }

           try {
                const response = await axios.get(`customers/${id}`);

                customer.value = response.data.data;

            } catch (error) {
                console.error('error fetch data: ',error)
            }

    }

    const updateCustomer = async  (id) => {

        if (!id) {
            console.warn('ID is missing');
            return
        }

        errors.value = ''

        try {

            await axios.put(`customers/${id}`, customer.value);

        }
        catch(error) {

            if (error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value = error.response.data.errors
                }
            }
        }

    }

    const storeCustomer = async (data) => {
        errors.value = ''

        try {
            let response = await axios.post(`customers`, data);
            await router.push({ name: 'customers.index' });

        } catch(error) {
            console.error('error post data',error);
            if (error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value = error.response.data.errors
                }
            }
        }
    }

    const destroyCustomer = async (id) => {

        let response = await axios.delete(`customers/${id}`);

    }

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
        console.log('pagination.value',pagination.value);
    }

    const getCistomersFromLink = async (url) => {
        if(!url) {
            return;
        }
        try {
          let response = await axios.get(url);
          customers.value = response.data.data;
          pagination.value = response.data;
          console.log(customers.value);
          setPaginationData(response.data)
        } catch (error) {
          console.error('get data error: ', error);
        }
      }


      const nextPage = () => {
        console.log('nextPage');
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
        errors,
        customers,
        customer,
        pagination,
        getCustomers,
        getCustomer,
        getCistomersFromLink,
        updateCustomer,
        storeCustomer,
        destroyCustomer,
        nextPage,
        prevPage
    }

}
