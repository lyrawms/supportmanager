<template>
    <Combobox v-model="selected">
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

export default {
    name: "ComboBox",
    props: {
        selectedType: {
            type: Object,
            required: false,
            default: null,
        },
    },

    components: {
        Combobox,
        ComboboxInput,
        ComboboxOptions,
        ComboboxOption,
    },
    data: () => ({
            selectedType: this.selectedType,
            types: [],
            query: "",
            debounceTimer: null


    }),
    methods: {
        fetchTypes() {
            fetch(`/types/index-search?query=${this.query}`, {
                method: "GET",
                headers: {
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
                credentials: "include", // Important for Sanctum auth
            })
                .then(response => response.json())
                .then(data => {
                    this.types = data.types;
                    console.log("Types fetched:", this.types);
                })
                .catch(error => {
                    console.error("Error fetching types:", error);
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
