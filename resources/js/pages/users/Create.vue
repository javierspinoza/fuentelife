<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, Loader2, Save } from 'lucide-vue-next';
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
import { Switch } from '@/components/ui/switch';
import InputError from '@/components/InputError.vue';
import * as userRoutes from '@/routes/users';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    is_active: true,
});

const submit = () => {
    form.post(userRoutes.store().url, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <AppLayout title="Crear Usuario">
        <div class="container mx-auto py-8 px-4">
            <div class="mb-6">
                <Link :href="userRoutes.index().url">
                    <Button variant="ghost" size="sm">
                        <ArrowLeft class="mr-2 h-4 w-4" />
                        Volver a Usuarios
                    </Button>
                </Link>
            </div>

            <Card class="max-w-2xl">
                <CardHeader>
                    <CardTitle class="text-2xl">Crear Nuevo Usuario</CardTitle>
                    <CardDescription
                        >Completa el formulario para crear un nuevo
                        usuario</CardDescription
                    >
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Nombre -->
                        <div class="space-y-2">
                            <Label for="name">Nombre Completo</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                type="text"
                                placeholder="Ej: Juan Pérez"
                                required
                                autocomplete="name"
                            />
                            <InputError :message="form.errors.name" />
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <Label for="email">Correo Electrónico</Label>
                            <Input
                                id="email"
                                v-model="form.email"
                                type="email"
                                placeholder="ejemplo@correo.com"
                                required
                                autocomplete="email"
                            />
                            <InputError :message="form.errors.email" />
                        </div>

                        <!-- Contraseña -->
                        <div class="space-y-2">
                            <Label for="password">Contraseña</Label>
                            <Input
                                id="password"
                                v-model="form.password"
                                type="password"
                                placeholder="Mínimo 8 caracteres"
                                required
                                autocomplete="new-password"
                            />
                            <InputError :message="form.errors.password" />
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="space-y-2">
                            <Label for="password_confirmation"
                                >Confirmar Contraseña</Label
                            >
                            <Input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                placeholder="Repite la contraseña"
                                required
                                autocomplete="new-password"
                            />
                            <InputError
                                :message="form.errors.password_confirmation"
                            />
                        </div>

                        <!-- Estado Activo -->
                        <div class="flex items-center justify-between rounded-lg border p-4">
                            <div class="space-y-0.5">
                                <Label for="is_active">Usuario Activo</Label>
                                <div class="text-sm text-muted-foreground">
                                    El usuario podrá iniciar sesión en el
                                    sistema
                                </div>
                            </div>
                            <Switch
                                id="is_active"
                                v-model:checked="form.is_active"
                            />
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
                                {{ form.processing ? 'Guardando...' : 'Crear Usuario' }}
                            </Button>
                            <Link :href="userRoutes.index().url">
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
