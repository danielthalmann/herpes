<script lang="ts">
    import Toast from "./Toast.svelte";
    import { dismissToast, toasts, type ToastType } from "./Toast.store";
</script>

{#if $toasts}
    <section
        class="fixed flex flex-col justify-center z-1000 top-0 left-0 right-0 my-6"
    >
        {#each <ToastType[]>$toasts as toast (toast.id)}
            <Toast
                type={toast.type}
                dismissible={toast.dismissible}
                dismiss={() => {
                    dismissToast(toast.id!);
                }}>{toast.message}</Toast
            >
        {/each}
    </section>
{/if}
