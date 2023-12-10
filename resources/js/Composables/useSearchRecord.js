import { ref, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import _debounce from 'lodash.debounce'

export default () => {
    const page = usePage()
    const searchRef = ref(page.props.queryStrings?.s)

    const handleSearch = _debounce((search) => {
        router.reload({
            data: {
                s: searchRef.value,
            }
        })
    }, 500)

    return {
        searchRef,
        handleSearch,
    }
}
