<script setup>
import InputError from '../InputError.vue';
import Textarea from '../Textarea.vue';
import PrimaryButton from '../PrimaryButton.vue';
import SecondaryButton from '../SecondaryButton.vue';
import FormWrapper from '@/Components/Forum/FormWrapper.vue'
import useCreateReply from '@/Composables/useCreateReply'

const { isVisible, hideReplyForm, form, thread } = useCreateReply()

// create reply
const handleCreateReply = () => {
    // to do
}
</script>


<template>
    <FormWrapper v-if="isVisible" :form="form">
        <!-- header -->
        <template #header>
            <header class="flex justify-between items-center">
                <h1 class="text-xl font-semibold">Replying to "{{ thread.title }}"</h1>
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
                    <Textarea placeholder="What's on your mind?" rows="4" v-model="form.body" class="h-64 align-top" />
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

