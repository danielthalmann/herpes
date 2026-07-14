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
        { key: "sum", label: "Montant", type: "fn",
          computed : (row) => {

            let sum: number = 0;

            row.invoice_items.forEach((val) => {
                if(val.quantity != undefined){
                    sum += val.unit_price * val.quantity;
                }
            });
            return sum;
          }
        },

    ]);

    let createComponents: FormComponent = $state.raw([
        { key: "ref", label: "Référence", type: "text" },
        { key: "invoice_date", label: "Date", type: "date", required: true },
        { key: "customer_id", label: "Client ID", type: "select" , options: [ {label: 'None', value: ''}, {label: 'Comité Fribourgeois des JDS', value: '01kmvcngdjr4k3y54fxzy4kxwm'} ] },
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
        { key: "invoice_date", label: "Date", type: "date", required: true },
        { key: "customer_id", label: "Client ID", type: "select" , options: [ {label: 'None', value: ''}, {label: 'Comité Fribourgeois des JDS', value: '01kmvcngdjr4k3y54fxzy4kxwm'} ] },
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
