<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { provide, ref, watch } from 'vue';
import Icon from '@/components/Icon.vue';
import { setFixedBody } from '@/lib/utils';
import { dummyCustomers } from '@/modules/customer/dummy';
import type { Customer } from '@/modules/customer/types';
import type { Item } from '@/modules/items/types';
import type { Vendor } from '@/modules/vendor/types';
import CustomerForm from './partials/CustomerForm.vue';
import SalesForm from './partials/SalesForm.vue';

defineProps<{
    customers: Customer[];
    items: Item[];
    vendors: Vendor[];
}>();

const activeCustomerForm = ref<boolean>(false);

provide('activeCustomerForm', activeCustomerForm);

watch(activeCustomerForm, (val) => {
    setFixedBody(val);
});

const salesFormRef = ref();

const onCustomerCreated = (newCustomer: Customer) => {
    console.log(newCustomer);

    salesFormRef.value.setCustomer(newCustomer);
};
</script>

<template>
    <Head title="Welcome"> </Head>
    <main class="p-5">
        <div class="c-container">
            <h4 class="d-flex align-items-center mb-5 gap-3">
                <Icon icon="cart" /> New Sales Order
            </h4>
            <SalesForm
                ref="salesFormRef"
                :customers="customers"
                :products="items"
                :vendors="vendors"
            />
        </div>
        <CustomerForm
            v-if="activeCustomerForm"
            @close-modal="activeCustomerForm = false"
            @on-customer-created="onCustomerCreated"
        />
    </main>
</template>
<style lang="scss" scoped>
main {
    height: 100vh;
    overflow-y: auto;
}

.c-container {
    margin: 0 auto;
    width: 1100px;
    max-width: 100%;
}
</style>
