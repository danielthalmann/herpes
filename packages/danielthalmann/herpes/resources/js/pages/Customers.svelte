

<script lang="ts">
    import { onMount } from "svelte";
    import Table, { type TableColumn } from "../components/table/Table.svelte";
    import Arianne from "../components/layouts/Arianne.svelte";
    import Form, { type FormComponent } from "../components/Form.svelte";
    import Button from "../components/Button.svelte";

    let {
        api
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
        }
    ]);

    let customers : Array<any> = $state([]);

    let selectedCustomer : any = $state.raw(null);

    onMount(() => {
        fetch(api).then((response) => {
            response.json().then((json) => {
                customers = json;
            });
        });
    });

    const updateCustomer = (customer : any) => {

        let index = customers.findIndex((customerItem: any) => { return customer!.id === customerItem.id;});
        if (index > -1) {
            customers[index] = customer;
        }
        selectedCustomer = null;

    }

    const deleteCustomer = (customer : any) => {

        let index = customers.findIndex((customerItem: any) => { return customer!.id === customerItem.id;});
        console.log(index);
        if (index > -1) {
            customers.splice(index, 1);
        }

    }

</script>

<div>

    <Arianne></Arianne>
    <Table rows={customers} columns={columns} ondelete={deleteCustomer} onshow={(row) => { selectedCustomer = JSON.parse(JSON.stringify(row)) }} ></Table>
    {#if selectedCustomer}
        <Form bind:data={selectedCustomer} components={columns} onchange={(key) => { console.log(key) }} />
        <Button variant="primary" onclick={() => {updateCustomer(selectedCustomer)}}>Save</Button>
        <Button onclick={() => {selectedCustomer = null}}>Close</Button>
    {/if}

</div>
