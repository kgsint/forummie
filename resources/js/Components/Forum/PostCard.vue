<script setup>
import { Link } from '@inertiajs/vue3';
import ForumPostCard from '@/Components/Forum/PostCard.vue'

defineOptions({
    inheritAttrs: false
})

defineProps({
    post: Object
})

</script>


<template>
    <article class="relative flex bg-white space-x-2 px-2 py-4 rounded-lg shadow"  v-bind="$attrs">
        <!-- profile image -->
        <div class="flex-none flex lg:items-center gap-2 lg:block mb-3">
            <a href="#">
                <img :src="post.user?.avatar" class="w-[28px] h-[28px] lg:w-14 lg:h-14 rounded-xl" alt="profile image" v-if="post.user">
                <img src="https://static.thenounproject.com/png/5034901-200.png" class="w-[20px] h-[20px] lg:w-14 lg:h-14 rounded-xl" alt="default profile image" v-else>

            </a>
        </div>
        <div class="flex flex-col">
            <div class="flex justify-between items-center">
                <Link href="#">
                    <!-- username -->
                    <h4 class="text-md font-semibold">{{ post.user?.username || '[Deleted User]' }}</h4>
                </Link>
            </div>

            <!-- created date -->
            <div class="text-xs text-gray-600 leading-normal font-semibold mb-3">
                <time :datetime="post.created_at.datetime" :title="post.created_at.datetime">{{ post.created_at.human }}</time>
            </div>

            <!-- description -->
            <p class="text-sm text-gray-600 leading-7">
                {{ post.body }}
            </p>
        </div>
    </article>

        <!-- {{ post.replies }} -->
        <ForumPostCard class="reply-post ml-10" v-if="post.replies.length" v-for="reply in post.replies" :key="reply.id" :post="reply"  />
</template>
