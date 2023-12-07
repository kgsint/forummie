import { useForm } from "@inertiajs/vue3"
import { ref } from "vue"
import useSweetalert from '@/Composables/useSweetalert'

const form = useForm({
    name: '',
    email: '',
    username: '',
    type: '',
    password: '',
    password_confirmation: '',
})
const showCreateUserModal = ref(false)

const { displayToastMessage } = useSweetalert()

export default () => {
    const createNewUser = () => {
        form.post(route('admin.users.store'), {
            onSuccess: () => {
                // toast message
                displayToastMessage(`New user(${form.username}) has been created`)
                // reset form
                form.reset()
                // close modal
                showCreateUserModal.value = false

            }
        })
    }

    return {
        form,
        showCreateUserModal,
        createNewUser,
    }
}
