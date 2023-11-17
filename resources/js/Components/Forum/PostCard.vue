<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import ForumPostCard from '@/Components/Forum/PostCard.vue'
import useCreateReply from '@/Composables/useCreateReply'
import EditIcon from '../Icons/EditIcon.vue';
import DeleteIcon from '../Icons/DeleteIcon.vue';
import { ref } from 'vue';
import Textarea from '../Textarea.vue';
import InputError from '../InputError.vue';

defineOptions({
    inheritAttrs: false
})

const props = defineProps({
    post: Object
})

const { showReplyForm } = useCreateReply()

// edit form object
const editForm = useForm({
    body: props.post.body
})
// ref for toggling edit form
const isEdit = ref(false)

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
        <div class="flex flex-col flex-1 space-y-3">
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
            <p v-if="!isEdit" class="text-sm text-gray-600 leading-7">
                {{ post.body }}
            </p>
            <!-- edit form -->
            <form @submit.prevent="handleEditPost"  v-else>
                <Textarea v-model="editForm.body" rows="4" />
                <InputError :message="editForm.errors.body" />
                <div class="space-x-3 text-right">
                    <button
                        type="button"
                        @click="isEdit = false"
                        class="bg-gray-200 px-4 py-2 text-sm rounded-xl font-bold hover:bg-gray-300 transition-all duration-150">
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="bg-blue-500 text-white px-4 py-2 text-sm rounded-xl font-bold hover:bg-blue-300 transition-all duration-150">
                        Update
                    </button>
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
                <div class="space-x-3">
                    <button @click="isEdit = true"><EditIcon /></button>
                    <button> <DeleteIcon class="text-red-500" /> </button>
                </div>
            </div>
        </div>
    </article>

    <!-- <pre>
        {{ post }}
    </pre> -->

        <!-- {{ post.replies }} -->
        <ForumPostCard class="reply-post ml-10" v-if="post?.replies?.length" v-for="reply in post.replies" :key="reply.id" :post="reply"  />
</template>
