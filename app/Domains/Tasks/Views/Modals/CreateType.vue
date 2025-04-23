<template>
    <Dialog width="lg" v-slot="{
            close,
        }">
        <div class="mt-3 text-center sm:mt-0 sm:text-left">
            <DialogTitle as="h3" class="text-2xl font-semibold text-stone-900 mb-6">Create Type</DialogTitle>
            <div class="flex mt-8">
                <form @submit.prevent="createType(close)" class="w-full flex">

                    <div class="w-full space-y-6">
                        <div class="">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                            <input v-model="title" id="title" type="text" placeholder="Enter a title"
                                   class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                                   required/>
                            <span v-if="errors?.title" class="text-red-600 text-sm">{{
                                    errors.title
                                }}</span>
                        </div>
                        <div class="">
                            <label for="sla" class="block text-sm font-medium text-gray-700">SLA:</label>
                            <input v-model="sla" id="sla" type="number" placeholder="4 days"
                                   class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                                   required/>
                            <span v-if="errors?.sla" class="text-red-600 text-sm">{{
                                    errors.sla
                                }}</span>
                        </div>
                        <div>
                            <div>
                                <label for="wantsColor" class="block text-sm font-medium text-gray-700">Wants
                                    Color:</label>
                                <checkbox v-model:checked="wantsColor"/>
                            </div>
                            <div v-show="wantsColor" class="">
                                <label for="color" class="block text-sm font-medium text-gray-700">Color:</label>

                                <ColorPicker v-model:pureColor="pureColor" format="hex"
                                             class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                                             id="color"/>
                                <span v-if="errors?.color" class="text-red-600 text-sm">{{
                                        errors.color
                                    }}</span>
                            </div>
                        </div>
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                    class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700">
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
import Editor from "@tinymce/tinymce-vue";
import {ColorPicker} from "vue3-colorpicker";
import Checkbox from "@/Components/Forms/Checkbox.vue";

export default {
    name: 'CreateType',
    components: {
        Checkbox,
        ColorPicker,
        Dialog,
        PrimaryButton,
        DialogTitle,
        CheckboxGroup,
        Editor
    },
    data: () => ({
        title: '',
        errors: {},
        pureColor: '#ff0000',
        sla: null,
        wantsColor: false,
    }),
    methods: {
        createType(closure) {
            // clear errors
            this.errors = {};
            // send the request
            this.$inertia.post('/types/create', {
                    title: this.title,
                    sla: this.sla,
                    color: this.wantsColor ? this.pureColor : null,
                }, {
                    preserveState: true,
                    onSuccess: () => {
                        // close the modal
                        closure();
                    },
                    onError: (errors) => {
                        // bind the errors
                        this.errors = errors;
                    }
                }
            )
        },
    }
}
</script>

<style scoped>
</style>

