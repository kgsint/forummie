<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed,onMounted, nextTick  } from 'vue';

const props = defineProps({
    statusCode: Number,
})

const backBtn = ref(null)

onMounted(() => {
    // focus button
    nextTick(() => backBtn.value.focus())
})
const titleByStatusCode = {
    401: 'Unauthorized',
    403: 'Forbidden',
    404: 'Not Found',
    500: 'Internal Server Error',
}

const title = computed(() => {
    return titleByStatusCode[props.statusCode]
})

const descriptionByStatusCode = {
    401: 'You need some check-in',
    403: 'This Action is not allowed buddy!',
    404: "Look Like you're Lost!",
    500: 'Oops, Something went wrong!',
}
const description = computed(() => {
    return descriptionByStatusCode[props.statusCode]
})

</script>

<template>
    <Head :title="title" />
    <div class="grid items-center text-center bg-gray-100" style="min-height: 100vh;">
        <div class="flex flex-col">
            <h1 class="text-4xl font-bold mb-12 text-gray-700">
                <span class="text-blue-400">{{ statusCode }}</span> {{ title }}
            </h1>
            <p class="text-gray-600 mb-2">{{ description }}</p>
            <div>
                <Link :href="route('forum.index')">
                    <button class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" ref="backBtn">Go back</button>
                </Link>
            </div>
        </div>
    </div>
</template>


<style scoped></style>
