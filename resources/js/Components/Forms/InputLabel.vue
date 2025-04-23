<script setup>
defineProps({
    value: String,
});
</script>

<template>
    <p class="text-base/6 text-stone-950 select-none data-disabled:opacity-50 sm:text-sm/6 " data-slot="label">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </p>
</template>
