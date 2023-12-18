<script setup>
import useUser from '@/Composables/useUser';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import InputError from '@/Components/InputError.vue';

const { handleBan, banUserForm } = useUser()
</script>

<template>
    <form @submit.prevent="handleBan">
        <div class="flex flex-col items-center gap-3 mb-3">
            <div class="mt-1 lg:w-64 xl:w-96">
                <label for="banned-reason" class="sr-only">Banned reason</label>
                <input
                    v-model="banUserForm.banned_reason"
                    type="text"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                        focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                    id="banned-reason"
                    placeholder="Reason for banning the user"
                />
                <InputError :message="banUserForm.errors.banned_reason" />
            </div>
        </div>
        <PrimaryButton class="float-right mb-4">Ban</PrimaryButton>
    </form>
</template>


<style scoped></style>
