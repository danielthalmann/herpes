<script lang="ts">
    import Form, { type FormComponent } from "../components/Form.svelte";
    import { type SelectOption } from "../components/Select.svelte";
    import WeekCalendar, { type CalendarEvent } from "../components/WeekCalendar.svelte";
    import { onMount } from 'svelte';
    import Dialog from "../components/Dialog.svelte";
    import Button from "../components/Button.svelte";
    import { type Paginate } from "../types/Laravel";

    let { api } = $props();

    let newEvent: CalendarEvent | null = $state.raw(null);
    let currentEvent: CalendarEvent | null = $state.raw(null);

    let events: CalendarEvent[] = $state.raw([]);
    let tickets: any[] = $state.raw([]);

    let ticketOptions: SelectOption[] = $derived(
        tickets.map((ticket) => ({ label: ticket.summary, value: ticket.id }))
    );

    let createEventComponents: FormComponent = $derived([
        { key: "ticket_id", label: "Ticket ID", type: "select" , options: ticketOptions },
        { key: "start", label: "Début", type: "datetime" },
        { key: "end", label: "Fin", type: "datetime" },
        { key: "comment", label: "Commentaire", type: "textarea" },
    ]);

    let editEventComponents: FormComponent = $derived([
        { key: "id", label: "id", type: "text", readonly: true },
        { key: "ticket_id", label: "Ticket ID", type: "select" , options: ticketOptions },
        { key: "start", label: "Début", type: "datetime" },
        { key: "end", label: "Fin", type: "datetime" },
        { key: "comment", label: "Commentaire", type: "textarea" },
    ]);

    // Formate une Date en "YYYY-MM-DDTHH:mm:ss" en heure locale (toISOString() convertit en UTC, ce qui décale l'heure).
    let toLocalDateTimeString = (date: Date): string => {
        const pad = (n: number) => String(n).padStart(2, '0');
        return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}:${pad(date.getSeconds())}`;
    };

    let addEvent = (slot: Date) => {
        newEvent = {
            id: '',
            ticket_id: '',
            start: toLocalDateTimeString(slot),
            end: toLocalDateTimeString(new Date(slot.getTime() + 60 * 60 * 1000)), // Default to 1 hour later
            comment: ''
        };
    };

    let editEvent = (event: CalendarEvent) => {
        currentEvent = event;
    };

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
        fetch(api.store, fetchOptions)
        .then(response => {
            loadEvents();
        });
        newEvent = null;
    };

    let updateEvent = (event: CalendarEvent) => {

        const fetchOptions: RequestInit = {
            method: 'PUT',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify(event)
        }
        fetch(api.update.replace('|id|', event.id), fetchOptions)
        .then(response => {
            loadEvents();
        });
        currentEvent = null;
    };

    let loadEvents = () => {
        fetch(api.index).then((response) => {
            response.json().then((json) => {
                const rows: Paginate = json;
                events = rows.data;
            });
        });
    };

    let loadTickets = () => {
        fetch(api.ticketIndex + '?paginate=1000').then((response) => {
            response.json().then((json) => {
                const rows: Paginate = json;
                tickets = rows.data;
            });
        });
    };

    onMount(() => {
        loadEvents();
        loadTickets();
    });

</script>

<WeekCalendar events={events} onSlotClick={(slot) => addEvent(slot)} onEventClick={(event) => editEvent(event) } ></WeekCalendar>

<Dialog title="Create" open={newEvent ? true: false}>

    <div class="mb-5">
        <Form
            bind:data={newEvent}
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
                createEvent(newEvent!);
            }}>Save
        </Button>
        <Button
            onclick={() => {
                newEvent = null;
            }}>Close
        </Button>
    </div>
    {/snippet}

</Dialog>

<Dialog title="Update" open={currentEvent ? true: false}>

    <div class="mb-5">
        <Form
            bind:data={currentEvent}
            components={editEventComponents}
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
                updateEvent(currentEvent!);
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
