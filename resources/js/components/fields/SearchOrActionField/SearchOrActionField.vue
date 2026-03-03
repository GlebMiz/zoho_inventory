<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';
import { handleClickOutside } from '@/lib/utils';
import Label from '../Label.vue';
import type { FieldProps } from '../types';
import SearchOrActionDropdown from './partials/SearchOrActionDropdown.vue';

const props = defineProps<
    FieldProps & {
        value: string | undefined;
        values?: any[];
        isFieldSelect?: boolean;
        classes?: { label?: string; input?: string };
    }
>();

const isActiveDropdown = ref(false);

watch(
    () => props.value,
    () => {
        isActiveDropdown.value = false;
    },
);

const dropdownRef = ref<HTMLElement | null>(null);

const clickListener = (e: MouseEvent) =>
    handleClickOutside(e, dropdownRef, closeDropdown);

const closeDropdown = () => (isActiveDropdown.value = false);

onMounted(() => {
    document.addEventListener('click', clickListener);
});

onUnmounted(() => {
    document.removeEventListener('click', clickListener);
});

function handleFocusIn() {
    isActiveDropdown.value = true;
}

defineExpose({ closeDropdown });

const searchQuery = ref('');

const model = defineModel();

watch(
    () => props.value,
    () => {
        isActiveDropdown.value = false;
    },
);

watch(model, (val) => {
    if (typeof val === 'string') searchQuery.value = val;
});
</script>
<template>
    <div class="field-container">
        <div class="row align-items-center">
            <Label
                v-if="label"
                :text="label"
                :required="required"
                :class="classes?.label"
            />
            <div :class="classes?.input">
                <div ref="dropdownRef" class="dropdown-container">
                    <input
                        v-if="isFieldSelect"
                        @focusin="handleFocusIn()"
                        v-model="model"
                        type="text"
                        class="form-control"
                        :placeholder="placeholder"
                    />
                    <input
                        v-else
                        readonly
                        @click="isActiveDropdown = !isActiveDropdown"
                        :value="value"
                        type="text"
                        class="form-control"
                        :placeholder="placeholder"
                    />

                    <SearchOrActionDropdown
                        v-model="searchQuery"
                        :isFieldSelect="isFieldSelect"
                        ref="dropdownRef"
                        :values="values"
                        v-show="isActiveDropdown"
                    >
                        <template #item="{ item }">
                            <slot name="item" :item="item" />
                        </template>
                        <template #action>
                            <slot name="action" />
                        </template>
                    </SearchOrActionDropdown>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
.dropdown-container {
    position: relative;
}
</style>
