<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({
    links: Array,
})
</script>

<template>
    <nav aria-label="Page navigation example">
      <ul class="flex items-center -space-x-px h-10 text-base">
        <!-- <li>
          <a href="#" class="flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
            <span class="sr-only">Previous</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
          </a>
        </li> -->
        <li v-for="link in links" :key="link.label" class="cursor-pointer">
          <Link
            v-if="link.url"
            :href="link.url"
            class="flex items-center justify-center px-4 h-10 leading-tight
                text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700"
            :class="{ 'text-white hover:text-white bg-blue-500  border-blue-300 hover:bg-blue-400': link.active }"
            v-html="link.label"></Link>

            <span
                v-else
                v-html="link.label"
                class="flex items-center justify-center px-4 h-10 leading-tight
                text-gray-500 bg-white border border-gray-300 cursor-text"
            >
            </span>
        </li>
        <!-- <li>
          <a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
            <span class="sr-only">Next</span>
            <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
          </a>
        </li> -->
      </ul>
    </nav>
</template>
