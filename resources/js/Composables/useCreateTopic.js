import { useForm } from "@inertiajs/vue3"
import { ref } from 'vue'
import useSweetalert from "./useSweetalert"

const form = useForm({
    name: '',
    slug: '',
})

const showCreateTopicModal = ref(false)

const { displayToastMessage } = useSweetalert()

export default () => {
    const createNewTopic = () => {
        form.post('/admin/topics', {
            onSuccess: () => {
                // display toast message
                displayToastMessage(`${form.name} has been added`)
                // reset
                form.reset()
                // close modal
                showCreateTopicModal.value = false
            }
        })
    }

    return {
        form,
        createNewTopic,
        showCreateTopicModal,
    }
}
