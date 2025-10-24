<template>
    <div class="custom-div absolute"
        :style="mask_url ? `mask-image: url('${mask_url}'); -webkit-mask-image: url('${mask_url}'); mask-size: contain; mask-repeat: no-repeat; mask-position: bottom left;` : ''"
        :class="{ 'aspect-square rounded-full': ball, 'absolute': ball }">
    </div>
</template>

<script setup>
const props = defineProps({
    mask_url: {
        type: String,
        default: ''
    },
    ball: {
        type: Boolean,
        default: false
    }
});
</script>