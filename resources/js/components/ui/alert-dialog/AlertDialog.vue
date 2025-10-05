<script setup lang="ts">
import { AlertDialogRoot } from 'reka-ui';

interface Props {
    open?: boolean;
    defaultOpen?: boolean;
}

defineProps<Props>();

interface Emits {
    (e: 'update:open', value: boolean): void;
}

const emit = defineEmits<Emits>();
</script>

<template>
    <AlertDialogRoot v-bind="$props" @update:open="emit('update:open', $event)">
        <slot />
    </AlertDialogRoot>
</template>
