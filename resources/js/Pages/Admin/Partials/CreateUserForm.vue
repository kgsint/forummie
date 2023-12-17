<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import useCreateUser from '@/Composables/useCreateUser';
import InputError from '@/Components/InputError.vue';
import useCheckAccountType from '@/Composables/useCheckAccountType';

const { form, createNewUser } = useCreateUser()
const { isAdmin } = useCheckAccountType()
</script>


<template>
    <form @submit.prevent="createNewUser">
        <div class="flex flex-col items-center gap-3 mb-3">
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="name" class="sr-only">User's Name</label>
                <input
                    v-model="form.name"
                    type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="name"
                    placeholder="Full Name of the user"
                />
                <InputError :message="form.errors.name" />
            </div>
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="email" class="sr-only">User's email</label>
                <input
                    v-model="form.email"
                    type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="email"
                    placeholder="Email Address of the user"
                />
                <InputError :message="form.errors.email" />
            </div>
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="username" class="sr-only">User's username</label>
                <input
                    v-model="form.username"
                    type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="username"
                    placeholder="Username of the user"
                />
                <InputError :message="form.errors.username" />
            </div>
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="type" class="sr-only">Account Type</label>
                <select
                    v-model="form.type"
                    class="w-64 bg-gray-50 border border-gray-300 text-gray-900 text-sm
                    focus:ring-blue-500 focus:border-blue-500 block p-2.5 rounded-full cursor-pointer"
                >
                    <option value="">Choose Account Type</option>
                    <option value="1">Default</option>
                    <option value="2">Moderator</option>
                    <option v-if="isAdmin()" value="3">Admin</option>
                </select>
                <InputError :message="form.errors.type" />
            </div>
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="password" class="sr-only">Password</label>
                <input
                    v-model="form.password"
                    type="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="password"
                    placeholder="Password"
                />
                <InputError :message="form.errors.password" />
            </div>
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="confirm-password" class="sr-only">Confirm Password</label>
                <input
                    v-model="form.password_confirmation"
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
