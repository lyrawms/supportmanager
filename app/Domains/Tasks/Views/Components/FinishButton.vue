<template>
    <primary-button :href="route('tasks.updateStatus', {uuid:uuid, status:'finished'} )" color="green">
        Finish
    </primary-button>
</template>
<script>
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

export default {
    name: "FinishButton",
    components: {PrimaryButton},
    props: {
        uuid: {
            type: String,
            required: true
        }
    },
}
</script>

<style scoped>

</style>
