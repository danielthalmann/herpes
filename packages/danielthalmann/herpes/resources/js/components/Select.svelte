<script lang="ts">
    import { type ClassValue, clsx } from 'clsx';
    import { twMerge } from 'tailwind-merge';
    import { onMount } from 'svelte';

    export type SelectOption = {
        value: string;
        label: string ;
        selected?: boolean
    };

    export type SelectProps = {
        value: string;
        placeholder?: string;
        label?: string;
        class?: string | undefined | null;
        classLabel?: string | undefined | null;
        classOutline?: string | undefined | null;
        onchange?: (value: any) => void;
        items?: SelectOption[]
    };

    let {
        value = $bindable(''),
        items = [],
        class: className,
        classLabel,
        classOutline,
        label,
        placeholder,
        onchange = (value: any) => {},
        ...restProps
    }: SelectProps = $props();

    let select: HTMLElement;

    function cn(...inputs: ClassValue[]) {
        return twMerge(clsx(inputs));
    }

    let selectStyle : string = $state('');
    let draweropened: boolean = $state(false);
    let openClass: string = $derived( draweropened ?  '' :  'rounded-b-lg' );
    let selectedItem : SelectOption | undefined = $state();

    function selectItem(item : SelectOption) {
        console.log(item);
        if (value != item.value) {
            onchange(item.value);
        }

        value = item.value;
        selectedItem = item;

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

    onMount(() => {
        selectedItem = items.find((item) => item.value === value);
        selectStyle = 'min-width: ' + select.clientWidth.toString() + 'px;';
    });

</script>

<!--
TypeScript Discriminated Unions + destructing (required for "bindable") do not
get along, so we shut typescript up by casting `value` to `never`, however,
from the perspective of the consumer of this component, it will be typed appropriately.
-->
<svelte:window onclick={clickExterior} />

<div class="mb-2">

    {#if label}
    <div
        class={cn(
            "pb-2 bg-white dark:bg-gray-800",
            classLabel,
        )}>
        {label}
    </div>
    {/if}

    <div bind:this={select} class={cn(
            "",
            classOutline,
        )}>

        <button
            onclick={() => {draweropened = !draweropened}}
            tabindex="0"
            class={cn(
                "bg-white w-full dark:bg-gray-800 flex min-h-11 rounded-md px-2 border border-gray-500 rounded-t-lg outline-none transition-all cursor-pointer",
                className,
                openClass
            )}>
            <div class="grow my-auto text-left pl-2">
                {#if selectedItem}
                    {selectedItem.label}&nbsp;
                {:else}
                    {placeholder}
                {/if}
            </div>

            <div class="flex ml-2">
                <svg class="h-5 my-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor">
                    <path d="M297.4 470.6C309.9 483.1 330.2 483.1 342.7 470.6L534.7 278.6C547.2 266.1 547.2 245.8 534.7 233.3C522.2 220.8 501.9 220.8 489.4 233.3L320 402.7L150.6 233.4C138.1 220.9 117.8 220.9 105.3 233.4C92.8 245.9 92.8 266.2 105.3 278.7L297.3 470.7z"/>
                </svg>
            </div>

        </button>

        {#if draweropened}
        <div class="relative">
            <div class="absolute" style={selectStyle}>
                <div class="
                bg-white
                dark:bg-gray-800
                focus-override!
                border-muted!
                shadow-popover!
                outline-hidden!
                z-2050!
                select-none!
                rounded-b-xl!
                border!
                border-neutral-300!
                px-1!
                py-3!
                ">

                    <div class="text-neutral-700 text-center m-auto">
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
                                outline-hidden
                                data-disabled:opacity-50
                                flex
                                h-10
                                w-full
                                select-none
                                items-center
                                py-3
                                pl-3
                                pr-1.5
                                text-sm
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
        </div>
        {/if}
    </div>
</div>
