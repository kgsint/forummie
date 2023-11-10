import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

// visible state
const isVisible = ref(false)
// form
const form = useForm({
    title: '',
    body: '',
    topic_id: '',
})

export default () => {
    // show create thread form
    const showCreateThreadForm = () => {
        isVisible.value = true
    }

    // hide create thread form
    const hideCreateThreadForm = () => {
        isVisible.value = false
    }

    return {
        form,
        isVisible,
        showCreateThreadForm,
        hideCreateThreadForm,
    }
}
