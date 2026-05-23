<script lang="ts">
    import type { HTMLInputAttributes } from "svelte/elements";

    type VariantType = "default" | "primary" | "submit" | "reset";

    export type ButtonProps =
        HTMLInputAttributes & {
            variant? : VariantType,
        };

    let {
        variant : VariantType = "primary",
        children,
        ...restProps
    }: ButtonProps = $props();

    let style : string = "rounded border-gray-300 w-8 accent-indigo-600 focus:ring-indigo-500 scale-150";

</script>

{#if children}
<label class="flex items-center">
    <input type="checkbox" class={style} {...restProps}/>
    <span class="ml-2 text-sm text-gray-900 dark:text-gray-100">{@render children?.()}</span>
</label>
{:else}
    <input type="checkbox" class={style} {...restProps}/>
{/if}
