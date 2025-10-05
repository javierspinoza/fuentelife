<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import {
    Alert,
    AlertDescription,
    AlertTitle,
} from '@/components/ui/alert';
import { CheckCircle2, X, XCircle } from 'lucide-vue-next';

const page = usePage();

const flash = computed(() => page.props.flash as { success?: string; error?: string });
const showSuccess = ref(false);
const showError = ref(false);

watch(
    () => flash.value,
    (newFlash) => {
        if (newFlash.success) {
            showSuccess.value = true;
            setTimeout(() => {
                showSuccess.value = false;
            }, 5000);
        }

        if (newFlash.error) {
            showError.value = true;
            setTimeout(() => {
                showError.value = false;
            }, 5000);
        }
    },
    { deep: true, immediate: true }
);
</script>

<template>
    <div class="fixed top-4 right-4 z-50 space-y-2 max-w-md">
        <!-- Success Alert -->
        <Transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 translate-x-full"
            enter-to-class="opacity-100 translate-x-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 translate-x-0"
            leave-to-class="opacity-0 translate-x-full"
        >
            <Alert
                v-if="showSuccess && flash.success"
                class="bg-green-50 border-green-200 dark:bg-green-950 dark:border-green-800 shadow-lg"
            >
                <div class="flex items-start gap-3">
                    <CheckCircle2 class="h-5 w-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" />
                    <div class="flex-1">
                        <AlertTitle class="text-green-900 dark:text-green-100 font-semibold">
                            ¡Éxito!
                        </AlertTitle>
                        <AlertDescription class="text-green-800 dark:text-green-200">
                            {{ flash.success }}
                        </AlertDescription>
                    </div>
                    <button
                        @click="showSuccess = false"
                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-100 flex-shrink-0"
                    >
                        <X class="h-4 w-4" />
                    </button>
                </div>
            </Alert>
        </Transition>

        <!-- Error Alert -->
        <Transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-from-class="opacity-0 translate-x-full"
            enter-to-class="opacity-100 translate-x-0"
            leave-active-class="transition-all duration-200 ease-in"
            leave-from-class="opacity-100 translate-x-0"
            leave-to-class="opacity-0 translate-x-full"
        >
            <Alert
                v-if="showError && flash.error"
                class="bg-red-50 border-red-200 dark:bg-red-950 dark:border-red-800 shadow-lg"
            >
                <div class="flex items-start gap-3">
                    <XCircle class="h-5 w-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" />
                    <div class="flex-1">
                        <AlertTitle class="text-red-900 dark:text-red-100 font-semibold">
                            Error
                        </AlertTitle>
                        <AlertDescription class="text-red-800 dark:text-red-200">
                            {{ flash.error }}
                        </AlertDescription>
                    </div>
                    <button
                        @click="showError = false"
                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-100 flex-shrink-0"
                    >
                        <X class="h-4 w-4" />
                    </button>
                </div>
            </Alert>
        </Transition>
    </div>
</template>
