<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, ImageIcon, Loader2, Save, X } from 'lucide-vue-next';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import * as productRoutes from '@/routes/products';

const form = useForm({
    name: '',
    price: '',
    image: null as File | null,
});

const imagePreview = ref<string | null>(null);

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        form.image = file;

        // Crear preview
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const removeImage = () => {
    form.image = null;
    imagePreview.value = null;
    // Reset file input
    const fileInput = document.getElementById('image') as HTMLInputElement;
    if (fileInput) fileInput.value = '';
};

const submit = () => {
    form.post(productRoutes.store().url, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            imagePreview.value = null;
        },
    });
};
</script>

<template>
    <AppLayout title="Crear Producto">
        <div class="container mx-auto py-8 px-4">
            <div class="mb-6">
                <Link :href="productRoutes.index().url">
                    <Button variant="ghost" size="sm">
                        <ArrowLeft class="mr-2 h-4 w-4" />
                        Volver a Productos
                    </Button>
                </Link>
            </div>

            <Card class="max-w-2xl">
                <CardHeader>
                    <CardTitle class="text-2xl">Crear Nuevo Producto</CardTitle>
                    <CardDescription
                        >Completa el formulario para agregar un nuevo producto
                        al catálogo</CardDescription
                    >
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Imagen -->
                        <div class="space-y-2">
                            <Label for="image">Imagen del Producto</Label>
                            <div class="space-y-4">
                                <!-- Preview de imagen -->
                                <div
                                    v-if="imagePreview"
                                    class="relative w-full max-w-sm"
                                >
                                    <div
                                        class="relative aspect-square rounded-lg overflow-hidden border-2 border-border bg-muted"
                                    >
                                        <img
                                            :src="imagePreview"
                                            alt="Preview"
                                            class="w-full h-full object-cover"
                                        />
                                        <Button
                                            type="button"
                                            size="sm"
                                            variant="destructive"
                                            class="absolute top-2 right-2"
                                            @click="removeImage"
                                        >
                                            <X class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </div>

                                <!-- Área de carga -->
                                <div
                                    v-else
                                    class="flex items-center justify-center w-full"
                                >
                                    <label
                                        for="image"
                                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-lg cursor-pointer bg-muted hover:bg-muted/80 transition-colors"
                                    >
                                        <div
                                            class="flex flex-col items-center justify-center pt-5 pb-6"
                                        >
                                            <ImageIcon
                                                class="w-12 h-12 mb-4 text-muted-foreground"
                                            />
                                            <p
                                                class="mb-2 text-sm text-muted-foreground"
                                            >
                                                <span class="font-semibold"
                                                    >Haz clic para subir</span
                                                >
                                                o arrastra y suelta
                                            </p>
                                            <p
                                                class="text-xs text-muted-foreground"
                                            >
                                                PNG, JPG, WEBP (MAX. 2MB)
                                            </p>
                                        </div>
                                        <input
                                            id="image"
                                            type="file"
                                            class="hidden"
                                            accept="image/jpeg,image/jpg,image/png,image/webp"
                                            @change="handleImageChange"
                                        />
                                    </label>
                                </div>
                            </div>
                            <InputError :message="form.errors.image" />
                        </div>

                        <!-- Nombre -->
                        <div class="space-y-2">
                            <Label for="name">Nombre del Producto</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                type="text"
                                placeholder="Ej: Camiseta de algodón"
                                required
                            />
                            <InputError :message="form.errors.name" />
                        </div>

                        <!-- Precio -->
                        <div class="space-y-2">
                            <Label for="price">Precio</Label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"
                                >
                                    $
                                </span>
                                <Input
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    placeholder="0.00"
                                    required
                                    class="pl-8"
                                />
                            </div>
                            <InputError :message="form.errors.price" />
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center gap-4 pt-4">
                            <Button
                                type="submit"
                                :disabled="form.processing"
                                class="min-w-[120px]"
                            >
                                <Loader2
                                    v-if="form.processing"
                                    class="mr-2 h-4 w-4 animate-spin"
                                />
                                <Save v-else class="mr-2 h-4 w-4" />
                                {{
                                    form.processing
                                        ? 'Guardando...'
                                        : 'Crear Producto'
                                }}
                            </Button>
                            <Link :href="productRoutes.index().url">
                                <Button type="button" variant="outline">
                                    Cancelar
                                </Button>
                            </Link>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

