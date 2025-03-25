<template>
    <AppLayout title="Settings">
        <template #header>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="font-semibold text-xl text-stone-800 leading-tight">
                        Settings
                    </h2>
                </div>
            </div>
        </template>
        <template #default>
            <div class="flex ">

                <div class="w-[50%] p-4 pt-8 m-4 bg-stone-50 rounded-2xl shadow-xl">
                    <h1 class="text-2xl text-center pb-6">Types</h1>
                    <div class="flex space-x-4 justify-evenly">
                        <div class="grid w-full max-w-lg grid-cols-1 lg:max-w-xs">
                            <input type="search" name="search" v-model="query" @input="handleSearchInput"
                                   class="col-start-1 row-start-1 block w-full rounded-md bg-white py-1.5 pl-10 pr-3 text-base text-stone-900 outline-1 -outline-offset-1 outline-stone-300 placeholder:text-stone-400 focus:outline-2 focus:-outline-offset-2 focus:outline-amber-600 sm:text-sm/6"
                                   placeholder="Search">
                            <FontAwesomeIcon :icon="faSearch"
                                             class="pointer-events-none col-start-1 row-start-1 ml-3 self-center text-stone-400"/>

                        </div>
                        <primary-button color="amber" modal :href="route('types.create')" class="w-[30%]">
                            <FontAwesomeIcon :icon="faSearch" class="me-2"/>
                            Create type
                        </primary-button>
                    </div>
                    <div class="flex justify-center flex-wrap py-4">
                        <div v-for="type in dataTypes.data" :key="type.uuid" class="m-1.5 flex grow">
                            <a>
                                <Type :type="type"/>
                            </a>

                        </div>
                        <p v-if="(dataTypes.data) && dataTypes.data.length === 0" class="font-extralight">No types
                            found</p>
                    </div>
                    <div v-if="!query"
                         class="px-4 py-3 pt-6 flex items-center justify-center sm:px-6 border-t border-stone-200">
                        <nav class="relative flex justify-center">
                            <template v-for="link in dataTypes.links" :key="link.label">
                                <Link
                                    preserve-scroll
                                    :href="link.url ?? ''"
                                    v-html="link.label"
                                    class="flex items-center justify-center px-3 py-2 text-sm rounded-lg text-amber-600"
                                    :class="{ 'bg-amber-300': link.active, '!text-amber-600/50': !link.url }"
                                />
                            </template>
                        </nav>
                    </div>
                </div>
                <div class="w-[50%] flex items-center justify-center">
                    <AddToSlackButton class="m-4"/>
                </div>
            </div>
        </template>
    </AppLayout>
</template>
<script>
import {defineComponent} from "vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import tinycolor from "tinycolor2";
import AppLayout from "@/Layouts/AppLayout.vue";
import {faPlus, faSearch} from '@fortawesome/free-solid-svg-icons';
import {Link} from "@inertiajs/vue3";
import Type from "../../Tasks/Views/Components/Type.vue";
import AddToSlackButton from "./AddToSlackButton.vue";


export default {
    name: "Settings",
    components: {AddToSlackButton, Type, Link, AppLayout, FontAwesomeIcon, PrimaryButton},
    props: {
        types: {
            type: Object,
            required: true
        }
    },
    data: () => ({
        faPlus,
        faSearch,
        query: "",
        debounceTimer: null,
        dataTypes: [],
    }),

    methods: {
        fetchTypes() {
            if (this.query !== '') {
                fetch(`/types/index-search?query=${this.query}`, {
                    method: "GET",
                    headers: {
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    credentials: "include",
                })
                    .then(response => response.json())
                    .then(data => {
                        this.dataTypes = data.types;
                    })
                    .catch(error => {
                        console.error("Error fetching types:", error);
                    });
            } else {
                this.dataTypes = this.types;
            }
        },
        handleSearchInput() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.fetchTypes();
            }, 800);
        },
    },
    mounted() {
        this.dataTypes = this.types;
    }
}
</script>

<style scoped>

</style>
