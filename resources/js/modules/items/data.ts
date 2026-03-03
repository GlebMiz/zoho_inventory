import type { ListItem } from './types';

export const createEmptyListItem = (): ListItem => ({
    details: null,
    quantity: '1.00',
    rate: '0.00',
});
