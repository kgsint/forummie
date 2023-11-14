import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    title: '',
    body: '',
    topic_id: '',
})
const isVisible = ref(false)

export default () => {
    const showUpdateForm = () => {
        isVisible.value = true
    }

    const hideUpdateForm = () => {
        isVisible.value = false
    }

    return {
        form,
        isVisible,
        showUpdateForm,
        hideUpdateForm
    }
}
