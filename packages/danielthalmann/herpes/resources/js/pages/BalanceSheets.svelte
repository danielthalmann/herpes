<script lang="ts">
    import { type TableColumn, type TableAction } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import Crud from "../components/Crud.svelte";

    let { api } = $props();

    let tablecolumns: TableColumn = $state.raw([
        { key: "id", label: "id", type: "id" },
        { key: "balance_sheet_date", label: "Date du bilan", type: "text" },
    ]);

    let actions: TableAction[] = [
        { label: "print", variant: "primary", onclick: (row) => {
            window.open((<string>api.print).replace('|id|', row.id), '_blank');
        } },
    ];

    let createComponents: FormComponent = $state.raw([
        { key: "balance_sheet_date", label: "Date du bilan", type: "date", required: true },
    ]);

    let editComponents: FormComponent = $state.raw([
        { key: "id", label: "id", type: "text", readonly: true },
        { key: "balance_sheet_date", label: "Date du bilan", type: "date", required: true },
    ]);
</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
    actions={actions}
/>
