<template>
    <Combobox v-model="selectedType">
        <ComboboxInput v-model="query"/>
        <ComboboxOptions>
            <ComboboxOption
                v-for="type in types"
                :key="type.uuid"
                :value="type"
            >
                {{ type.title }}
            </ComboboxOption>
        </ComboboxOptions>
    </Combobox>
</template>
<script>


import {Combobox, ComboboxInput, ComboboxOption, ComboboxOptions} from "@headlessui/vue";
import {router} from "@inertiajs/vue3";

export default {
    name: "ComboBox",

    components: {
        Combobox,
        ComboboxInput,
        ComboboxOptions,
        ComboboxOption,
    },
    data() {
        return {
            selectedTasks: null,
            types: [],
            query: "",
            debounceTimer: null
        }

    },
    methods: {
        fetchTypes() {
            router.get("/types", {limit: 5, search: this.query}, {
                preserveState: true,
                only: ['types'],
                onSuccess: (response) => {
                    this.types = response.types;
                    this.loading = false;
                },
            });
        },
        handleInput() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.fetchTypes();
            }, 300);
        }
    },
    mounted() {
        this.fetchTypes();
    }
}

</script>

<style scoped>

</style>
