<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'

// props
const props = defineProps({
    form: Object
})

const markdownPreviewEnabled = ref(false)
const markdownHtml = ref('')
const loading = ref(false)

// watch changes in markdownPreviewEnabled ref
watch(markdownPreviewEnabled, (isEnabled) => {
    // if not enabled, do not make a request
    if(! isEnabled) {
        return
    }

    loading.value = true
    // if enabled, request to markdown.preview route with body
    axios.post(route('markdown.preview'), {
        body: props.form.body,
    }).then(
        res => {
            loading.value = false // reset loading
            markdownHtml.value = res.data.markdown_html // assign response data to markdownHtml ref
        }
    )
})

</script>


<template>
    <div class="fixed bottom-0 w-full shadow-sm">
        <div class="max-w-full lg:max-w-5xl mx-auto h-full bg-gray-100 border-2 border-blue-200 shadow-sm p-6 rounded-md space-y-6">
            <!-- header -->
            <div>
                <slot name="header" />
            </div>
            <!-- form -->
            <div>
                <slot name="main" :markdownPreviewEnabled="markdownPreviewEnabled" />
                <!-- markdown preview  -->
                <div
                    v-html="markdownHtml"
                    v-if="markdownPreviewEnabled && !loading"
                    class="h-64 w-full bg-gray-200 rounded-md markdown p-3 overflow-auto"
                >
                </div>
                <!-- loading -->
                <div
                    v-if="loading"
                    class="h-64 w-full bg-gray-200 grid items-center text-center rounded-md markdown p-3 overflow-auto"
                >
                    Loading...
                </div>

                <div class="flex justify-between">
                    <div>
                        toolbar
                    </div>
                    <!-- toggle markdown markdown preview -->
                    <button
                        @click="markdownPreviewEnabled = !markdownPreviewEnabled"
                        class="text-xs text-blue-500"
                    >
                        {{ markdownPreviewEnabled ? 'Turn off' : 'Turn on' }} markdown preview
                    </button>
                </div>
            </div>
            <!-- btns or smth -->
            <div class="pb-5">
                <slot name="footer" />
            </div>
        </div>
    </div>
</template>

