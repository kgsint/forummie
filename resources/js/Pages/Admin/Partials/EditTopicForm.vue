<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import useTopic from '@/Composables/useTopic';
import InputError from '@/Components/InputError.vue'
import useHelper from '@/Composables/useHelper'
import { watch } from 'vue'

const { form, handleUpdate } = useTopic()
const { convertToSlug } = useHelper()

watch(() => form.name, (name) => {
    form.slug = convertToSlug(name)
})
</script>

<template>
    <form @submit.prevent="handleUpdate">
        <div class="flex justify-between items-center gap-3 mb-3">
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="name" class="sr-only">Topic's Name</label>
                <input
                    v-model="form.name"
                    type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="name"
                    placeholder="Name of the topic"
                />
                <InputError :message="form.errors.name" />
            </div>
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="slug" class="sr-only">Topic's slug</label>
                <input
                    v-model="form.slug"
                    type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="slug"
                    placeholder="Slug for the Topic"
                />
                <InputError :message="form.errors.slug" />
            </div>
        </div>
        <PrimaryButton class="float-right mb-4">Update</PrimaryButton>
    </form>
</template>
