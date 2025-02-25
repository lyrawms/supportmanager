<template>
    <Dialog width="7xl">
        <div class="mt-3 text-center sm:mt-0 sm:text-left">
            <DialogTitle as="h3" class="text-2xl font-semibold text-stone-900 mb-6">Create Task</DialogTitle>
            <div class="flex mt-8">
                <form @submit.prevent="createTask" class="w-full flex">
                    <div class="w-[60%] pr-4">

                    </div>

                    <div class="w-[40%] space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                            <input v-model="formData.title" id="title" type="text"
                                   class="mt-1 p-2 border border-gray-300 rounded-md w-full"/>
                            <span v-if="errors.title" class="text-red-600 text-sm">{{ errors.title }}</span>
                        </div>

                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline:</label>
                            <input v-model="formData.deadline" id="deadline" type="date"
                                   class="mt-1 p-2 border border-gray-300 rounded-md w-full"/>
                            <span v-if="errors.deadline" class="text-red-600 text-sm">{{ errors.deadline }}</span>
                        </div>

                        <div>
                            <label for="intercomLink" class="block text-sm font-medium text-gray-700">Intercom
                                Link:</label>
                            <input v-model="formData.intercomLink" id="intercomLink" type="url"
                                   class="mt-1 p-2 border border-gray-300 rounded-md w-full"/>
                            <span v-if="errors.intercomLink" class="text-red-600 text-sm">{{
                                    errors.intercomLink
                                }}</span>
                        </div>

                        <div>
                            <label for="sla" class="block text-sm font-medium text-gray-700">SLA:</label>
                            <input v-model="formData.sla" id="sla" type="number"
                                   class="mt-1 p-2 border border-gray-300 rounded-md w-full"/>
                            <span v-if="errors.sla" class="text-red-600 text-sm">{{ errors.sla }}</span>
                        </div>
                        <div class="flex justify-end mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </Dialog>
</template>

<script>
import Dialog from "@/Components/Overlays/Dialog.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import {DialogTitle} from "@headlessui/vue";
import CheckboxGroup from "@/Components/Forms/CheckboxGroup.vue";

export default {
    components: {
        Dialog,
        PrimaryButton,
        DialogTitle,
        CheckboxGroup,
    },
    data: () => ({
        formData: {
            title: '',
            description: '',
            deadline: '',
            intercomLink: '',
            sla: '',
        },
        errors: {}
    }),
    methods: {
        createTask() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('/tasks/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                credentials: 'include',
                body: JSON.stringify({
                    formData: this.formData,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Task created", data);

                })
                .catch(error => {
                    console.error("Error creating task", error);
                    this.errors = error;
                });
        },
        assignDescription(value) {
            this.formData.description = value;
        }
    }
}
</script>

<style scoped>
</style>
