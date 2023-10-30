<script setup>
import SideNavigation from '@/Components/Forum/SideNavigation.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ForumShowCard from '@/Components/Forum/ShowCard.vue'
import { Link } from '@inertiajs/vue3'
import BackIcon from '@/Components/Icons/BackIcon.vue'
import ForumReplyCard from '@/Components/Forum/ReplyCard.vue'

defineProps({
    thread: {
        type: Object,
        required: true,
    }
})
</script>


<template>
    <!-- main -->
    <AppLayout>
        <!-- back button -->
        <Link
            :href="route('forum.index')"
            class="hover:bg-black bg-gray-200 rounded-full
                    hover:text-white px-2 py-1 inline-block mb-3 transition-colors duration-200"
        >
            <BackIcon class="inline-block text-sm" /> <span class="text-sm font-semibold">Back</span>
        </Link>
        <!-- main thread -->
        <ForumShowCard :thread="thread" />

        <!-- replies -->
        <!-- <ForumReplyCard /> -->

        <!-- sidebar -->
        <template #sidebar>
            <SideNavigation />
        </template>
    </AppLayout>
</template>
