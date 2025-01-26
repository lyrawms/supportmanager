<script setup>
import {Menu, MenuButton, MenuItems} from '@headlessui/vue';
import {computed, Fragment} from 'vue';

const props = defineProps({
    align: {
        type: String,
        default: 'right',
    },
    width: {
        type: String,
        default: '48',
    },
    contentClasses: {
        type: Array,
        default: () => ['bg-white'],
    },
});

const widthClass = computed(() => {
    return {
        '48': 'w-48',
    }[props.width.toString()];
});

const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'ltr:origin-top-left rtl:origin-top-right start-0';
    }

    if (props.align === 'right') {
        return 'ltr:origin-top-right rtl:origin-top-left end-0';
    }

    return 'origin-top';
});
</script>

<template>
    <Menu as="div" class="relative">
        <MenuButton>
            <slot name="trigger" />
        </MenuButton>

        <Transition
            as="template"
            enter="transition ease-out duration-200"
            enter-from="transform opacity-0 scale-95"
            enter-to="transform opacity-100 scale-100"
            leave="transition ease-in duration-75"
            leave-from="transform opacity-100 scale-100"
            leave-to="transform opacity-0 scale-95"
        >
            <MenuItems
                class="absolute z-50 mt-2 rounded-md shadow-lg"
                :class="[widthClass, alignmentClasses]"
            >
                <div class="rounded-md ring-1 ring-black/5 dropdown-content" :class="contentClasses">
                    <slot name="content" />
                </div>
            </MenuItems>
        </Transition>
    </Menu>
</template>
