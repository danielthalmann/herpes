<script lang="ts">
    import { onMount } from "svelte";
    import Table, { type TableColumn } from "../components/Table.svelte";
    import Arianne from "../components/layouts/Arianne.svelte";
    import Form, { type FormComponent } from "../components/Form.svelte";
    import Button from "../components/Button.svelte";
    import { type Paginate } from "../types/Laravel";
    import { type AddressType } from "../types/App";
    import Dialog from "../components/Dialog.svelte";

    let { api } = $props();

    type TableContext = {
        perpage: number;
        search: string;
    };

    let tablecolumns: TableColumn = $state.raw([
        { key: "id", label: "id", type: "id" },
        { key: "company", label: "Société", type: "text" },
        { key: "department", label: "Département", type: "text" },
        { key: "name", label: "Nom", type: "text" },
        { key: "street", label: "Rue", type: "text" },
        { key: "zipcode", label: "NPA", type: "text" },
        { key: "city", label: "Ville", type: "text" },
    ]);

    let createComponents: FormComponent = $state.raw([
        { key: "company", label: "Société", type: "text" },
        { key: "department", label: "Département", type: "text" },
        { key: "name", label: "Nom", type: "text" },
        { key: "street", label: "Rue", type: "text" },
        { key: "zipcode", label: "NPA", type: "text" },
        { key: "city", label: "Ville", type: "text" },
    ]);

    let editComponents: FormComponent = $state.raw([
        { key: "id", label: "id", className: "w-12", type: "text", readonly: true },
        { key: "company", label: "Société", type: "text" },
        { key: "department", label: "Département", type: "text" },
        { key: "name", label: "Nom", type: "text" },
        { key: "street", label: "Rue", type: "text" },
        { key: "zipcode", label: "NPA", type: "text" },
        { key: "city", label: "Ville", type: "text" },
    ]);

    let addresses: Paginate | undefined = $state();
    let selectedAddress: AddressType | null = $state.raw(null);
    let newAddress: AddressType | null = $state.raw(null);

    let context: TableContext = { perpage: 20, search: "" };

    onMount(() => {
        loadRows();
    });

    const changePerPage = (perpage: number = 20) => {
        context.perpage = perpage;
        loadRows();
    };

    const loadRows = () => {
        fetch(api.index + "?paginate=" + context.perpage + "&search=" + context.search).then((response) => {
            response.json().then((json) => {
                addresses = json;
            });
        });
    };

    const addRow = (address: AddressType) => {
        const fetchOptions: RequestInit = {
            method: "POST",
            headers: { Accept: "application/json", "Content-Type": "application/json" },
            body: JSON.stringify(address),
        };
        fetch((<string>api.store).replace("|id|", address.id!), fetchOptions).then(() => {
            loadRows();
        });
        newAddress = null;
    };

    const updateRow = (address: AddressType) => {
        let index = addresses!.data.findIndex((item: any) => address!.id === item.id);
        if (index > -1) {
            const fetchOptions: RequestInit = {
                method: "PUT",
                headers: { Accept: "application/json", "Content-Type": "application/json" },
                body: JSON.stringify(address),
            };
            fetch((<string>api.update).replace("|id|", address.id!), fetchOptions).then(() => {
                addresses!.data[index] = address;
            });
        }
        selectedAddress = null;
    };

    const createRow = () => {
        newAddress = {
            company : '',
            department : '',
            name : '',
            street : '',
            zipcode : '',
            city : ''
         };
    };

    const editRow = (address: AddressType) => {
        selectedAddress = JSON.parse(JSON.stringify(address));
    };

    const deleteRow = (address: AddressType) => {
        let index = addresses!.data.findIndex((item: any) => address!.id === item.id);
        if (index > -1) {
            fetch((<string>api.destroy).replace("|id|", address.id!), { method: "DELETE" }).then(() => {
                addresses!.data.splice(index, 1);
            });
        }
    };

    const searchRows = (search: string) => {
        context.search = search;
        loadRows();
    };
</script>

<div>
    <Arianne></Arianne>
    {#if addresses}
        <Table
            title={api.name}
            rows={addresses!.data}
            columns={tablecolumns}
            perpage={addresses.per_page}
            onchangeperpage={changePerPage}
            ondelete={deleteRow}
            oncreate={createRow}
            onsearch={searchRows}
            onedit={editRow}
        />
    {/if}

    <Dialog title="Edit" open={selectedAddress ? true : false}>
        <div class="mb-5">
            <Form bind:data={selectedAddress!} components={editComponents} onchange={() => {}} />
        </div>
        <div class="border-b mb-5 border-neutral-400"></div>
        <div class="mb-3 text-right">
            <Button variant="primary" onclick={() => updateRow(selectedAddress!)}>Save</Button>
            <Button onclick={() => { selectedAddress = null; }}>Close</Button>
        </div>
    </Dialog>

    <Dialog title="Create" open={newAddress ? true : false}>
        <div class="mb-5">
            <Form bind:data={newAddress} components={createComponents} onchange={() => {}} />
        </div>
        <div class="border-b mb-5 border-neutral-400"></div>
        <div class="mb-3 text-right">
            <Button variant="primary" onclick={() => addRow(newAddress!)}>Save</Button>
            <Button onclick={() => { newAddress = null; }}>Close</Button>
        </div>
    </Dialog>
</div>
