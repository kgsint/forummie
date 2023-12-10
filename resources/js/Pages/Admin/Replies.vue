<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head, Link } from '@inertiajs/vue3';
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue';
import Pagination from '@/Components/Forum/Pagination.vue'
import ViewIcon from '@/Components/Icons/ViewIcon.vue';

defineProps({
    replies: Object,
})

// const handleDelete = (reply) => {

// }
</script>



<template>
    <Head title="Replies" />
    <AdminLayout>
        <!-- header -->
        <template #header>
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1
                        class="text-xl font-semibold text-gray-900 sm:text-2xl"
                    >
                        All Replies From their respective threads
                    </h1>
                </div>
                <div class="sm:flex">
                    <div
                        class="justify-between items-center mb-3 flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700"
                    >
                        <form class="lg:pr-3" action="#" method="GET">
                            <label for="users-search" class="sr-only"
                                >Search</label
                            >
                            <div class="relative mt-1 lg:w-64 xl:w-96">
                                <input
                                    type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                    placeholder="Search for replies"
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
        <!-- main -->
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table
                            class="min-w-full divide-y divide-gray-200 table-fixed"
                        >
                            <thead class="bg-gray-100">
                                <tr>
                                    <th
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase"
                                    >
                                        Author
                                    </th>
                                    <th
                                        scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase"
                                    >
                                        Thread
                                    </th>
                                    <th
                                        scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase"
                                    >
                                        Content
                                    </th>
                                    <th
                                        scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="bg-white divide-y divide-gray-200"
                            >
                                <tr class="hover:bg-gray-100" v-for="reply in replies.data" :key="reply.id">
                                    <td
                                        class="p-4 text-base text-gray-900 whitespace-nowrap"
                                    >
                                        {{ reply.user.name }}
                                    </td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ reply.thread.title }}
                                    </td>
                                    <td
                                        class="p-4 text-base text-gray-500 whitespace-nowrap"
                                    >
                                        {{ reply.excerpt }}
                                    </td>
                                    <td
                                        class="p-4 space-x-2 whitespace-nowrap"
                                    >
                                        <div>
                                            <Link
                                                :href="route('forum.show', {
                                                    thread: reply.thread,
                                                    post: reply.id
                                                })"
                                            >
                                                <ViewIcon class="text-gray-500 hover:text-gray-900" />
                                            </Link>
                                            <!-- <button
                                                @click="handleDelete(reply)"
                                                type="button"
                                                class="px-3 py-2 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300"
                                            >
                                                <DeleteIcon class="w-4 h-4" />
                                            </button> -->
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- pagination -->
            <Pagination :links="replies.meta.links" class="mt-3 mb-20 mx-auto" />
    </AdminLayout>
</template>

