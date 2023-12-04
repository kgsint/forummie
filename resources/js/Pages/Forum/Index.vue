<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Select from '@/Components/Select.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ForumPreview from '@/Components/Forum/PreviewCard.vue'
import SearchIcon from '@/Components/Icons/SearchIcon.vue'
import SideNavigation from '@/Components/Forum/SideNavigation.vue'
import { Head, router, usePage } from '@inertiajs/vue3'
import _omitBy from 'lodash.omitby'
import _isempty from 'lodash.isempty'
import useCreateThread from '@/Composables/useCreateThread'
import _debounce from 'lodash.debounce'
import { ref, watch, onMounted } from 'vue';
import useInfiniteScrolling from '@/Composables/useInfiniteScrolling'
import useIntersect from '@/Composables/useIntersect'
import cannotSearchImg from '@/assets/images/cannot-search.png'

const page = usePage()
const { showCreateThreadForm } = useCreateThread()


const props = defineProps({
    threads: Object,
})

// infinite scrolling composable
const { data, loading, loadMoreData } = useInfiniteScrolling('threads')
// break element to check for intersection with browser viewport
const breakPointEl = ref(null)

// to observe intersect
useIntersect(breakPointEl, loadMoreData)


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
        },
        onSuccess: () => {
            data.value = props.threads.data
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
                <form class="bg-gray-200 px-2 rounded-full">
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
                <!-- when there is no thread (excluding search or filter) -->
                <div
                    v-else-if="! threads.data.length && $page.props.queryStrings == {}"
                    class="flex flex-col items-center"
                >
                    <h4 class="text-lg font-semibold">Sorry. There is no thread or question at the momemnt.</h4>
                </div>
                <!-- cannnot found illustration and text for search or filter -->
                <div
                    v-if="! threads.data.length && $page.props.queryStrings"
                    class="flex flex-col items-center"
                >
                    <h4 class="text-lg font-semibold">Sorry. Cannot find what you are looking for at the moment.</h4>
                    <img :src="cannotSearchImg" alt="cannot search or filter illustration" class="max-w-[400px]">
                </div>
            </div>
            <div ref="breakPointEl"></div>
            <div v-if="loading" class="text-xl text-center my-12">Loading...</div>
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
