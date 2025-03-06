<template>
    <AppLayout title="Tasks">
        <template #header>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="font-semibold text-xl text-stone-800 leading-tight">
                        Tasks
                    </h2>
                </div>
                <div class="mt-4 sm:mt-0 sm:flex-none w-[30%]">
                    <TabGroup :defaultIndex="selectedIndex">
                        <TabList class="flex space-x-1 rounded-xl bg-stone-100 shadow-sm p-1">
                            <Tab
                                v-for="(category, index) in categories"
                                as="template"
                                :key="index"
                            >
                                <a class="w-full" :href="route('tasks.index', {category: category})">
                                    <button
                                        :class="[
              'w-full rounded-lg py-2.5 text-sm font-medium leading-5',
              'ring-white/60 ring-offset-2 ring-offset-amber-400 focus:outline-none focus:ring-2',
              selectedIndex === index
                ? 'bg-white text-amber-500 shadow'
                : 'text-amber-300 hover:bg-white/[0.12] hover:text-amber-500',
            ]"
                                    >
                                        {{ selectedIndex === index ? category + ' Tasks' : category }}
                                    </button>
                                </a>
                            </Tab>
                        </TabList>
                    </TabGroup>
                </div>
            </div>
        </template>

        <template #default>
            <div v-if="tasks.data[0]">
                <Table :tasks="tasks.data"/>
                <div
                    class="bg-stone-50 rounded-b-lg px-4 py-3 flex items-center justify-center sm:px-6 border-t border-stone-200">
                    <nav class="relative flex justify-center">
                        <template v-for="link in tasks.links" :key="link.label">
                            <Link
                                preserve-scroll
                                :href="link.url + `&category=${categoryFromUrl}` ?? ''"
                                v-html="link.label"
                                class="flex items-center justify-center px-3 py-2 text-sm rounded-lg text-amber-600"
                                :class="{ 'bg-amber-300': link.active, '!text-amber-600/50': !link.url }"
                            />
                        </template>
                    </nav>
                </div>
            </div>
            <div v-else>
                <p class="text-center text-lg text-stone-500 font-semibold py-6">
                    No Tasks Found
                </p>
            </div>
        </template>
    </AppLayout>
</template>
<script>
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {faGear, faCheck, faPlus, faSearch} from '@fortawesome/free-solid-svg-icons';
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Table from "../Components/Table/Table.vue";
import {Link} from "@inertiajs/vue3";
import {Tab, TabGroup, TabList, TabPanel, TabPanels} from "@headlessui/vue";

export default {
    name: "IndexTasks",
    components: {
        Table,
        TabPanel,
        TabPanels,
        Tab,
        TabList,
        TabGroup,
        FontAwesomeIcon,
        PrimaryButton,
        AppLayout,
        Link,
    },
    props: {
        tasks: {
            type: Object,
            required: true,
        },
    },
    data: () => ({
        faPlus,
        faSearch,
        faGear,
        faCheck,
        categories: ['Your', 'Team', 'Company'],
        selectedIndex: -1,
        categoryFromUrl: '',
    }),
    methods: {
        getCategoryFromUrl() {
            const params = new URLSearchParams(window.location.search);
            this.categoryFromUrl = params.get("category") || this.categories[0];
            return this.categories.indexOf(this.categoryFromUrl) !== -1 ? this.categories.indexOf(this.categoryFromUrl) : 0;
        }
    },
    mounted() {
        this.selectedIndex = this.getCategoryFromUrl();
    }
};
</script>
