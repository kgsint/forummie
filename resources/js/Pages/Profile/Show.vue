<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3'
import ProfileCard from '@/Pages/Profile/Partials/ProfileCard.vue'

defineProps({
    user: Object,
})
</script>


<template>
    <Head :title="user.username" />
    <AppLayout>
        <div class="p-3 rounded-lg mx-auto">
            <!-- tabs -->
            <nav class="w-full flex items-center justify-between space-x-6 max-w-[400px] bg-white p-3">
                <button class="block px-16 border-b-2 border-blue-400 text-blue-400 hover:text-blue-400 text-lg font-light" style="padding: 0 3rem;">Threads Posted</button>
                <button class="block px-16 hover:text-blue-400 text-lg font-light" style="padding: 0 3rem;">Replies Posted</button>
            </nav>
            {{ user.username }}
        </div>
        <!-- profile card -->
        <template #sidebar>
            <ProfileCard :user="user" />
        </template>
    </AppLayout>
</template>


<style scoped></style>
