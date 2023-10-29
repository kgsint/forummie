<script setup>
import { Link } from '@inertiajs/vue3';
</script>


<template>
    <article class="flex bg-white space-x-2 px-2 py-4 rounded-lg shadow">
        <!-- profile image -->
        <div class="flex-none flex lg:items-center gap-2 lg:block mb-3">
            <a href="#">
                <img src="https://source.unsplash.com/200x200/?face&crop=face&v=1" class="w-[28px] h-[28px] lg:w-14 lg:h-14 rounded-xl" alt="profile image">
            </a>
        </div>
        <div class="flex flex-col">
            <div class="flex justify-between items-center">
                <Link href="#">
                    <!-- username -->
                    <h4 class="text-md font-semibold">Username</h4>
                </Link>
            </div>

            <!-- created date -->
            <div class="text-xs text-gray-600 leading-normal font-semibold mb-3">
                posted 10 minutes ago
            </div>

            <!-- title -->
            <h3 class="bg-blue-50 mb-3 text-2xl p-3 rounded-xl font-semibold">Thread Title</h3>

            <!-- description -->
            <p class="text-sm text-gray-600 leading-7">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat aliquid expedita quaerat omnis iste minus consequuntur ullam molestias possimus, quod eum consectetur commodi dolore voluptatibus accusamus, ipsa nisi eius provident non quo hic magnam recusandae! Saepe, facere commodi. Recusandae rem magnam, ab nihil provident aspernatur quaerat, distinctio enim nulla voluptate velit id fuga vel quis suscipit porro facere consequatur? Ea accusantium est dolorum, ipsam, temporibus error provident similique iure labore asperiores repudiandae alias laboriosam quaerat ex exercitationem? Animi sequi voluptates at, cupiditate nemo odit iure consequuntur libero quo ipsum modi quas quisquam praesentium molestias itaque tempora voluptatem error dolorem rem.
            </p>
        </div>
    </article>
</template>
