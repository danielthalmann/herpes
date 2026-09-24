<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import Crud from "../components/Crud.svelte";
    import { type SelectOption } from "../components/Select.svelte";
    import { type Paginate } from "../types/Laravel";
    import { onMount } from 'svelte';

    let { api } = $props();

    let accounts: any[] = $state.raw([]);

    let accountOptions: SelectOption[] = $derived(
        accounts.map((account) => ({ label: account.code + ' - ' + account.name, value: account.id }))
    );

    onMount(() => {
        fetch(api.accountIndex + '?paginate=1000').then((response) => {
            response.json().then((json) => {
                const rows: Paginate = json;
                accounts = rows.data;
            });
        });
    });

    let tablecolumns: TableColumn = $state.raw([
        { key: "id", label: "id", type: "id" },
        { key: "date", label: "Date", type: "text" },
        { key: "accounting_text", label: "Texte comptable", type: "text" },
        { key: "account_text", label: "Compte", type: "text" },
        { key: "debit", label: "Débit", type: "fn",
            computed : (row) => {
                return row.debit / 100;
            }
        },
        { key: "credit", label: "Crédit", type: "fn",
            computed : (row) => {
                return row.credit / 100;
            }
        },
    ]);

    let createComponents: FormComponent = $derived([
        { key: "date", label: "Date", type: "date", required: true },
        { key: "account_from_id", label: "Compte from ID", type: "select", options: accountOptions },
        { key: "account_to_id", label: "Compte to ID", type: "select", options: accountOptions },
        { key: "accounting_text", label: "Texte comptable", type: "text" },
        { key: "invoice_id", label: "Facture ID", type: "text" },
//        { key: "tax_code", label: "Code TVA", type: "text" },
//        { key: "tax_rate", label: "Taux TVA", type: "text" },
//        { key: "tax_value", label: "Valeur TVA", type: "text" },
        { key: "debit", label: "Débit", type: "text" },
        { key: "credit", label: "Crédit", type: "text" },
    ]);

    let editComponents: FormComponent = $derived([
        { key: "id", label: "id", type: "text", readonly: true },
        { key: "date", label: "Date", type: "date", required: true },
        { key: "account_from_id", label: "Compte from ID", type: "select", options: accountOptions },
        { key: "account_to_id", label: "Compte to ID", type: "select", options: accountOptions },
        { key: "accounting_text", label: "Texte comptable", type: "text" },
        { key: "invoice_id", label: "Facture ID", type: "text" },
//        { key: "tax_code", label: "Code TVA", type: "text" },
//        { key: "tax_rate", label: "Taux TVA", type: "text" },
//        { key: "tax_value", label: "Valeur TVA", type: "text" },
        { key: "debit", label: "Débit", type: "text" },
        { key: "credit", label: "Crédit", type: "text" },
    ]);
</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>
