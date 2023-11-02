<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Select from '@/Components/Select.vue';
import TextInput from '@/Components/TextInput.vue';
import ForumPreview from '@/Components/Forum/PreviewCard.vue'
import SearchIcon from '@/Components/Icons/SearchIcon.vue'
import SideNavigation from '@/Components/Forum/SideNavigation.vue'
import Pagination from '@/Components/Forum/Pagination.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
    threads: Object,
})

</script>


<template>
    <AppLayout>
        <Head title="Home" />
        <main class="">
            <!-- top nav filter -->
            <nav class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-x-6">
                <div class="flex space-x-2 items-center">
                    <Select class="w-32 rounded-full">
                        <option value="">Latest</option>
                        <option value="">Resolved</option>
                        <option value="">Unresolved</option>
                    </Select>

                    <Select class="w-32">
                        <option value="">All</option>
                        <option
                            v-for="topic in $page.props.topics"
                            :key="topic.slug"
                            :value="topic.slug"
                        >
                            {{ topic.name }}
                        </option>
                    </Select>
                </div>
                <form action="#" method="get" class="bg-gray-200 px-2 rounded-full">
                    <label for="s" class="flex items-center">
                        <SearchIcon />
                        <TextInput class="bg-transparent border-none outline-none focus:ring-0" placeholder="Search for threads..." />
                    </label>
                </form>
            </nav>
            <!-- <pre>
                {{ $page.props.threads }}
            </pre> -->
            <!-- forum wrapper -->
            <div class="space-y-6 mt-8">
                <!-- loop threads (forum preview card) -->
                <ForumPreview
                    v-for="thread in threads.data"
                    :key="thread.id"
                    :thread="thread"
                />
            </div>
            <!-- pagination -->
            <div class="mt-3" v-if="threads.data.length">
                <Pagination
                    :links="threads.meta.links"
                />
            </div>
        </main>
        <!-- sidebar -->
        <template #sidebar>
            <SideNavigation />
        </template>
    </AppLayout>
</template>
