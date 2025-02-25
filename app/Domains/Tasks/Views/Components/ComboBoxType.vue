<template>
    <div class="relative">
        <Combobox v-model="selected">
            <div class="relative mt-1">
                <div
                    class="relative w-full cursor-default overflow-hidden rounded-lg bg-white text-left shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
                >
                    <ComboboxInput
                        :displayValue="selected ? (type) => type.title : () => ''"
                        class="w-full border-none py-1 pl-3 pr-10 text-sm leading-5 focus:ring-0"
                        @change="handleInput"

                    />
                    <ComboboxButton
                        class="absolute inset-y-0 right-0 flex items-center pr-2"
                        @click="handleButtonClick"
                    >
                        <span class="rotate-90 text-gray-700">
                            < >
                        </span>
                    </ComboboxButton>
                </div>

                <ComboboxOptions
                    class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm"
                >
                    <div
                        v-if="types.length === 0 && query !== ''"
                        class="cursor-default select-none px-4 py-2 text-gray-700"
                    >
                        Nothing found.
                    </div>

                    <ComboboxOption
                        v-for="type in types"
                        :key="type.uuid"
                        :value="type"
                        v-slot="{selected, active}"
                    >

                        <li
                            class="relative cursor-default select-none py-2 pl-10 pr-4"
                            :class="{
                  'bg-amber-600 text-white': active,
                  'text-gray-900': !active,
                }"
                        >
                <span
                    class="block truncate"
                    :class="{ 'font-medium': selected, 'font-normal': !selected }"
                >
                  {{ type.title }}
                </span>
                            <span
                                v-if="selected"
                                class="absolute inset-y-0 left-0 flex items-center pl-3"
                                :class="{ 'text-white': active, 'text-amber-600': !active }"
                            >
                  <span class="text-lg">✓</span>
                </span>
                        </li>
                    </ComboboxOption>
                </ComboboxOptions>
            </div>
        </Combobox>
    </div>
</template>
<script>


import {Combobox, ComboboxButton, ComboboxInput, ComboboxOption, ComboboxOptions} from "@headlessui/vue";

export default {
    name: "ComboBoxType",
    props: {
        currentAssignedType: {
            type: Object,
            default: null,
            required: false
        },
        taskUuid: {
            required: true
        }
    },
    emits: ['updateTaskType'],

    components: {
        ComboboxButton,
        Combobox,
        ComboboxInput,
        ComboboxOptions,
        ComboboxOption,
    },
    data: () => ({
        selected: null,
        types: [],
        query: "",
        debounceTimer: null,
        firstFetchCheck: false,


    }),
    methods: {
        fetchTypes() {
            fetch(`/types/index-search?query=${this.query}&currentAssignedType=${this.currentAssignedType ? this.currentAssignedType.uuid : null}`, {
                method: "GET",
                headers: {
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
                credentials: "include",
            })
                .then(response => response.json())
                .then(data => {
                    this.types = data.types;
                })
                .catch(error => {
                    console.error("Error fetching types:", error);
                });
        },
        handleInput(event) {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.query = event.target.value;
                this.fetchTypes();
            }, 800);
        },
        firstFetch() {
            this.fetchTypes();
        },
        handleButtonClick() {
            this.firstFetchCheck = !this.firstFetchCheck;
            if (this.firstFetchCheck) {
                this.fetchTypes();
            }
        }
    },
    mounted() {
        if (this.currentAssignedType && this.query === "") {
            this.selected = this.currentAssignedType;
        }
    },
    watch: {
        selected() {
            if (this.selected !== this.currentAssignedType) {
                this.$emit('updateTaskType', this.selected)
            }
        }
    }
}

</script>

<style scoped>

</style>
