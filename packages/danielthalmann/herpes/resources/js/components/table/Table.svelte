<script lang="ts">
    import Button from "../Button.svelte";
    import Input from "../Input.svelte";
    import Checkbox from "../Checkbox.svelte";
    import Select from "../Select.svelte";

    let items = [{
        value: '10',
        label: '10'
    },
    {
        value: '20',
        label: 'Un long text'
    }
];

</script>


<div class="flex content-center mb-5">
    <h1 class="font-medium grow text-3xl content-center">
        <span>Customers</span>
    </h1>
    <div class="content-center">
        <Button href="http://localhost:8000/admin/customers/create">
        Créer
        </Button>
    </div>
</div>

<div class=" bg-gray-800/90 rounded-lg">
    <!-- search and filter -->
    <div class="flex justify-end">
        <div class="inline-block m-3 content-center">
            <Input variant="search" placeholder="search..." name="search" />
        </div>
        <div class=" m-3 content-center">
            <Button>test</Button>
        </div>
    </div>

    <div class="mb-3">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-700 ">
                    <th class="text-left px-2 py-3 w-3"><Checkbox/></th>
                    <th class="text-left px-2 py-3">id</th>
                    <th class="text-left px-2 py-3">aaa</th>
                    <th class="text-left px-2 py-3">bbb</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="px-2 py-3"><Checkbox/></td>
                    <td class="px-2 py-3">id</td>
                    <td class="px-2 py-3">aaa</td>
                    <td class="px-2 py-3">bbb</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">
        <div class="inline-block m-3  content-center">
            <Input variant="search" placeholder="search..." name="search" />

        </div>
        <div class=" m-3 content-center">
            <Select value="" items={items} />
        </div>
    </div>

</div>
