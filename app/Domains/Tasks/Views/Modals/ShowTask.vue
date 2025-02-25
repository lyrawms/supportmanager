<template>
    <Dialog width="3xl">

        <div class="mt-3 text-center sm:mt-0 sm:text-left">
            <DialogTitle as="h3" class="text-base font-semibold text-stone-900">{{ task.title }}</DialogTitle>
            <div class="flex mt-8">
                <div class="w-3/5" v-html="formData.description"></div>
<!--dit moet nog aangepast worden -->

                <div class="w-2/5 rounded-2xl">
                    <div class=" bg-amber-200 p-4 rounded-2xl space-y-6">
                        <div class="border-stone-200 bg-white shadow-lg rounded-2xl p-4 space-y-2">
                            <div>
                                <p>Deadline</p>
                                <p class="text-stone-500">{{
                                        $moment(task.created_at).isAfter($moment().subtract(1, 'week')) ? $moment(task.created_at).calendar() : $moment(task.created_at).format('DD/MM/YYYY')
                                    }}</p>
                            </div>
                            <div>
                                <p>Completed at</p>
                                <p v-if="task.completed_at" class=" text-stone-500">{{
                                        $moment(task.created_at).isAfter($moment().subtract(1, 'week')) ? $moment(task.created_at).calendar() : $moment(task.created_at).format('DD/MM/YYYY')
                                    }}</p>
                                <p v-else class=" text-stone-500">Not completed yet</p>
                            </div>
                            <div>
                                <p>SLA</p>
                                <p class=" text-stone-500">{{ task.sla }} Days</p>
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
                                <p v-if="currentType && !showComboBoxType"
                                   :style="{ color: getMostReadableColor(currentType.color) ,backgroundColor: currentType.color }"
                                   class="flex w-min rounded-2xl px-2 py-1">
                                    {{ currentType.title }}</p>
                                <p v-else-if="showComboBoxType">
                                    <ComboBoxType :currentAssignedType="currentType" :taskUuid="task.uuid"
                                              @updateTaskType="assignNewType"/>
                                </p>
                                <p v-else-if="!currentType" class="text-stone-500 my-1"> None</p>
                            </div>
                        </div>
                        <div class="p-4 bg-white shadow-lg rounded-2xl space-y-1">
                            <div>
                                <a @click="handleUserClick" class="cursor-pointer underline">User</a>
                                <p v-if="currentUser &&!showComboBoxUser" class="text-stone-500">{{ currentUser.name }}</p>
                                <p v-else-if="showComboBoxUser">
                                    <ComboBoxUser :currentAssignedUser="currentUser" :taskUuid="task.uuid"
                                              @updateTaskUser="assignNewUser"/>
                                </p>
                                    <p v-else-if="!currentUser" class="text-stone-500"> None</p>

                            </div>
                            <div>
                                <p>Creator</p>
                                <p v-if="task.creator_id" class="text-stone-500">{{ task.creator?.name }}</p>
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

        </template>

        <!--<template #secondary>
            <checkbox-group>
                <checkbox-field>
                    <input-label>Create another issue</input-label>
                    <Checkbox name="discoverability" v-model="valueOfCheckbox" color="amber" />
                </checkbox-field>
            </checkbox-group>
        </template>-->
    </Dialog>
</template>


<script>
import {Modal, ModalLink} from '@inertiaui/modal-vue'
import Dialog from "@/Components/Overlays/Dialog.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import {DialogTitle} from "@headlessui/vue";
import CheckboxGroup from "@/Components/Forms/CheckboxGroup.vue";
import CheckboxField from "@/Components/Forms/CheckboxField.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import Checkbox from "@/Components/Forms/Checkbox.vue";
import InputDescription from "@/Components/Forms/InputDescription.vue";
import tinycolor from "tinycolor2";
import ComboBoxType from "../Components/ComboBoxType.vue";
import ComboBoxUser from "../Components/ComboBoxUser.vue";

export default {
    methods: {
        handleTypeClick() {
            this.toggleComboBoxType();
            this.updateTaskType(this.newType);
        },
        handleUserClick() {
            this.toggleComboBoxUser();
            this.updateTaskUser(this.newUser);
        },
        getMostReadableColor(color) {
            return tinycolor.mostReadable(color, [], {includeFallbackColors: true});
        },
        toggleComboBoxType() {
            this.showComboBoxType = !this.showComboBoxType;
        },
        toggleComboBoxUser() {
            this.showComboBoxUser = !this.showComboBoxUser;
        },

        updateTaskType(type) {
            if (!this.showComboBoxType && (type.uuid && type.uuid !== (this.currentType ? this.currentType.uuid : null))) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                this.currentType = this.newType
                fetch('/task/update-type', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        taskUuid: this.task.uuid,
                        typeUuid: type.uuid,
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Task type updated:", data);

                    })
                    .catch(error => {
                        console.error("Error updating task type:", error);
                    });
            }
        },
        updateTaskUser(user) {
            if (!this.showComboBoxUser && (user.uuid && user.uuid !== (this.currentUser ? this.currentUser.uuid : null))) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                this.currentUser = this.newUser
                fetch('/task/update-user', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        taskUuid: this.task.uuid,
                        userUuid: user.uuid,
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Task user updated:", data);

                    })
                    .catch(error => {
                        console.error("Error updating task user:", error);
                    });
            }
        },
        assignNewType(type) {
            this.newType = type;
        },
        assignNewUser(user) {
            this.newUser = user;
        }
    },
    components: {
        ComboBoxUser,
        ComboBoxType,
        Modal,
        ModalLink,
        Dialog,
        PrimaryButton,
        DialogTitle,
        CheckboxGroup,
        CheckboxField,
        InputLabel,
        Checkbox,
        InputDescription,
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
        currentUser: {},
        newType: {},
        newUser: {},
        froalaConfig: {
            editable: true,
        },
    }),
    mounted() {
        this.currentType = this.task.type;
        this.currentUser = this.task.assignee;
    }

}
</script>
