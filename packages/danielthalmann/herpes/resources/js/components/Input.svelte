<script lang="ts">
    import type {HTMLInputAttributes } from "svelte/elements";

    type VariantType = "default" | "search";

    export type InputProps = HTMLInputAttributes & {
            variant? : VariantType,
            label? : string
        };

    let {
        variant = "default",
        label,
        ...restProps
    }: InputProps = $props();

    // "inline-block rounded-lg border border-indigo-600 bg-indigo-600 py-2 px-3 text-sm font-medium text-white";
    let style : string = $derived.by(() => {
        let base : string = "px-4 py-2 border text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 border-gray-500 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all";
        if (variant == "search") {
            base += " pl-9";
        }
        return base;
    });

</script>

<div class="relative inline-block">
{#if label}
    <label class="mt-2" for="{name + 'id'}">
        <span class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">{label} @if($required === 'true') * @endif</span>
        <input class={style} {...restProps} />
    </label>
{:else}
    {#if variant == 'search'}
    <svg class="h-5 my-2 absolute top-1 left-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd"></path>
    </svg>
    {/if}
    <input class={style} {...restProps} />
{/if}
</div>

