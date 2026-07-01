<script lang="ts">
    import type { HTMLTextareaAttributes } from "svelte/elements";

    type VariantType = "default" | "full";

    export type TextareaProps = HTMLTextareaAttributes & {
            variant? : VariantType,
            label? : string,
            required? : boolean
        };

    let {
        variant = "default",
        value = $bindable(''),
        label,
        required = false,
        ...restProps
    }: TextareaProps = $props();

    // "inline-block rounded-lg border border-indigo-600 bg-indigo-600 py-2 px-3 text-sm font-medium text-white";
    let style : string = $derived.by(() => {
        let base : string = "px-4 py-2 min-h-48 border text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border-gray-500 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all";
        if (variant == "full") {
            base += " w-full";
        }
        return base;
    });

</script>

<div class="inline-block">
{#if label}
    <label class="mt-2" for="{name + 'id'}">
        <span class="block text-sm font-semibold text-gray-900 dark:text-gray-100 mb-1">{label} {#if required === true} * {/if}</span>
    </label>
{/if}
    <textarea bind:value={value} class={style} {...restProps} ></textarea>

</div>

