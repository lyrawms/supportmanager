<template>
    <div :class="groupClasses" data-slot="control">
        <slot />
    </div>
</template>

<script>
export default {
    computed:{
        groupClasses(){
            return [
                "space-y-3",
                "has-data-[slot=description]:space-y-6",
                "has-data-[slot=description]:**:data-[slot=label]:font-medium",
            ]
        }
    }
};
</script>

<style scoped>

</style>