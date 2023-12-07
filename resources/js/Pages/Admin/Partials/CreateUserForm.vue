<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>


<template>
    <form>
        <div class="flex flex-col items-center gap-3 mb-3">
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="name" class="sr-only">User's Name</label>
                <input
                    type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="name"
                    placeholder="Full Name of the user"
                />
            </div>
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="email" class="sr-only">User's email</label>
                <input
                    type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="email"
                    placeholder="Email Address of the user"
                />
            </div>
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="username" class="sr-only">User's username</label>
                <input
                    type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="username"
                    placeholder="Username of the user"
                />
            </div>
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="password" class="sr-only">Password</label>
                <input
                    type="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="password"
                    placeholder="Password"
                />
            </div>
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="confirm-password" class="sr-only">Confirm Password</label>
                <input
                    type="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="confirm-password"
                    placeholder="Confirm Password"
                />
            </div>
        </div>
        <PrimaryButton class="float-right mb-4">Create</PrimaryButton>
    </form>
</template>


<style scoped></style>
