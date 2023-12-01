<script setup>
import SideNavigation from '@/Components/Forum/SideNavigation.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ForumShowCard from '@/Components/Forum/ShowCard.vue'
import { Link, Head, router, usePage } from '@inertiajs/vue3'
import BackIcon from '@/Components/Icons/BackIcon.vue'
import ForumPostCard from '@/Components/Forum/PostCard.vue'
import Pagination from '@/Components/Forum/Pagination.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import useCreateReply from '@/Composables/useCreateReply'
import EditIcon from '@/Components/Icons/EditIcon.vue'
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue'
import useUpdateThread from '@/Composables/useUpdateThread'
import { onMounted, onUpdated, nextTick } from 'vue';
import Swal from 'sweetalert2'
import VueScrollTo from 'vue-scrollto'

const page = usePage()
// composables
const { showReplyForm } = useCreateReply()
const { showUpdateForm, form, threadData } = useUpdateThread()

// props
const props = defineProps({
    thread: {
        type: Object,
        required: true,
    },
    posts: {
        type: Object
    }
})

// mounted hook
onMounted(() => {
    // populate form data
    form.title = props.thread.title
    form.body = props.thread.body_markdown
    form.topic_id = props.thread.topic.id

    // populate threadData for request
    threadData.value = props.thread

    // scroll to the newly created post
    nextTick(() => {
        let postId = page.props.queryStrings?.post_id
        scrollToPost(postId)
    })
})

// when component is updated (condition when post was edited or so...)
onUpdated(() => {
    // scroll to the newly created post
    nextTick(() => {
        let postId = page.props.queryStrings?.post_id
        scrollToPost(postId)
    })
})
// scroll to post fn
const scrollToPost = (postId) => {
    if(postId) {
        VueScrollTo.scrollTo(`#post-${postId}`, 500)
    }
}

// delete thread
const handleDelete = () => {
    // confirm with sweet alert
    Swal.fire({
      text: `Do you want delete this thread "${props.thread.title}"?`,
      showCancelButton: true,
      confirmButtonText: "Delete",
      confirmButtonColor: "#eb020e",
    }).then((result) => {
      /* if confirmed */
      if (result.isConfirmed) {
        router.delete(route('forum.destroy', props.thread), {
            onSuccess: () => {
                Swal.fire("Thread has been deleted!", "", "success");
            }
        })

      }
    });
}
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
            <div class="space-x-2" v-if="thread.can.update">
                <button
                    @click="showUpdateForm(thread)"
                    class="border border-gray-500 p-3 rounded-md hover:bg-gray-900 hover:text-white duration-150 transition-all">
                    <EditIcon />
                </button>
                <button
                    @click="handleDelete"
                    class="text-red-500 border border-red-500 p-3 rounded-md hover:bg-red-500 hover:text-white duration-150 transition-all">
                    <DeleteIcon />
                </button>
            </div>
        </div>
        <!-- main thread -->
        <ForumShowCard :thread="thread" />

        <!-- posts for thread (replies / responses) -->
        <div class="posts-container relative space-y-3">
            <ForumPostCard
                v-for="post in posts.data"
                :key="post.id"
                :post="post"
                :solutionId="thread.solution?.id"
            />
        </div>
        <!-- pagination -->
        <div class="flex justify-center">
            <Pagination :links="posts.meta.links" class="mt-3 mx-auto" />
        </div>

        <!-- sidebar -->
        <template #sidebar>
            <PrimaryButton v-if="$page.props.auth.user" @click="showReplyForm(thread)">Reply To This Thread</PrimaryButton>
            <SideNavigation />
        </template>
    </AppLayout>
</template>
