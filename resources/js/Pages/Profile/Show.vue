<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import ProfileCard from "@/Pages/Profile/Partials/ProfileCard.vue";
import ThreadPreviewCard from "./Partials/ThreadPreviewCard.vue";
import ReplyPreviewCard from "./Partials/ReplyPreviewCard.vue";
import { ref } from "vue";

defineProps({
    user: Object,
});

const tab = ref("threads");
</script>

<template>
    <Head :title="user.username" />
    <AppLayout>
        <div class="p-3 rounded-lg mx-auto">
            <!-- tabs -->
            <nav
                class="w-full flex items-center justify-between space-x-6 max-w-[600px] bg-white p-3"
            >
                <button
                    @click.prevent="tab = 'threads'"
                    class="block px-16 hover:text-blue-400 text-lg font-light"
                    :class="{
                        'border-b-2 border-blue-400 text-blue-400':
                            tab === 'threads',
                    }"
                    style="padding: 0 3rem"
                >
                    Threads Posted
                </button>
                <button
                    @click.prevent="tab = 'replies'"
                    class="block px-16 hover:text-blue-400 text-lg font-light"
                    :class="{
                        'border-b-2 border-blue-400 text-blue-400':
                            tab === 'replies',
                    }"
                    style="padding: 0 3rem"
                >
                    Replies Posted
                </button>
            </nav>
            <!-- threads -->
            <div v-if="tab === 'threads'" class="mt-6 space-y-3">
                <ThreadPreviewCard
                    v-for="thread in user.threads"
                    :thread="thread"
                    :user="user"
                    :is-solved="thread.solution?.id ? true : false"
                />
            </div>
            <!-- replies -->
            <div v-if="tab === 'replies'" class="mt-6 space-y-3">
                <ReplyPreviewCard
                    v-for="post in user.posts"
                    :post="post"
                    :user="user"
                />
            </div>
        </div>
        <!-- profile card -->
        <template #sidebar>
            <ProfileCard :user="user" />
        </template>
    </AppLayout>
</template>

<style scoped></style>
