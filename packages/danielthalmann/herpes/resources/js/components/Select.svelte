<script lang="ts">
    import { type ClassValue, clsx } from 'clsx';
    import { twMerge } from 'tailwind-merge';

    type SelectOption = {value: string ; label: string ; selected? : boolean};

    type Props = {
        value: string;
        placeholder?: string;
        label?: string;
        class?: string | undefined | null;
        classLabel?: string | undefined | null;
        classOutline?: string | undefined | null;
        items?: SelectOption[]
    };

    let {
        value = $bindable(),
        items = [],
        class: className,
        classLabel,
        classOutline,
        label,
        placeholder,
        ...restProps
    }: Props = $props();

    let select: HTMLElement;

    function cn(...inputs: ClassValue[]) {
        return twMerge(clsx(inputs));
    }

    let draweropened: boolean = $state(false);
    let openClass: string = $derived( draweropened ?  '' :  'rounded-b-lg' );

    const selectedItem = $derived(
        items.find((item) => item.value === value)
    );

    function selectItem(item : SelectOption) {
        value = item.value;
        draweropened = false;
    }

    function clickExterior(event : MouseEvent) {

        let elem : HTMLElement = <HTMLElement>event.target!;
        while (elem != null && elem != document.body && elem != select) {
            elem = <HTMLElement>elem.parentNode;
        }
        if (elem != select && draweropened) {
            draweropened = !draweropened;
        }
    }

</script>

<!--
TypeScript Discriminated Unions + destructing (required for "bindable") do not
get along, so we shut typescript up by casting `value` to `never`, however,
from the perspective of the consumer of this component, it will be typed appropriately.
-->
<svelte:window onclick={clickExterior} />

<div bind:this={select} class={cn(
        "relative",
        classOutline,
    )}>
    {#if label}
    <div
        class={cn(
            "px-2 absolute -top-4 left-2 bg-white dark:bg-gray-800  mb-8",
            classLabel,
        )}>
        {label}
    </div>
    {/if}
    <div class="relative">
        <input type="hidden" value={value} {...restProps}/>
        <button onclick={() => {draweropened = !draweropened}}
            class={cn(
                "px-4 py-2 border bg-white dark:bg-gray-800 border-gray-500 rounded-t-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all pr-9 cursor-pointer",
                className,
                openClass
            )}>
            {selectedItem?.label ? selectedItem?.label : placeholder}&nbsp;
            <svg class="h-5 my-2 absolute top-1 right-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor">
                <path d="M297.4 470.6C309.9 483.1 330.2 483.1 342.7 470.6L534.7 278.6C547.2 266.1 547.2 245.8 534.7 233.3C522.2 220.8 501.9 220.8 489.4 233.3L320 402.7L150.6 233.4C138.1 220.9 117.8 220.9 105.3 233.4C92.8 245.9 92.8 266.2 105.3 278.7L297.3 470.7z"/>
            </svg>
        </button>

        {#if draweropened}
        <div class="absolute left-0 right-0">
            <div class="
            bg-white
            dark:bg-gray-800
            focus-override!
            border-muted!
            shadow-popover!
            outline-hidden!
            z-2050!
            max-h-[var(--bits-select-content-available-height)]!
            w-[var(--bits-select-anchor-width)]!
            min-w-[var(--bits-select-anchor-width)]!
            select-none!
            rounded-b-xl!
            border!
            border-gray-500
            px-1!
            py-3!
            data-[side=bottom]:translate-y-1!
            data-[side=left]:-translate-x-1!
            data-[side=right]:translate-x-1!
            data-[side=top]:-translate-y-1!">

                <div class="text-neutral-700! m-auto!">
                    <i class="fa-solid fa-up"></i>
                </div>

                {#snippet option(item: SelectOption)}

                    {item.label}
                    {#if item.selected}
                        <div class="ml-auto">
                            <i class="fa-regular fa-check"></i>
                        </div>
                    {/if}

                {/snippet}

                <div>
                    {#each items as item}
                        <button
                            onclick={() => {selectItem(item)}}
                            class="
                            outline-hidden!
                            data-disabled:opacity-50!
                            flex!
                            h-10!
                            w-full!
                            select-none!
                            items-center!
                            py-3!
                            pl-5!
                            pr-1.5!
                            text-sm!
                            cursor-pointer
                            overflow-hidden
                            text-ellipsis
                            text-nowrap
                            ">
                            {@render option(item)}

                        </button>
                    {/each}
                </div>

                <div class="text-neutral-700! m-auto!">
                    <i class="fa-solid fa-down"></i>
                </div>
            </div>
        </div>
        {/if}
    </div>
</div>
