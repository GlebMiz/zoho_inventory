<script lang="ts" setup>
defineProps<{
    text: string;
    required?: boolean;
}>();
</script>
<template>
    <label :class="{ required: required }">{{ text }}</label>
</template>
<style lang="scss" setup>
.required {
    color: var(--bs-danger);

    &::after {
        content: '*';
    }
}
</style>
