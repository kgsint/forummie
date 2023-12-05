import { router } from '@inertiajs/vue3'
import _omitBy from 'lodash.omitby'
import _isempty from 'lodash.isempty'
import _debounce from 'lodash.debounce'


export default () => {
    // filter via topic
    const filterTopic = (e) => {
        router.visit('/', {
            data: _omitBy({
                'filter[topic]': e.target.value
            }, _isempty), // e.target.value is '' or null, data object won't be included in request params
            preserveScroll: true,
        })
    }

    // filter solved and unresolved threads via dropdown
    const filterNav = (e) => {
        router.visit('/', {
            data: _omitBy({
                [e.target.value]: e.target.value ? '1' : null
            }, _isempty)
        })
    }

    return {
        filterTopic,
        filterNav,
    }
}
