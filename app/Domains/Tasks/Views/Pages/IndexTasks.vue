<template>
    <AppLayout title="Tasks">
        <template #header>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="font-semibold text-xl text-stone-800 leading-tight">
                        Tasks
                    </h2>
                    <p class="mt-2 text-sm text-stone-700">A list of all the users in your account including their name,
                        title, email and role.</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <primary-button color="amber" modal :href="route('tasks.create')">
                        <font-awesome-icon :icon="faPlus" class="me-2"/>
                        Create issue
                    </primary-button>
                </div>
            </div>
        </template>

        <template #default>
            <TasksTable :tasks="tasks.data"/>
           <div class="bg-stone-50 rounded-b-lg px-4 py-3 flex items-center justify-center sm:px-6 border-t border-stone-200">
               <nav class="relative flex justify-center">
                   <template v-for="link in tasks.links" :key="link.label">
                       <Link
                           preserve-scroll
                           :href="link.url ?? ''"
                           v-html="link.label"
                           class="flex items-center justify-center px-3 py-2 text-sm rounded-lg text-amber-600"
                           :class="{ 'bg-amber-300': link.active, '!text-amber-600/50': !link.url }"
                       />
                   </template>
               </nav>
           </div>
        </template>
    </AppLayout>
</template>
<script>
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {faGear, faCheck, faPlus, faSearch} from '@fortawesome/free-solid-svg-icons';
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import {default as TasksTable} from "../Components/Table/Table.vue";
import {Link} from "@inertiajs/vue3";

export default {
    components: {
        FontAwesomeIcon,
        PrimaryButton,
        AppLayout,
        TasksTable,
        Link,
    },
    props: {
        tasks: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            faPlus,
            faSearch,
            faGear,
            faCheck,
        };
    },
};
</script>
