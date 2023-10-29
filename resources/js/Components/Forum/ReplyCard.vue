<script setup>
import { Link } from '@inertiajs/vue3';
</script>


<template>
    <article class="flex bg-white space-x-2 px-2 py-4 rounded-lg shadow mt-3">
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

            <!-- description -->
            <p class="text-sm text-gray-600 leading-7">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat aliquid expedita quaerat omnis iste minus consequuntur ullam molestias possimus, quod eum consectetur commodi dolore voluptatibus accusamus.
            </p>
        </div>
    </article>
</template>
