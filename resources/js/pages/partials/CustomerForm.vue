<script setup lang="ts">
import { useForm } from 'vee-validate';
import { ref } from 'vue';
import ErrorSection from '@/components/ErrorSection.vue';
import TextField from '@/components/fields/TextField.vue';
import Icon from '@/components/Icon.vue';
import { removeLoader, showLoader } from '@/lib/loader';
import { createCustomer } from '@/modules/customer/api';

const validationSchema = {};

const initialValues = {
    name: null,
    email: null,
    phone: null,
};

const { defineField, handleSubmit } = useForm({
    validationSchema,
    initialValues,
});

const [name] = defineField('name');
const [email] = defineField('email');
const [phone] = defineField('phone');

const emits = defineEmits(['close-modal', 'on-customer-created']);

const errors = ref<any[] | null>(null);

const onSubmit = handleSubmit((values) => {
    showLoader();
    errors.value = null;

    createCustomer(values)
        .then(({ data }) => {
            const { id, name, email } = data.data;
            const newCustomer = {
                id,
                name,
                email,
            };

            emits('on-customer-created', newCustomer);
            emits('close-modal');
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
</script>
<template>
    <div class="wrapper">
        <form class="form d-flex flex-column gap-3 p-4" @submit="onSubmit">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="form-title">New Customer</h5>
                <button
                    @click="$emit('close-modal')"
                    type="button"
                    class="btn-reset close-btn"
                >
                    <Icon icon="x" />
                </button>
            </div>
            <ErrorSection :errors="errors" />
            <TextField v-model="name" required label="Display Name" />
            <TextField v-model="email" label="Email" />
            <TextField v-model="phone" label="Phone" />
            <div class="mt-auto">
                <button type="submit" class="btn btn-primary mt-4 px-4">
                    Save
                </button>
            </div>
        </form>
    </div>
</template>
<style lang="scss" scoped>
.wrapper {
    z-index: 99;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba($color: #000000, $alpha: 0.2);
}

.form {
    background-color: var(--bs-white);
    width: 800px;
    height: 600px;
}

.close-btn {
    font-size: 1.75rem;
    color: var(--bs-danger);
}
</style>
