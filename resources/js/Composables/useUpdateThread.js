import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const threadData = ref(null)
const isVisible = ref(false)

const form = useForm({
    title: '',
    body: '',
    topic_id: '',
})

export default () => {
    const showUpdateForm = () => {
        isVisible.value = true
    }

    const hideUpdateForm = () => {
        isVisible.value = false

    }

    return {
        form,
        threadData,
        isVisible,
        showUpdateForm,
        hideUpdateForm
    }
}
