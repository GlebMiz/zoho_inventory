import axios from 'axios';
export const createSalesOrder = (data) => {
    return axios.post('/', data);
};
