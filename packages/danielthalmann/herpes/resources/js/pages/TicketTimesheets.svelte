<script lang="ts">
    import Form, { type FormComponent } from "../components/Form.svelte";
    import Button from "../components/Button.svelte";
    import Table, { type TableContext, type TableColumn, type TableAction } from "../components/Table.svelte";
    import { onMount } from 'svelte';
    import Breadcrumb from "../components/Breadcrumb.svelte";
    import { decodeHTML } from "../Utils/Encoding";
    import { type Paginate } from "../types/Laravel";
    import { type TimesheetType, type TicketType } from "../types/App";
    import Dialog from "../components/Dialog.svelte";


    let { api } = $props();

    let rows: Paginate | undefined = $state();
    let selectedRow: any | null = $state.raw(null);

    let ticket : TicketType = $state.raw(null);

    onMount(() => {
        loadRows();
        loadTicket();
    });

    let context : TableContext = {
        page: 1,
        perpage : 20,
        search : ''
    };

    const changePage = (page: number = 1) => {
        context.page = page;
        loadRows();
    };

    const changePerPage = (perpage: number = 20) => {
        context.page = 1;
        context.perpage = perpage;
        loadRows();
    };

    const loadRows = () => {
        fetch(api.index + "?paginate=" + context.perpage + '&page=' + context.page + '&search=' + context.search).then((response) => {
            response.json().then((json) => {
                rows = json;
            });
        });
    };
    const loadTicket = () => {
        console.log(api);
        fetch(api.ticketShow).then((response) => {
            response.json().then((json) => {
                ticket = json;
                console.log(ticket);
            });
        });
    };


    let tablecolumns: TableColumn = [
        { key: "start", label: "Début" },
        { key: "end", label: "Fin", },
        { key: "comment", label: "Commentaire"},
    ]; 
    
    let editComponents: FormComponent = $derived([
        { key: "id", label: "id", type: "text", readonly: true },
        //{ key: "ticket_id", label: "Ticket ID", type: "select" , options: ticketOptions },
        { key: "start", label: "Début", type: "datetime" },
        { key: "end", label: "Fin", type: "datetime" },
        { key: "comment", label: "Commentaire", type: "textarea" },
    ]);
    

    const editRow = (timesheet: TimesheetType) => {
        selectedRow = JSON.parse(JSON.stringify(timesheet));
    };

    const updateRow = (timesheet: TimesheetType) => {
        let index = rows!.data.findIndex((item: any) => {
            return timesheet!.id === item.id;
        });
        if (index > -1) {
            const fetchOptions: RequestInit = {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify(timesheet)
            }
            fetch((<string>api.update).replace('|id|', timesheet.id!), fetchOptions)
            .then(response => {
                if (response.ok) {
                    rows!.data[index] = timesheet;
                }
            });
        }
        selectedRow = null;
    };    


</script> 

<div>
    <Breadcrumb breadcrumb={JSON.parse(decodeHTML(api.breadcrumb ?? '[]'))} />
    {#if rows}
        <Table
            title={api.name}
            rows={rows!.data}
            columns={tablecolumns}
            perpage={rows.per_page}
            currentpage={rows.current_page}
            lastpage={rows.last_page}
            total={rows.total}
            onchangepage={changePage}
            onchangeperpage={changePerPage}
            onedit={editRow}

        />
    {/if}

    <Dialog title="Edit" open={selectedRow ? true: false}>

        <div class="mb-5">
            <Form
                bind:data={selectedRow!}
                components={editComponents}
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
                    updateRow(selectedRow!);
                }}>Save
            </Button>
            <Button
                onclick={() => {
                    selectedRow = null;
                }}>Close
            </Button>
        </div>
        {/snippet}

    </Dialog>    


</div>
