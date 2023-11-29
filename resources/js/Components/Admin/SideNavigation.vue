<script setup>
import UserIcon from "@/Components/Icons/UserIcon.vue"
import PostIcon from "@/Components/Icons/PostIcon.vue"
defineProps(['showSideNavigation'])
</script>


<template>
    <aside
        v-show="showSideNavigation"
        class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
        aria-label="Sidebar"
    >
        <div
            class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200"
        >
            <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
                <div
                    class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200"
                >
                    <ul class="pb-2 space-y-2">
                        <li>
                            <form action="#" method="GET" class="lg:hidden">
                                <label for="mobile-search" class="sr-only"
                                    >Search</label
                                >
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                                    >
                                        <svg
                                            class="w-5 h-5 text-gray-500"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd"
                                            ></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        name="email"
                                        id="mobile-search"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5"
                                        placeholder="Search"
                                    />
                                </div>
                            </form>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group"
                            >
                                <UserIcon />
                                <span class="ml-3" sidebar-toggle-item=""
                                    >Manage Users</span
                                >
                            </a>
                        </li>
                        <li>
                            <a
                                href="https://github.com/themesberg/flowbite-admin-dashboard"
                                target="_blank"
                                class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 group"
                            >
                                <PostIcon />
                                <span class="ml-3" sidebar-toggle-item=""
                                    >Manage Replies</span
                                >
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
</template>


<style scoped></style>
