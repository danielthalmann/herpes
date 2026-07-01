<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import { type FormComponent } from "../components/Form.svelte";
    import Crud from "../components/Crud.svelte";
    import WeekCalendar, { type CalendarEvent } from "../components/WeekCalendar.svelte";
    import { onMount } from 'svelte';

    let { api } = $props();

    let tablecolumns: TableColumn = $state.raw([
        { key: "id", label: "id", type: "id" },
        { key: "type", label: "Type", type: "text" },
        { key: "status", label: "Statut", type: "text" },
        { key: "summary", label: "Résumé", type: "text", className: "w-96" },
        { key: "customer_id", label: "Client", type: "text" },
    ]);

    let createComponents: FormComponent = $state.raw([
        { key: "type", label: "Type", type: "select", options: [ {label: 'EPIC', value: 'EPIC'},  {label: 'TICKET', value: 'TICKET'}] },
        { key: "status", label: "Statut", type: "text" },
        { key: "summary", label: "Résumé", type: "text", required: true },
        { key: "description", label: "Description", type: "text" },
        { key: "customer_id", label: "Client ID", type: "select",  },
        { key: "reporter_id", label: "Rapporteur ID", type: "select" },
        { key: "assignee_id", label: "Assigné ID", type: "select" },
    ]);

    let editComponents: FormComponent = $state.raw([
        { key: "id", label: "id", type: "text", readonly: true },
        { key: "type", label: "Type", type: "select", options: [ {label: 'EPIC', value: 'EPIC'},  {label: 'TICKET', value: 'TICKET'}] },
        { key: "status", label: "Statut", type: "text" },
        { key: "summary", label: "Résumé", type: "text", required: true },
        { key: "description", label: "Description", type: "text" },
        { key: "customer_id", label: "Client ID", type: "text" },
        { key: "reporter_id", label: "Rapporteur ID", type: "text" },
        { key: "assignee_id", label: "Assigné ID", type: "text" },
        { key: "invoice", label: "Facturé", type: "text" },
        { key: "invoiced_at", label: "Date de facturation", type: "text" },
    ]);

    let events: CalendarEvent[] = [
        { id: '1asd', ticket_id: 'a', start: '2026-06-30T09:00:00', end: '2026-06-30T10:30:00', comment: 'Réunion client', color: 'blue' },
        { id: '2asd', ticket_id: 'b', start: '2026-06-30T14:00:00', end: '2026-06-30T15:00:00', comment: 'Dev sprint', color: 'purple' },
        { id: '3asd', ticket_id: 'a', start: '2026-07-01T10:00:00', end: '2026-07-01T11:30:00', comment: 'Correction bug', color: 'red' },
    ];

    onMount(() => {

    });



</script>

<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>

<WeekCalendar events={events} ></WeekCalendar>
