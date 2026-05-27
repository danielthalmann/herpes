

<script lang="ts">
    import { onMount } from "svelte";
    import Table, { type TableColumn } from "../components/Table.svelte";
    import Arianne from "../components/layouts/Arianne.svelte";
    import Form, { type FormComponent } from "../components/Form.svelte";
    import Button from "../components/Button.svelte";


    type PaginateLink = Array<{
        url: String | null;
        label: String;
        page: Number | null;
        active: boolean
    }>

    type Paginate = {
        current_page: Number;
        data: Array<any>;
        first_page_url: String | null;
        from: Number;
        last_page: Number;
        last_page_url: String | null;
        links: PaginateLink;
        next_page_url: null;
        path: String | null;
        per_page: Number;
        prev_page_url: String | null;
        to: Number;
        total: Number;
    }

    let {
        api,
    } = $props();

    let columns : TableColumn & FormComponent = $state.raw([
        {
            key : 'id',
            label : 'id',
            className: 'w-12',
            type: 'text',
            readonly: true
        },{
            key : 'name',
            label : 'Nom',
            type: 'text',
            required : true
        },{
            key : 'addresses',
            label : 'Adresse',
            type: 'table',
            required : false,
            columns : [
                {
                    key : 'company',
                    label : 'company',
                    type: 'text'
                },{
                    key : 'department',
                    label : 'department',
                    type: 'text'
                },{
                    key : 'name',
                    label : 'name',
                    type: 'text'
                },{
                    key : 'street',
                    label : 'street',
                    type: 'text'
                },{
                    key : 'zipcode',
                    label : 'zipcode',
                    type: 'text'
                },{
                    key : 'city',
                    label : 'city',
                    type: 'text'
                },
            ]
        }

    ]);

    let customers : Paginate | undefined = $state();

    let selectedCustomer : any = $state.raw(null);

    onMount(() => {
        loadCustomer();
    });

    const changePerPage = (perpage : Number = 20) => {
        loadCustomer(perpage);
    };

    const loadCustomer = (perpage : Number = 20) => {
        fetch(api + '?paginate=' + perpage).then((response) => {
            response.json().then((json) => {
                customers = json;
            });
        });
    }

    const updateCustomer = (customer : any) => {

        let index = customers!.data.findIndex((customerItem: any) => { return customer!.id === customerItem.id;});
        if (index > -1) {
            customers!.data[index] = customer;
        }
        selectedCustomer = null;

    }

    const deleteCustomer = (customer : any) => {
        let index = customers!.data.findIndex((customerItem: any) => { return customer!.id === customerItem.id;});
        console.log(index);
        if (index > -1) {
            customers!.data.splice(index, 1);
        }
    }

</script>

<div>

    <Arianne></Arianne>
    {#if customers}
        <Table rows={customers!.data} columns={columns} perpage={customers.per_page} onchangeperpage={changePerPage} ondelete={deleteCustomer} onshow={(row) => { selectedCustomer = JSON.parse(JSON.stringify(row)) }} ></Table>
    {/if}
    {#if selectedCustomer}
        <Form bind:data={selectedCustomer} components={columns} onchange={(key) => { console.log(key) }} />
        <Button variant="primary" onclick={() => {updateCustomer(selectedCustomer)}}>Save</Button>
        <Button onclick={() => {selectedCustomer = null}}>Close</Button>
    {/if}

</div>
