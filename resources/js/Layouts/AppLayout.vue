<script setup>
import {onMounted, ref} from 'vue';
import {Head, Link, router} from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Elements/Banner.vue';
import Dropdown from '@/Components/Elements/Dropdown.vue';
import DropdownLink from '@/Components/Elements/DropdownLink.vue';
import NavLink from '@/Components/Elements/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {faGear, faCheck, faPlus, faSearch} from '@fortawesome/free-solid-svg-icons';
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title"/>

        <Banner/>

        <div class="min-h-screen bg-stone-100">
            <nav class="bg-white border-b border-stone-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="left" width="60">absolute
                                    -inset-1.5
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-stone-500 bg-white hover:text-stone-700 focus:outline-hidden focus:bg-stone-50 active:bg-stone-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.current_team.name }}

                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Team Settings -->
                                            <DropdownLink
                                                class="rounded-t-md"
                                                :href="route('teams.show', $page.props.auth.user.current_team)">
                                                <FontAwesomeIcon :icon="faGear" class="me-2 text-stone-400"/>
                                                Team Settings
                                            </DropdownLink>

                                            <div class="border-t border-stone-200"/>

                                            <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                                <form @submit.prevent="switchToTeam(team)">
                                                    <DropdownLink as="button">
                                                        <div class="flex items-center">
                                                            <div class="flex-grow">{{ team.name }}</div>
                                                            <FontAwesomeIcon
                                                                v-if="team.id == $page.props.auth.user.current_team_id"
                                                                :icon="faCheck" class="ms-2 text-amber-500 size-5"/>
                                                        </div>
                                                    </DropdownLink>
                                                </form>
                                            </template>

                                            <div class="border-t border-stone-200"/>

                                            <DropdownLink v-if="$page.props.jetstream.canCreateTeams"
                                                          class="rounded-b-md"
                                                          :href="route('teams.create')">
                                                <FontAwesomeIcon :icon="faPlus" class="me-2 text-stone-400"/>
                                                Create New Team
                                            </DropdownLink>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>

                            <div class="mx-6 border-r border-stone-200"/>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:mr-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>
                                <NavLink :href="route('tasks.index', {category : 'Company'})"
                                         :active="route().current('tasks.index')">
                                    Tasks
                                </NavLink>
                                <NavLink :href="route('settings')" :active="route().current('settings')">
                                    Settings
                                </NavLink>
                            </div>
                        </div>


                        <div class="flex flex-1 items-center justify-center px-2 lg:ml-6 gap-4 lg:justify-end">
                            <primary-button color="amber" modal :href="route('tasks.create')">
                                <font-awesome-icon :icon="faPlus" class="me-2"/>
                                Create issue
                            </primary-button>
                            <div class="grid w-full max-w-lg grid-cols-1 lg:max-w-xs">
                                <input type="search" name="search"
                                       class="col-start-1 row-start-1 block w-full rounded-md bg-white py-1.5 pl-10 pr-3 text-base text-stone-900 outline outline-1 -outline-offset-1 outline-stone-300 placeholder:text-stone-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-amber-600 sm:text-sm/6"
                                       placeholder="Search">
                                <font-awesome-icon :icon="faSearch"
                                                   class="pointer-events-none col-start-1 row-start-1 ml-3 size-5 self-center text-stone-400"/>

                            </div>
                        </div>
                        <div class="flex items-center lg:hidden">
                            <!-- Mobile menu button -->
                            <button type="button"
                                    class="relative inline-flex items-center justify-center rounded-md p-2 text-stone-400 hover:bg-stone-100 hover:text-stone-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-amber-500"
                                    aria-controls="mobile-menu" aria-expanded="false">
                                <span class="absolute -inset-0.5"></span>
                                <span class="sr-only">Open main menu</span>
                                <!--
                                  Icon when menu is closed.

                                  Menu open: "hidden", Menu closed: "block"
                                -->
                                <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                                </svg>
                                <!--
                                  Icon when menu is open.

                                  Menu open: "block", Menu closed: "hidden"
                                -->
                                <svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="hidden lg:ml-4 lg:flex lg:items-center">
                            <button type="button"
                                    class="relative shrink-0 rounded-full bg-white p-1 text-stone-400 hover:text-stone-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                <span class="absolute -inset-1.5"></span>
                             <div>
                                 {{ $page.props.flash.toasts }}
                             </div>
                            </button>

                            <!-- Profile dropdown -->
                            <div class="relative ml-4 shrink-0">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button type="button"
                                                class="relative flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2"
                                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                            <img class="size-10 rounded-full"
                                                 :src="$page.props.auth.user.profile_photo_url"
                                                 :alt="$page.props.auth.user.name">
                                        </button>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-stone-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profile
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                                      :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-stone-200"/>

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-stone-400 hover:text-stone-500 hover:bg-stone-100 focus:outline-hidden focus:bg-stone-100 focus:text-stone-500 transition duration-150 ease-in-out"
                                @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="size-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
                     class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('tasks.index')" :active="route().current('tasks.index')">
                            Tasks
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('settings')" :active="route().current('settings')">
                            Settings
                        </ResponsiveNavLink>

                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-stone-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img class="size-10 rounded-full object-cover"
                                     :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-stone-800">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-stone-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures"
                                               :href="route('api-tokens.index')"
                                               :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-stone-200"/>

                                <div class="block px-4 py-2 text-xs text-stone-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)"
                                                   :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams"
                                                   :href="route('teams.create')"
                                                   :active="route().current('teams.create')">
                                    Create New Team
                                </ResponsiveNavLink>

                                <!-- Team Switcher -->
                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-stone-200"/>

                                    <div class="block px-4 py-2 text-xs text-stone-400">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == $page.props.auth.user.current_team_id"
                                                         class="me-2 size-5 text-green-400"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow-xs">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
            <main class="mt-8 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="relative -mx-1 bg-white shadow-xs rounded-lg border border-stone-200">
                    <slot/>
                </div>
            </main>
        </div>
    </div>
</template>
