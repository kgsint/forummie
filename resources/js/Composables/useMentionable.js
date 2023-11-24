import { router } from "@inertiajs/vue3"
import { ref } from "vue"
import axios from "axios"

const mentionableList = ref([])

export default () => {
    const handleMentionSearch = async (search) => {
        // making request to laravel using axios
        const res = await axios.post('/mentions/search', {
            username: search
        })

        // populate data from response
        mentionableList.value = res.data.items
    }

    return {
        mentionableList,
        handleMentionSearch
    }
}
