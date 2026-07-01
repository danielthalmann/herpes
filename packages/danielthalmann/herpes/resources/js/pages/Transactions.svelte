<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import Crud from "../components/Crud.svelte";

    let { api } = $props();

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
                return row.debit / 100;
            }
        },
    ]);

    let createComponents: FormComponent = $state.raw([
        { key: "date", label: "Date", type: "text", required: true },
        { key: "transaction_group", label: "Groupe", type: "text" },
        { key: "account_from_id", label: "Compte from ID", type: "text" },
        { key: "account_to_id", label: "Compte to ID", type: "text" },
        { key: "invoice_id", label: "Facture ID", type: "text" },
        { key: "accounting_text", label: "Texte comptable", type: "text" },
        { key: "tax_code", label: "Code TVA", type: "text" },
        { key: "tax_rate", label: "Taux TVA", type: "text" },
        { key: "tax_value", label: "Valeur TVA", type: "text" },
        { key: "debit", label: "Débit", type: "text" },
        { key: "credit", label: "Crédit", type: "text" },
    ]);

    let editComponents: FormComponent = $state.raw([
        { key: "id", label: "id", type: "text", readonly: true },
        { key: "date", label: "Date", type: "text", required: true },
        { key: "transaction_group", label: "Groupe", type: "text" },
        { key: "account_from_id", label: "Compte from ID", type: "select" },
        { key: "account_to_id", label: "Compte to ID", type: "text" },
        { key: "invoice_id", label: "Facture ID", type: "text" },
        { key: "accounting_text", label: "Texte comptable", type: "text" },
        { key: "tax_code", label: "Code TVA", type: "text" },
        { key: "tax_rate", label: "Taux TVA", type: "text" },
        { key: "tax_value", label: "Valeur TVA", type: "text" },
        { key: "debit", label: "Débit", type: "text" },
        { key: "credit", label: "Crédit", type: "text" },
    ]);
</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>
