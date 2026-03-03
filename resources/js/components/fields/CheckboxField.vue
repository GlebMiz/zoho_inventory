<script setup lang="ts">
import Label from './Label.vue';
import type { FieldProps } from './types';

const props = defineProps<FieldProps>();
const model = defineModel<boolean | null>();
</script>
<template>
    <div class="form-check">
        <input
            v-model="model"
            class="form-check-input"
            type="checkbox"
            value=""
            id="purchaseOrderCheckbox"
        />
        <Label
            v-if="label"
            :text="label"
            :required="required"
            class="form-check-label"
            for="purchaseOrderCheckbox"
        />
    </div>
</template>
