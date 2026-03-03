export type Customer = {
    id: string;
    name: string;
    email: string;
};

export type CustomerPayload = {
    name: string | null;
    email: string | null;
    phone: string | null;
};
