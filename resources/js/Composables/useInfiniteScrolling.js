import { usePage, router } from "@inertiajs/vue3"
import { ref } from 'vue'

const page = usePage()

export default (propName) => {
    const propData = () => page.props[propName] // getter for props passed down from laravel
    const data = ref(propData().data) // data ref
    const pageUrl = page.url // initial page url
    const loading = ref(false)

    const loadMoreData = () => {
        // return when there is no next url to paginate
        if(! propData().links.next) {
            return
        }

        // loading
        loading.value = true
        // making request to load
        router.get(propData().links.next, {}, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                // reset history back to base url when scrolling
                window.history.replaceState({}, '', pageUrl)
                // push data to data ref
                data.value = [...data.value, ...propData().data]
                // reset loading
                loading.value = false
            }
        })
    }
    return {
        data,
        loading,
        loadMoreData,
    }
}
