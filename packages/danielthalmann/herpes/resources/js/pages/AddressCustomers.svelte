<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import Crud from "../components/Crud.svelte";

    let { api } = $props();

    let tablecolumns: TableColumn = $state.raw([
        { key: "id", label: "id", type: "id" },
        { key: "company", label: "Société", type: "text" },
        { key: "department", label: "Département", type: "text" },
        { key: "name", label: "Nom", type: "text" },
        { key: "firstname", label: "Prénom", type: "text" },
        { key: "street", label: "Rue", type: "text" },
        { key: "zipcode", label: "NPA", type: "text" },
        { key: "city", label: "Ville", type: "text" },
    ]);

    let createComponents: FormComponent = $state.raw([
        { key: "company", label: "Société", type: "text" },
        { key: "department", label: "Département", type: "text" },
        { key: "name", label: "Nom", type: "text" },
        { key: "firstname", label: "Prénom", type: "text" },
        { key: "street", label: "Rue", type: "text" },
        { key: "zipcode", label: "NPA", type: "text" },
        { key: "city", label: "Ville", type: "text" },
    ]);

    let editComponents: FormComponent = $state.raw([
        { key: "id", label: "id", className: "w-12", type: "text", readonly: true },
        { key: "company", label: "Société", type: "text" },
        { key: "department", label: "Département", type: "text" },
        { key: "name", label: "Nom", type: "text" },
        { key: "firstname", label: "Prénom", type: "text" },
        { key: "street", label: "Rue", type: "text" },
        { key: "zipcode", label: "NPA", type: "text" },
        { key: "city", label: "Ville", type: "text" },
    ]);

</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>
