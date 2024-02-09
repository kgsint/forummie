import useSweetalert from "./useSweetalert"
import { router } from '@inertiajs/vue3'
import axios from 'axios'

const { displayConfirmMessage, displayToastMessage } = useSweetalert()

export default (thread) => {
    // report spam
    const handleReportSpam = async () => {
        const result = await displayConfirmMessage(`Do you want report this thread "${thread.title}" as spam?`, 'Report')

        // making request to server
        if(result.isConfirmed) {
            try {
                const res = await axios.post(route('threads.spams.store', { thread: thread.id }))

                if(res.status === 200) {
                    displayToastMessage(res.data.message)
                }
            }catch(e) {
                displayToastMessage(e.response.data.message, 'error')
            }
        }
    }
    // delete
    const handleDelete = async () => {
        // confirm with sweet alert
        const result = await displayConfirmMessage(`Do you want delete this thread "${thread.title}"?`)
          /* if confirmed */
          if (result.isConfirmed) {
            router.delete(route('forum.destroy', thread), {
                onSuccess: () => {
                    displayToastMessage(`Thread has been deleted!`)
                }
            })
          }
    }

    return {
        handleReportSpam,
        handleDelete
    }
}

