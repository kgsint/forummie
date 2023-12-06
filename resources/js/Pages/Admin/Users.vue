<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue';
import { Head, router, usePage } from '@inertiajs/vue3'
import Pagination from '@/Components/Forum/Pagination.vue'
import { ref, watch } from 'vue'
import _debounce from 'lodash.debounce'
import useSweetalert from '@/Composables/useSweetalert';

defineProps({
    users: Object,
})

const page = usePage()
const { displayConfirmMessage, displayToastMessage } = useSweetalert()

const searchUser = ref(page.props.queryStrings?.s ?? '')

// debounced search
const handleSearch = _debounce((search) => {
    router.reload({
        data: {
            s: search
        }
    })
}, 500)

// watch changes in search input
watch(searchUser, (search) => {
    handleSearch(search)
})

// delete user
const handleDelete = (user) => {
    // confirm with sweet alert
    displayConfirmMessage(
        `Do you want to delete ${user.username}`
        )
        .then((result) => {
            /* if confirmed */
            if (result.isConfirmed) {
                let username = user.username
                router.delete(route('admin.users.destroy', user.username), {
                onSuccess: () => {
                    displayToastMessage(`@${username} has been deleted`)
                }
                })
            }
        });
}

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
                                    v-model="searchUser"
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
                                        <button
                                            @click="handleDelete(user)"
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 text-xs font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"
                                        >
                                            <DeleteIcon class="w-4 h-4 mr-1" />
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
            <Pagination :links="users.meta.links" class="mt-3 mb-20 mx-auto" />
    </AdminLayout>
</template>


<style scoped></style>
