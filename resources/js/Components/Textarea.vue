<script setup>
    import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: String,
        // required: true,
    },
});

defineEmits(['update:modelValue']);

const textarea = ref(null);

onMounted(() => {
    if (textarea.value.hasAttribute('autofocus')) {
        textarea.value.focus();
    }
});

defineExpose({ focus: () => textarea.value.focus() });
</script>


<template>
    <textarea
    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    @input="$emit('update:modelValue', $event.target.value)"
    ref="textarea"
    cols="30" rows="10">{{ modelValue }}</textarea>
</template>

