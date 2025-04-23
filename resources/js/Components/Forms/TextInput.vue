<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class="relative block w-full appearance-none rounded-lg px-[calc(--spacing(3.5)-1px)] py-[calc(--spacing(2.5)-1px)] sm:px-[calc(--spacing(3)-1px)] sm:py-[calc(--spacing(1.5)-1px)] text-base/6 text-stone-950 placeholder:text-stone-500 sm:text-sm/6 dark:text-white border border-stone-950/10 data-hover:border-stone-950/20 data-invalid:border-red-500 data-invalid:data-hover:border-red-500 data-disabled:border-stone-950/20"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
