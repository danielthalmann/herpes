<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import Crud from "../components/Crud.svelte";

    let { api } = $props();

    let tablecolumns: TableColumn = $state.raw([
        { key: "id", label: "id", type: "id" },
        { key: "type", label: "Type", type: "select", options: [ {label: 'EPIC', value: 'EPIC'},  {label: 'TICKET', value: 'TICKET'}] },
        { key: "status", label: "Statut", type: "select" , options: [ {label: 'À faire', value: 'TODO'},  {label: 'En cours', value: 'WIP'},  {label: 'Terminé', value: 'FINISH'} ] },
        { key: "summary", label: "Résumé", type: "text", className: "w-96" },
        { key: "eval_times", label: "Évaluation du temps de travail", type: "text" },
//        { key: "customer_id", label: "Client", type: "text" },
    ]);

    let createComponents: FormComponent = $state.raw([
        { key: "type", label: "Type", type: "select", options: [ {label: 'EPIC', value: 'EPIC'},  {label: 'TICKET', value: 'TICKET'}] },
        //{ key: "status", label: "Statut", type: "select" , options: [ {label: 'À faire', value: 'TODO'},  {label: 'En cours', value: 'WIP'},  {label: 'Terminé', value: 'FINISH'} ] },
        { key: "summary", label: "Résumé", type: "text", required: true },
        { key: "parent_id", label: "Parent", type: "select" , options: [ {label: 'None', value: ''}, {label: 'Adaptation site JDS', value: '01kwedch35f2p85gtyw2sggsph'} ] },
        { key: "description", label: "Description", type: "textarea" },
        { key: "eval_times", label: "Évaluation du temps de travail", type: "text" },
        { key: "customer_id", label: "Client ID", type: "select",  },
        { key: "reporter_id", label: "Rapporteur ID", type: "select" },
        { key: "assignee_id", label: "Assigné ID", type: "select" },
    ]);

    let editComponents: FormComponent = $state.raw([
        { key: "id", label: "id", type: "text", readonly: true },
        // { key: "type", label: "Type", type: "select", options: [ {label: 'EPIC', value: 'EPIC'},  {label: 'TICKET', value: 'TICKET'}] },
        { key: "status", label: "Statut", type: "select" , options: [ {label: 'À faire', value: 'TODO'},  {label: 'En cours', value: 'WIP'},  {label: 'Terminé', value: 'FINISH'} ] },
        { key: "summary", label: "Résumé", type: "text", required: true },
        { key: "parent_id", label: "Parent", type: "select" , options: [ {label: 'None', value: ''}, {label: 'Adaptation site JDS', value: '01kwedch35f2p85gtyw2sggsph'} ] },
        { key: "description", label: "Description", type: "textarea" },
        { key: "eval_times", label: "Évaluation du temps de travail", type: "text" },
        { key: "customer_id", label: "Client ID", type: "select" , options: [ {label: 'None', value: ''}, {label: 'Comité Fribourgeois des JDS', value: '01kmvcngdjr4k3y54fxzy4kxwm'} ] },
        { key: "reporter_id", label: "Rapporteur ID", type: "text" },
        { key: "assignee_id", label: "Assigné ID", type: "text" },
        { key: "invoice", label: "À Facturer", type: "checkbox" },
        // { key: "invoiced_at", label: "Date de facturation", type: "text" },
    ]);
</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>
