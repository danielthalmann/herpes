<script lang="ts">
    import Button from "../Button.svelte";
    import Input from "../Input.svelte";
    import Checkbox from "../Checkbox.svelte";
    import Select from "../Select.svelte";
    import { type ClassValue, clsx } from 'clsx';
    import { twMerge } from "tailwind-merge";

    export type TableColumn = Array<{key: string, label: string, className?: string}>;

    type TableProps = {
        columns?: TableColumn;
        rows?: Array<any>;
    };

    let {
        rows,
        columns
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

<div class=" bg-gray-800/90 rounded-lg">
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
                <tr class="bg-gray-700 ">
                    <th class="text-left px-2 py-3 w-10"><Checkbox/></th>
                {#each columns as column}
                    <th class={cn("text-left px-2 py-3", column.className)}>{column.label}</th>
                {/each}
                </tr>
            </thead>
            <tbody>
                {#each rows as row}
                <tr class="border-b">
                    <td class="px-2 py-3"><Checkbox/></td>
                    {#each columns as column}
                        <td class={cn("px-2 py-3", column.className)}>{row[column.key]}</td>
                    {/each}
                </tr>
                {/each}
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">
        <div class="inline-block m-3  content-center">
            <Input variant="search" placeholder="search..." name="search" />

        </div>
        <div class=" m-3 content-center">
            <Select value="20" items={items} />
        </div>
    </div>

</div>
