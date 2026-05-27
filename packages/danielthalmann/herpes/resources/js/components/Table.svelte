<script lang="ts">
    import Button from "./Button.svelte";
    import Input from "./Input.svelte";
    import Checkbox from "./Checkbox.svelte";
    import Select from "./Select.svelte";
    import { type ClassValue, clsx } from 'clsx';
    import { twMerge } from "tailwind-merge";

    export type TableColumn = Array<{
        key: string,
        label: string,
        className?: string
    }>;

    type TableProps = {
        columns?: TableColumn;
        rows?: Array<any>;
        multiselect?: boolean;
        perpage?: Number;
        timerdelete?: number;
        onchangeperpage?: (Paginate: Number) => void;
        onselect?: (row: any) => void;
        onshow?: (row: any) => void;
        ondelete?: (row: any) => void;
    };

    let {
        rows,
        columns,
        multiselect = false,
        timerdelete = 3,
        perpage = $bindable(20),
        onchangeperpage = (Paginate: Number) => {},
        onselect = (row) => {},
        onshow = (row) => {},
        ondelete = (row) => {},
    }: TableProps = $props();

    let items = [{
            value: '20',
            label: '20'
        },
        {
            value: '50',
            label: '50'
        },
        {
            value: '100',
            label: '100'
        }
    ];

    const ontempodelete = (row: any) => {
        row._timerhandler = setTimeout(() => { ondelete(row); }, timerdelete * 1000);
    }
    const canceldelete  = (row: any) => {
        if(row._timerhandler)
            clearTimeout(row._timerhandler);
        row._timerhandler = null;
    }

    function cn(...inputs: ClassValue[]) {
        return twMerge(clsx(inputs));
    }

</script>


<div class="flex content-center mb-5">
    <h1 class="font-medium grow text-3xl content-center">
        <span>Customers</span>
    </h1>
    <div class="content-center">
        <Button href="http://localhost:8000/admin/customers/create">
        Créer
        </Button>
    </div>
</div>

<div class="bg-gray-300 dark:bg-gray-800/90 rounded-lg">
    <!-- search and filter -->
    <div class="flex justify-end">
        <div class="inline-block m-3 content-center">
            <Input variant="search" placeholder="search..." name="search" />
        </div>
        <div class=" m-3 content-center">
            <Button>test</Button>
        </div>
    </div>

    <div class="mb-3">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-500 dark:bg-gray-700">
                    {#if multiselect}
                    <th class="text-left px-2 py-3 w-10"><Checkbox/></th>
                    {/if}
                {#each columns as column}
                    <th class={cn("text-left pl-5 py-3", column.className)}>{column.label}</th>
                {/each}
                    <th class="text-left px-2 py-3 w-10"></th>
                </tr>
            </thead>
            <tbody>
                {#each rows as row}
                <tr class="border-b border-gray-500 dark:border-gray-700" onclick={() => {onselect(row)}}>
                    {#if multiselect}
                    <td class="px-2 py-3"><Checkbox/></td>
                    {/if}
                    {#each columns as column}
                        <td class={cn("pl-5 py-3", column.className)}>{row[column.key]}</td>
                    {/each}
                    <th class="px-2 py-3 text-nowrap">
                        <Button variant="primary" onclick={() => {onshow(row)}}>show</Button>
                        {#if row._timerhandler}
                            <Button variant="warning" onclick={() => {canceldelete(row)}}>cancel delete</Button>
                        {:else}
                            <Button onclick={() => {ontempodelete(row)}}>delete</Button>
                        {/if}
                    </th>
                </tr>
                {/each}
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">
        <div class="inline-block m-3  content-center">

        </div>

        <div class="inline-block m-3  content-center">
            Rows per page :
        </div>
        <div class=" m-3 content-center">
            <Select value={(perpage).toString()} onchange={onchangeperpage} items={items} />
        </div>
    </div>

</div>
