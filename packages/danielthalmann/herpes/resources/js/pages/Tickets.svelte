<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import { type SelectOption } from "../components/Select.svelte";
    import Crud from "../components/Crud.svelte";
    import { onMount } from 'svelte';
    import { type Paginate } from "../types/Laravel";

    let { api } = $props();

    let tickets: any[] = $state.raw([]);
    let users: any[] = $state.raw([]);
    let customers: any[] = $state.raw([]);

    let ticketOptions: SelectOption[] = $derived(
        tickets.map((ticket) => ({ label: ticket.summary, value: ticket.id }))
    );

    let userOptions: SelectOption[] = $derived(
        users.map((user) => ({ label: user.name, value: user.id }))
    );

    let customerOptions: SelectOption[] = $derived(
        customers.map((customer) => ({ label: customer.name, value: customer.id }))
    );    


    let tablecolumns: TableColumn = $state.raw([
        { key: "id", label: "id", type: "id" },
        { key: "type", label: "Type", type: "select", options: [ {label: 'EPIC', value: 'EPIC'},  {label: 'TICKET', value: 'TICKET'}] },
        { key: "status", label: "Statut", type: "select" , options: [ {label: 'À faire', value: 'TODO'},  {label: 'En cours', value: 'WIP'},  {label: 'Terminé', value: 'FINISH'} ] },
        { key: "summary", label: "Résumé", type: "text", className: "w-96" },
        { key: "times", label: "Temps", type: "text" },
        { key: "eval_times", label: "Évaluation du temps de travail", type: "text" },
        
//        { key: "customer_id", label: "Client", type: "text" },
    ]);

    let createComponents: FormComponent = $derived([
        { key: "type", label: "Type", type: "select", options: [ {label: 'EPIC', value: 'EPIC'},  {label: 'TICKET', value: 'TICKET'}] },
        //{ key: "status", label: "Statut", type: "select" , options: [ {label: 'À faire', value: 'TODO'},  {label: 'En cours', value: 'WIP'},  {label: 'Terminé', value: 'FINISH'} ] },
        { key: "summary", label: "Résumé", type: "text", required: true },
        { key: "parent_id", label: "Parent", type: "select" , options: ticketOptions },
        { key: "description", label: "Description", type: "textarea" },
        { key: "eval_times", label: "Évaluation du temps de travail", type: "text" },
        { key: "customer_id", label: "Client ID", type: "select", options: customerOptions  },
//        { key: "reporter_id", label: "Rapporteur ID", type: "select" },
        { key: "assignee_id", label: "Assigné ID", type: "select" , options: userOptions },
    ]);

    let editComponents: FormComponent = $derived([
        { key: "id", label: "id", type: "text", readonly: true },
        // { key: "type", label: "Type", type: "select", options: [ {label: 'EPIC', value: 'EPIC'},  {label: 'TICKET', value: 'TICKET'}] },
        { key: "status", label: "Statut", type: "select" , options: [ {label: 'À faire', value: 'TODO'},  {label: 'En cours', value: 'WIP'},  {label: 'Terminé', value: 'FINISH'} ] },
        { key: "summary", label: "Résumé", type: "text", required: true },
        { key: "parent_id", label: "Parent", type: "select" , options: ticketOptions },
        { key: "description", label: "Description", type: "textarea" },
        { key: "eval_times", label: "Évaluation du temps de travail", type: "text" },
        { key: "customer_id", label: "Client ID", type: "select" , options: customerOptions },
//        { key: "reporter_id", label: "Rapporteur ID", type: "text" },
        { key: "assignee_id", label: "Assigné ID", type: "select" , options: userOptions },
        { key: "invoice", label: "À Facturer", type: "checkbox" },
        // { key: "invoiced_at", label: "Date de facturation", type: "text" },
    ]);

    let loadTickets = () => {
        fetch(api.ticketEpicIndex + '?paginate=1000').then((response) => {
            response.json().then((json) => {
                const rows: Paginate = json;
                tickets = rows.data;
                tickets.unshift({ summary: 'None', id: '' })
            });
        });
    };

    let loadUsers = () => {
        fetch(api.userIndex + '?paginate=1000').then((response) => {
            response.json().then((json) => {
                const rows: Paginate = json;
                users = rows.data;
                users.unshift({ name: 'None', id: '' })
            });
        });
    };   
    
    let loadCustomers = () => {
        fetch(api.customerIndex + '?paginate=1000').then((response) => {
            response.json().then((json) => {
                const rows: Paginate = json;
                customers = rows.data;
                customers.unshift({ name: 'None', id: '' })
            });
        });
    };     

    onMount(() => {
        loadTickets();
        loadUsers();
        loadCustomers();
    });

</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>
