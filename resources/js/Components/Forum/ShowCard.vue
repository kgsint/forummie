<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted, onUpdated } from 'vue'
import useMentionable from '@/Composables/useMentionable'

const props = defineProps({
    thread: {
        type: Object,
        required: true,
    },
})

const { highlightMentionedUser } = useMentionable()

onMounted(() => {
    props.thread.body = highlightMentionedUser(props.thread.body)
})
onUpdated(() => {
    props.thread.body = highlightMentionedUser(props.thread.body)
})
</script>


<template>
    <article class="flex bg-white space-x-2 px-2 py-4 rounded-lg shadow mb-6">
        <!-- profile image -->
        <div class="flex-none flex lg:items-center gap-2 lg:block mb-3">
            <a href="#">
                <img :src="thread.user?.avatar" class="w-[28px] h-[28px] lg:w-14 lg:h-14 rounded-xl" alt="profile image" v-if="thread.user">
                <img src="https://static.thenounproject.com/png/5034901-200.png" class="w-[28px] h-[28px] lg:w-14 lg:h-14 rounded-xl" v-else >
            </a>
        </div>
        <div class="flex flex-col flex-1">
            <div class="flex justify-between items-center">
                <Link href="#">
                    <!-- username -->
                    <h4 class="text-md font-semibold">{{ thread.user?.username || '[Deleted User]' }}</h4>
                </Link>
            </div>

            <!-- created date -->
            <div class="text-xs text-gray-600 leading-normal font-semibold mb-3">
                posted <time
                            :datetime="thread.created_at.datetime"
                            :title="thread.created_at.datetime">
                            {{ thread.created_at.human }}
                        </time>
            </div>

            <!-- title -->
            <h3 class="bg-blue-50 mb-3 text-2xl p-3 rounded-xl font-semibold">{{ thread.title }}</h3>

            <!-- description -->
            <div v-html="thread.body" class="markdown"></div>
        </div>
    </article>
</template>
