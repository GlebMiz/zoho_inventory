<script setup lang="ts">
import type { FieldArrayContext } from 'vee-validate';
import { computed } from 'vue';

const props = defineProps<{
    total: number;
    qtty: number;
    adjustments?: FieldArrayContext<{ name: string; value: string }>;
}>();

const sum = computed(() => {
    return (
        Number(props.adjustments?.fields.value[0].value.value ?? 0) +
        props.total
    ).toFixed(2);
});
</script>

<template>
    <div class="total">
        <div class="total-head">
            <div class="total-head-text">
                <span>Sub Total</span>
                <span>Total Quantity : {{ qtty }}</span>
            </div>
            <div>{{ total.toFixed(2) }}</div>
        </div>
        <div v-if="adjustments" class="total-adjustment">
            <input
                type="text"
                v-model="adjustments.fields.value[0].value.name"
                class="form-control"
            />
            <input
                type="text"
                v-model="adjustments.fields.value[0].value.value"
                class="form-control"
            />
            <span class="ms-auto">{{
                Number(adjustments.fields.value[0].value.value) ?? 0
            }}</span>
        </div>
        <div class="total-sum">
            <span>Total</span>
            <span>{{ sum }}</span>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.total {
    margin-left: auto;
    width: 50%;
    display: flex;
    flex-direction: column;
    gap: 2rem;
    background-color: var(--bs-gray-100);
    padding: 1rem;
}

.total-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    font-weight: 500;
}

.total-head-text {
    display: flex;
    flex-direction: column;

    > span:last-child {
        font-size: 0.85rem;
    }
}

.total-adjustment {
    display: flex;
    gap: 1rem;
    align-items: center;

    > input {
        width: 180px;
    }
}

.total-sum {
    display: flex;
    justify-content: space-between;
    font-size: 1.25rem;
    font-weight: 500;
}
</style>
