<script lang="ts">
    import { type Snippet } from "svelte";
    import { fade } from "svelte/transition";


    type DialogProps = {
        title?: string;
        open?: boolean;
        children?: Snippet<[]>;
    };

    let {
        title = $bindable(),
        open = $bindable(false),
        children
    } : DialogProps = $props();



</script>

{#if open}
<div class="base">
    <div class="portal">
        <div class="overlay z-2000 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 fixed inset-0 bg-black/50"  transition:fade
        ></div>
        <div class="max-h-lvh top-0 bottom-0 relative overflow-y-visible">
            <div
                class="bg-gray-300 dark:bg-gray-800/90 rounded-lg shadow-2xl data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 outline-hidden fixed left-[50%] top-[50%] z-2050 w-full max-w-[calc(100%-2rem)] translate-x-[-50%] translate-y-[-50%] border sm:max-w-140 md:w-full flex flex-col max-h-[90vh]"  transition:fade
            >
                <div class="shrink-0 px-5 pt-5">
                    <div class="flex w-full items-center justify-center text-lg font-semibold tracking-tight">
                        {#if title}
                            {title}
                        {:else}
                            {'Dialog'}
                        {/if}
                    </div>
                    <div class="bg-muted -mx-5 mb-0 mt-5 block h-px border-b"></div>
                </div>
                <div class="text-foreground-alt overflow-y-auto flex-1 px-5 py-5">
                    {@render children?.()}
                </div>
            </div>
        </div>
    </div>
</div>
{/if}
