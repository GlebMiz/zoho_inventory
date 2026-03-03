<script setup lang="ts">
import type { FieldArrayContext } from 'vee-validate';
import draggable from 'vuedraggable';
import SubformItem from './SubformItem.vue';

const props = defineProps<{
    items: FieldArrayContext<unknown>;
    rateField?: string;
}>();

const { remove, push, move, fields } = props.items;

function onDragEnd(evt: any) {
    const { oldIndex, newIndex } = evt;
    if (oldIndex == null || newIndex == null) return;
    if (oldIndex === newIndex) return;

    move(oldIndex, newIndex);
}

function removeRow(index: number) {
    if (fields.value.length > 1) remove(index);
}

defineEmits(['addItem']);
</script>

<template>
    <div>
        <table class="w-100">
            <thead>
                <tr class="subform-row">
                    <th class="col-drag"></th>
                    <th class="col-details">Item Details</th>
                    <th class="col-qtty">Quantity</th>
                    <th class="col-rate">Rate</th>
                    <th class="col-amount">Amount</th>
                    <th class="col-action"></th>
                </tr>
            </thead>
            <draggable
                tag="tbody"
                :model-value="fields"
                @end="onDragEnd"
                handle=".drag-btn"
            >
                <template #item="{ element, index }">
                    <SubformItem
                        :key="element.key"
                        :item="element.value"
                        :rate-field="rateField"
                        @remove-row="removeRow(index)"
                    />
                </template>
            </draggable>
        </table>
        <button
            class="btn btn-primary mt-4"
            type="button"
            @click="$emit('addItem')"
        >
            + Add row
        </button>
    </div>
</template>

<style lang="scss" scoped>
.table {
    width: 100%;
}

th {
    font-weight: 500;
    font-size: 0.9rem;
    text-transform: uppercase;
    padding: 0.5rem 1.75rem;
}

.col-details {
    padding-left: 0;
}

.col-qtty,
.col-rate {
    width: 16.66%;
    text-align: right;
}

.col-amount {
    text-align: right;
}

.col-drag,
.col-action {
    width: 0;
    padding: 0;
}

.col-details {
    width: 50%;
}

.col-amount {
    padding: 0.5rem 1rem;
}
</style>
