import { ref } from 'vue'

// visible state
const isVisible = ref(false)

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
        isVisible,
        showCreateThreadForm,
        hideCreateThreadForm,
    }
}
