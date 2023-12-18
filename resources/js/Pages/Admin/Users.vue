<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue';
import { Head } from '@inertiajs/vue3'
import Pagination from '@/Components/Forum/Pagination.vue'
import { watch } from 'vue'
import _debounce from 'lodash.debounce'
import Modal from '@/Components/Modal.vue';
import CreateUserForm from './Partials/CreateUserForm.vue';
import useCreateUser from '@/Composables/useCreateUser'
import useSearchRecord from '@/Composables/useSearchRecord'
import useUser from '@/Composables/useUser';
import UserPlusIcon from '@/Components/Icons/UserPlusIcon.vue';
import BanIcon from '@/Components/Icons/BanIcon.vue'

defineProps({
    users: Object,
})

const { handleDelete} = useUser()
const { showCreateUserModal } = useCreateUser()
const { searchRef, handleSearch } = useSearchRecord()

// watch changes in search input
watch(searchRef, (search) => {
    handleSearch(search)
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
                        class="flex-col md:flex-row md:justify-between md:items-center mb-3 flex"
                    >
                        <form class="mb-3 md:mb-0 lg:pr-3" action="#" method="GET">
                            <label for="users-search" class="sr-only"
                                >Search</label
                            >
                            <div class="relative mt-1 lg:w-64 xl:w-96">
                                <input
                                    v-model="searchRef"
                                    type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                    placeholder="Search for users"
                                />
                            </div>
                        </form>
                        <button class="flex items-center justify-center space-x-1 text-center text-xs md:text-sm font-semibold bg-gray-200 text-gray-700 hover:opacity-75 duration-200 px-2 py-3 rounded-lg border border-gray-400 shadow" @click="showCreateUserModal = true">
                            <UserPlusIcon />
                            <span>Create new User</span>
                        </button>
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
                                        Type
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
                                            class="w-10 h-10 rounded-full object-cover"
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
                                        {{ user.type }}
                                    </td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ user.joined_at.format }}
                                    </td>
                                    <td
                                        class="p-4 space-x-2 whitespace-nowrap"
                                    >
                                        <div class="flex items-center space-x-2">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4"
                                            >
                                                <BanIcon />
                                                <span>Ban</span>
                                            </button>
                                            <button
                                                @click="handleDelete(user)"
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"
                                            >
                                                <DeleteIcon class="w-4 h-4 mr-1" />
                                                Delete user
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- pagination -->
            <Pagination :links="users.meta.links" class="mt-3 mb-20 mx-auto" />
    </AdminLayout>

    <!-- create user modal -->
    <Modal
        :show="showCreateUserModal"
        @close="showCreateUserModal = false"
    >
        <div class="px-3 py-6">
            <div class="flex justify-between items-start">
                <h3 class="border-b-2 mb-3 pb-3 border-gray-300 flex-1 text-center text-xl">Create new User</h3>
                <span
                    @click="showCreateUserModal = false"
                    class="px-3 py-1 text-xl bg-gray-300 hover:bg-gray-500 hover:text-white
                    transition-all rounded-md duration-150 cursor-pointer">
                    &times;
                </span>
            </div>
            <CreateUserForm />
        </div>
    </Modal>
</template>


<style scoped></style>
