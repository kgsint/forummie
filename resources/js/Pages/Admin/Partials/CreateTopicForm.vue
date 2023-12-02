<script setup>
import useCreateTopic from '@/Composables/useCreateTopic'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { watch } from 'vue'
import useHelper from '@/Composables/useHelper'

const { form, createNewTopic } = useCreateTopic()
const { convertToSlug } = useHelper()

// auto-generated slug on type
watch(() => form.name, (name) => {
    // console.log(convertToSlug(name))
    form.slug = convertToSlug(name)
})

</script>


<template>
    <form @submit.prevent="createNewTopic">
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
            </div>
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="slug" class="sr-only">Topic's slug</label>
                <input
                    v-model="form.slug"
                    type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="name"
                    placeholder="Slug for the Topic"
                />
            </div>
        </div>
        <PrimaryButton class="float-right mb-4">Create</PrimaryButton>
    </form>
</template>


<style scoped></style>
