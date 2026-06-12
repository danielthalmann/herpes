<script lang="ts">
    import { onMount } from "svelte";
    import Table, { type TableColumn } from "../components/Table.svelte";
    import Arianne from "../components/layouts/Arianne.svelte";
    import Form, { type FormComponent } from "../components/Form.svelte";
    import Button from "../components/Button.svelte";
    import { type Paginate } from "../types/Laravel";
    import { type CustomerType } from "../types/App";
    import Dialog from "../components/Dialog.svelte";


    let { api } = $props();

    type TableContext = {
        perpage: number;
        search: string;
    };

    let tablecolumns: TableColumn = $state.raw([
        {
            key: "id",
            label: "id",
            type: "id",
        },
        {
            key: "name",
            label: "Nom",
            type: "text",

        },
        {
            key: "addresses",
            label: "Adresse",
            type: "fn",
            escaped: true,
            computed : (row : CustomerType) => {
                console.log(row);
                let ret : string = '';
                let index : number = 0;
                row.addresses!.forEach((address) => {
                    index++;
                    ret += address.company ? address.company + '<br/>' : '';
                    ret += address.name + '<br/>';
                    ret += address.street ? address.street + '<br/>' : '';
                    ret += address.zipcode ? address.zipcode + ' ' + address.city + '<br/>' : '';
                    if(index < (row.addresses?.length ?? 0)) {
                        ret += '<br/>';
                    }
                });
                return ret;
            }
        }
    ]);

    let createComponents: FormComponent = $state.raw([
        {
            key: "name",
            label: "Nom",
            type: "text",
            required: true,
        }
    ]);

    let editComponents: FormComponent = $state.raw([
        {
            key: "id",
            label: "id",
            className: "w-12",
            type: "text",
            readonly: true,
        },
        {
            key: "name",
            label: "Nom",
            type: "text",
            required: true,
        }
        /*
        ,
        {
            key: "addresses",
            label: "Adresse",
            type: "table",
            required: false,
            columns: [
                {
                    key: "company",
                    label: "company",
                    type: "text"
                },
                {
                    key: "department",
                    label: "department",
                    type: "text"
                },
                {
                    key: "name",
                    label: "name",
                    type: "text"
                },
                {
                    key: "street",
                    label: "street",
                    type: "text"
                },
                {
                    key: "zipcode",
                    label: "zipcode",
                    type: "text"
                },
                {
                    key: "city",
                    label: "city",
                    type: "text"
                }
            ]
        }
        */
    ]);

    let customers: Paginate | undefined = $state();

    let selectedCustomer: CustomerType | null = $state.raw(null);
    let newCustomer: CustomerType | null = $state.raw(null);

    onMount(() => {
        loadRows();
    });

    let context : TableContext = {
        perpage : 20,
        search : ''
    };

    const changePerPage = (perpage: number = 20) => {
        context.perpage = perpage;
        loadRows();
    };

    const loadRows = () => {
        fetch(api.index + "?paginate=" + context.perpage + '&search=' + context.search).then((response) => {
            response.json().then((json) => {
                customers = json;
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
        fetch((<string>api.store).replace('|id|', customer.id), fetchOptions)
        .then(response => {
            loadRows();
        });

        newCustomer = null;
    };

    const updateRow = (customer: CustomerType) => {
        let index = customers!.data.findIndex((customerItem: any) => {
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
            fetch((<string>api.update).replace('|id|', customer.id), fetchOptions)
            .then(response => {
                customers!.data[index] = customer;
            });
        }
        selectedCustomer = null;
    };
    const createRow = (customer: CustomerType) => {
        newCustomer = {
            name: ''
        };
    };
    const editRow = (customer: CustomerType) => {
        selectedCustomer = JSON.parse(JSON.stringify(customer));
    };

    const deleteRow = (customer: CustomerType) => {
        let index = customers!.data.findIndex((customerItem: any) => {
            return customer!.id === customerItem.id;
        });
        if (index > -1) {
            const fetchOptions: RequestInit = {
                method: 'DELETE'
            }
            fetch((<string>api.destroy).replace('|id|', customer.id), fetchOptions)
            .then(response => {
                customers!.data.splice(index, 1);
            });
        }
    };

    const searchRows = (search: string) => {
        context.search = search;
        loadRows();
    }

</script>

<div>
    <Arianne></Arianne>
    {#if customers}
        <Table
            rows={customers!.data}
            columns={tablecolumns}
            perpage={customers.per_page}
            onchangeperpage={changePerPage}
            ondelete={deleteRow}
            oncreate={createRow}
            onsearch={searchRows}
            onedit={editRow}
        />
    {/if}

    <Dialog title="Edit" open={selectedCustomer ? true: false}>

        <div class="mb-5">
            <Form
                bind:data={selectedCustomer!}
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
                    updateRow(selectedCustomer!);
                }}>Save
            </Button>
            <Button
                onclick={() => {
                    selectedCustomer = null;
                }}>Close
            </Button>
        </div>

    </Dialog>


    <Dialog title="Create" open={newCustomer ? true: false}>

        <div class="mb-5">
            <Form
                bind:data={newCustomer}
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
                    addRow(newCustomer!);
                }}>Save
            </Button>
            <Button
                onclick={() => {
                    newCustomer = null;
                }}>Close
            </Button>
        </div>

    </Dialog>

</div>
