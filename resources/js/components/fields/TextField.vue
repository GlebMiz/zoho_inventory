<script setup lang="ts">
import Label from './Label.vue';
import type { FieldProps } from './types';

const props = defineProps<FieldProps>();
const model = defineModel<string | null>();
</script>
<template>
    <div class="row align-items-center">
        <Label v-if="label" :text="label" :required="required" class="col-2" />
        <div class="col-6">
            <div class="input-group">
                <input
                    v-model="model"
                    type="text"
                    class="form-control"
                    :placeholder="placeholder"
                />
            </div>
        </div>
    </div>
</template>
