<script setup>
defineProps({
    modelValue: {
        type: String,
    },
})
defineEmits(['update:modelValue'])
</script>

<template>
    <select
        @change="$emit('update:modelValue', $event.target.value)"
        :value="modelValue"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
        focus:ring-blue-500 focus:border-blue-500 block p-2.5 w-32 rounded-full cursor-pointer"
    >
      <slot />
    </select>
</template>
