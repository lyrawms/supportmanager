<template>
    <Dialog v-bind="{ close }" width="3xl">

        <div class="mt-3 text-center sm:mt-0 sm:text-left">
            <DialogTitle as="h3" class="text-base font-semibold text-stone-900">Deactivate account</DialogTitle>
            <div class="mt-2">
                <p class="text-sm text-stone-500">Are you sure you want to deactivate your account? All of your data will be permanently removed from our servers forever. This action cannot be undone.</p>
            </div>

            Nour is stoer
        </div>

        <template #cta>
            <PrimaryButton color="amber" @click="close">
                Deactivate
            </PrimaryButton>
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
import { Modal, ModalLink } from '@inertiaui/modal-vue'
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
    data: () => ({
        valueOfCheckbox: false
    }),
}
</script>
