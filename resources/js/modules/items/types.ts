export type ListItem = {
    details: Item | string | null;
    quantity: string;
    rate: string;
};

export type Item = {
    id: string;
    name: string;
    sku: string;
    rate: number;
    purchase_rate?: number;
    description?: string;
    stock_on_hand?: number;
};
