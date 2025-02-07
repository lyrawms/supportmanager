<template>
    <Dialog v-bind="{ close }" width="3xl">

        <div class="mt-3 text-center sm:mt-0 sm:text-left">
            <DialogTitle as="h3" class="text-base font-semibold text-stone-900">{{ task.title }}</DialogTitle>
            <div class="flex mt-8">
                <div class="w-3/5">
                    <p>{{ task.description }}</p>
                </div>
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
                            <div>
                                <p class="pb-1">Type</p>
                                <p v-if="task.type_id" :style="{ color: getMostReadableColor(task.type.color) ,backgroundColor: task.type.color }" class="flex w-min rounded-2xl px-2 text-center py-0.5">
                                    {{ task.type.title }}</p>
                                <p v-else class="text-stone-500"> None</p>
                            </div>
                        </div>
                        <div class="p-4 bg-white shadow-lg rounded-2xl space-y-1">
                            <div>
                                <p>Creator</p>
                                <p v-if="task.creator_id" class="text-stone-500">{{ task.creator.name }}</p>
                                <p v-else class="text-stone-500"> None</p>
                            </div>
                            <div>
                                <p>Assignee</p>
                                <p v-if="task.assignee_id" class="text-stone-500">{{ task.assignee.name }}</p>
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

export default {
    methods: {
        getMostReadableColor(color) {
            return tinycolor.mostReadable(color, [], {includeFallbackColors: true});
        }
    },
    components: {
        Modal,
        ModalLink,
        Dialog,
        PrimaryButton,
        DialogTitle,
        CheckboxGroup,
        CheckboxField,
        InputLabel,
        Checkbox,
        InputDescription
    },
    props: {
        task: {
            type: Object,
            required: true
        }
    },
    data: () => ({
        valueOfCheckbox: false
    }),

}
</script>
