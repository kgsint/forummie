<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({
    links: Array,
})
</script>

<template>
    <nav aria-label="Page navigation example">
      <ul class="flex items-center -space-x-px h-10 text-base">
        <li v-for="link in links" :key="link.label" class="cursor-pointer">
          <Link
            v-if="link.url"
            :href="link.url"
            class="flex items-center justify-center px-4 h-10 leading-tight
                text-gray-800 bg-white border border-gray-300 hover:bg-gray-100"
            :class="{ ' font-bold border-black': link.active }"
            v-html="link.label"></Link>

            <span
                v-else
                v-html="link.label"
                class="flex items-center justify-center px-4 h-10 leading-tight
                text-gray-500 bg-white border border-gray-300 cursor-text"
            >
            </span>
        </li>
      </ul>
    </nav>
</template>
