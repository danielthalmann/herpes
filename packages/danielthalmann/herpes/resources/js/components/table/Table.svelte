<script lang="ts">
    import Button from "../Button.svelte";
    import Input from "../Input.svelte";


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
    <div class="flex justify-end">
        <div class="inline-block m-3  content-center">
            <Input variant="search" placeholder="search..." name="search" />
        </div>
        <div class=" m-3 content-center">
            <Button>test</Button>
        </div>
    </div>
</div>
