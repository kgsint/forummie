<script setup>
import { Link, router, useForm } from '@inertiajs/vue3';
import ForumPostCard from '@/Components/Forum/PostCard.vue'
import useCreateReply from '@/Composables/useCreateReply'
import EditIcon from '../Icons/EditIcon.vue';
import DeleteIcon from '../Icons/DeleteIcon.vue';
import { ref, watch, computed, onMounted, onUpdated } from 'vue';
import Textarea from '../Textarea.vue';
import InputError from '../InputError.vue';
import Swal from 'sweetalert2'
import axios from 'axios';
import useMentionable from '@/Composables/useMentionable'

defineOptions({
    inheritAttrs: false
})

// props
const props = defineProps({
    post: Object,
    solutionId: Number
})

const isBestAnswer = computed(() => {
    return props.solutionId === props.post.id
})

// composables
const { showReplyForm } = useCreateReply()
const { highlightMentionedUser } = useMentionable()
// edit form object
const editForm = useForm({
    body: props.post.body_markdown
})
// ref for toggling edit form
const isEdit = ref(false)
const markdownPreviewEnabled = ref(false)
const markdownHtml = ref('')
const loading = ref(false) // loading indicator for markdown preview

watch(markdownPreviewEnabled, (isEnabled) => {
    // markdown preview is off, do nothing
    if(! isEnabled) {
        return
    }

    loading.value = true
    // if turn on, making request to the specific route
    axios.post(route('markdown.preview'), {
        body: editForm.body.trim(),
    }).then(res => {
        loading.value = false
        markdownHtml.value = res.data.markdown_html
    })
})

// highlight mention user
onMounted(() => {
    props.post.body = highlightMentionedUser(props.post.body)
})
onUpdated(() => {
    props.post.body = highlightMentionedUser(props.post.body)
})

// submit edit form request
const handleEditPost = () => {
    editForm.patch(route('posts.update', {
        thread: props.post.thread,
        post: props.post
    }), {
        onSuccess: () => {
            isEdit.value = false
        }
    })
}

// submit delete form request
const handleDeletePost = () => {
    Swal.fire({
      title: "Do you want to delete the post?",
      showCancelButton: true,
      confirmButtonText: "Delete",
      confirmButtonColor: "#eb020e",
    }).then((result) => {
      /* if confirmed */
      if (result.isConfirmed) {
        router.delete(route('posts.destroy', {
            thread: props.post.thread,
            post: props.post
        }))
        Swal.fire("Deleted!", "", "success");
      }
    });

}

// hide edit form
const hideEditForm = () => {
    isEdit.value = false
    editForm.errors.body = '' // when toggling off the form, reset validation error if any
}

// mark/unmark as best answer
const handleBestAnswer = () => {
    router.patch(route('threads.best-answer', {
        thread: props.post.thread,
        post: props.post
    }
        ), {
        post_id: props.solutionId === props.post.id ? null : props.post.id, // if is already marked, unmark, if not mark as best answer
    }, {
        preserveScroll: true
    })
}
</script>


<template>
    <article
        :id="`post-${post.id}`"
        class="relative flex bg-white space-x-2 px-2 py-4 rounded-lg shadow thread-post"
        v-bind="$attrs"
        :class="{ '!bg-blue-50 border border-blue-400': isBestAnswer }"
    >
        <!-- profile image -->
        <div class="flex-none flex lg:items-center gap-2 lg:block mb-3">
            <a href="#">
                <img :src="post.user?.avatar" class="w-[28px] h-[28px] lg:w-14 lg:h-14 rounded-xl" alt="profile image" v-if="post.user">
                <img src="https://static.thenounproject.com/png/5034901-200.png" class="w-[20px] h-[20px] lg:w-14 lg:h-14 rounded-xl" alt="default profile image" v-else>
            </a>
        </div>
        <div class="flex flex-col flex-1 space-y-3">
            <div class="flex justify-between items-start">
                <div class="flex flex-col">
                    <Link href="#" class="mb-1" style="color: #111; text-decoration: none;">
                        <!-- username -->
                        <h4 class="text-md font-semibold">{{ post.user?.username || '[Deleted User]' }}</h4>
                    </Link>
                    <!-- created date -->
                    <div class="text-xs text-gray-600 leading-normal font-semibold">
                        <time :datetime="post.created_at.datetime" :title="post.created_at.datetime">{{ post.created_at.human }}</time>
                    </div>
                </div>
                <h5 v-if="isBestAnswer" class="text-blue-600 font-bold">Best Answer</h5>
            </div>

            <!-- description -->
            <p
                v-if="!isEdit"
                v-html="post.body"
                class="text-sm text-gray-600 leading-7">
            </p>

            <!-- edit form -->
            <form @submit.prevent="handleEditPost"  v-else>
                <!-- textarea for editing post -->
                <div v-if="! markdownPreviewEnabled">
                    <Textarea v-model="editForm.body" rows="4" class="h-32" />
                    <InputError :message="editForm.errors.body" />
                </div>
                <!-- markdown preview panel -->
                <div
                    v-html="markdownHtml"
                    class="bg-gray-200 w-full h-32 mb-2 p-3 rounded-lg  markdown"
                    v-if="markdownPreviewEnabled && !loading">
                </div>

                <!-- loading indicator -->
                <div v-if="loading" class="bg-gray-200 w-full mb-2 p-3 rounded-lg  markdown text-center my-auto">
                    <span>Loading...</span>
                </div>

                <div class="space-x-3 flex justify-between items-start">
                    <button
                        type="button"
                        @click="markdownPreviewEnabled = !markdownPreviewEnabled"
                        class="text-xs text-blue-500 cursor-pointer">
                        {{ markdownPreviewEnabled ? 'Turn off' : 'Turn on' }} Markdown Preview
                    </button>
                    <div class="space-x-2">
                        <button
                            type="button"
                            @click="hideEditForm"
                            class="bg-gray-200 px-4 py-2 text-sm rounded-xl font-bold hover:bg-gray-300 transition-all duration-150">
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="bg-blue-500 text-white px-4 py-2 text-sm rounded-xl font-bold hover:bg-blue-300 transition-all duration-150">
                            Update
                        </button>
                    </div>
                </div>
            </form>

            <!-- reply, edit and delete button -->
            <div class="flex items-center justify-between" v-if="!isEdit">
                <button
                    v-if="$page.props.auth.user"
                    @click="showReplyForm(post, false)"
                    class="bg-gray-200 px-4 py-2 text-sm rounded-xl font-bold hover:bg-gray-300 transition-all duration-150">
                    Reply
                </button>

                <!-- action btns -->
                <div class="space-x-3 flex items-center">
                    <button
                        @click="handleBestAnswer"
                        v-if="post.thread.can.manage"
                        class="text-sm text-blue-500 hover:underline">{{ isBestAnswer ? 'Remove' : 'Mark' }} as best answer</button>

                    <button
                        v-if="post.can.update"
                        @click="isEdit = true">
                        <EditIcon />
                    </button>
                    <button
                        v-if="post.can.delete"
                        @click="handleDeletePost">
                        <DeleteIcon class="text-red-500" />
                    </button>
                </div>
            </div>
        </div>
    </article>

        <!-- {{ post.replies }} -->
        <ForumPostCard
            class="reply-post ml-10"
            v-if="post?.replies?.length"
            v-for="reply in post.replies"
            :key="reply.id"
            :post="reply"
            :solutionId="solutionId"
        />
</template>
