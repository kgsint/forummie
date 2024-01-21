<script setup>
import Navigation from '@/Layouts/Partials/Navigation.vue'
import CreateThreadForm from '@/Components/Forum/CreateThreadForm.vue'
import CreateReplyForm from '@/Components/Forum/CreateReplyForm.vue'
import UpdateThreadForm from '@/Components/Forum/UpdateThreadForm.vue'
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <Navigation />

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto py-12 md:grid grid-cols-8 sm:p-6 md:p-3 lg:p-8 lg:space-x-6">
                <!-- sidebar -->
                <div class="col-span-2">
                    <slot name="sidebar" />
                </div>
                <!-- main -->
                <div class="col-span-6 p-3 mx-auto lg:p-0">
                    <slot/>
                </div>
            </main>
        </div>
    </div>

    <!-- create thread form -->
    <CreateThreadForm />
    <!-- update thread form -->
    <UpdateThreadForm />
    <!-- create reply form -->
    <CreateReplyForm />
</template>
