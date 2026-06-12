<script lang="ts">
    import { onMount } from "svelte";
    import Table, { type TableColumn } from "../components/Table.svelte";
    import Breadcrumb from "../components/Breadcrumb.svelte";
    import Form, { type FormComponent } from "../components/Form.svelte";
    import Button from "../components/Button.svelte";
    import { type Paginate } from "../types/Laravel";
    import { type CustomerType } from "../types/App";
    import Dialog from "../components/Dialog.svelte";
    import { decodeHTML } from "../Utils/Encoding";

    export type TableContext = {
        page: number;
        perpage: number;
        search: string;
    };

    export type CrudProps = {
        api: any;
        tablecolumns: TableColumn;
        createComponents: FormComponent;
        editComponents: FormComponent;
    };

    let {
        api,
        tablecolumns,
        createComponents,
        editComponents
    } : CrudProps = $props();

    let rows: Paginate | undefined = $state();
    let selectedRow: any | null = $state.raw(null);
    let newRow: any | null = $state.raw(null);

    onMount(() => {
        loadRows();

    });

    let context : TableContext = {
        page: 1,
        perpage : 20,
        search : ''
    };

    const changePage = (page: number = 1) => {
        context.page = page;
        loadRows();
    };

    const changePerPage = (perpage: number = 20) => {
        context.page = 1;
        context.perpage = perpage;
        loadRows();
    };

    const loadRows = () => {
        fetch(api.index + "?paginate=" + context.perpage + '&page=' + context.page + '&search=' + context.search).then((response) => {
            response.json().then((json) => {
                rows = json;
            });
        });
    };

    const addRow = (customer: CustomerType) => {

        const fetchOptions: RequestInit = {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(customer)
        }
        fetch((<string>api.store).replace('|id|', customer.id!), fetchOptions)
        .then(response => {
            loadRows();
        });

        newRow = null;
    };

    const updateRow = (customer: CustomerType) => {
        let index = rows!.data.findIndex((customerItem: any) => {
            return customer!.id === customerItem.id;
        });
        if (index > -1) {
            const fetchOptions: RequestInit = {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(customer)
            }
            fetch((<string>api.update).replace('|id|', customer.id!), fetchOptions)
            .then(response => {
                rows!.data[index] = customer;
            });
        }
        selectedRow = null;
    };
    const createRow = () => {
        newRow = {
            name: ''
        };
    };
    const editRow = (customer: CustomerType) => {
        selectedRow = JSON.parse(JSON.stringify(customer));
    };

    const openRow = (customer: CustomerType) => {
        document.location.href = (<string>api.open).replace('|id|', customer.id!);
    };

    const deleteRow = (customer: CustomerType) => {
        let index = rows!.data.findIndex((customerItem: any) => {
            return customer!.id === customerItem.id;
        });
        if (index > -1) {
            const fetchOptions: RequestInit = {
                method: 'DELETE'
            }
            fetch((<string>api.destroy).replace('|id|', customer.id!), fetchOptions)
            .then(response => {
                rows!.data.splice(index, 1);
            });
        }
    };

    const searchRows = (search: string) => {
        context.search = search;
        loadRows();
    }


</script>

<div>
    <Breadcrumb breadcrumb={JSON.parse(decodeHTML(api.breadcrumb ?? '[]'))} />
    {#if rows}
        <Table
            title={api.name}
            rows={rows!.data}
            columns={tablecolumns}
            perpage={rows.per_page}
            currentpage={rows.current_page}
            lastpage={rows.last_page}
            total={rows.total}
            onchangepage={changePage}
            onchangeperpage={changePerPage}
            onopen={api.open ? openRow : undefined}
            ondelete={deleteRow}
            oncreate={createRow}
            onsearch={searchRows}
            onedit={editRow}
        />
    {/if}

    <Dialog title="Edit" open={selectedRow ? true: false}>

        <div class="mb-5">
            <Form
                bind:data={selectedRow!}
                components={editComponents}
                onchange={(key) => {
                }}
            />
        </div>
        <div class="border-b mb-5 border-neutral-400"></div>

        <div class="mb-3 text-right">
            <Button
                variant="primary"
                onclick={() => {
                    updateRow(selectedRow!);
                }}>Save
            </Button>
            <Button
                onclick={() => {
                    selectedRow = null;
                }}>Close
            </Button>
        </div>

    </Dialog>

    <Dialog title="Create" open={newRow ? true: false}>

        <div class="mb-5">
            <Form
                bind:data={newRow}
                components={createComponents}
                onchange={(key) => {
                }}
            />
        </div>
        <div class="border-b mb-5 border-neutral-400"></div>

        <div class="mb-3 text-right">
            <Button
                variant="primary"
                onclick={() => {
                    addRow(newRow!);
                }}>Save
            </Button>
            <Button
                onclick={() => {
                    newRow = null;
                }}>Close
            </Button>
        </div>

    </Dialog>

</div>
