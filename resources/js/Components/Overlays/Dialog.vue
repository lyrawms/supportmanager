<template>
    <HeadlessModal
        ref="modalRef"
        v-slot="{
            afterLeave,
            close,
            config,
            emit,
            getChildModal,
            getParentModal,
            id,
            index,
            modalContext,
            onTopOfStack,
            isOpen,
            reload,
            setOpen,
        }"
    >
        <BaseDialog :open="isOpen" @close="close" :width="width">
            <slot v-bind="{close}"></slot>

            <template #cta>
                <slot name="cta"></slot>
            </template>

            <template #secondary>
                <slot name="secondary"></slot>
            </template>
        </BaseDialog>
    </HeadlessModal>
</template>

<script>
import {HeadlessModal} from '@inertiaui/modal-vue'
import BaseDialog from './BaseDialog.vue'

export default {
    components: {
        HeadlessModal,
        BaseDialog,
    },
    props: {
        width: {},
    },
    data() {
        return {
            modal: null,
        }
    },
    methods: {
        openModal() {
            this.modal = this.$refs.modalRef
            this.modal.open()
        },
        closeModal() {
            this.modal.close()
        },
    },
}
</script>