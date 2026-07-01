export type TimesheetType = {
    id?: string;
    ticket_id?: string;
    start?: string;
    end?: string;
    comment?: string;
    created_at?: string;
    updated_at?: string;
};

export type TicketType = {
    id?: string;
    type?: string;
    status?: string;
    summary?: string;
    description?: string;
    customer_id?: string;
    parent_id?: string;
    reporter_id?: number;
    assignee_id?: number;
    times?: number;
    eval_times?: string;
    invoice?: boolean;
    invoiced_at?: string;
    created_at?: string;
    updated_at?: string;
};

export type AddressType = {
    city?: string;
    company?: string;
    customer_id?: string;
    department?: string;
    id?: string;
    name?: string;
    firstname?: string;
    street?: string;
    zipcode?: string;
    created_at?: string;
    updated_at?: string;
}

export type CustomerType = {
    id?: string;
    name?: string;
    addresses?: Array<AddressType>;
    created_at?: string;
    updated_at?: string;
    deleted_at?: string;
}
