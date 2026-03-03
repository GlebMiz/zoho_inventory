<script setup lang="ts">
import Label from './Label.vue';
import type { FieldProps } from './types';

const props = defineProps<
    FieldProps & { values: { value: string; label: string }[] }
>();
const model = defineModel<Date>();
</script>
<template>
    <div class="row align-items-center">
        <Label v-if="label" :text="label" :required="required" class="col-2" />
        <div class="col-6">
            <select v-model="model" class="form-select">
                <option v-for="item in values" :value="item.value">
                    {{ item.label }}
                </option>
            </select>
        </div>
    </div>
</template>
