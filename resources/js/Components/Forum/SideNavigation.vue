<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
</script>


<template>
     <aside class="hidden md:block md:sticky p-3">
        <PrimaryButton class="mb-6">Create thread</PrimaryButton>
        <!-- sidebar filter options -->
        <ul class="flex flex-col space-y-3">
            <li class="list-none">
                <a href="#" class="inline-block bg-blue-100 text-blue-400 p-3 w-full rounded-xl transition-colors duration-200 text-sm font-semibold">
                    <span class="bg-blue-400 w-[4px] h-[16px] px-2 py-1 rounded-lg mr-2"></span>
                    All Threads
                </a>
            </li>
            <li class="list-none">
                <a href="#" class="inline-block hover:bg-blue-100 hover:text-blue-400 p-3 w-full rounded-xl transition-colors duration-200 text-sm font-semibold">
                    <span class="bg-gray-300 hover w-[4px] h-[16px] px-2 py-1 rounded-lg mr-2"></span>
                    Solved
                </a>
            </li>
            <li class="list-none">
                <a href="#" class="inline-block hover:bg-blue-100 hover:text-blue-400 p-3 w-full rounded-xl transition-colors duration-200 text-sm font-semibold">
                    <span class="bg-gray-300 w-[4px] h-[16px] px-2 py-1 rounded-lg mr-2"></span>
                    Unsolved
                </a>
            </li>
        </ul>
    </aside>
</template>
