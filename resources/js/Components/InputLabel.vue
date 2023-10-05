<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="block font-bold text-sm text-gray-700 tracking-wide">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
