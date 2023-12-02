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

    // highlight mention user
    const highlightMentionedUser = (body) => {
        return body.replace(/@(\w+)/g, '<span class="mentioned-user">@$1</span>')
    }

    return {
        mentionableList,
        handleMentionSearch,
        highlightMentionedUser,
    }
}
