<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    thread: {
        type: Object,
        required: true,
    },
})
</script>


<template>
    <article class="flex bg-white space-x-2 px-2 py-4 rounded-lg shadow mb-6">
        <!-- profile image -->
        <div class="flex-none flex lg:items-center gap-2 lg:block mb-3">
            <a href="#">
                <img :src="thread.user.avatar" class="w-[28px] h-[28px] lg:w-14 lg:h-14 rounded-xl" alt="profile image">
            </a>
        </div>
        <div class="flex flex-col">
            <div class="flex justify-between items-center">
                <Link href="#">
                    <!-- username -->
                    <h4 class="text-md font-semibold">{{ thread.user.username }}</h4>
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
            <p class="text-sm text-gray-600 leading-7">
                {{ thread.description }}
            </p>
        </div>
    </article>
</template>
