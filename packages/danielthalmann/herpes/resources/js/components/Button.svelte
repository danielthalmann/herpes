<script lang="ts">
    import type { HTMLAnchorAttributes, HTMLButtonAttributes } from "svelte/elements";

    type ButtonType = "link" | "button" | "submit" | "reset" | null | undefined;
    type VariantType = "default" | "primary" | "warning";

    export type ButtonProps =
        HTMLButtonAttributes &
        HTMLAnchorAttributes & {
            type? : ButtonType,
            variant? : VariantType,
        };

    let {
        type : ButtonType = "button",
        variant = $bindable("default"),
        children,
        ...restProps
    }: ButtonProps = $props();

    let type : ButtonType = $state(null);
    let style : string = $state("cursor-pointer inline-block rounded-lg border py-2 px-3 text-sm font-medium");

    switch (variant) {
        case 'primary':
            style += ' border-indigo-600 bg-indigo-600 text-white hover:bg-indigo-600/30 dark:hover:text-white hover:text-indigo-600';
            break;
        case 'warning':
            style += ' border-orange-600 bg-orange-600 text-white hover:bg-orange-600/30 dark:hover:text-white hover:text-orange-600';
            break;
        default:
            style += ' border-indigo-600 bg-transparent text-black dark:bg-indigo-600/60 dark:text-gray-200 hover:bg-indigo-600/30 dark:hover:text-white hover:text-indigo-600';
    }

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
