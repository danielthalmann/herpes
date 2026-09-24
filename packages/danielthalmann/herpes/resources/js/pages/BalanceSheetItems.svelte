<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import { type SelectOption } from "../components/Select.svelte";
    import Crud from "../components/Crud.svelte";

    let { api } = $props();

    const balanceTypeOptions: SelectOption[] = [
        { label: 'Actif', value: 'ACTIF' },
        { label: 'Passif', value: 'PASSIF' },
        { label: 'Pertes et profits', value: 'PERTE_PROFFIT' },
        { label: 'Frais de fonctionnement', value: 'FRAIS_FONCTIONNEMENT' },
        { label: 'Capital', value: 'CAPITAL' },
    ];

    let tablecolumns: TableColumn = $state.raw([
        { key: "id", label: "id", type: "id" },
        { key: "balance_type", label: "Type", type: "select", options: balanceTypeOptions },
        { key: "description", label: "Description", type: "text" },
        { key: "amount", label: "Montant", type: "fn",
            computed : (row) => {
                return row.amount / 100;
            }
        },
        { key: "currency", label: "Devise", type: "text" },
    ]);

    let createComponents: FormComponent = $state.raw([
        { key: "balance_type", label: "Type", type: "select", options: balanceTypeOptions },
        { key: "description", label: "Description", type: "text" },
        { key: "amount", label: "Montant (centimes)", type: "number" },
        { key: "currency", label: "Devise", type: "select" , options: [{label: 'CHF', value: 'CHF'} ] },
    ]);

    let editComponents: FormComponent = $state.raw([
        { key: "id", label: "id", type: "text", readonly: true },
        { key: "balance_type", label: "Type", type: "select", options: balanceTypeOptions },
        { key: "description", label: "Description", type: "text" },
        { key: "amount", label: "Montant (centimes)", type: "number" },
        { key: "currency", label: "Devise", type: "select" , options: [{label: 'CHF', value: 'CHF'} ] },
    ]);
</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>
