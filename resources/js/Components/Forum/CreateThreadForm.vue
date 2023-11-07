<script setup>
import TextInput from '../TextInput.vue';
import InputError from '../InputError.vue';
import Textarea from '../Textarea.vue';
import PrimaryButton from '../PrimaryButton.vue';
import SecondaryButton from '../SecondaryButton.vue';
import Select from '../Select.vue'
import FormWrapper from '@/Components/Forum/FormWrapper.vue'
import useCreateThread from '@/Composables/useCreateThread'


const { isVisible, hideCreateThreadForm, form } = useCreateThread()
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
            {{ form }}
        </template>
        <!-- form -->
        <template #main>
            <form>
                <div class="flex items-start space-x-4 mb-3">
                    <div class="flex-grow">
                        <TextInput placeholder="Title" class="flex-grow w-full" v-model="form.title" />
                        <InputError :message="form.errors.title" />
                    </div>
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
                </div>
                <!-- textarea -->
                <div>
                    <Textarea placeholder="What's on your mind?" rows="4" v-model="form.body" />
                    <InputError :message="form.errors.body" />
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
