import useSweetalert from "./useSweetalert"
import { router } from "@inertiajs/vue3"
import axios from "axios"

const { displayConfirmMessage, displayToastMessage } = useSweetalert()

export default (post) => {
    // toggle best answer
    const handleBestAnswer = (solutionId) => {
        router.patch(route('threads.best-answer', {
            thread: post.thread,
            post
        }
            ), {
            post_id: solutionId === post.id ? null : post.id, // if is already marked, unmark, if not mark as best answer
        }, {
            preserveScroll: true
        })
    }
    // spam report
    const handleSpamReport = async () => {
        const result = await displayConfirmMessage('Are you sure you want to report this reply as spam?', 'Report')

        // making request to server
        if(result.isConfirmed) {
            try {
                let res = await axios.post(route('posts.spams.store', { post: post.id }))

                if(res.status === 200) {
                    displayToastMessage(res.data.message)
                }
            }catch(e) {
                displayToastMessage(e.response.data.message, 'error')
            }
        }
    }
    // delete
    const handleDeletePost = async () => {
        const result = await displayConfirmMessage('Do you want to delete this reply?')
        /* if confirmed */
        if (result.isConfirmed) {
            router.delete(route('posts.destroy', {
                thread: post.thread,
                post
            }), {
                onSuccess: () => displayToastMessage('Reply has been deleted')
            })
        }
    }

    return {
        handleBestAnswer,
        handleSpamReport,
        handleDeletePost
    }
}
