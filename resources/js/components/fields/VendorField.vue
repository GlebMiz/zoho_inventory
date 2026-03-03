<script setup lang="ts">
import { computed, inject, watch, Ref, ref } from 'vue';
import type { Vendor } from '@/modules/vendor/types';
import SearchOrActionField from './SearchOrActionField/SearchOrActionField.vue';
import type { FieldProps } from './types';

const props = defineProps<FieldProps & { vendors: Vendor[] }>();

const vendor = defineModel<string | null>();

const vendorName = computed(() =>
    vendor.value
        ? props.vendors.filter((c) => c.id == vendor.value)[0].name
        : '',
);
</script>
<template>
    <SearchOrActionField
        :classes="{ label: 'col-2', input: 'col-6' }"
        required
        :value="vendorName"
        :values="vendors"
        :label="label"
        :placeholder="placeholder"
    >
        <template #item="{ item }">
            <div
                class="d-flex gap-2 rounded"
                :class="{ selected: vendor == item.id }"
                @click="vendor = item.id"
            >
                <div class="image">
                    <span :key="item.id">{{ item.name[0] }}</span>
                </div>
                <div class="d-flex flex-column info">
                    <span class="name">{{ item.name }}</span>
                </div>
            </div>
        </template>
    </SearchOrActionField>
</template>
<style lang="scss" scoped>
.image {
    border-radius: 50%;
    background-color: rgb(219, 219, 219);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    height: 40px;
    width: 40px;
}

.name {
    font-size: 0.9rem;
}
</style>
