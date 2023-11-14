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
import EditIcon from '@/Components/Icons/EditIcon.vue'
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue'
import useUpdateThread from '@/Composables/useUpdateThread'
import { onMounted } from 'vue';

const { showReplyForm } = useCreateReply()
const { showUpdateForm, form } = useUpdateThread()

const props = defineProps({
    thread: {
        type: Object,
        required: true,
    },
    posts: {
        type: Object
    }
})

onMounted(() => {
    // populate data
    form.title = props.thread.title
    form.body = props.thread.body
    form.topic_id = props.thread.topic.id
})
</script>


<template>
    <Head :title="thread.title" />
    <!-- main -->
    <AppLayout>
        <div class="flex items-center justify-between mb-3">
            <!-- back button -->
            <Link
                :href="route('forum.index')"
                class="hover:bg-black bg-gray-200 rounded-full
                        hover:text-white px-2 py-1 inline-block transition-colors duration-200"
            >
                <BackIcon class="inline-block text-sm" /> <span class="text-sm font-semibold">Back</span>
            </Link>
            <!-- update and delete button -->
            <div class="space-x-2">
                <button
                    @click="showUpdateForm"
                    class="w-12 h-12 border border-gray-500 p-3 rounded-md hover:bg-gray-900 hover:text-white duration-150 transition-all">
                    <EditIcon />
                </button>
                <button class="w-12 h-12 text-red-500 border border-red-500 p-3 rounded-md hover:bg-red-500 hover:text-white duration-150 transition-all">
                    <DeleteIcon />
                </button>
            </div>
        </div>
        <!-- main thread -->
        <ForumShowCard :thread="thread" />


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
