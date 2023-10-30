<script setup>
import { Link } from '@inertiajs/vue3'
import MessageIcon from '@/Components/Icons/MessageIcon.vue'

defineProps({
    thread: Object
})
</script>


<template>
    <article class="flex flex-col lg:flex-row bg-white lg:space-x-2 px-2 py-4 rounded-lg shadow">
        <!-- profile image -->
        <div class="flex-none flex items-center gap-2 lg:block mb-3">
            <a href="#">
                <img :src="thread.user.avatar" class="w-14 h-14 rounded-xl" alt="profile image">
            </a>
            <strong class="lg:hidden">
                {{ thread.user.username }}
            </strong>
        </div>
        <!-- title and description -->
        <div class="flex flex-col">
            <!-- title -->
            <div class="flex justify-between items-center mb-3">
                <Link :href="route('forum.show', thread.slug)" class="hover:underline">
                    <h4 class="text-2xl font-semibold">{{ thread.title }}</h4>
                </Link>
                <div class="flex items-center space-x-4">
                    <span class="flex items-center text-xs gap-1"><MessageIcon /> 0</span>
                    <Link href="#" class="text-xs font-semibold px-3 py-1 rounded-full border hover:bg-gray-900 hover:text-white transition-colors duration-150 border-gray-700">
                        {{ thread.topic.name }}
                    </Link>
                </div>
            </div>

            <!-- description -->
            <p class="text-sm text-gray-600 leading-normal line-clamp-2 mb-3">{{ thread.description }}</p>
            <!-- replied status -->
            <div class="text-xs text-gray-600 leading-normal line-clamp-2">
                <Link href="#" class="text-blue-400 underline hover:no-underline">{{ thread.user.name }}</Link> posted {{ thread.created_at }}
            </div>
        </div>
    </article>
</template>


<style scoped></style>
