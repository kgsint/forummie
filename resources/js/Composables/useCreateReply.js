import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const isVisible = ref(false)
const thread = ref(null)
const post = ref(null)
const form = useForm({
    body: '',
    parent_id: null,
})

export default () => {
    const showReplyForm = (data, isThread = true) => {
        // check if thread or post are already assigned
        // if so reset before assign to the respective data to thread or post
        if(thread.value) {
            thread.value = null
        }
        if(post.value) {
            post.value = null
        }

        // check is it replying to the original thread or post(s)
        // and assign
        if(isThread) {
            thread.value = data // current thread replying to
        }else {
            post.value = data
        }

        isVisible.value = true
    }
    const hideReplyForm = () => {
        // reset state of thread and post
        thread.value = null
        post.value = null

        isVisible.value = false
    }

    return {
        isVisible,
        form,
        thread,
        post,
        showReplyForm,
        hideReplyForm,
    }
}
