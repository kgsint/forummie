<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue'
import Pagination from '@/Components/Forum/Pagination.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Modal from '@/Components/Modal.vue'
import { ref } from 'vue'

defineProps({
    topics: Object,
})

const showCreateTopicModal = ref(false)

</script>


<template>
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
            <form>
                <div class="flex justify-between items-center gap-3 mb-3">
                    <div class="mt-1 lg:w-64 xl:w-96">
                        <label for="name" class="sr-only">Topic's Name</label>
                        <input
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                                focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                            id="name"
                            placeholder="Name of the topic"
                        />
                    </div>
                    <div class="mt-1 lg:w-64 xl:w-96">
                        <label for="slug" class="sr-only">Topic's slug</label>
                        <input
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                                focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                            id="name"
                            placeholder="Slug for the Topic"
                        />
                    </div>
                </div>
                <PrimaryButton class="float-right mb-4">Create</PrimaryButton>
            </form>
        </div>
    </Modal>

    <Head title="Manage Tags" />
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
                                    placeholder="Search for topics"
                                />
                            </div>
                        </form>

                        <PrimaryButton @click="showCreateTopicModal = true">
                            Create new Topic
                        </PrimaryButton>
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
                                        <button
                                            type="button"
                                            class="px-3 py-2 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300"
                                        >
                                            <DeleteIcon class="w-4 h-4" />
                                        </button>
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
</template>


<style scoped></style>
