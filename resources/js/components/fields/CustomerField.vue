<script setup lang="ts">
import type { Ref } from 'vue';
import { computed, inject, watch, ref } from 'vue';
import Plus from '@/assets/icons/Plus.vue';
import type { Customer } from '@/modules/customer/types';
import SearchOrActionField from './SearchOrActionField/SearchOrActionField.vue';
import type { FieldProps } from './types';

const props = defineProps<FieldProps & { customers: Customer[] }>();

const activeCustomerForm = inject<Ref<boolean>>('activeCustomerForm');

const customer = defineModel<string | null>();

const customerName = computed(() =>
    customer.value
        ? props.customers.filter((c) => c.id == customer.value)[0].name
        : '',
);

const searchOrActionField = ref<InstanceType<
    typeof SearchOrActionField
> | null>(null);

const openCustomerForm = () => {
    if (activeCustomerForm) {
        activeCustomerForm.value = true;
        searchOrActionField.value?.closeDropdown();
    }
};
</script>
<template>
    <SearchOrActionField
        :classes="{ label: 'col-2', input: 'col-6' }"
        ref="searchOrActionField"
        required
        :value="customerName"
        :values="customers"
        :label="label"
        :placeholder="placeholder"
    >
        <template #item="{ item }">
            <div
                class="d-flex gap-2 rounded"
                :class="{ selected: customer == item.id }"
                @click="customer = item.id"
            >
                <div class="image">
                    <span :key="item.id">{{ item.name[0] }}</span>
                </div>
                <div class="d-flex flex-column info">
                    <span class="name">{{ item.name }}</span>
                    <span class="email">{{ item.email }}</span>
                </div>
            </div>
        </template>
        <template #action>
            <button
                @click="openCustomerForm"
                type="button"
                class="btn-reset d-flex text-primary gap-3 p-2"
            >
                <Plus /> New Customer
            </button>
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

.email {
    font-size: 0.75rem;
}
</style>
