<script setup>
import SideNavigation from '@/Components/Forum/SideNavigation.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ForumShowCard from '@/Components/Forum/ShowCard.vue'
import { Link } from '@inertiajs/vue3'
import BackIcon from '@/Components/Icons/BackIcon.vue'
import { Head } from '@inertiajs/vue3'
import ForumPostCard from '@/Components/Forum/PostCard.vue'
import Pagination from '@/Components/Forum/Pagination.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import useCreateReply from '@/Composables/useCreateReply'

const { showReplyForm } = useCreateReply()

defineProps({
    thread: {
        type: Object,
        required: true,
    },
    posts: {
        type: Object
    }
})
</script>


<template>
    <Head :title="thread.title" />
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
        <ForumShowCard :thread="thread" :posts="posts" />


        <!-- posts for thread (replies / responses) -->
        <div class="posts-container relative space-y-3">
            <ForumPostCard v-for="post in posts.data" :key="post.id" :post="post" />
        </div>
        <!-- pagination -->
        <div class="flex justify-center">
            <Pagination :links="posts.meta.links" class="mt-3 mx-auto" />
        </div>

        <!-- sidebar -->
        <template #sidebar>
            <PrimaryButton v-if="$page.props.auth.user" @click="showReplyForm(thread)">Reply</PrimaryButton>
            <SideNavigation />
        </template>
    </AppLayout>
</template>
