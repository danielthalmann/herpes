<script lang="ts">
    import { type TableColumn } from "../components/Table.svelte";
    import Form, { type FormComponent } from "../components/Form.svelte";
    import Crud from "../components/Crud.svelte";
    import { type SelectOption } from "../components/Select.svelte";
    import WeekCalendar, { type CalendarEvent } from "../components/WeekCalendar.svelte";
    import { onMount } from 'svelte';
    import Dialog from "../components/Dialog.svelte";
    import Button from "../components/Button.svelte";
    import { type Paginate } from "../types/Laravel";

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

    let currentEvent: CalendarEvent | null = $state.raw(null);

    let createEventComponents: FormComponent = $state.raw([]);

    let events: CalendarEvent[] = $state.raw([]);;


    let addEvent = (slot: Date) => {
        
        console.log('Adding event:', event);

        fetch(api.index).then((response) => {
            response.json().then((json) => {
                const rows: Paginate = json;
                
                let ticketOptions: SelectOption[] = [];

                rows.data.forEach((row: any) => {
                    ticketOptions.push({ label: row.summary, value: row.id });
                });                

                createEventComponents = [
                    { key: "id", label: "id", type: "text", readonly: true },
                    { key: "ticket_id", label: "Ticket ID", type: "select" , options: ticketOptions },
                    { key: "start", label: "Début", type: "datetime" },
                    { key: "end", label: "Fin", type: "datetime" },
                    { key: "comment", label: "Commentaire", type: "textarea" },
                ];

                currentEvent = {
                    id: '',
                    ticket_id: '',
                    start: slot.toISOString().split('.')[0],
                    end: new Date(slot.getTime() + 60 * 60 * 1000).toISOString().split('.')[0], // Default to 1 hour later
                    comment: ''
                };


            });
        });

    };

    console.log(api);

    let createEvent = (event: CalendarEvent) => {

        const fetchOptions: RequestInit = {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify(event)
        }
        fetch(api.timesheetStore, fetchOptions)
        .then(response => {
            events.push(event);
            loadEvents();
        });
        currentEvent = null;
    };

    let loadEvents = () => {
        fetch(api.timesheetIndex).then((response) => {
            response.json().then((json) => {
                const rows: Paginate = json;
                events = rows.data;
            });
        });
    };

    onMount(() => {
        loadEvents();

    });

</script>

<div class="mb-4">
<Crud api={api}
    tablecolumns={tablecolumns}
    createComponents={createComponents}
    editComponents={editComponents}
/>
</div>

<WeekCalendar events={events} onSlotClick={(slot) => addEvent(slot)} onEventClick={(event) => console.log(event) } ></WeekCalendar>

<Dialog title="Create" open={currentEvent ? true: false}>

    <div class="mb-5">
        <Form
            bind:data={currentEvent}
            components={createEventComponents}
            onchange={(key) => {
            }}
        />
    </div>
    <div class="border-b mb-5 border-neutral-400"></div>

    {#snippet footer()}
    <div class="mb-3 text-right">
        <Button
            variant="primary"
            onclick={() => {
                createEvent(currentEvent!);
            }}>Save
        </Button>
        <Button
            onclick={() => {
                currentEvent = null;
            }}>Close
        </Button>
    </div>
    {/snippet}

</Dialog>