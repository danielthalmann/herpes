export type AddressType = {
    city?: string;
    company?: string;
    customer_id: string;
    department?: string;
    id: string;
    name?: string;
    street?: string;
    zipcode?: string;
    created_at?: string;
    updated_at?: string;
}

export type CustomerType = {
    id: string;
    name: string;
    addresses?: Array<AddressType>;
    created_at?: string;
    updated_at?: string;
    deleted_at?: string;
}
