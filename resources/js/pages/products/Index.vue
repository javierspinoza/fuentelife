<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import {
    ImageIcon,
    MoreVertical,
    Package,
    Pencil,
    Plus,
    Trash2,
} from 'lucide-vue-next';
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
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
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
import * as productRoutes from '@/routes/products';

interface Product {
    id: number;
    name: string;
    price: string;
    image: string | null;
    created_at: string;
}

interface PaginatedProducts {
    data: Product[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
}

interface Props {
    products: PaginatedProducts;
}

defineProps<Props>();

const productToDelete = ref<Product | null>(null);
const showDeleteDialog = ref(false);

const openDeleteDialog = (product: Product) => {
    productToDelete.value = product;
    showDeleteDialog.value = true;
};

const deleteProduct = () => {
    if (productToDelete.value) {
        router.delete(productRoutes.destroy(productToDelete.value.id).url, {
            preserveScroll: true,
            onSuccess: () => {
                showDeleteDialog.value = false;
                productToDelete.value = null;
            },
        });
    }
};

const formatPrice = (price: string) => {
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(parseFloat(price));
};

const getImageUrl = (image: string | null) => {
    if (!image) return null;
    return `/storage/${image}`;
};
</script>

<template>
    <AppLayout title="Gestión de Productos">
        <div class="container mx-auto py-8 px-4">
            <Card>
                <CardHeader>
                    <div class="flex items-center justify-between">
                        <div>
                            <CardTitle class="text-3xl font-bold"
                                >Gestión de Productos</CardTitle
                            >
                            <CardDescription class="mt-2"
                                >Administra el catálogo de productos</CardDescription
                            >
                        </div>
                        <Link :href="productRoutes.create().url">
                            <Button>
                                <Plus class="mr-2 h-4 w-4" />
                                Nuevo Producto
                            </Button>
                        </Link>
                    </div>
                </CardHeader>

                <CardContent>
                    <!-- Grid de productos -->
                    <div
                        v-if="products.data.length > 0"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
                    >
                        <Card
                            v-for="product in products.data"
                            :key="product.id"
                            class="overflow-hidden group hover:shadow-lg transition-shadow"
                        >
                            <!-- Imagen del producto -->
                            <div
                                class="relative aspect-square bg-muted overflow-hidden"
                            >
                                <img
                                    v-if="product.image"
                                    :src="getImageUrl(product.image)"
                                    :alt="product.name"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center bg-muted"
                                >
                                    <ImageIcon
                                        class="h-20 w-20 text-muted-foreground"
                                    />
                                </div>

                                <!-- Menú de acciones flotante -->
                                <div
                                    class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                >
                                    <DropdownMenu>
                                        <DropdownMenuTrigger as-child>
                                            <Button
                                                size="sm"
                                                variant="secondary"
                                                class="h-8 w-8 p-0 shadow-lg"
                                            >
                                                <MoreVertical class="h-4 w-4" />
                                            </Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="end">
                                            <DropdownMenuItem as-child>
                                                <Link
                                                    :href="
                                                        productRoutes.edit(
                                                            product.id,
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
                                            <DropdownMenuSeparator />
                                            <DropdownMenuItem
                                                class="text-destructive focus:text-destructive"
                                                @click="
                                                    openDeleteDialog(product)
                                                "
                                            >
                                                <Trash2 class="mr-2 h-4 w-4" />
                                                Eliminar
                                            </DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </div>
                            </div>

                            <!-- Información del producto -->
                            <CardContent class="p-4">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex-1 min-w-0">
                                        <h3
                                            class="font-semibold text-lg truncate"
                                            :title="product.name"
                                        >
                                            {{ product.name }}
                                        </h3>
                                        <p
                                            class="text-2xl font-bold text-primary mt-1"
                                        >
                                            {{ formatPrice(product.price) }}
                                        </p>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <!-- Estado vacío -->
                    <div
                        v-else
                        class="flex flex-col items-center justify-center py-16 text-center"
                    >
                        <Package
                            class="h-24 w-24 text-muted-foreground/50 mb-4"
                        />
                        <h3 class="text-xl font-semibold mb-2">
                            No hay productos
                        </h3>
                        <p class="text-muted-foreground mb-6">
                            Comienza agregando tu primer producto al catálogo
                        </p>
                        <Link :href="productRoutes.create().url">
                            <Button>
                                <Plus class="mr-2 h-4 w-4" />
                                Crear Producto
                            </Button>
                        </Link>
                    </div>

                    <!-- Paginación -->
                    <div
                        v-if="products.last_page > 1"
                        class="mt-6 flex items-center justify-between"
                    >
                        <div class="text-sm text-muted-foreground">
                            Mostrando {{ products.from }} a {{ products.to }} de
                            {{ products.total }} productos
                        </div>
                        <div class="flex gap-2">
                            <Link
                                v-for="page in products.last_page"
                                :key="page"
                                :href="
                                    productRoutes.index({ query: { page } }).url
                                "
                                preserve-scroll
                            >
                                <Button
                                    :variant="
                                        page === products.current_page
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
                        permanentemente el producto
                        <strong>{{ productToDelete?.name }}</strong> del
                        catálogo.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Cancelar</AlertDialogCancel>
                    <AlertDialogAction
                        class="bg-destructive text-destructive-foreground hover:bg-destructive/90"
                        @click="deleteProduct"
                    >
                        Eliminar
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </AppLayout>
</template>

