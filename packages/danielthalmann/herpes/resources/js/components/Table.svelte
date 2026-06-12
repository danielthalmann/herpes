<script lang="ts">
    import Button from "./Button.svelte";
    import Input from "./Input.svelte";
    import Checkbox from "./Checkbox.svelte";
    import Select from "./Select.svelte";
    import { type ClassValue, clsx } from 'clsx';
    import { twMerge } from "tailwind-merge";

    export type TableColumn = Array<{
        key: string;
        label?: string;
        className?: string;
        type?: 'id' | 'text' | 'fn';
        escaped?: boolean;
        computed?: (row: any) => void;
    }>;

    type TableProps = {
        title?: string;
        columns?: TableColumn;
        rows?: Array<any>;
        multiselect?: boolean;
        perpage?: number;
        currentpage?: number;
        lastpage?: number;
        total?: number;
        timerdelete?: number;
        onchangepage?: (page: number) => void;
        onchangeperpage?: (paginate: number) => void;
        onsearch?: (search: string) => void;
        onpage?: (page: number) => void;
        onselect?: (row: any) => void;
        oncreate?: () => void;
        onopen?: (row: any) => void;
        onedit?: (row: any) => void;
        ondelete?: (row: any) => void;
    };

    let {
        rows,
        title = 'Grid',
        columns = [],
        multiselect = false,
        timerdelete = 1,
        perpage = 20,
        currentpage = 1,
        lastpage = 1,
        total,
        onchangepage = (page: number) => {},
        onchangeperpage = (paginate: number) => {},
        onpage = (page: number) => {},
        onsearch = (search: string) => {},
        onselect = (row) => {},
        oncreate,
        onopen,
        onedit,
        ondelete,
    }: TableProps = $props();

    let items = [{
            value: '5',
            label: '5'
        },
        {
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

    let search = $state('');

    const ontempodelete = (row: any) => {
        row._timerhandler = setTimeout(() => { ondelete!(row); }, timerdelete * 1000);
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
        <span>{title}</span>
    </h1>
    {#if oncreate}
        <div class="content-center">
            <Button onclick={() => {oncreate()}}>
            Add
            </Button>
        </div>
    {/if}
</div>

<div class="bg-gray-300 dark:bg-gray-800/90 rounded-lg">
    <!-- search and filter -->
    <div class="flex justify-end">
        <div class="inline-block m-3 content-center">
            <Input variant="search" placeholder="search..." onkeyup={(event) => { onsearch((<HTMLInputElement>event.target!).value) }} />
        </div>
        <!--
        <div class=" m-3 content-center">
            <Button>Columns</Button>
        </div>
        -->
    </div>

    <div class="mb-3">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-500 dark:bg-gray-700">
                    {#if multiselect}
                    <th class="text-left px-2 py-3 w-10"><Checkbox/></th>
                    {/if}
                {#each columns as column}
                    {#if column.type != 'id'}
                        <th class={cn("text-left pl-5 py-3", column.className)}>{column.label ?? column.key}</th>
                    {/if}
                {/each}
                    <th class="text-left px-2 py-3 w-10">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                {#each rows as row}
                <tr class="border-b border-gray-500 dark:border-gray-700" onclick={() => {onselect(row)}}>
                    {#if multiselect}
                    <td class="px-2 py-3"><Checkbox/></td>
                    {/if}
                    {#each columns as column}
                        {#if column.type != 'id'}
                            {#if column.type == 'fn'}
                                <td class={cn("pl-5 py-3", column.className)}>
                                {#if column.escaped === true}
                                    {@html column.computed ? column.computed(row) : 'computed' }
                                {:else}
                                    {column.computed ? column.computed(row) : 'computed' }
                                {/if}
                                </td>
                            {:else}
                                <td class={cn("pl-5 py-3", column.className)}>{row[column.key]}</td>
                            {/if}
                        {/if}
                    {/each}
                    <th class="px-2 py-3 text-nowrap">
                        {#if onedit}
                            <Button variant="primary" onclick={() => {onedit(row)}}>edit</Button>
                        {/if}
                        {#if onopen}
                            <Button variant="primary" onclick={() => {onopen(row)}}>open</Button>
                        {/if}
                        {#if ondelete}
                            {#if row._timerhandler}
                                <Button variant="warning" onclick={() => {canceldelete(row)}}>cancel delete</Button>
                            {:else}
                                <Button onclick={() => {ontempodelete(row)}}>delete</Button>
                            {/if}
                        {/if}
                    </th>
                </tr>
                {/each}
            </tbody>
        </table>
    </div>

    <div class="md:flex ">
        <div class="mx-auto sm:grow mb-3">
        {#if lastpage > 1}
            <div class="inline-block m-3 content-center">

                <Button disabled={currentpage == 1} onclick={() => { onchangepage(currentpage - 1) }}>previous page</Button>
                <Button disabled={currentpage == lastpage} onclick={() => { onchangepage(currentpage + 1) }} >next page</Button>

            </div>
        {/if}
        </div>

        <div class="flex justify-end mb-3">
            {#if lastpage > 1}
                <div class="inline-block m-3 content-center">

                    current page : <div class="inline-block rounded-lg border dark:bg-gray-800 border-gray-500 py-2 px-3 font-medium text-black dark:text-gray-200">{currentpage + ' / ' + lastpage}</div>

                </div>
            {/if}

            {#if total}
            <div class="mr-3 inline-block content-center">
                total : <div class="inline-block rounded-lg border dark:bg-gray-800 border-gray-500 py-2 px-3 font-medium text-black dark:text-gray-200">{total}</div>
            </div>
            {/if}
            <div class="mr-1 inline-block content-center">
                Rows per page :
            </div>
            <div class="mr-3 content-center">
                <Select value={(perpage).toString()} onchange={onchangeperpage} items={items} />
            </div>
        </div>
    </div>


</div>
