<script setup lang="ts">
defineProps<{
    errors: string[] | null;
}>();
</script>
<template>
    <div v-if="errors" class="errors-container mb-4 rounded">
        <ul class="mb-0">
            <li v-for="error in errors">
                {{ error }}
            </li>
        </ul>
    </div>
</template>
<style lang="scss" scoped>
.errors-container {
    background-color: rgba($color: var(--bs-danger-rgb), $alpha: 0.2);
    padding: 1rem;
}
</style>
