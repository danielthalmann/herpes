

<script lang="ts">
    import { onMount } from "svelte";
    import Table, { TableColumn } from "../components/table/Table.svelte";
    import Arianne from "../components/layouts/Arianne.svelte";

    let {
        api
    } = $props();

    let columns : TableColumn = $state.raw([
        {
            key : 'id',
            label : 'id',
            className: 'w-12'
        },{
            key : 'name',
            label : 'Nom'
        }
    ]);

    let customers = $state([]);

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
    <Table rows={customers} columns={columns}></Table>

</div>
