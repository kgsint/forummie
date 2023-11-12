import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const isVisible = ref(false)
const thread = ref(null)
const form = useForm({
    body: '',
    parent_id: null,
})

export default () => {
    const showReplyForm = (threadData) => {
        thread.value = threadData // current thread replying to
        isVisible.value = true
    }
    const hideReplyForm = () => {
        isVisible.value = false
    }

    return {
        isVisible,
        form,
        thread,
        showReplyForm,
        hideReplyForm,
    }
}
