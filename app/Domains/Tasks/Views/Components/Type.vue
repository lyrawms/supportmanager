<template>
    <p
       :style="{ color: getMostReadableColor(type.color) ,backgroundColor: type.color }"
       class="flex w-min rounded-2xl px-2 py-1">
        {{ type.title }}</p>
</template>
<script>
import tinycolor from "tinycolor2";

export default {
    name: "Type",
    props: {
        type: {
            type: Object,
            required: true
        },
    }, methods: {
        getMostReadableColor(color) {
            return tinycolor.mostReadable(color, [], {includeFallbackColors: true});
        },
    }
}
</script>


<style scoped>

</style>
