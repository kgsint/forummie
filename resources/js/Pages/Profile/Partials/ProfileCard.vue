<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({
    user: Object,
})
</script>


<template>
    <div class="bg-white p-3 rounded-lg">
        <!-- profile image -->
        <img :src="user.avatar" :alt="user.username" class="w-20 h-20 rounded-full object-cover">
        <!-- username -->
        <div class="flex items-center">
            <h3 class="text-xl font-bold">{{ user.name }}</h3>
            <span>(@{{ user.username }})</span>
        </div>
        <!-- joined_at -->
        <p class="text-gray-400 mb-6">Joined at {{ user.joined_at.format }}</p>
        <!-- edit profile button -->
        <Link
            v-if="user.can.update"
            :href="route('profile.edit')"
            class="px-3 py-1 border-2 border-gray-300 rounded-lg  hover:opacity-75 bg-gray-200"
        >
            Edit Profile
        </Link>
        <h3 class="text-lg text-gray-700 border-b">Stats</h3>
        <ul class="text-gray-500 text-md">
            <li>Threads - {{ user.threads.length }}</li>
            <li>Replies - {{ user.posts.length }}</li>
        </ul>
    </div>
</template>


<style scoped></style>
