<template>
    <Dialog width="7xl">

        <div class="mt-3 text-center sm:mt-0 sm:text-left">
            <DialogTitle as="h3" class="text-base font-semibold text-stone-900 p-4">{{
                    task.title
                }}
            </DialogTitle>
            <div class="flex mt-8">
                <div v-if="task.description" class="w-3/5 p-4" v-html="task.description"></div>
                <p v-else class="w-3/5 p-4"> No description added</p>
                <div class="w-3/5 rounded-2xl">
                    <div class="mb-4">
                        <Status :status="task.status"/>
                    </div>
                    <div class=" bg-amber-200 p-4 rounded-2xl space-y-6">
                        <div class="border-stone-200 bg-white shadow-lg rounded-2xl p-4 space-y-2">
                            <div>
                                <p>Deadline</p>
                                <p class="text-stone-500">{{
                                        $moment(deadline).isAfter($moment().subtract(1, 'week')) ? $moment(deadline).calendar() : $moment(deadline).format('DD/MM/YYYY')
                                    }}</p>
                            </div>
                            <div>
                                <p>Finished at</p>
                                <p v-if="task.finished_at" class=" text-stone-500">{{
                                        $moment(task.finished_at).isAfter($moment().subtract(1, 'week')) ? $moment(task.finished_at).calendar() : $moment(task.finished_at).format('DD/MM/YYYY')
                                    }}</p>
                                <p v-else class=" text-stone-500">Not completed yet</p>
                            </div>
                            <div>
                                <p>SLA</p>
                                <p class=" text-stone-500">{{ sla }} Days</p>
                            </div>
                        </div>
                        <div class="p-4 shadow-lg rounded-2xl bg-white space-y-1">
                            <div>
                                <p>Intercom</p>
                                <a v-if="task.intercom_link" :href="task.intercom_link" target="_blank"
                                   rel="noopener noreferrer" class="text-blue-500">Link</a>
                                <p v-else class="text-stone-500"> None</p>
                            </div>
                            <div>
                                <p>Priority</p>
                                <p v-if="task.priority" class="text-stone-500">{{ task.priority }}</p>
                                <p v-else class="text-stone-500"> None</p>
                            </div>
                            <div class="space-y-1">
                                <a @click="handleTypeClick" class="cursor-pointer underline">Type</a>
                                <Type v-if="currentType && !showComboBoxType" :type="currentType"/>
                                <p v-else-if="showComboBoxType">
                                    <ComboBoxSubject :currentAssignedSubject="currentType"
                                                     subject="type"
                                                     @updateTaskType="assignNewType"/>
                                </p>
                                <p v-else-if="!currentType" class="text-stone-500 my-1"> None</p>
                            </div>
                        </div>
                        <div class="p-4 bg-white shadow-lg rounded-2xl space-y-1">
                            <div>
                                <a @click="handleUserClick" class="cursor-pointer underline">Assignee</a>
                                <p v-if="currentAssignee && !showComboBoxUser" class="text-stone-500">{{
                                        currentAssignee.name
                                    }}</p>
                                <p v-else-if="showComboBoxUser">
                                    <ComboBoxSubject :currentAssignedSubject="currentAssignee"
                                                     @updateTaskUser="assignNewUser" subject="user"/>
                                </p>
                                <p v-else-if="!currentAssignee" class="text-stone-500"> None</p>

                            </div>
                            <div>
                                <p>Creator</p>
                                <p v-if="task.creator_id" class="text-stone-500">{{
                                        task.creator?.name
                                    }}</p>
                                <p v-else class="text-stone-500"> None</p>
                            </div>
                        </div>
                    </div>
                    <div class="pt-3 px-8">
                        <div>
                            <p class="text-xs text-stone-500">Created at: {{
                                    $moment(task.created_at).isAfter($moment().subtract(1, 'week')) ? $moment(task.created_at).calendar() : $moment(task.created_at).format('DD/MM/YYYY')
                                }} </p>
                        </div>
                        <div>
                            <p class="text-xs text-stone-500">Updated at: {{
                                    $moment(task.updated_at).isAfter($moment().subtract(1, 'week')) ? $moment(task.updated_at).calendar() : $moment(task.updated_at).format('DD/MM/YYYY')
                                }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <template #cta>
            <primary-button :href="route('tasks.updateStatus', {uuid:task.uuid, status:'finished', category:getCategoryFromUrl() } )" link color="green">
                Finish
            </primary-button>
            <primary-button @click="close" :href="route('tasks.delete', {uuid:task.uuid, category:getCategoryFromUrl() } )" link color="red">
                Delete
            </primary-button>
        </template>


    </Dialog>
</template>


<script>
import Dialog from "@/Components/Overlays/Dialog.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import {DialogTitle} from "@headlessui/vue";
import CheckboxGroup from "@/Components/Forms/CheckboxGroup.vue";
import ComboBoxSubject from "../Components/ComboBoxSubject.vue";
import Type from "../Components/Type.vue";
import dayjs from "dayjs";
import Status from "../Components/Status.vue";
import { Link } from '@inertiajs/vue3';


export default {
    name: "ShowTask",
    components: {
        Link,
        Status,
        Type,
        ComboBoxSubject,
        Dialog,
        PrimaryButton,
        DialogTitle,
        CheckboxGroup,
    },
    props: {
        task: {
            type: Object,
            required: true
        }
    },

    data: () => ({
        valueOfCheckbox: false,
        showComboBoxType: false,
        showComboBoxUser: false,
        currentType: {},
        currentAssignee: {},
        deadline: null,
        sla: null,
        newType: {},
        newUser: {},
    }),
    methods: {
        getCategoryFromUrl() {
            // get the table category from the url
            const params = new URLSearchParams(window.location.search);
            return params.get("category") || 'Company';
        },
        handleTypeClick() {
            this.toggleComboBoxType();
            this.updateTaskType(this.newType);
        },
        handleUserClick() {
            this.toggleComboBoxUser();
            this.updateTaskUser(this.newUser);
        },
        toggleComboBoxType() {
            // toggle the visibility of the combobox
            this.showComboBoxType = !this.showComboBoxType;
        },
        toggleComboBoxUser() {
            // toggle the visibility of the combobox
            this.showComboBoxUser = !this.showComboBoxUser;
        },
        updateTaskTypePageData(type) {
            // update the task type data on the page
            this.currentType = type;
            this.sla = type.sla;
            this.deadline = dayjs(this.task.created_at).add(type.sla, "day").format("YYYY-MM-DD HH:mm:ss");
        },
        updateTaskUserPageData(user) {
            // update the task user data on the page
            this.currentAssignee = user;
        },

        updateTaskType(type) {
            // if the combobox type is not visible, the new type is set and is different than the current type, update the task type
            if (!this.showComboBoxType && (type.uuid && type.uuid !== (this.currentType ? this.currentType.uuid : null))) {
                // first update the data on the page
                this.updateTaskTypePageData(type);
                // send the request to the server
                this.$inertia.post(
                    '/task/update-type',
                    {
                        taskUuid: this.task.uuid,
                        typeUuid: type.uuid,
                        category: this.getCompanyParam(),
                    },
                    {
                        preserveScroll: true, // Prevents page scroll reset
                        onSuccess: () => {
                            // log the success
                            console.log("Task type updated successfully");
                        },
                        onError: (error) => {
                            // log the error
                            console.error("Error updating task type:", error);
                        }
                    }
                );
            }
        },
        updateTaskUser(user) {
            // if the combobox user is not visible, the new user is set and is different than the current user, update the task user
            if (!this.showComboBoxUser && (user.uuid && user.uuid !== (this.currentAssignee ? this.currentAssignee.uuid : null))) {
                // first update the data on the page
                this.updateTaskUserPageData(user);
                // send the request to the server
                this.$inertia.post(
                    '/task/update-user',
                    {
                        taskUuid: this.task.uuid,
                        userUuid: user.uuid,
                        category: this.getCompanyParam(),
                    },
                    {
                        preserveScroll: true,
                        onSuccess: () => {
                            // log the success
                            console.log("Task user updated successfully");
                        },
                        onError: (error) => {
                            // log the error
                            console.error("Error updating task user:", error);
                        }
                    }
                );
            }
        },
        getCompanyParam() {
            // get the company parameter from the url
            return new URLSearchParams(window.location.search).get("category") || "Company";
        },
        assignNewType(type) {
            // assign the new type
            this.newType = type;
        },
        assignNewUser(user) {
            // assign the new user
            this.newUser = user;
        },

    },
    mounted() {
        this.currentType = this.task.type;
        this.currentAssignee = this.task.assignee;
        this.deadline = this.task.deadline;
        this.sla = this.task.sla;

    }


}
</script>
