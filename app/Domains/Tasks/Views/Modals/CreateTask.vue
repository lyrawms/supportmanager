<template>
    <Dialog width="7xl" v-slot="{ close }">
        <div class="mt-3 text-center sm:mt-0 sm:text-left">
            <DialogTitle as="h3" class="text-2xl font-semibold text-stone-900 mb-6">Create Task</DialogTitle>
            <div class="flex mt-8">
                <form @submit.prevent="createTask(close)" class="w-full flex">
                    <div class="w-[60%] pr-4">
                        <Editor api-key="wp8m69hyu1ls1lnsuv1n80fthykysrbv6juuafklqvvsfql2"
                                v-model="description"
                                :init="{
                            max_height: 500,
                            min_height: 300,
                                }"></Editor>
                        <span v-if="errors.description"
                              class="text-red-600 text-sm">{{ errors.description[0] }}</span>
                    </div>
                    <div class="w-[40%] space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                            <input v-model="title" id="title" type="text" placeholder="Enter a title"
                                   class="mt-1 p-2 border border-gray-300 rounded-md w-full"
                                   required/>
                            <span v-if="errors?.title" class="text-red-600 text-sm">{{
                                    errors.title[0]
                                }}</span>
                        </div>
                        <div>
                            <label for="intercomLink" class="block text-sm font-medium text-gray-700">Intercom
                                Link:</label>
                            <input v-model="intercomLink" id="intercomLink" type="url"
                                   placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ"
                                   class="mt-1 p-2 border border-gray-300 rounded-md w-full"/>
                            <span v-if="errors?.intercomLink" class="text-red-600 text-sm">{{
                                    errors.intercomLink[0]
                                }}</span>
                        </div>

                        <div>
                            <a @click="handleTypeClick" class="cursor-pointer underline">Type</a>
                            <Type v-if="currentType && !showComboBoxType" :type="currentType"/>
                            <p v-else-if="showComboBoxType">
                                <ComboBoxSubject :currentAssignedSubject="{}"
                                                 subject="type"
                                                 @updateTaskType="assignNewType"/>
                            </p>
                            <p v-else-if="!currentType" class="text-stone-500 my-1"> None</p>
                            <span v-if="errors?.type" class="text-red-600 text-sm">{{
                                    errors.type[0]
                                }}</span>
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
import ComboBoxSubject from "../Components/ComboBoxSubject.vue";
import Type from "../Components/Type.vue";

export default {
    components: {
        Type,
        ComboBoxSubject,
        Dialog,
        PrimaryButton,
        DialogTitle,
        CheckboxGroup,
        Editor
    },
    data: () => ({
        title: '',
        description: '',
        intercomLink: '',
        sla: '',
        type: {},
        errors: {},
        currentType: null,
        showComboBoxType: false
    }),
    methods: {
        createTask(closure) {
            this.errors = {};
            if (!this.currentType || !this.currentType.uuid) {
                this.errors.type = ['Type is required.'];
            } else {
                this.$inertia.post(
                    '/tasks/create',
                    {
                        title: this.title,
                        description: this.description,
                        intercomLink: this.intercomLink,
                        type: this.currentType.uuid,
                        category: this.getCategoryFromUrl(),
                    },
                    {
                        preserveScroll: true,
                        onSuccess: () => {
                            closure();
                        },
                        onError: (errors) => {
                            this.errors = errors;
                        }
                    }
                )

            }
        },
        handleTypeClick() {
            this.toggleComboBoxType();
        },
        assignNewType(newType) {
            this.currentType = newType;
        },
        toggleComboBoxType() {
            this.showComboBoxType = !this.showComboBoxType;
        },
        getCategoryFromUrl() {
            const params = new URLSearchParams(window.location.search);
            return params.get("category") || 'Company';
        }
    }
}
</script>

<style scoped>
</style>
