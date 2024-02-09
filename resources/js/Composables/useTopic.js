import { useForm, router } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'
import useSweetalert from '@/Composables/useSweetalert'

const showEditTopicRef = ref(false)
const topicRef = ref(null)
const form = useForm({
    name: '',
    slug: '',
})


const { displayConfirmMessage, displayToastMessage } = useSweetalert()

export default () => {

    onMounted(() => {
        if(topicRef.value) {
            form.name = topicRef.value.name
            form.slug = topicRef.value.slug
        }
        // reset validation errors if any if the component is mounted
        if(form.hasErrors) {
            form.clearErrors()
        }
    })

    const showEditTopicModal = (topicData) => {
        showEditTopicRef.value = true
        topicRef.value = topicData
    }

    const hideEditTopicModal = () => {
        showEditTopicRef.value = false
    }

    const handleUpdate = () => {
        form.patch(
            route('admin.topics.update', {
                topic: topicRef.value }
                ),
                {
                    onSuccess: () => {
                        // display toast message
                        displayToastMessage('Topic has been updated')
                        // reset form
                        form.reset()
                        // close modal
                        showEditTopicRef.value = false
                    }
                }
            )
    }

    const handleDelete = async (topic) => {
        const result = await displayConfirmMessage(`Do you want to delete "${topic.name}"`)

        /* if confirmed */
        if (result.isConfirmed) {
            let topicName = topic.name
            router.delete(route('admin.topics.destroy', topic.id), {
            onSuccess: () => {
                displayToastMessage(`${topicName} has been deleted`)
            }
            })
        }
    }

    return {
        form,
        topicRef,
        showEditTopicRef,
        showEditTopicModal,
        hideEditTopicModal,
        handleUpdate,
        handleDelete,
    }
}
