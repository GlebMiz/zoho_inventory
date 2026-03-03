<script setup lang="ts">
import { ref } from 'vue';
import SearchOrActionList from './SearchOrActionList.vue';

const props = defineProps<{
    values?: any[];
    isFieldSelect?: boolean;
    searchQuery: string;
}>();

const searchQuery = defineModel<string>();
</script>
<template>
    <div class="dropdown rounded shadow">
        <div v-if="!isFieldSelect">
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Search"
                class="form-control"
            />
        </div>
        <SearchOrActionList :values="values" :query="searchQuery">
            <template #item="{ item }">
                <slot name="item" :item="item" />
            </template>
        </SearchOrActionList>
        <slot name="action" />
    </div>
</template>
<style lang="scss" scoped>
.dropdown {
    z-index: 2;
    position: absolute;
    width: 100%;
    top: calc(100% + 0.5rem);
    padding: 0.25rem;
    background-color: var(--bs-white);
}
</style>
