<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import {
    Mail,
    MoreVertical,
    Pencil,
    Plus,
    Power,
    PowerOff,
    Trash2,
    User as UserIcon,
} from 'lucide-vue-next';
import { computed, ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Badge } from '@/components/ui/badge';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import * as userRoutes from '@/routes/users';

interface User {
    id: number;
    name: string;
    email: string;
    is_active: boolean;
    created_at: string;
}

interface PaginatedUsers {
    data: User[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
}

interface Props {
    users: PaginatedUsers;
}

defineProps<Props>();

const page = usePage();
const currentUserId = computed(() => page.props.auth?.user?.id);

const userToDelete = ref<User | null>(null);
const showDeleteDialog = ref(false);

const openDeleteDialog = (user: User) => {
    userToDelete.value = user;
    showDeleteDialog.value = true;
};

const deleteUser = () => {
    if (userToDelete.value) {
        router.delete(userRoutes.destroy(userToDelete.value.id).url, {
            preserveScroll: true,
            onSuccess: () => {
                showDeleteDialog.value = false;
                userToDelete.value = null;
            },
        });
    }
};

const toggleUserStatus = (user: User) => {
    router.patch(
        userRoutes.toggleActive(user.id).url,
        {},
        {
            preserveScroll: true,
        },
    );
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <AppLayout title="Gestión de Usuarios">
        <div class="container mx-auto py-8 px-4">
            <Card>
                <CardHeader>
                    <div class="flex items-center justify-between">
                        <div>
                            <CardTitle class="text-3xl font-bold"
                                >Gestión de Usuarios</CardTitle
                            >
                            <CardDescription class="mt-2"
                                >Administra todos los usuarios del
                                sistema</CardDescription
                            >
                        </div>
                        <Link :href="userRoutes.create().url">
                            <Button>
                                <Plus class="mr-2 h-4 w-4" />
                                Nuevo Usuario
                            </Button>
                        </Link>
                    </div>
                </CardHeader>

                <CardContent>
                    <div class="rounded-md border">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Usuario</TableHead>
                                    <TableHead>Email</TableHead>
                                    <TableHead>Estado</TableHead>
                                    <TableHead>Fecha de Creación</TableHead>
                                    <TableHead class="text-right"
                                        >Acciones</TableHead
                                    >
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow
                                    v-for="user in users.data"
                                    :key="user.id"
                                >
                                    <TableCell>
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10"
                                            >
                                                <UserIcon
                                                    class="h-5 w-5 text-primary"
                                                />
                                            </div>
                                            <div>
                                                <div
                                                    class="font-medium text-foreground"
                                                >
                                                    {{ user.name }}
                                                </div>
                                                <div
                                                    v-if="
                                                        user.id ===
                                                        currentUserId
                                                    "
                                                    class="text-xs text-muted-foreground"
                                                >
                                                    (Tú)
                                                </div>
                                            </div>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <div class="flex items-center gap-2">
                                            <Mail class="h-4 w-4 text-muted-foreground" />
                                            <span class="text-sm">{{
                                                user.email
                                            }}</span>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <Badge
                                            :variant="
                                                user.is_active
                                                    ? 'default'
                                                    : 'secondary'
                                            "
                                        >
                                            {{
                                                user.is_active
                                                    ? 'Activo'
                                                    : 'Inactivo'
                                            }}
                                        </Badge>
                                    </TableCell>
                                    <TableCell class="text-sm text-muted-foreground">
                                        {{ formatDate(user.created_at) }}
                                    </TableCell>
                                    <TableCell class="text-right">
                                        <DropdownMenu>
                                            <DropdownMenuTrigger as-child>
                                                <Button
                                                    variant="ghost"
                                                    size="sm"
                                                >
                                                    <MoreVertical
                                                        class="h-4 w-4"
                                                    />
                                                </Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="end">
                                                <DropdownMenuItem as-child>
                                                    <Link
                                                        :href="
                                                            userRoutes.edit(
                                                                user.id,
                                                            ).url
                                                        "
                                                        class="flex items-center"
                                                    >
                                                        <Pencil
                                                            class="mr-2 h-4 w-4"
                                                        />
                                                        Editar
                                                    </Link>
                                                </DropdownMenuItem>
                                                <DropdownMenuItem
                                                    @click="
                                                        toggleUserStatus(user)
                                                    "
                                                >
                                                    <Power
                                                        v-if="user.is_active"
                                                        class="mr-2 h-4 w-4"
                                                    />
                                                    <PowerOff
                                                        v-else
                                                        class="mr-2 h-4 w-4"
                                                    />
                                                    {{
                                                        user.is_active
                                                            ? 'Desactivar'
                                                            : 'Activar'
                                                    }}
                                                </DropdownMenuItem>
                                                <DropdownMenuSeparator />
                                                <DropdownMenuItem
                                                    class="text-destructive focus:text-destructive"
                                                    :disabled="
                                                        user.id ===
                                                        currentUserId
                                                    "
                                                    @click="
                                                        openDeleteDialog(user)
                                                    "
                                                >
                                                    <Trash2
                                                        class="mr-2 h-4 w-4"
                                                    />
                                                    Eliminar
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>

                    <!-- Paginación -->
                    <div
                        v-if="users.last_page > 1"
                        class="mt-4 flex items-center justify-between"
                    >
                        <div class="text-sm text-muted-foreground">
                            Mostrando {{ users.from }} a {{ users.to }} de
                            {{ users.total }} usuarios
                        </div>
                        <div class="flex gap-2">
                            <Link
                                v-for="page in users.last_page"
                                :key="page"
                                :href="userRoutes.index({ query: { page } }).url"
                                preserve-scroll
                            >
                                <Button
                                    :variant="
                                        page === users.current_page
                                            ? 'default'
                                            : 'outline'
                                    "
                                    size="sm"
                                >
                                    {{ page }}
                                </Button>
                            </Link>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>

        <!-- Dialog de confirmación de eliminación -->
        <AlertDialog v-model:open="showDeleteDialog">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle
                        >¿Estás completamente seguro?</AlertDialogTitle
                    >
                    <AlertDialogDescription>
                        Esta acción no se puede deshacer. Esto eliminará
                        permanentemente al usuario
                        <strong>{{ userToDelete?.name }}</strong> del sistema.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Cancelar</AlertDialogCancel>
                    <AlertDialogAction
                        class="bg-destructive text-destructive-foreground hover:bg-destructive/90"
                        @click="deleteUser"
                    >
                        Eliminar
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </AppLayout>
</template>
