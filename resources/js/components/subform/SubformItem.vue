<script setup lang="ts">
//@ts-nocheck
import { computed, inject, ref } from 'vue';
import { createEmptyListItem } from '@/modules/items/data';
import type { Item, ListItem } from '@/modules/items/types';
import SearchOrActionField from '../fields/SearchOrActionField/SearchOrActionField.vue';
import Icon from '../Icon.vue';

const props = defineProps<{
    item: ListItem;
    rateField?: string;
}>();

const amount = computed(() =>
    (Number(props.item.quantity) * Number(props.item.rate)).toFixed(2),
);

const products: undefined | any[] = inject('products');

const onProductSelect = (product: Item) => {
    props.item.details = product;
    props.item.rate = product[props.rateField ?? 'rate'];
};

const productRemove = () => {
    const newItem = createEmptyListItem();
    props.item.details = newItem.details;
    props.item.quantity = newItem.quantity;
    props.item.rate = newItem.rate;
};

defineEmits(['removeRow']);
</script>

<template>
    <tr class="subform-row">
        <td class="col-drag">
            <div class="drag-btn">
                <Icon class="drag-icon" icon="drag" />
            </div>
        </td>
        <td class="col-details">
            <div
                v-if="item.details && typeof item.details === 'object'"
                class="d-flex flex-column gap-2"
            >
                <div class="details-product">
                    <span>
                        {{ item.details.name }}
                    </span>
                    <span> SKU: {{ item.details.sku }} </span>
                    <button
                        class="details-product-remove btn-reset"
                        type="button"
                        @click="productRemove"
                    >
                        <Icon icon="x" />
                    </button>
                </div>
                <div>
                    <textarea
                        v-model="item.details.description"
                        class="form-control w-100"
                        rows="2"
                        style="resize: none"
                        placeholder="Add a description to your item"
                    ></textarea>
                </div>
            </div>
            <SearchOrActionField
                v-else
                :isFieldSelect="true"
                v-model="item.details"
                :values="props.rateField ? products?.filter(prod => prod[props.rateField]) : products"
                placeholder="Type or Click to select the Product"
            >
                <template #item="{ item: product }">
                    <div
                        class="d-flex gap-2 rounded"
                        @click="onProductSelect(product)"
                    >
                        <span class="info">{{ product.name }}</span>
                    </div>
                </template>
            </SearchOrActionField>
            <!-- <input v-model="item.details" type="text" class="form-control"
                placeholder="Type or click to select an item"> -->
        </td>
        <td>
            <input v-model="item.quantity" type="number" class="form-control" />
        </td>
        <td>
            <input v-model="item.rate" type="number" class="form-control" />
        </td>
        <td>{{ amount }}</td>
        <td class="col-action">
            <div class="col-action-wrapper">
                <button
                    @click="$emit('removeRow')"
                    type="button"
                    class="btn-reset delete-btn"
                >
                    <Icon class="action-icon" icon="x" />
                </button>
            </div>
        </td>
    </tr>
</template>

<style lang="scss" scoped>
.subform-row {
    & > td:not(.col-drag, .col-action) {
        padding: 0.5rem 1rem;
    }

    & > td:nth-child(n + 3) {
        input {
            text-align: right;
        }

        text-align: right;
    }

    & > .col-details {
        padding-left: 0 !important;
    }
}

.col-drag,
.col-action {
    width: 0;
    padding: 0;
    position: relative;
}

.drag-btn {
    position: absolute;
    left: -25px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;

    .drag-icon {
        height: 18px;
        width: auto;
    }
}

.col-action-wrapper {
    position: absolute;
    right: -25px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    gap: 0.5rem;

    .action-icon {
        height: 18px;
        width: auto;
    }
}

.delete-btn {
    & > .action-icon {
        display: flex;
        align-items: center;
        font-size: 2rem;
        color: var(--bs-danger);
    }
}

.details-product {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    position: relative;
    padding-right: 1rem;
    line-height: 100%;

    & > span:nth-child(2) {
        font-size: 0.75rem;
        color: var(--bs-gray-600);
    }
}

.details-product-remove {
    position: absolute;
    top: 0.25rem;
    right: 0rem;
    font-size: 1.25rem;
    color: var(--bs-danger);
}

.col-details textarea {
    font-size: 0.85rem;
}
</style>
