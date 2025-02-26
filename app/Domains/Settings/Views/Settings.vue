<template>
    <AppLayout title="Settings">
        <template #header>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="font-semibold text-xl text-stone-800 leading-tight">
                        Settings
                    </h2>
                </div>
            </div>
        </template>
        <template #default>
            <div class="flex ">

                <div class="w-[50%]">
                    
                </div>
                <div class="w-[50%]">
                    meneer
                </div>
            </div>
        </template>
    </AppLayout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

export default {
    name: "Settings",
    components: {PrimaryButton, AppLayout}
}
</script>

<style scoped>

</style>
