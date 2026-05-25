<script lang="ts">
    import Checkbox from "./Checkbox.svelte";
import Input from "./Input.svelte";

    export type FormComponent = Array<{
        type: 'text' | 'number' | 'checkbox',
        key: string,
        label?: string,
        required?: boolean,
        columnName?: string,
    }>;

    export type DataRef = {
        [key: string]: string | boolean | number ;
    };

    export type FormProps = {
        components : FormComponent,
        data?: DataRef
    };

    let {
        components,
        data = $bindable({})
    }: FormProps = $props();



</script>

<div class="mb-3">
    {#each components as component}
        <div class="mb-3 grow flex flex-col">
            {#if component.type == 'text'}
                <Input variant="full" label={component.label} required={component.required} bind:value={<string>(data[component.key])} />
            {/if}
            {#if component.type == 'number'}
                <Input variant="full" label={component.label} required={component.required} type="number" bind:value={<string>(data[component.key])} />
            {/if}
            {#if component.type == 'checkbox'}
                <Checkbox bind:checked={<boolean>(data[component.key])}>{component.label}</Checkbox>
            {/if}
        </div>
    {/each}
</div>
