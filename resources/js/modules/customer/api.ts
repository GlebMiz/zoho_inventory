import axios from 'axios';
import type { CustomerPayload } from './types';
import { Customer } from './types';
export const createCustomer = (data: CustomerPayload) => {
    return axios.post('/customers', data);
};
