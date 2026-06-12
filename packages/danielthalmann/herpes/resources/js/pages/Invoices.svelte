<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import Crud from "../components/Crud.svelte";

    let { api } = $props();

    let tablecolumns: TableColumn = $state.raw([
        { key: "id", label: "id", type: "id" },
        { key: "ref", label: "Référence", type: "text" },
        { key: "invoice_date", label: "Date", type: "text" },
        { key: "customer_company", label: "Société", type: "text" },
        { key: "customer_name", label: "Client", type: "text" },
        { key: "customer_city", label: "Ville", type: "text" },
    ]);

    let createComponents: FormComponent = $state.raw([
        { key: "ref", label: "Référence", type: "text" },
        { key: "invoice_date", label: "Date", type: "text", required: true },
        { key: "customer_id", label: "Customer ID", type: "text" },
        { key: "customer_company", label: "Société", type: "text" },
        { key: "customer_department", label: "Département", type: "text" },
        { key: "customer_name", label: "Nom", type: "text" },
        { key: "customer_street", label: "Rue", type: "text" },
        { key: "customer_zipcode", label: "NPA", type: "text" },
        { key: "customer_city", label: "Ville", type: "text" },
    ]);

    let editComponents: FormComponent = $state.raw([
        { key: "id", label: "id", className: "w-12", type: "text", readonly: true },
        { key: "ref", label: "Référence", type: "text" },
        { key: "invoice_date", label: "Date", type: "text", required: true },
        { key: "customer_id", label: "Customer ID", type: "text" },
        { key: "customer_company", label: "Société", type: "text" },
        { key: "customer_department", label: "Département", type: "text" },
        { key: "customer_name", label: "Nom", type: "text" },
        { key: "customer_street", label: "Rue", type: "text" },
        { key: "customer_zipcode", label: "NPA", type: "text" },
        { key: "customer_city", label: "Ville", type: "text" },
    ]);
</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>
