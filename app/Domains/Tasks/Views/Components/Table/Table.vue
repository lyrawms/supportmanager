<template>
    <div class="flow-root">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="relative">
                    <div v-if="selectedTasks.length > 0"
                         class="absolute top-0 left-14 flex h-12 items-center space-x-3 bg-white sm:left-12">
                        <button type="button"
                                class="inline-flex items-center rounded-sm bg-white px-2 py-1 text-sm font-semibold text-stone-900 ring-1 shadow-xs ring-stone-300 ring-inset hover:bg-stone-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white">
                            Bulk edit
                        </button>
                        <button type="button"
                                class="inline-flex items-center rounded-sm bg-white px-2 py-1 text-sm font-semibold text-stone-900 ring-1 shadow-xs ring-stone-300 ring-inset hover:bg-stone-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white">
                            Delete all
                        </button>
                    </div>
                    <table class="min-w-full table-fixed divide-y divide-stone-300">
                        <thead>
                        <tr>
                            <th scope="col" class="relative px-7 sm:w-12 sm:px-6">
                                <div class="group absolute top-1/2 left-4 -mt-2 grid size-4 grid-cols-1">
                                    <input type="checkbox"
                                           class="col-start-1 row-start-1 appearance-none rounded-sm border border-stone-300 bg-white checked:border-amber-600 checked:bg-amber-600 indeterminate:border-amber-600 indeterminate:bg-amber-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600 disabled:border-stone-300 disabled:bg-stone-100 disabled:checked:bg-stone-100 forced-colors:appearance-auto"
                                           :checked="indeterminate || selectedTasks.length === tasks.length"
                                           @change="selectedTasks = $event.target.checked ? tasks.map((t) => t.id) : []"/>
                                    <svg
                                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-stone-950/25"
                                        viewBox="0 0 14 14" fill="none">
                                        <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5"
                                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11"
                                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </th>
                            <th scope="col"
                                class="min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-stone-900">Name
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-stone-900">Status</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-stone-900">Type
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-stone-900">Prio
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-stone-900">
                                Deadine
                            </th>
                            <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-3">
                                <span class="sr-only">View</span>
                            </th>
                            <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-3">
                                <span class="sr-only">Done</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-200 bg-white">
                        <tr v-for="task in tasks" :key="task.id"
                            :class="[selectedTasks.includes(task.id) && 'bg-stone-50']">
                            <td class="relative px-7 sm:w-12 sm:px-6">
                                <div v-if="selectedTasks.includes(task.id)"
                                     class="absolute inset-y-0 left-0 w-0.5 bg-amber-600"></div>
                                <div class="group absolute top-1/2 left-4 -mt-2 grid size-4 grid-cols-1">
                                    <input type="checkbox"
                                           class="col-start-1 row-start-1 appearance-none rounded-sm border border-stone-300 bg-white checked:border-amber-600 checked:bg-amber-600 indeterminate:border-amber-600 indeterminate:bg-amber-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600 disabled:border-stone-300 disabled:bg-stone-100 disabled:checked:bg-stone-100 forced-colors:appearance-auto"
                                           :value="task.id" v-model="selectedTasks"/>
                                    <svg
                                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-stone-950/25"
                                        viewBox="0 0 14 14" fill="none">
                                        <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5"
                                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11"
                                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </td>
                            <td :class="['py-4 pr-3 text-sm font-medium whitespace-nowrap', selectedTasks.includes(task.id) ? 'text-amber-600' : 'text-stone-900']">
                                {{ task.title }}
                            </td>
                            <td class="px-3 py-4 text-sm whitespace-nowrap">
                                <Status :status="task.status"/>
                            </td>
                            <td class="px-3 py-4 text-sm whitespace-nowrap">
                                <Type :type="task.type"/>
                            </td>
                            <td class="px-3 py-4 text-sm whitespace-nowrap text-stone-500">
                                Prio
                            </td>
                            <td class="px-3 py-4 text-sm whitespace-nowrap text-stone-500">
                                {{ task.deadline }}
                            </td>
                            <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-3">
                                <primary-button :href="route('tasks.show', {uuid:task.uuid} )" modal color="amber">
                                    View
                                </primary-button>
                            </td>
                            <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-3">
                                <primary-button
                                    :href="route('tasks.updateStatus', {uuid:task.uuid, status:'finished'} )" modal
                                    color="green">
                                    Finish
                                </primary-button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ref} from "vue";
import {Link} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Type from "../Type.vue";
import Status from "../Status.vue";

export default {
    name: "Table",
    components: {Status, Type, PrimaryButton, Link},
    props: {
        tasks: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            selectedTasks: ref([]),
        }
    },
    computed: {
        indeterminate() {
            return this.selectedTasks.length > 0 && this.selectedTasks.length < this.tasks.length;
        }
    },
};
</script>
