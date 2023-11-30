<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue';
import { Head } from '@inertiajs/vue3'

defineProps({
    users: Object,
})
</script>


<template>
    <Head title="Manage Users" />
    <AdminLayout>
        <!-- header -->
        <template #header>
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1
                        class="text-xl font-semibold text-gray-900 sm:text-2xl"
                    >
                        All users
                    </h1>
                </div>
                <div class="sm:flex">
                    <div
                        class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700"
                    >
                        <form class="lg:pr-3" action="#" method="GET">
                            <label for="users-search" class="sr-only"
                                >Search</label
                            >
                            <div class="relative mt-1 lg:w-64 xl:w-96">
                                <input
                                    type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                    placeholder="Search for users"
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
                                        Name
                                    </th>
                                    <th
                                        scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase"
                                    >
                                        Role
                                    </th>
                                    <th
                                        scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase"
                                    >
                                        Joined At
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
                                <tr class="hover:bg-gray-100" v-for="user in users.data" :key="user.id">
                                    <td
                                        class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap"
                                    >
                                        <img
                                            class="w-10 h-10 rounded-full"
                                            :src="user.avatar"
                                            alt="user's avatar"
                                        />
                                        <div
                                            class="text-sm font-normal text-gray-500"
                                        >
                                            <div
                                                class="text-base font-semibold text-gray-900"
                                            >
                                                {{ user.name }} <span class="font-light text-xs">(@{{ user.username }})</span>
                                            </div>
                                            <div
                                                class="text-sm font-normal text-gray-500"
                                            >
                                                {{ user.email }}
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        class="p-4 text-base text-gray-900 whitespace-nowrap"
                                    >
                                        {{ user.role }}
                                    </td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ user.joined_at.format }}
                                    </td>
                                    <td
                                        class="p-4 space-x-2 whitespace-nowrap"
                                    >
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"
                                        >
                                            <DeleteIcon class="mr-1" />
                                            Delete user
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- pagination -->
            <div
                class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between"
            >
                <div class="flex items-center mb-4 sm:mb-0">
                    <a
                        href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100"
                    >
                        <svg
                            class="w-7 h-7"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </a>
                    <a
                        href="#"
                        class="inline-flex justify-center p-1 mr-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100"
                    >
                        <svg
                            class="w-7 h-7"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </a>
                    <span
                        class="text-sm font-normal text-gray-500 dark:text-gray-400"
                        >Showing
                        <span
                            class="font-semibold text-gray-900"
                            >1-20</span
                        >
                        of
                        <span
                            class="font-semibold text-gray-900"
                            >2290</span
                        ></span
                    >
                </div>
            </div>
    </AdminLayout>
</template>


<style scoped></style>
