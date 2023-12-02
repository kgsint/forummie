import { useForm } from "@inertiajs/vue3"
import { ref } from 'vue'

const form = useForm({
    name: '',
    slug: '',
})

const showCreateTopicModal = ref(false)

export default () => {
    const createNewTopic = () => {
        form.post('/admin/topics', {
            onSuccess: () => {
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
