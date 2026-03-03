<script setup lang="ts">
import DatePicker from 'primevue/datepicker';
import Label from './Label.vue';
import type { FieldProps } from './types';

const props = defineProps<FieldProps>();

const model = defineModel<Date | null>();
</script>
<template>
    <div class="row align-items-center">
        <Label v-if="label" :text="label" :required="required" class="col-2" />
        <div class="col-6">
            <DatePicker
                v-model="model"
                date-format="dd.mm.yy"
                fluid
                :pt="{ panel: { class: 'datepicker-panel' } }"
                class="date-picker"
            />
        </div>
    </div>
</template>
<style lang="scss">
.datepicker-panel {
    min-width: unset !important;
}
</style>
