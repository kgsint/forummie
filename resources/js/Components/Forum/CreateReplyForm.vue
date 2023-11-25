<script setup>
import InputError from '../InputError.vue';
import Textarea from '../Textarea.vue';
import PrimaryButton from '../PrimaryButton.vue';
import SecondaryButton from '../SecondaryButton.vue';
import FormWrapper from '@/Components/Forum/FormWrapper.vue'
import useCreateReply from '@/Composables/useCreateReply'
import { Mentionable } from 'vue-mention';
import useMentionable from '@/Composables/useMentionable'
import { onMounted } from 'vue';

// composables
const { isVisible, hideReplyForm, form, thread, post } = useCreateReply()
const { mentionableList, handleMentionSearch } = useMentionable()

// create reply
const handleCreateReply = () => {
    // thread or post is'nt null or not
    let threadId = thread.value ? thread.value.id : post.value.thread.id

    // check it is replying to the post
    if(post.value) {
        // just one level of nested reply
        // and assign it to form data object
        form.parent_id = post.value.parent ? post.value.parent.id : post.value.id
    }

    form.post(route('posts.store', threadId), {
        onSuccess: () => {
            // reset form data
            form.reset()
            // hide form dialog/modal
            hideReplyForm()
        }
    })
}
</script>


<template>
    <FormWrapper v-if="isVisible" :form="form">
        <!-- header -->
        <template #header>
            <header class="flex justify-between items-center">
                <h1 v-if="thread" class="text-xl font-semibold">Reply to "{{ thread.title }}"</h1>
                <h1 v-if="post" class="text-xl font-semibold">Reply to @{{ post.user?.username || '[Deleted User]' }}</h1>
                <span
                    @click="hideReplyForm"
                    class="px-3 py-1 text-2xl bg-gray-300 hover:bg-gray-500 hover:text-white
                    transition-all rounded-md duration-150 cursor-pointer">
                    &times;
                </span>
            </header>
        </template>
        <!-- form -->
        <template #main="{ markdownPreviewEnabled }">
            <form id="storeReplyForm" @submit.prevent="handleCreateReply">
                <!-- body textarea -->
                <div v-if="! markdownPreviewEnabled">
                    <Mentionable
                        :keys="['@']"
                        :items="mentionableList"
                        v-on:search="handleMentionSearch"
                    >
                        <Textarea
                            placeholder="What's on your mind?"
                            rows="4"
                            v-model="form.body"
                            class="h-64 align-top"
                        />
                    </Mentionable>
                    <InputError :message="form.errors.body" />
                </div>
            </form>
        </template>
        <!-- footer -->
        <template #footer>
            <div class="flex items-center space-x-3">
                <SecondaryButton @click="hideReplyForm">Cancel</SecondaryButton>
                <PrimaryButton
                    type="submit"
                    form="storeReplyForm"
                    :disabled="form.processing"
                    :class="{ 'opacity-75': form.processing }"
                >
                    Reply
                </PrimaryButton>
            </div>
        </template>
    </FormWrapper>
</template>

