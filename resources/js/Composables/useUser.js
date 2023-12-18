import useSweetalert from '@/Composables/useSweetalert';
import { router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const userRef = ref(null)
const showBanUserModal = ref(false)
const banUserForm = useForm({
    banned_reason: ''
})

export default () => {
    const { displayConfirmMessage, displayToastMessage } = useSweetalert()

    const displayBanUserModal = (user) => {
        userRef.value = user
        showBanUserModal.value = true
    }

    const hideBanUserModal = () => {
        userRef.value = null
        showBanUserModal.value = false
    }

    const handleBan = () => {
        banUserForm.patch(route('admin.users.ban', userRef.value.id), {
            onSuccess: () => {
                displayToastMessage(`@${userRef.value.id} has been banned`)
            }
        })
    }

    const handleDelete = (user) => {
        // confirm with sweet alert
        displayConfirmMessage(
            `Do you want to delete @${user.username}`
            )
            .then((result) => {
                /* if confirmed */
                if (result.isConfirmed) {
                    let username = user.username
                    router.delete(route('admin.users.destroy', user.username), {
                    onSuccess: () => {
                        displayToastMessage(`@${username} has been deleted`)
                    }
                    })
                }
            });
    }

    return {
        banUserForm,
        userRef,
        displayBanUserModal,
        hideBanUserModal,
        showBanUserModal,
        handleBan,
        handleDelete,
    }
}
