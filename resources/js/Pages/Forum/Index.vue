<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Select from '@/Components/Select.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ForumPreview from '@/Components/Forum/PreviewCard.vue'
import SearchIcon from '@/Components/Icons/SearchIcon.vue'
import SideNavigation from '@/Components/Forum/SideNavigation.vue'
import Pagination from '@/Components/Forum/Pagination.vue'
import { Head, router, usePage } from '@inertiajs/vue3'
import _omitBy from 'lodash.omitby'
import _isempty from 'lodash.isempty'
import useCreateThread from '@/Composables/useCreateThread'
import _debounce from 'lodash.debounce'
import { ref, watch, onMounted } from 'vue';

const page = usePage()
const { showCreateThreadForm } = useCreateThread()

const props = defineProps({
    threads: Object,
})

// infinite scrolling
const data = ref(props.threads.data)
const loading = ref(false)
const breakPointEl = ref(null)
const pageUrl = page.url
const loadMoreData = () => {
    // return when there is no next url to paginate
    if(! props.threads.links.next) {
        return
    }

    // loading
    loading.value = true
    router.get(props.threads.links.next, {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            window.history.replaceState({}, '', pageUrl)
            data.value = [...data.value, ...props.threads.data]
            // reset loading
            loading.value = false
        }
    })
}

// to observe intersect
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        // if view point els are intersecting
        if(entry.isIntersecting) {
            loadMoreData()
        }
    })
})
// load more data when intersect
onMounted(() => {
    observer.observe(breakPointEl.value)
})


// filter threads via topic
const filterTopic = (e) => {
    router.visit('/', {
        data: _omitBy({
            'filter[topic]': e.target.value
        }, _isempty), // e.target.value is '' or null, data object won't be included in request params
        preserveScroll: true,
    })
}

// search
const search = ref(page.props.queryStrings?.s ?? '')
const searchInput = ref(null)

// search
const handleSearch = _debounce((search) => {
    router.reload({
        data: {
            s: search
        }
    })
}, 500)

// watch search model for changes
watch(search, (search) => {
    handleSearch(search)
})

onMounted(() => {
    // track current search value
    // search.value = page.props.queryStrings?.s ?? ''

    // focus when searching
    if(search.value) {
        searchInput.value.focus()
    }
})

// filter solved and unresolved threads via dropdown
const filterNav = (e) => {
    router.visit('/', {
        data: _omitBy({
            [e.target.value]: e.target.value ? '1' : null
        }, _isempty)
    })
}
</script>


<template>
    <AppLayout>
        <Head title="Home" />
        <main class="">
            <!-- top nav filter -->
            <nav class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-x-6">
                <div class="flex space-x-2 items-center">
                    <button @click="showCreateThreadForm" class="block md:hidden rounded-xl text-xs px-3 py-1 bg-blue-600 text-white font-semibold">
                        Create Thread
                    </button>
                    <select
                        @change="filterNav"
                        class="w-32 bg-gray-50 border border-gray-300 text-gray-900 text-sm
                        focus:ring-blue-500 focus:border-blue-500 block p-2.5 rounded-full cursor-pointer"
                    >
                        <option value="">Latest</option>
                        <option
                            value="filter[resolved]"
                            :selected="$page.props.queryStrings?.filter?.resolved"
                        >
                            Resolved
                        </option>
                        <option
                            value="filter[unresolved]"
                            :selected="$page.props.queryStrings?.filter?.unresolved"
                        >
                            Unresolved
                        </option>
                    </select>

                    <select
                        @change="filterTopic"
                        class="w-32 bg-gray-50 border border-gray-300 text-gray-900 text-sm
                        focus:ring-blue-500 focus:border-blue-500 block p-2.5 rounded-full cursor-pointer"
                    >
                        <option value="">All</option>
                        <option
                            v-for="topic in $page.props.topics"
                            :key="topic.slug"
                            :value="topic.slug"
                            :selected="topic.slug === $page.props.queryStrings?.filter?.topic"
                        >
                            {{ topic.name }}
                        </option>
                    </select>
                    <!-- {{ $page.props.queryStrings }} -->

                </div>
                <form action="#" method="get" class="bg-gray-200 px-2 rounded-full">
                    <label for="s" class="flex items-center">
                        <SearchIcon />
                        <TextInput
                            v-model="search"
                            class="bg-transparent border-none outline-none focus:ring-0"
                            placeholder="Search for threads..."
                            ref="searchInput"
                        />
                    </label>
                </form>
            </nav>
            <!-- <pre>
                {{ $page.props.threads }}
            </pre> -->
            <!-- forum wrapper -->
            <div class="space-y-6 mt-8">
                <!-- loop threads (forum preview card) -->
                <ForumPreview
                    v-if="threads.data.length"
                    v-for="thread in data"
                    :key="thread.id"
                    :thread="thread"
                    :isSolved="thread.solution?.id ? true : false"
                />
            </div>
            <!-- pagination -->
            <!-- <div class="mt-3" v-if="threads.data.length">
                <Pagination
                    :links="threads.meta.links"
                />
            </div> -->
            <div ref="breakPointEl"></div>
            <div v-if="loading" class="text-xl">Loading...</div>
        </main>
        <!-- sidebar -->
        <template #sidebar>
            <SideNavigation>
                <!-- create thread btn -->
                <PrimaryButton
                    @click="showCreateThreadForm"
                    v-if="$page.props.auth.user" class="mb-6">
                    Create thread
                </PrimaryButton>
            </SideNavigation>
        </template>
    </AppLayout>
</template>
