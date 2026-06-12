<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import Crud from "../components/Crud.svelte";

    let { api } = $props();

    let tablecolumns: TableColumn = $state.raw([
        { key: "id", label: "id", type: "id" },
        { key: "no", label: "N°", type: "text" },
        { key: "description", label: "Description", type: "text" },
        { key: "quantity", label: "Quantité", type: "text" },
        { key: "unit_price", label: "Prix unitaire", type: "text" },
        { key: "currency", label: "Devise", type: "text" },
        { key: "quantity_type", label: "Unité", type: "text" },
    ]);

    let createComponents: FormComponent = $state.raw([
        { key: "no", label: "N°", type: "text" },
        { key: "description", label: "Description", type: "text" },
        { key: "quantity", label: "Quantité", type: "text" },
        { key: "unit_price", label: "Prix unitaire", type: "text" },
        { key: "currency", label: "Devise", type: "text" },
        { key: "quantity_type", label: "Unité", type: "text" },
    ]);

    let editComponents: FormComponent = $state.raw([
        { key: "id", label: "id", className: "w-12", type: "text", readonly: true },
        { key: "no", label: "N°", type: "text" },
        { key: "description", label: "Description", type: "text" },
        { key: "quantity", label: "Quantité", type: "text" },
        { key: "unit_price", label: "Prix unitaire", type: "text" },
        { key: "currency", label: "Devise", type: "text" },
        { key: "quantity_type", label: "Unité", type: "text" },
    ]);
</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>
