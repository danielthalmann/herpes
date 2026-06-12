
<script lang="ts">

    export type BreadcrumbLink = {
        url?: string | null;
        label: string;
    };

    export type BreadcrumbProps = {
        breadcrumb?: Array<BreadcrumbLink>
    };

    let {
        breadcrumb = $bindable([])
    } : BreadcrumbProps = $props();

</script>

{#if breadcrumb.length > 0}
<nav class="mb-3">
    <ol class="flex content-middle">
        {#each breadcrumb as crumb, index}
            <li class="flex">
                {#if index > 0}
                    <svg class="h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path>
                    </svg>
                    <!--
                    <svg class=" h-7 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"></path>
                    </svg>
                    -->
                {/if}
                {#if crumb.url}
                    <a href={crumb.url} class="fi-breadcrumbs-item-label">
                        {crumb.label}
                    </a>
                {:else}
                    <span class="">
                        {crumb.label}
                    </span>
                {/if}
            </li>

        {/each}
    </ol>
</nav>
{/if}
