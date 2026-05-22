<script lang="ts">
    import type { HTMLAnchorAttributes, HTMLButtonAttributes } from "svelte/elements";

    type ButtonType = "link" | "button" | "submit" | "reset" | null | undefined;
    type VariantType = "default" | "primary" | "submit" | "reset";

    export type ButtonProps =
        HTMLButtonAttributes &
        HTMLAnchorAttributes & {
            type? : ButtonType,
            variant? : VariantType,
        };

    let {
        type : ButtonType = "button",
        variant : VariantType = "primary",
        children,
        ...restProps
    }: ButtonProps = $props();

    let type : ButtonType = $state(null);

    let style : string = "cursor-pointer inline-block rounded-lg border border-indigo-600 bg-indigo-600 py-2 px-3 text-sm font-medium text-white hover:bg-indigo-600/30 dark:hover:text-white hover:text-indigo-600";

</script>

{#if type == 'link'}
    <a class={style} {...restProps}>
        {@render children?.()}
    </a>
{:else}
    <button type={type} class={style} {...restProps}>
        {@render children?.()}
    </button>
{/if}
