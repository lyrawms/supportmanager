<template>
    <TransitionRoot as="template" :show="open">
        <Dialog class="relative z-10" @close="close">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-stone-800/20 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-start sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full" :class="[`sm:max-w-${width}`]">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6">
                                <slot v-bind="{ close }"></slot>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 gap-2 flex justify-between items-center">
                                <slot name="secondary">
                                    <div></div>
                                </slot>
                                <div class="sm:flex sm:flex-row-reverse justify-self-end gap-2">
                                    <slot name="cta" v-bind="{ close }"></slot>
                                    <PrimaryButton @click="close">
                                        Cancel
                                    </PrimaryButton>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
export default {
    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        PrimaryButton
    },
    props: {
        open: {
            type: Boolean,
            default: false
        },
        width: {
            type: String,
            default: 'lg'
            /* sm:max-w-lg, sm:max-w-xl, sm:max-w-2xl, sm:max-w-3xl */
        }
    },
    emits: ['close'],
    methods: {
        close() {
            this.$emit('close')
        }
    }
}
</script>
