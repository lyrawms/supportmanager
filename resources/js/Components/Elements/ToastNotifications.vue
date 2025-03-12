<template>
    <div>
        <button
            v-if="toasts"
            class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 hover:bg-gray-800 hover:text-white dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
            :class="{ 'animate-pulse': !reToasted }"
            @click="toastAgain()"

        >
            <FontAwesomeIcon :icon="reToasted ? faBellSlash : faBell" class="h-5 w-5"/>
        </button>
        <div v-else
             class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100">
            <FontAwesomeIcon :icon="faBell" class="h-5 w-5"/>

        </div>

    </div>
</template>

<script setup>
import {ref, watch, computed} from 'vue'
import {usePage} from '@inertiajs/vue3'
import {toast} from 'vue3-toastify'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import {faBell, faBellSlash} from '@fortawesome/free-solid-svg-icons'

const toasts = computed(() => usePage().props.flash.toasts)
const reToasted = ref(false)

function fireToast(notification, sticky = false) {
    toast(notification.message, {
        position: toast.POSITION.TOP_RIGHT,
        toastId: notification.id,
        type: notification.type,
        newestOnTop: true,
        theme: toast.THEME.COLORED,
        autoClose: !sticky && (notification.type === 'success' ? 5000 : false),
        closeOnClick: !sticky,
        onClose: () => (reToasted.value = false),
    })
}

function fireToasts(sticky = false) {
    toasts.value?.forEach((notification) => fireToast(notification, sticky))
}

function toastAgain() {
    reToasted.value ? toast.remove() : fireToasts(true)
    reToasted.value = !reToasted.value
}

watch(
    toasts,
    (newToasts) => {
        if (newToasts?.length) {
            reToasted.value = false
            fireToasts()
        }
    },
    {deep: true, immediate: true}
)
watch(
    () => usePage().props.flash.toasts, // Pass a getter function to watch
    (newToasts, oldToasts) => {
        console.log("hoi", newToasts); // Correct console.log usage
    },
    { deep: true } // Add deep watch if needed.
);
</script>
