<script setup>
import { Link } from '@inertiajs/vue3'
import MessageIcon from '@/Components/Icons/MessageIcon.vue'
</script>


<template>
    <article class="flex flex-col lg:flex-row bg-white lg:space-x-2 px-2 py-4 rounded-lg shadow">
        <!-- profile image -->
        <div class="flex-none flex items-center gap-2 lg:block mb-3">
            <a href="#">
                <img src="https://source.unsplash.com/200x200/?face&crop=face&v=1" class="w-14 h-14 rounded-xl" alt="profile image">
            </a>
            <strong class="lg:hidden">
                Username
            </strong>
        </div>
        <!-- title and description -->
        <div class="flex flex-col">
            <!-- title -->
            <div class="flex justify-between items-center mb-3">
                <Link href="#" class="hover:underline">
                    <h4 class="text-2xl font-semibold">My Thread Title</h4>
                </Link>
                <div class="flex items-center space-x-4">
                    <span class="flex items-center text-xs gap-1"><MessageIcon /> 10</span>
                    <Link href="#" class="text-sm px-4 py-2 rounded-full border hover:bg-gray-900 hover:text-white transition-colors duration-150 border-gray-200">Tag One</Link>
                </div>
            </div>

            <!-- paragraph -->
            <p class="text-sm text-gray-600 leading-normal line-clamp-2 mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae adipisci, ab quam deleniti sed, ullam temporibus, odio obcaecati accusamus exercitationem ipsum ea qui. Fuga consectetur, quae, cum voluptatum vitae nam deleniti iusto ut cumque, dolorem illo amet unde neque obcaecati?</p>
            <!-- replied status -->
            <div class="text-xs text-gray-600 leading-normal line-clamp-2">
                replied 10 minutes ago
            </div>
        </div>
    </article>
</template>


<style scoped></style>
