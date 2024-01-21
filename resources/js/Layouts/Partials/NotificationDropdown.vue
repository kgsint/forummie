<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import { router } from '@inertiajs/vue3'

// mark notification as read
const markAsRead = (noti) => {
    router.patch(route('notifications.update', { id: noti.id, redirectUrl: noti.data.url }))
}
</script>


<template>
    <Dropdown width="80" v-if="$page.props.auth.user">
        <template #trigger>
            <button class="d-flex items-center space-x-1 bg-blue-500 px-2 py-3 md:p-3 text-white text-xs md:text-sm rounded-xl">
                <span>Notifications</span>
                 <!-- notification count  -->
                <span
                    v-if="$page.props.auth.notifications.length"
                    class="bg-red-500 text-xs px-2 py-1 rounded-xl"
                >
                    {{ $page.props.auth.notifications.length }}
                </span>
            </button>
        </template>
        <template #content>
            <div v-if="$page.props.auth.notifications.length" class="max-h-[300px] overflow-y-auto cursor-pointer">
                <li
                    v-for="noti in $page.props.auth.notifications"
                    :key="noti.id"
                    class="list-none cursor-pointer"
                    @click="markAsRead(noti)"
                >
                    <div class="flex p-2 rounded hover:bg-gray-100 cursor-pointer">
                      <div class="ms-2 text-sm cursor-pointer">
                          <label v-if="noti.data.type === 'thread_reply'" class="font-medium text-gray-900 cursor-pointer">
                            <div>{{ noti.data.thread_title }}</div>
                            <p class="text-xs font-normal text-gray-900">
                                {{ noti.data.message }}
                            </p>
                          </label>
                      </div>
                    </div>
                </li>
            </div>
            <div v-else class="text-sm text-gray-500 py-3 px-2 text-center">
                There is no notification for you at the moment.
            </div>
        </template>
    </Dropdown>
</template>


<style scoped></style>
