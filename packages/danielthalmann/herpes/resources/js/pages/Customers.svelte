

<script lang="ts">
    import { onMount } from "svelte";
    import Table, { type TableColumn } from "../components/table/Table.svelte";
    import Arianne from "../components/layouts/Arianne.svelte";
    import Form, { type FormComponent } from "../components/Form.svelte";

    let {
        api
    } = $props();

    let columns : TableColumn & FormComponent = $state.raw([
        {
            key : 'id',
            label : 'id',
            className: 'w-12',
            type: 'text'
        },{
            key : 'name',
            label : 'Nom',
            type: 'text',
            required : true
        }
    ]);

    let customers = $state([]);

    let customer = $state.raw(null);

    onMount(() => {

        fetch(api).then((response) => {
            response.json().then((json) => {
                customers = json;
            });
        });
    });

</script>

<div>

    <Arianne></Arianne>
    <Table rows={customers} columns={columns} onshow={(row) => { customer = row }} ></Table>
    {#if customer}
        <Form bind:data={customer} components={columns} />
    {/if}

</div>
