<script lang="ts">
    import Checkbox from "./Checkbox.svelte";
import Input from "./Input.svelte";

    export type FormComponent = Array<{
        type: 'text' | 'number' | 'checkbox',
        key: string,
        label?: string,
        required?: boolean,
        columnName?: string,
        readonly?:boolean,
    }>;

    export type DataRef = {
        [key: string]: string | boolean | number ;
    };

    export type FormProps = {
        components : FormComponent,
        data?: DataRef,
        onchange?: (key: string) => void
    };

    let {
        components,
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
                <Input variant="full" label={component.label} onchange={() => {change(component.key)}} required={component.required} bind:value={<string>(data[component.key])} />
            {/if}
            {#if component.type == 'number'}
                <Input variant="full" label={component.label} onchange={() => {change(component.key)}} required={component.required} type="number" bind:value={<string>(data[component.key])} />
            {/if}
            {#if component.type == 'checkbox'}
                <Checkbox bind:checked={<boolean>(data[component.key])}  onchange={() => {change(component.key)}}>{component.label}</Checkbox>
            {/if}
        {/if}
        </div>
    {/each}
</div>
