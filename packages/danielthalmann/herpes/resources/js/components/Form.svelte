<script lang="ts">
    import Checkbox from "./Checkbox.svelte";
    import Input from "./Input.svelte";
    import Select, { type SelectOption } from "./Select.svelte";
    import Table, { type TableColumn } from "./Table.svelte";
    import Textarea from "./Textarea.svelte";

    export type FormComponent = Array<{
        type: 'text' | 'textarea' | 'date' | 'datetime' | 'number' | 'checkbox' | 'table' | 'select',
        key: string,
        label?: string,
        required?: boolean,
        columnName?: string,
        readonly?: boolean,
        options?: SelectOption[],
        columns?: TableColumn
    }>;

    export type DataRef = {
        [key: string]: string | boolean | number ;
    };

    export type FormProps = {
        components : FormComponent,
        data?: DataRef | any,
        onchange?: (key: string) => void
    };

    let {
        components = $bindable(),
        data = $bindable({}),
        onchange = (key: string) => {}
    }: FormProps = $props();


    const change = (key : string) => {
        onchange(key);
    }

</script>

<div class="mb-3">
    {#each components as component}
        <div class="mb-3 grow flex flex-col">
        {#if component.readonly ?? false}
            <div class="inline-block">
            {#if component.label}
                <label class="mt-2" for="{component.key + 'id'}">
                    <span class="block text-sm font-semibold text-gray-900 dark:text-gray-100 mb-1">{component.label}</span>
                    <div class="px-4 py-2 border text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border-gray-500 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">{<string>(data[component.key])}</div>
                </label>
            {:else}
                <div class="px-4 py-2 border text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border-gray-500 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">{<string>(data[component.key])}</div>
            {/if}
            </div>
        {:else}
            {#if component.type == 'text'}
                <Input variant="full" label={component.label} onchange={() => {change(component.key)}} required={component.required} bind:value={data[component.key]} />
            {/if}
            {#if component.type == 'textarea'}
                <Textarea variant="full" label={component.label} onchange={() => {change(component.key)}} required={component.required} bind:value={data[component.key]} />
            {/if}
            {#if component.type == 'number'}
                <Input variant="full" label={component.label} onchange={() => {change(component.key)}} required={component.required} type="number" bind:value={data[component.key]} />
            {/if}
            {#if component.type == 'date'}
                <Input variant="full" label={component.label} onchange={() => {change(component.key)}} required={component.required} type="date" bind:value={data[component.key]} />
            {/if}
            {#if component.type == 'datetime'}
                <Input variant="full" label={component.label} onchange={() => {change(component.key)}} required={component.required} type="datetime" bind:value={data[component.key]} />
            {/if}
            {#if component.type == 'checkbox'}
                <Checkbox bind:checked={<boolean>(data[component.key])} onchange={() => {change(component.key)}}>{component.label}</Checkbox>
            {/if}
            {#if component.type == 'table'}
                <Table rows={<Array<any>>(data[component.key])} columns={component.columns} onopen={(row) => { JSON.parse(JSON.stringify(row)) }} ></Table>
            {/if}
            {#if component.type == 'select'}
                <Select label={component.label} bind:value={data[component.key] as string} items={component.options}  ></Select>
            {/if}

        {/if}
        </div>
    {/each}
</div>
