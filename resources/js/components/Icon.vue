<script setup lang="ts">
import { computed } from 'vue';
import Bag from '@/assets/icons/Bag.vue';
import Cart from '@/assets/icons/Cart.vue';
import Drag from '@/assets/icons/Drag.vue';
import Plus from '@/assets/icons/Plus.vue';
import X from '@/assets/icons/X.vue';

const iconComponents = {
    cart: Cart,
    drag: Drag,
    plus: Plus,
    x: X,
    bag: Bag,
};

const props = defineProps<{
    icon: keyof typeof iconComponents;
}>();

const component = computed(() => iconComponents[props.icon]);
</script>
<template>
    <component :is="component" class="icon" />
</template>
<style lang="scss" scoped>
.icon {
    height: 25px;
    width: auto;
}
</style>
