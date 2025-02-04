<template>
    <AppLayout title="Tasks">
        <template #header>
            <h2 class="font-semibold text-xl text-stone-800 leading-tight">
                Tasks
            </h2>
        </template>

        <template #default>
            <TasksTable :tasks="tasks"/>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import {default as TasksTable} from "../Components/Table/Table.vue";

export default {
    name: "Index",
    components: {TasksTable, AppLayout},
    props: {
        tasks: {
            type: Array,
            required: true
        }
    }
}
</script>

<style scoped>

</style>
