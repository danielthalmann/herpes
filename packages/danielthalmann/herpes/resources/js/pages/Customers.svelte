<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import { type CustomerType } from "../types/App";
    import Crud from "../components/Crud.svelte";

    let { api } = $props();

    let tablecolumns: TableColumn = $state.raw([
        {
            key: "id",
            label: "id",
            type: "id",
        },
        {
            key: "name",
            label: "Nom",
            type: "text",
            className: "w-96"
        },
        {
            key: "addresses",
            label: "Adresse",
            type: "fn",
            escaped: true,
            computed : (row : CustomerType) => {
                console.log(row);
                let ret : string = '';
                let index : number = 0;
                ret += '<div class="md:flex">'
                row.addresses!.forEach((address) => {
                    index++;
                    ret += '<div class="border rounded-lg m-3 p-3 dark:bg-gray-800 border-gray-500 inline-block">'
                    ret += address.company ? address.company + '<br/>' : '';
                    ret += address.name ? (address.firstname ?? '') + ' ' + address.name + '<br/>' : '';
                    ret += address.street ? address.street + '<br/>' : '';
                    ret += address.zipcode ? address.zipcode + ' ' + address.city + '<br/>' : '';
                    ret += '</div>'
                });
                ret += '</div>'
                return ret;
            }
        }
    ]);

    let createComponents: FormComponent = $state.raw([
        {
            key: "name",
            label: "Nom",
            type: "text",
            required: true,
        }
    ]);

    let editComponents: FormComponent = $state.raw([
        {
            key: "id",
            label: "id",
            className: "w-12",
            type: "text",
            readonly: true,
        },
        {
            key: "name",
            label: "Nom",
            type: "text",
            required: true,
        }
    ]);

</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>
