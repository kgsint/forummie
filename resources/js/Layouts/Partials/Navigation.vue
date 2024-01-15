<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const showingNavigationDropdown = ref(false);

// mark notification as read
const markAsRead = (noti) => {
    router.patch(route('notifications.update', { id: noti.id, redirectUrl: noti.data.url }))
}
</script>


<template>
    <nav class="bg-white py-3 border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link href="/">
                            <ApplicationLogo
                                class="block h-9 w-auto fill-current text-gray-800"
                            />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <NavLink href="/" :active="route().current('forum.index')">
                            Forum
                        </NavLink>
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- notifications dropdown -->
                    <Dropdown width="80" v-if="$page.props.auth.user">
                        <template #trigger>
                            <button class="d-flex items-center space-x-1 bg-blue-500 p-3 text-white text-sm rounded-xl">
                                <span>Notifications</span>
                                 <!-- notification count  -->
                                <span
                                    v-if="$page.props.auth.notifications.length"
                                    class="bg-red-500 text-xs px-2 py-1 rounded-xl"
                                >
                                    {{ $page.props.auth.notifications.length }}
                                </span>
                            </button>
                        </template>
                        <template #content>
                            <div v-if="$page.props.auth.notifications.length" class="max-h-[300px] overflow-y-auto cursor-pointer">
                                <li
                                    v-for="noti in $page.props.auth.notifications"
                                    :key="noti.id"
                                    class="list-none cursor-pointer"
                                    @click="markAsRead(noti)"
                                >
                                    <div class="flex p-2 rounded hover:bg-gray-100 cursor-pointer">
                                      <div class="ms-2 text-sm cursor-pointer">
                                          <label for="helper-checkbox-1" class="font-medium text-gray-900 cursor-pointer">
                                            <div>{{ noti.data.thread.title }}</div>
                                            <p id="helper-checkbox-text-1" class="text-xs font-normal text-gray-900">@{{ noti.data.username }} answered your thread</p>
                                          </label>
                                      </div>
                                    </div>
                                </li>
                            </div>
                            <div v-else class="text-sm text-gray-500 py-3 px-2 text-center">
                                There is no notification for you at the moment.
                            </div>
                        </template>
                    </Dropdown>
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative" v-if="$page.props.auth.user">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                    >
                                        <span v-if="$page.props.auth.user">
                                            <img
                                                :src="$page.props.auth.user.avatar"
                                                :alt="$page.props.auth.user.name"
                                                class="w-8 h-8 focus:ring-2 ring-2 ring-blue-500 rounded-full object-cover"
                                            />
                                        </span>
                                        <span v-else>Guest</span>

                                        <svg
                                            v-else
                                            class="ml-2 -mr-0.5 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.show', $page.props.auth.user)"> Profile </DropdownLink>
                                <DropdownLink :href="route('profile.edit')"> Settings </DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                    <!-- if guest -->
                    <div class="flex items-center justify-between space-x-2" v-else>
                        <Link :href="route('login')">
                            <PrimaryButton>Login</PrimaryButton>
                        </Link>
                        <Link :href="route('register')">
                            <SecondaryButton>Register</SecondaryButton>
                        </Link>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                    >
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }"
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
        <div
            :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
            class="sm:hidden"
        >
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink :href="route('forum.index')" :active="route().current('forum.index')">
                    Forum
                </ResponsiveNavLink>
            </div>

            <!-- Responsive nav items (auth) -->
            <div class="pt-4 pb-1 border-t border-gray-200" v-if="$page.props.auth.user">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">
                        {{ $page.props.auth.user.name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink
                        :href="route('profile.show', $page.props.auth.user)"
                        :active="route().current('profile.edit')"
                    >
                        Profile
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('profile.edit')" :active="route().current('profile.edit')"> Settings </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
            <!-- Responsive nav item (guest) -->
            <div class="pt-4 pb-1 border-t border-gray-200" v-else>
                <ResponsiveNavLink :href="route('login')"> Login </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('register')">
                    Register
                </ResponsiveNavLink>
            </div>
        </div>
    </nav>
</template>


<style scoped></style>
