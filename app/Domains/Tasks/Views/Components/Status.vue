<template>
    <p
        class="w-max rounded-4xl text-white text-md px-3 py-2"
        :class="color">
        {{ status }}</p>
</template>
<script>

export default {
    name: "Status",
    props: {
        status: {
            type: String,
            required: true
        },
    },
    data: () => ({
        color: ''
    }),
    mounted() {
        switch (this.status) {
            case 'Finished':
                return this.color = 'bg-green-500';
            case 'In Progress':
                return this.color = 'bg-yellow-500';
            case 'Open':
                return this.color = 'bg-blue-500';
            case 'Deleted':
                return this.color = 'bg-red-500';
            default:
                return this.color = 'bg-gray-500';
        }
    }
}
</script>


<style scoped>

</style>
