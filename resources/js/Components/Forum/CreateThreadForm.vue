<script setup>
import TextInput from '../TextInput.vue';
import InputError from '../InputError.vue';
import Textarea from '../Textarea.vue';
import PrimaryButton from '../PrimaryButton.vue';
import SecondaryButton from '../SecondaryButton.vue';
import FormWrapper from '@/Components/Forum/FormWrapper.vue'
import useCreateThread from '@/Composables/useCreateThread'

const { isVisible, hideCreateThreadForm } = useCreateThread()
</script>


<template>
    <FormWrapper v-if="isVisible">
        <!-- header -->
        <template #header>
            <header class="flex justify-between items-center">
                <h1 class="text-xl font-semibold">Create Thread</h1>
                <span
                    @click="hideCreateThreadForm"
                    class="px-3 py-1 text-2xl bg-gray-300 hover:bg-gray-500 hover:text-white
                    transition-all rounded-md duration-150 cursor-pointer">
                    &times;
                </span>
            </header>
        </template>
        <!-- form -->
        <template #main>
            <form>
                <div class="flex items-start space-x-4 mb-3">
                    <div class="flex-grow">
                        <TextInput placeholder="Title" class="flex-grow w-full" />
                        <InputError message="Some error" />
                    </div>
                    <select
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                        focus:ring-blue-500 focus:border-blue-500 block p-2.5 w-32 rounded-full cursor-pointer">
                        <option
                            v-for="topic in $page.props.topics"
                            :key="topic.slug"
                            :value="topic.slug"
                        >
                            {{ topic.name }}
                        </option>
                    </select>
                </div>
                <!-- textarea -->
                <div>
                    <Textarea placeholder="What's on your mind?" rows="4" />
                    <InputError message="Some error" />
                </div>
            </form>
        </template>
        <!-- footer -->
        <template #footer>
            <div class="flex items-center space-x-3">
                <SecondaryButton @click="hideCreateThreadForm">Cancel</SecondaryButton>
                <PrimaryButton>Create</PrimaryButton>
            </div>
        </template>
    </FormWrapper>
</template>


<style scoped></style>
