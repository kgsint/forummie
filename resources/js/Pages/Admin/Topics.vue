<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue'
import Pagination from '@/Components/Forum/Pagination.vue'
import Modal from '@/Components/Modal.vue'
import useCreateTopic from '@/Composables/useCreateTopic'
import CreateTopicForm from '@/Pages/Admin/Partials/CreateTopicForm.vue'
import PlusCircleIcon from '@/Components/Icons/PlusCircleIcon.vue'
import { watch } from 'vue'
import _debounce from 'lodash.debounce'
import EditIcon from '@/Components/Icons/EditIcon.vue'
import useTopic from '@/Composables/useTopic'
import EditTopicForm from './Partials/EditTopicForm.vue'
import useSearchRecord from '@/Composables/useSearchRecord'

defineProps({
    topics: Object,
})

// composables
const { showCreateTopicModal } = useCreateTopic()
const { showEditTopicRef, showEditTopicModal, hideEditTopicModal, handleDelete } = useTopic()
const { searchRef, handleSearch} = useSearchRecord()

watch(searchRef, (search) => {
    handleSearch(search)
})
</script>


<template>
    <Head title="Manage Topics" />
    <AdminLayout>
        <!-- header -->
        <template #header>
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1
                        class="text-xl font-semibold text-gray-900 sm:text-2xl"
                    >
                        All Topics
                    </h1>
                </div>
                <div class="sm:flex">
                    <div
                        class="flex-col md:flex-row md:justify-between md:items-center mb-3 flex"
                    >
                        <form class="lg:pr-3 mb-3 md:mb-0" action="#" method="GET">
                            <label for="users-search" class="sr-only"
                                >Search</label
                            >
                            <div class="relative mt-1 lg:w-64 xl:w-96">
                                <input
                                    v-model="searchRef"
                                    type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                    placeholder="Search for topics"
                                />
                            </div>
                        </form>

                        <button class="flex justify-center md:justify-start items-center gap-1 text-xs md:text-sm font-semibold bg-gray-200 text-gray-700 hover:opacity-75 duration-200 px-2 py-3 rounded-lg border border-gray-400 shadow" @click="showCreateTopicModal = true">
                            <PlusCircleIcon class="h-4 w-4" />
                            Create new Topic
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
                                        Slug
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
                                <tr class="hover:bg-gray-100" v-for="topic in topics.data" :key="topic.id">
                                    <td
                                        class="p-4 text-base text-gray-900 whitespace-nowrap"
                                    >
                                        {{ topic.name }}
                                    </td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ topic.slug }}
                                    </td>
                                    <td
                                        class="p-4 space-x-2 whitespace-nowrap"
                                    >
                                        <div class="flex items-center space-x-2">
                                            <button
                                                @click="showEditTopicModal(topic)"
                                                type="button"
                                                class="px-3 py-2 text-xs font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-800 focus:ring-4 focus:ring-red-300"
                                            >
                                                <EditIcon class="w-4 h-4" />
                                            </button>
                                            <button
                                                @click="handleDelete(topic)"
                                                type="button"
                                                class="px-3 py-2 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300"
                                            >
                                                <DeleteIcon class="w-4 h-4" />
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
            <Pagination :links="topics.meta.links" class="mt-3 mb-20 mx-auto" />
    </AdminLayout>

    <!-- create topic modal -->
    <Modal :show="showCreateTopicModal" @close="showCreateTopicModal = false">
        <div class="px-3 py-6">
            <div class="flex justify-between items-start">
                <h3 class="border-b-2 mb-3 pb-3 border-gray-300 flex-1">Create new Topic</h3>
                <span
                    @click="showCreateTopicModal = false"
                    class="px-3 py-1 text-xl bg-gray-300 hover:bg-gray-500 hover:text-white
                    transition-all rounded-md duration-150 cursor-pointer">
                    &times;
                </span>
            </div>
            <!-- create topic from -->
            <CreateTopicForm />
        </div>
    </Modal>

    <Modal :show="showEditTopicRef" @close="hideEditTopicModal">
        <div class="px-3 py-6">
            <div class="flex justify-between items-start">
                <h3 class="border-b-2 mb-3 pb-3 border-gray-300 flex-1">Edit Topic</h3>
                <span
                    @click="hideEditTopicModal"
                    class="px-3 py-1 text-xl bg-gray-300 hover:bg-gray-500 hover:text-white
                    transition-all rounded-md duration-150 cursor-pointer">
                    &times;
                </span>
            </div>
            <EditTopicForm />
        </div>
    </Modal>
</template>
