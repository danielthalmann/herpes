
export type PaginateLink = Array<{
    url: string | null;
    label: string;
    page: number | null;
    active: boolean;
}>;

export type Paginate = {
    current_page: number;
    data: Array<any>;
    first_page_url: string | null;
    from: number;
    last_page: number;
    last_page_url: string | null;
    links: PaginateLink;
    next_page_url: null;
    path: string | null;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
};
