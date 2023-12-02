import { useForm } from "@inertiajs/vue3"
import { ref } from 'vue'

const form = useForm({
    name: '',
    slug: '',
})

const showCreateTopicModal = ref(false)

export default () => {
    const createNewTopic = () => {
        console.log(form.name, form.slug)
        form.post('/admin/topics', {
            onSuccess: () => {
                form.reset()
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
