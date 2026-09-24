<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import Crud from "../components/Crud.svelte";

    let { api } = $props();

    let tablecolumns: TableColumn = $state.raw([
        { key: "id", label: "id", type: "id" },
        { key: "code", label: "Code", type: "text" },
        { key: "name", label: "Nom", type: "text" },
    ]);

    let createComponents: FormComponent = $state.raw([
        { key: "code", label: "Code", type: "text", required: true },
        { key: "name", label: "Nom", type: "text", required: true },
    ]);

    let editComponents: FormComponent = $state.raw([
        { key: "id", label: "id", type: "text", readonly: true },
        { key: "code", label: "Code", type: "text", required: true },
        { key: "name", label: "Nom", type: "text", required: true },
    ]);
</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>
