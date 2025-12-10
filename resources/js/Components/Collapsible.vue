<script setup>
import { ref, computed, nextTick } from 'vue';

const props = defineProps({
    icon: {
        type: Array,
        default: () => ['fas', 'arrow-right']
    },
    maxHeight: {
        type: [String, Number],
        default: 500
    }
});

const isOpen = ref(false);
const collapsibleRef = ref(null);

function isInViewport(el) {
    if (!el) return false;
    const rect = el.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

const toggle = () => {
    isOpen.value = !isOpen.value;

    if (isOpen.value) {
        setTimeout(() => {
            if (collapsibleRef.value) {
                collapsibleRef.value.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }
        }, 350);
    }
}

const maxHeightStyle = computed(() => {
    const value = props.maxHeight;
    return typeof value === 'number' ? `${value}px` : value;
});
</script>

<template>
    <div ref="collapsibleRef" class="collapsible-wrapper w-full px-16 pt-4">
        <button type="button" class="pb-6 flex items-center gap-2 text-4xl text-lime-500 font-bold w-full text-left"
            @click="toggle" :aria-expanded="isOpen" aria-controls="collapsible-content">

            <slot name="header"></slot>

            <font-awesome-icon :icon="icon"
                :class="['transition-transform duration-300', { 'rotate-90': isOpen, 'rotate-0': !isOpen }]"
                class="-mb-[7px] text-3xl" />
        </button>

        <div id="collapsible-content"
            class="about-collapsible px-10 text-lg overflow-hidden transition-[max-height,padding,opacity] duration-500 ease-in-out"
            :class="{
                'py-0': !isOpen,
                'opacity-0': !isOpen,
                'py-4': isOpen,
                'opacity-100': isOpen
            }" :style="{
                'max-height': isOpen ? maxHeightStyle : '0'
            }">

            <slot></slot>
        </div>
    </div>
</template>