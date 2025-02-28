<template>
    <Dialog width="4xl" v-slot="{ close }">
        <div class="mt-3 text-center sm:mt-0 sm:text-left">
            <DialogTitle as="h3" class="text-2xl font-semibold text-stone-900 mb-6">Create Task</DialogTitle>
            <div class="flex mt-8">
                <form @submit.prevent="createType" class="w-full flex">

                    <div class="w-full flex space-y-6">
                        <div class="w-1/2">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                            <input v-model="title" id="title" type="text" placeholder="Enter a title"
                                   class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                                   required/>
                            <span v-if="errors?.title" class="text-red-600 text-sm">{{
                                    errors.title[0]
                                }}</span>
                        </div>
                        <div class="w-1/2">
                            <label for="color" class="block text-sm font-medium text-gray-700">Color:</label>

                            <ColorPicker v-model:pureColor="pureColor" v-model:gradientColor="gradientColor" class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                                          required id="color"/>
                            <span v-if="errors?.color" class="text-red-600 text-sm">{{
                                    errors.color[0]
                                }}</span>
                            <p>{{ pureColor}}</p>
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

export default {
    name: 'CreateType',
    components: {
        ColorPicker,
        Dialog,
        PrimaryButton,
        DialogTitle,
        CheckboxGroup,
        Editor
    },
    data: () => ({
        title: '',
        color: '',
        errors: {},
        pureColor: '#ff0000',
        gradientColor: '',
    }),
    methods: {
        createType() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('/types/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                credentials: 'include',
                body: JSON.stringify({
                    title: this.title,
                    color: this.color,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.errors) {
                        this.errors = data.errors;
                        console.error("Error creating type", data.errors);
                    } else if (data) {
                        console.log("Type created", data);
                    }

                })
                .catch(error => {
                    console.error("Error creating type", error);
                    this.errors = error;
                });
        },
    }
}
</script>

<style scoped>
</style>

