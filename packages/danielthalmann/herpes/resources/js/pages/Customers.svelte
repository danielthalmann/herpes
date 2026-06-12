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

    let components: FormComponent = $state.raw([
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

    let selectedCustomer: any = $state.raw(null);

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
        fetch(api + "?paginate=" + context.perpage + '&search=' + context.search).then((response) => {
            response.json().then((json) => {
                customers = json;
            });
        });
    };

    const updateRow = (customer: any) => {
        let index = customers!.data.findIndex((customerItem: any) => {
            return customer!.id === customerItem.id;
        });
        if (index > -1) {
            customers!.data[index] = customer;
        }
        selectedCustomer = null;
    };

    const deleteRow = (customer: any) => {
        let index = customers!.data.findIndex((customerItem: any) => {
            return customer!.id === customerItem.id;
        });
        if (index > -1) {
            customers!.data.splice(index, 1);
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
            onsearch={searchRows}
            onedit={(row) => {
                selectedCustomer = JSON.parse(JSON.stringify(row));
            }}
        />
    {/if}

    <Dialog title="Edit" open={selectedCustomer ? true: false}>

        <div class="mb-5">
            <Form
                bind:data={selectedCustomer}
                components={components}
                onchange={(key) => {
                }}
            />
        </div>
        <div class="border-b mb-5 border-neutral-400"></div>

        <div class="mb-3 text-right">
            <Button
                variant="primary"
                onclick={() => {
                    updateRow(selectedCustomer);
                }}>Save
            </Button>
            <Button
                onclick={() => {
                    selectedCustomer = null;
                }}>Close
            </Button>
        </div>

    </Dialog>


</div>
