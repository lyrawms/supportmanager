<template>
    <AppLayout title="Tasks">
        <template #header>
            <h2 class="font-semibold text-xl text-stone-800 leading-tight">
                Tasks
            </h2>
        </template>

        <template #default>
            <TasksTable :tasks="tasks.data"/>
            <nav class="relative flex justify-center">
                <template v-for="link in tasks.links" :key="link.label">
                    <Link
                        preserve-scroll
                        :href="link.url ?? ''"
                        v-html="link.label"
                        class="flex items-center justify-center px-3 py-2 text-sm rounded-lg text-gray-600"
                        :class="{ 'bg-gray-200': link.active, '!text-gray-300': !link.url }"
                    />
                </template>
            </nav>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import {default as TasksTable} from "../Components/Table/Table.vue";
import { Link } from '@inertiajs/vue3';
export default {
    name: "Index",
    components: {TasksTable, AppLayout, Link},
    props: {
        tasks: {
            type: Object,
            required: true
        }
    },


}
</script>

<style scoped>

</style>
