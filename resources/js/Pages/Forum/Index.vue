<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Select from '@/Components/Select.vue';
import TextInput from '@/Components/TextInput.vue';
import ForumPreview from '@/Components/Forum/PreviewCard.vue'
import SearchIcon from '@/Components/Icons/SearchIcon.vue'
import SideNavigation from '@/Components/Forum/SideNavigation.vue'
</script>


<template>
    <AppLayout>
        <main class="py-6 px-2">
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
                        <option value="">Topic One</option>
                        <option value="">Topic Two</option>
                        <option value="">Topic Three</option>
                        <option value="">Topic Three</option>
                    </Select>
                </div>
                <form action="#" method="get" class="bg-gray-200 px-2 rounded-full">
                    <label for="s" class="flex items-center">
                        <SearchIcon />
                        <TextInput class="bg-transparent border-none outline-none focus:ring-0" placeholder="Search for threads..." />
                    </label>
                </form>
            </nav>
            <!-- forum wrapper -->
            <div class="space-y-6 mt-12">
                <ForumPreview />
                <ForumPreview />
            </div>
        </main>
        <!-- sidebar -->
        <template #sidebar>
            <SideNavigation />

        </template>
    </AppLayout>
</template>
