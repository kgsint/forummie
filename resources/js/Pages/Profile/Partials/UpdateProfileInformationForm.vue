<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue'
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue'

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const form = useForm({
    _method: 'PUT',
    name: user.name,
    email: user.email,
    username: user.username,
    photo: null,
});

// template ref
const photoInput = ref(null)
// template ref
const removePreviewBtn = ref(null)
// preview photo
const photoPreview = ref(null)

const updatePhotoPreview = () => {
    // get file
    const photo = photoInput.value.files[0]

    if(! photo) return
    // read file
    const reader = new FileReader
    reader.onload = (e) => {
        photoPreview.value = e.target.result
    }
    reader.readAsDataURL(photo)
}

const removePhotoPreview = () => {
    photoPreview.value = null
    form.photo = null
}

// handle form request
const handleUpdateProfileInformation = () => {
    if(photoInput.value) {
        form.photo = photoInput.value.files[0]
    }

    form.post(route('profile.update'), {
        preserveState: true,
        onSuccess: () => {
            removePreviewBtn.value.style.display = 'none'
        }
    })
}

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="handleUpdateProfileInformation" class="mt-6 space-y-6">
            <!-- profile image -->
            <div>
                <!-- current profile image -->
                <div v-if="! photoPreview">
                    <img
                        :src="user.avatar"
                        :alt="user.username"
                        class="rounded-full h-20 w-20 object-cover"
                    >
                </div>
                <!-- preview image -->
                <div v-else class="relative">
                    <span
                        class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        :style="`background-image: url('${photoPreview}')`"
                    >
                    </span>
                    <button
                        ref="removePreviewBtn"
                        class="absolute left-[4rem] top-1 text-sm bg-red-500 text-white w-6 h-6 text-center flex items-center justify-center rounded-full"
                        @click.prevent="removePhotoPreview">
                        &times;
                    </button>
                </div>
                <!-- input file -->
                <input
                    ref="photoInput"
                    type="file"
                    id="profile-photo"
                    class="hidden"
                    @input="updatePhotoPreview"
                >
                <!-- label for input file -->
                <InputLabel for="profile-photo" value="Profile Photo" class="sr-only" />

                <SecondaryButton @click.prevent="photoInput.click()" class="mt-2">Upload a new Photo</SecondaryButton>
            </div>
            <!-- name -->
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- username -->
            <div>
                <InputLabel for="username" value="Username" />

                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.username"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <!-- email -->
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-blue-400">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
