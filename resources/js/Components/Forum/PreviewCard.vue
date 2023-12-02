<script setup>
import { Link } from '@inertiajs/vue3'
import MessageIcon from '@/Components/Icons/MessageIcon.vue'
import { router } from '@inertiajs/vue3';
import CheckedIcon from '../Icons/CheckedIcon.vue'

const props = defineProps({
    thread: Object,
    isSolved: Boolean,
})

const redirectToShow = (e) => {
    // check the target element is thread's topic or  not
    if(! e.target.classList.contains('topic')) {
        router.visit(route('forum.show', props.thread.slug))
    }
}

</script>


<template>
    <article
        @click="redirectToShow"
        class="flex flex-col lg:flex-row bg-white lg:space-x-2 px-2 py-4 rounded-lg
            shadow cursor-pointer hover:shadow-lg duration-150 transition-all"
        :class="{ 'border-2 border-blue-200': isSolved }"
    >
        <!-- profile image -->
        <div class="flex-none flex items-center gap-2 lg:block mb-3">
            <a href="#">
                <img :src="thread.user?.avatar" class="w-8 h-8 md:w-14 md:h-14 rounded-xl" alt="profile image" v-if="thread.user">
                <img src="https://static.thenounproject.com/png/5034901-200.png" class="w-14 h-14 rounded-xl" alt="default profile image" v-else >
            </a>
            <!-- username -->
            <strong class="lg:hidden">
                {{ thread.user?.username || '[Deleted User]' }}
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
                <div class="flex lg:items-center space-x-4">
                    <!-- no of posts in the thread -->
                    <span class="flex items-center text-xs gap-1"><MessageIcon />{{ thread.no_of_posts }}</span>
                    <!-- topic -->
                    <Link
                        :href="`/?filter[topic]=${thread.topic.slug}`"
                        class="topic text-xs font-semibold px-3 py-1 rounded-full border hover:bg-gray-900
                        hover:text-white transition-colors duration-150 border-gray-700"
                    >
                        {{ thread.topic.name }}
                    </Link>
                </div>
            </div>

            <!-- description -->
            <div class="markdown preview" v-html="thread.body"></div>
            <!-- <p class="text-sm text-gray-600 leading-normal line-clamp-2 mb-3">{{ thread.body }}</p> -->

            <div class="flex justify-between items-center">
                <!-- conditionally display reply or posted by owner -->
                <Link
                    :href="route('forum.show', thread.slug)"
                    v-if="thread.latest_post"
                    class="text-xs text-gray-600 leading-normal line-clamp-2 hover:underline">
                    <Link href="#" class="text-blue-400 hover:underline">
                        {{ thread.latest_post.user?.username || '[deleted user]' }}
                    </Link> replied
                    <time
                        :datetime="thread.latest_post.created_at.datetime"
                        :title="thread.latest_post.created_at.datetime"
                    >
                        {{ thread.latest_post.created_at.human }}
                    </time>
                </Link>
                <div v-else class="text-xs text-gray-600 leading-normal line-clamp-2">
                    <Link href="#" class="text-blue-400 hover:underline">
                        {{ thread.user?.username || '[deleted user]' }}
                    </Link> posted
                    <time
                        :datetime="thread.created_at.datetime"
                        :title="thread.created_at.datetime"
                    >
                        {{ thread.created_at.human }}
                    </time>
                </div>

                <div v-if="isSolved" class="flex items-center text-blue-500">
                    <CheckedIcon /> Solved
                </div>
            </div>
        </div>
    </article>
</template>
