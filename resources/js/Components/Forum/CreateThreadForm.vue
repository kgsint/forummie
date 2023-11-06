<script setup>
import TextInput from '../TextInput.vue';
import InputError from '../InputError.vue';
import Textarea from '../Textarea.vue';
import PrimaryButton from '../PrimaryButton.vue';
import SecondaryButton from '../SecondaryButton.vue';


import FormWrapper from '@/Components/Forum/FormWrapper.vue'
</script>


<template>
    <FormWrapper>
        <!-- header -->
        <template #header>
            <h1 class="text-xl font-semibold">Create Thread</h1>
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
                        focus:ring-blue-500 focus:border-blue-500 block p-2.5 w-32 rounded-full">
                        <option value="">Laravel</option>
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
            <div class="flex justify-between items-center">
                <div></div>
                <!-- <p
                class="hidden text-xs text-gray-600 md:block"> * You may use Markdown with <a
                    href="https://docs.github.com/en/get-started/writing-on-github/getting-started-with-writing-and-formatting-on-github/basic-writing-and-formatting-syntax" target="_blank" rel="noreferrer noopener" class="text-blue-500 underline"> GitHub-flavored </a> code blocks. </p> -->
                <div class="flex items-center space-x-3">
                    <SecondaryButton>Cancel</SecondaryButton>
                    <PrimaryButton>Create</PrimaryButton>
                </div>

            </div>
        </template>
    </FormWrapper>
</template>


<style scoped></style>
