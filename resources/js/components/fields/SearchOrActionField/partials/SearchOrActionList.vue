<script lang="ts" setup>
import { computed, inject, ref } from 'vue';

const props = defineProps<{
    query?: string;
    values?: any[];
}>();

const filteredValues = computed(() => {
    const q = props.query?.trim().toLowerCase();

    const result = !q
        ? props.values
        : props.values?.filter((c) => c.name.toLowerCase().includes(q));

    return result ? result.slice(0, 3) : [];
});
</script>
<template>
    <div class="d-flex flex-column search-action-list py-2">
        <template v-for="item in filteredValues">
            <slot name="item" :item="item" />
        </template>

        <div
            v-if="filteredValues.length == 0"
            class="text-secondary text-center"
        >
            NO RESULTS FOUND
        </div>
    </div>
</template>
<style lang="scss">
.search-action-list > * {
    cursor: pointer;
    padding: 0.5rem;

    &:hover {
        background-color: var(--bs-gray-200);
    }

    &.selected {
        background-color: var(--bs-primary);

        .info {
            color: var(--bs-white);
        }
    }
}
</style>
