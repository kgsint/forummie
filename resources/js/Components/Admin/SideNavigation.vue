<script setup>
import UserIcon from "@/Components/Icons/UserIcon.vue"
import PostIcon from "@/Components/Icons/PostIcon.vue"
import { Link } from '@inertiajs/vue3'
import TagIcon from '@/Components/Icons/TagIcon.vue';


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
                            <Link
                                :href="route('admin.users.index')"
                                class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group"
                                :class="{ 'bg-gray-200 hover:bg-gray-300': $page.component === 'Admin/Users' }"
                            >
                                <UserIcon />
                                <span class="ml-3" sidebar-toggle-item=""
                                    >Users</span
                                >
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('admin.topics.index')"
                                class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group"
                                :class="{ 'bg-gray-200 hover:bg-gray-300': $page.component === 'Admin/Topics' }"
                            >
                                <TagIcon />
                                <span class="ml-3" sidebar-toggle-item=""
                                    >Topics</span
                                >
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('admin.replies.index')"
                                class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 group"
                            >
                                <PostIcon />
                                <span class="ml-3">
                                    Replies
                                </span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
</template>


<style scoped></style>
