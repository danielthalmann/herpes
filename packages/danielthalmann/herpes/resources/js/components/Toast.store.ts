import { writable } from "svelte/store";

export const toasts = writable([]);

export type ToastType = {
    id?: number;
    message?: string;
    type?: 'info'|'error'|'success';
    dismissible?: boolean;
    timeout?: number;
};

export const addToast = (toast: ToastType) => {
    // Create a unique ID so we can easily find/remove it
    // if it is dismissible/has a timeout.
    const id: number = Math.floor(Math.random() * 10000);

    // Setup some sensible defaults for a toast.
    const newToast: ToastType = {
        id,
        message: toast.message ?? '',
        type: toast.type ?? "info",
        dismissible: toast.dismissible ?? true,
        timeout: toast.timeout ?? 3000,
    };

    // Push the toast to the top of the list of toasts
    toasts.update((all) => [<never>newToast, ...all] );

    // If toast is dismissible, dismiss it after "timeout" amount of time.
    if (newToast.timeout) setTimeout(() => { dismissToast(id); }, newToast.timeout);
};

export const dismissToast = (id : number) => {
    toasts.update((all) => all.filter((t : ToastType) => t.id !== id));
};
