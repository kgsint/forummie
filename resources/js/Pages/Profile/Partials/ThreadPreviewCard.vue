<script setup>
import { Link, router } from '@inertiajs/vue3'

defineProps({
    thread: {
        type: Object,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
    isSolved: {
        type: Boolean,
    }
})
</script>


<template>
    <article
        @click="router.get(route('forum.show', { thread }))"
        class="flex flex-col lg:flex-row bg-white lg:space-x-2 px-2 py-4 rounded-lg
            shadow cursor-pointer hover:shadow-lg duration-150 transition-all max-w-[600px]"
        :class="{ 'border-2 border-blue-200': isSolved }"
    >
        <!-- profile image -->
        <div class="flex-none flex items-center gap-2 lg:block mb-3">
            <a href="#">
                <img :src="user?.avatar" class="w-8 h-8 md:w-14 md:h-14 rounded-xl object-cover" alt="profile image" v-if="user">
                <img src="https://static.thenounproject.com/png/5034901-200.png" class="w-14 h-14 rounded-xl" alt="default profile image" v-else >
            </a>
            <!-- username -->
            <strong class="lg:hidden">
                {{ user?.username || '[Deleted User]' }}
            </strong>
        </div>

        <!-- title and description -->
        <div class="flex flex-col flex-grow">
            <!-- title -->
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-3">
                <Link
                    :href="route('forum.show', thread.slug)"
                    class="hover:underline mb-3 lg:mb-0"
                >
                    <h4 class="text-lg lg:text-2xl font-semibold">{{ thread.title }}</h4>
                </Link>
            </div>

            <!-- description -->
            <div class="markdown preview" v-html="thread.body"></div>
        </div>
    </article>
</template>
