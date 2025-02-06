<template>
    <Dialog v-bind="{ close }" width="3xl">

        <div class="mt-3 text-center sm:mt-0 sm:text-left">
            <DialogTitle as="h3" class="text-base font-semibold text-stone-900">{{ task.title }}</DialogTitle>
            <div class="flex mt-8">
                <div class="w-2/3">
                    <p>{{ task.description }}</p>
                </div>
                <div class="space-y-3 w-1/3">
                    <div>
                        <p>Created at</p>
                        <p class=" text-stone-500">{{ task.created_at }}</p>
                    </div>
                    <div>
                        <p>Deadline</p>
                        <p class=" text-stone-500">{{ task.deadline }}</p>
                    </div>
                    <div>
                        <p>SLA</p>
                        <p class=" text-stone-500">{{ task.sla }} Days</p>
                    </div>
                    <div>
                        <p>Intercom</p>
                        <a v-if="task.intercom_link" :href="task.intercom_link" target="_blank" rel="noopener noreferrer" class="text-blue-500">Link</a>
                        <p v-else class="text-stone-500"> None</p>
                    </div>

                        <div>
                        <p>Completed at</p>
                        <p v-if="task.completed_at" class=" text-stone-500">{{ task.completed_at }}</p>
                        <p v-else class=" text-stone-500">Not completed yet</p>
                    </div>
                    <div>
                        <p>Priority</p>
                        <p v-if="task.priority" class="text-stone-500">{{ task.priority }}</p>
                        <p v-else class="text-stone-500"> None</p>
                    </div>
                    <div>
                        <p>Type</p>
                        <p v-if="task.type" class="text-stone-500">{{ task.type }}</p>
                        <p v-else class="text-stone-500"> None</p>
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

export default {
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
