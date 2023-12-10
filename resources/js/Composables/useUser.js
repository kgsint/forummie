import useSweetalert from '@/Composables/useSweetalert';
import { router } from '@inertiajs/vue3'

export default () => {
    const { displayConfirmMessage, displayToastMessage } = useSweetalert()

    const handleDelete = (user) => {
        // confirm with sweet alert
        displayConfirmMessage(
            `Do you want to delete ${user.username}`
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
        handleDelete
    }
}
