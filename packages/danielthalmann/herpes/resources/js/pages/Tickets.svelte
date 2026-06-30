<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import Crud from "../components/Crud.svelte";

    let { api } = $props();

    let tablecolumns: TableColumn = $state.raw([
        { key: "id", label: "id", type: "id" },
        { key: "type", label: "Type", type: "text" },
        { key: "status", label: "Statut", type: "text" },
        { key: "summary", label: "Résumé", type: "text", className: "w-96" },
        { key: "customer_id", label: "Client", type: "text" },
    ]);

    let createComponents: FormComponent = $state.raw([
        { key: "type", label: "Type", type: "text" },
        { key: "status", label: "Statut", type: "text" },
        { key: "summary", label: "Résumé", type: "text", required: true },
        { key: "description", label: "Description", type: "text" },
        { key: "customer_id", label: "Client ID", type: "text" },
        { key: "reporter_id", label: "Rapporteur ID", type: "text" },
        { key: "assignee_id", label: "Assigné ID", type: "text" },
    ]);

    let editComponents: FormComponent = $state.raw([
        { key: "id", label: "id", type: "text", readonly: true },
        { key: "type", label: "Type", type: "text" },
        { key: "status", label: "Statut", type: "text" },
        { key: "summary", label: "Résumé", type: "text", required: true },
        { key: "description", label: "Description", type: "text" },
        { key: "customer_id", label: "Client ID", type: "text" },
        { key: "reporter_id", label: "Rapporteur ID", type: "text" },
        { key: "assignee_id", label: "Assigné ID", type: "text" },
        { key: "invoice", label: "Facturé", type: "text" },
        { key: "invoiced_at", label: "Date de facturation", type: "text" },
    ]);
</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>
