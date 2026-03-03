<script setup lang="ts">
import type { FieldArrayContext } from 'vee-validate';
import { computed, Ref } from 'vue';
import SubformTable from './SubformTable.vue';
import SubformTotal from './SubformTotal.vue';

const props = defineProps<{
    items: FieldArrayContext<unknown>;
    adjustments?: FieldArrayContext<{ name: string; value: string }>
}>();

defineEmits(['addItem']);

const totals = computed(() => {
    const result = props.items.fields.value.reduce(
        (acc, field) => {
            const item = field.value as {
                quantity: number;
                rate: number;
            };

            const q = Number(item.quantity ?? 0);
            const r = Number(item.rate ?? 0);

            acc.qtty += q;
            acc.subtotal += q * r;

            return acc;
        },
        {
            qtty: 0,
            subtotal: 0,
        },
    );

    return {
        qtty: result.qtty,
        total: Number(result.subtotal.toFixed(2)),
    };
});
</script>

<template>
    <div>
        <div class="table-header">Item Table</div>
        <SubformTable
            :items="items"
            @add-item="$emit('addItem')"
        />
        <SubformTotal
            :adjustments="adjustments"
            :qtty="totals.qtty"
            :total="totals.total"
        />
    </div>
</template>

<style scoped>
.table-header {
    font-weight: bold;
    background-color: var(--bs-gray-100);
    padding: 1rem;
}
</style>
