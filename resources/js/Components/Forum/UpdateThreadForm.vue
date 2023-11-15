<script setup>
import TextInput from '../TextInput.vue';
import InputError from '../InputError.vue';
import Textarea from '../Textarea.vue';
import PrimaryButton from '../PrimaryButton.vue';
import SecondaryButton from '../SecondaryButton.vue';
import Select from '../Select.vue'
import FormWrapper from '@/Components/Forum/FormWrapper.vue'
import useUpdateThreadForm from '@/Composables/useUpdateThread'


const { isVisible, hideUpdateForm, form, threadData } = useUpdateThreadForm()

// update thread
const handleUpdateThread = () => {
    form.patch(route('forum.update', threadData.value), {
        onSuccess: () => {
            isVisible.value = false
        }
    })
}
</script>


<template>
    <FormWrapper v-if="isVisible" :form="form">
        <!-- header -->
        <template #header>
            <header class="flex justify-between items-center">
                <h1 class="text-xl font-semibold">Update Thread</h1>
                <span
                    @click="hideUpdateForm"
                    class="px-3 py-1 text-2xl bg-gray-300 hover:bg-gray-500 hover:text-white
                    transition-all rounded-md duration-150 cursor-pointer">
                    &times;
                </span>
            </header>
        </template>
        <!-- form -->
        <template #main="{ markdownPreviewEnabled }">
            <form id="updateThreadForm" @submit.prevent="handleUpdateThread">
                <div class="flex items-start space-x-4 mb-3">
                    <!-- title -->
                    <div class="flex-grow">
                        <TextInput placeholder="Title" class="flex-grow w-full" v-model="form.title" />
                        <InputError :message="form.errors.title" />
                    </div>
                    <!-- select topic -->
                    <div>
                        <Select
                            v-model="form.topic_id"
                        >
                            <option value="">Choose Topic</option>
                            <option
                                v-for="topic in $page.props.topics"
                                :key="topic.id"
                                :value="topic.id"
                            >
                                {{ topic.name }}
                            </option>
                        </Select>
                        <InputError :message="form.errors.topic_id" />
                    </div>
                </div>
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
                <SecondaryButton @click="hideUpdateForm">Cancel</SecondaryButton>
                <PrimaryButton
                    type="submit"
                    form="updateThreadForm"
                    :disabled="form.processing"
                    :class="{ 'opacity-75': form.processing }"
                >
                    Update
                </PrimaryButton>
            </div>
        </template>
    </FormWrapper>
</template>

