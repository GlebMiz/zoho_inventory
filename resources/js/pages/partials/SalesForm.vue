<script setup lang="ts">
import { useFieldArray, useForm } from 'vee-validate';
import { computed, provide, ref, toRaw } from 'vue';
import ErrorSection from '@/components/ErrorSection.vue';
import CheckboxField from '@/components/fields/CheckboxField.vue';
import CustomerField from '@/components/fields/CustomerField.vue';
import DateField from '@/components/fields/DateField.vue';
import TextField from '@/components/fields/TextField.vue';
import Subform from '@/components/subform/Subform.vue';
import { removeLoader, showLoader } from '@/lib/loader';
import { showPopover } from '@/lib/popover';
import type { Customer } from '@/modules/customer/types';
import { createEmptyListItem } from '@/modules/items/data';
import type { Item, ListItem } from '@/modules/items/types';
import { createSalesOrder } from '@/modules/sales_order/api';
import { dummyPaymentTerms } from '@/modules/sales_order/dummy';
import type { Vendor } from '@/modules/vendor/types';

const props = defineProps<{
    customers: Customer[];
    products: Item[];
    vendors: Vendor[];
}>();

const paymentTerms = dummyPaymentTerms.map((pt) => ({ name: pt, id: pt }));
const products = ref(structuredClone(toRaw(props.products)));
provide('products', products);
const customers = computed(() => props.customers);

const validationSchema = {};

const initialValues = {
    salesOrder: null,
    customer: null as string | null,
    date: null,
    paymentTerm: paymentTerms[0].id,
    items: [createEmptyListItem()],
    adjustments: [
        {
            name: 'Adjustment',
            value: null,
        },
    ],
    createPO: false,
};

const { defineField, handleSubmit, resetForm } = useForm({
    validationSchema,
    initialValues,
});

const [salesOrder] = defineField('salesOrder');
const [customer] = defineField('customer');
const [date] = defineField('date');
const items = useFieldArray('items');
const adjustments = useFieldArray<{ name: string; value: string }>(
    'adjustments',
);

const [createPO] = defineField('createPO');

const errors = ref<any[] | null>(null);

const onSubmit = handleSubmit((values) => {
    showLoader();
    errors.value = null;

    createSalesOrder(values)
        .then(() => {
            products.value = props.products;
            resetForm();
            showPopover('Sales Order has been created');
        })
        .catch((res) => {
            const resErrors = res.response?.data?.errors;
            if (resErrors) {
                errors.value = Object.entries(resErrors).map(
                    (error: any) => error[1][0],
                );
            } else {
                errors.value = [
                    'Something went wrong! Please check your fields and try again!',
                ];
            }
            document.querySelector('main')?.scrollTo({ top: 0 });
        })
        .finally(() => {
            removeLoader();
        });
});

const addItem = () => {
    items.push(createEmptyListItem());
};

const setCustomer = (value: Customer) => {
    customers.value.push(value);
    customer.value = value.id;
};

defineExpose({ setCustomer });

</script>
<template>
    <form @submit="onSubmit">
        <ErrorSection :errors="errors" />
        <section>
            <CustomerField v-model="customer" :customers="customers" label="Customer"
                placeholder="Select or Add Customer" />
        </section>
        <section class="d-flex flex-column mt-5 gap-3">
            <TextField v-model="salesOrder" required label="Sales Order" />
            <DateField v-model="date" required label="Sales Order Date" />
        </section>
        <section class="mt-5">
            <Subform :items="items" :adjustments="adjustments" @add-item="addItem" />
        </section>
        <hr />
        <section>
            <CheckboxField v-model="createPO" label="Additionaly create a purchase order" />
        </section>
        <section class="mt-5">
            <button class="btn btn-primary px-4">Save</button>
        </section>
    </form>
</template>
<style lang="scss" scoped>
.purchaseForm {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}
</style>
