<script setup lang="ts">
import { AlertDialogPortal, type AlertDialogPortalProps } from 'reka-ui';
</script>

<template>
    <AlertDialogPortal v-bind="$props">
        <slot />
    </AlertDialogPortal>
</template>

