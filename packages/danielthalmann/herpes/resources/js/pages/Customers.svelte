

<script lang="ts">
    import { onMount } from "svelte";
    import Table from "../components/table/Table.svelte";
    import Arianne from "../components/layouts/Arianne.svelte";
    onMount(() => {
        console.log('mount');
    });

</script>

<div>

    <Arianne></Arianne>
    <Table></Table>

</div>
