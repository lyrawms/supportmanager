<template>
    <p
        :style="{ color: getMostReadableColor(type.color ?? '#FFFFFF') ,backgroundColor: type.color ?? '#FFFFFF', border: !type.color ? '2px solid #000000' : 'none' }"
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
            // get the most readable color for the given color
            return tinycolor.mostReadable(color, [], {includeFallbackColors: true});
        },
    }
}
</script>


<style scoped>

</style>
