<script setup></script>


<template>
    <div class="fixed bottom-0 w-full shadow-sm">
        <div class="max-w-full lg:max-w-5xl mx-auto h-full bg-gray-100 border-2 border-blue-200 shadow-sm p-6 rounded-md space-y-6">
            <!-- header -->
            <div>
                <slot name="header" />
            </div>
            <!-- form -->
            <div>
                <slot name="main" />
            </div>
            <!-- btns or smth -->
            <div class="pb-5">
                <slot name="footer" />
            </div>
        </div>
    </div>
</template>

