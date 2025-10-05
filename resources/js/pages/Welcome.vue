<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BadgeCheck,
    Check,
    ChevronLeft,
    ChevronRight,
    Clock,
    Heart,
    Package,
    Shield,
    Sparkles,
    Star,
    ThumbsUp,
    Truck,
    Users,
    Zap,
} from 'lucide-vue-next';
import { onMounted, onUnmounted, ref } from 'vue';
import { dashboard, login, register } from '@/routes';

interface PricePackage {
    units: number;
    originalPrice: number;
    finalPrice: number;
    savings: number;
    discount: string;
    popular?: boolean;
}

const pricePackages: PricePackage[] = [
    {
        units: 1,
        originalPrice: 229900,
        finalPrice: 229900,
        savings: 0,
        discount: '',
    },
    {
        units: 2,
        originalPrice: 459800,
        finalPrice: 436800,
        savings: 23000,
        discount: '5% OFF',
        popular: true,
    },
    {
        units: 3,
        originalPrice: 689700,
        finalPrice: 620700,
        savings: 69000,
        discount: '10% OFF',
    },
];

const benefits = [
    {
        icon: Zap,
        title: 'Energía y Vitalidad',
        description: 'Impulsadas por nanotecnología avanzada',
    },
    {
        icon: Sparkles,
        title: 'Nutrición Pura',
        description: 'Completa y sin químicos artificiales',
    },
    {
        icon: Heart,
        title: 'Regeneración Celular',
        description: 'Natural con respaldo biotecnológico',
    },
];

const vitamins = [
    { name: 'Vitamina A', benefit: 'Visión y piel saludable' },
    { name: 'Vitamina C', benefit: 'Sistema inmune fuerte' },
    { name: 'Vitamina D', benefit: 'Huesos fuertes' },
    { name: 'Vitamina E', benefit: 'Antioxidante natural' },
    { name: 'Complejo B', benefit: 'Energía y metabolismo' },
    { name: 'Minerales', benefit: 'Balance nutricional' },
];

const testimonials = [
    {
        name: 'María González',
        location: 'Bogotá',
        comment:
            'En solo 2 semanas noté la diferencia. Duermo mejor y tengo más energía durante el día.',
        rating: 5,
        image: '/ImagesHome/8211a5ef-2b9a-4472-88fe-9a19fc5a4073.jpg',
    },
    {
        name: 'Carlos Rodríguez',
        location: 'Medellín',
        comment:
            '¡Increíble! Mi ansiedad ha disminuido notablemente. Lo recomiendo 100%.',
        rating: 5,
        image: '/ImagesHome/6b5ba6d2-7386-4b41-af53-391bf030dec4.jpg',
    },
    {
        name: 'Ana Martínez',
        location: 'Cali',
        comment:
            'El mejor suplemento que he probado. Mis hijos también lo toman y están más activos.',
        rating: 5,
        image: '/ImagesHome/694e48dc-8a6a-4a09-8882-c6b3eef56c4a.jpg',
    },
    {
        name: 'Luis Fernando',
        location: 'Barranquilla',
        comment:
            'Excelente producto natural. Me ayudó con el estrés del trabajo y ahora me siento mucho más tranquilo.',
        rating: 5,
        image: '/ImagesHome/8211a5ef-2b9a-4472-88fe-9a19fc5a4073.jpg',
    },
];

// Slider de Testimonios
const currentSlide = ref(0);
const autoplayInterval = ref<NodeJS.Timeout | null>(null);

// Calcular número de slides según la pantalla
// Mobile: 3 slides (1 por vista)
// Desktop: 2 slides (2 por vista)
const getSlidesCount = () => {
    if (typeof window === 'undefined') return 3;
    return window.innerWidth >= 768 ? Math.ceil(testimonials.length / 2) : testimonials.length;
};

const totalSlides = ref(getSlidesCount());

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % totalSlides.value;
};

const prevSlide = () => {
    currentSlide.value =
        currentSlide.value === 0 ? totalSlides.value - 1 : currentSlide.value - 1;
};

const goToSlide = (index: number) => {
    currentSlide.value = index;
};

// Auto-play del slider
const startAutoplay = () => {
    autoplayInterval.value = setInterval(() => {
        nextSlide();
    }, 5000); // Cambia cada 5 segundos
};

const stopAutoplay = () => {
    if (autoplayInterval.value) {
        clearInterval(autoplayInterval.value);
        autoplayInterval.value = null;
    }
};

// Countdown Timer
const timeLeft = ref({
    hours: 23,
    minutes: 59,
    seconds: 59,
});

onMounted(() => {
    // Countdown timer
    setInterval(() => {
        if (timeLeft.value.seconds > 0) {
            timeLeft.value.seconds--;
        } else {
            timeLeft.value.seconds = 59;
            if (timeLeft.value.minutes > 0) {
                timeLeft.value.minutes--;
            } else {
                timeLeft.value.minutes = 59;
                if (timeLeft.value.hours > 0) {
                    timeLeft.value.hours--;
                }
            }
        }
    }, 1000);

    // Iniciar autoplay del slider
    startAutoplay();

    // Actualizar total de slides si cambia el tamaño de ventana
    window.addEventListener('resize', () => {
        totalSlides.value = getSlidesCount();
        if (currentSlide.value >= totalSlides.value) {
            currentSlide.value = 0;
        }
    });
});

onUnmounted(() => {
    stopAutoplay();
});

const formatPrice = (price: number) => {
    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(price);
};
</script>

<template>
    <Head title="Fuente Life - Reduce Estrés, Ansiedad e Insomnio">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-white">
        <!-- Header Sticky -->
        <header
            class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-lg border-b border-green-100 shadow-sm"
        >
            <nav class="container mx-auto px-4 lg:px-8 py-3">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center gap-2">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg"
                        >
                            <Heart class="w-6 h-6 text-white" :stroke-width="2.5" />
                        </div>
                        <span
                            class="text-xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent"
                        >
                            FUENTE LIFE
                        </span>
                    </div>

                    <!-- CTA Header -->
                    <button
                        class="hidden sm:inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold hover:shadow-xl transition-all duration-300 hover:scale-105 animate-pulse-slow"
                    >
                        <Package class="w-5 h-5" />
                        Comprar Ahora
                    </button>
                </div>
            </nav>
        </header>

        <!-- Hero Section - Impacto Inmediato -->
        <section
            class="pt-20 pb-8 lg:pt-32 lg:pb-16 bg-gradient-to-br from-green-50 via-emerald-50 to-white"
        >
            <div class="container mx-auto px-3 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <!-- Headline Principal -->
                    <div class="text-center mb-6 lg:mb-12 space-y-3 lg:space-y-5 animate-fade-in-up">
                        <div
                            class="inline-flex items-center gap-1.5 lg:gap-2 px-3 py-1.5 lg:px-4 lg:py-2 rounded-full bg-green-100 border-2 border-green-300 shadow-sm"
                        >
                            <Users class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-green-700" />
                            <span class="text-xs lg:text-sm font-bold text-green-700">
                                +7 MILLONES DE PACIENTES FELICES
                            </span>
                        </div>

                        <h1
                            class="text-xl sm:text-2xl lg:text-5xl font-extrabold text-gray-900 leading-tight max-w-4xl mx-auto px-2 lg:px-4"
                        >
                            ¿Sabías que el
                            <span
                                class="text-red-600 font-black relative inline-block"
                                style="text-decoration: underline; text-decoration-style: wavy; text-decoration-color: rgba(239, 68, 68, 0.4); text-underline-offset: 6px;"
                            >
                                estrés
                            </span>
                            puede agotar tus células tanto como tus emociones?
                        </h1>
                    </div>

                    <!-- Grid Hero -->
                    <div class="grid lg:grid-cols-2 gap-4 lg:gap-8 items-start">
                        <!-- Columna Izquierda: Imagen + Temporizador -->
                        <div class="space-y-3 lg:space-y-6 animate-fade-in-up animation-delay-200">
                            <!-- Imagen Producto -->
                            <div class="relative">
                                <div
                                    class="relative bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl lg:rounded-3xl p-4 lg:p-6 shadow-xl lg:shadow-2xl"
                                >
                                    <div class="aspect-square rounded-xl lg:rounded-2xl overflow-hidden">
                                        <img
                                            src="/ImagesHome/694e48dc-8a6a-4a09-8882-c6b3eef56c4a.jpg"
                                            alt="Fuente Life - Producto Principal"
                                            class="w-full h-full object-cover"
                                        />
                                    </div>

                                    <!-- Badge Flotante -->
                                    <div
                                        class="absolute -top-2 -right-2 lg:-top-3 lg:-right-3 bg-gradient-to-br from-yellow-400 to-orange-500 text-white px-3 py-1.5 lg:px-5 lg:py-2.5 rounded-xl lg:rounded-2xl shadow-lg lg:shadow-xl transform rotate-12 animate-bounce-slow"
                                    >
                                        <div class="text-center">
                                            <div class="text-sm lg:text-lg font-black">
                                                OFERTA
                                            </div>
                                            <div class="text-[10px] lg:text-xs font-semibold">
                                                ESPECIAL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Countdown Timer debajo de la imagen -->
                            <div
                                class="bg-gradient-to-r from-red-500 to-orange-500 text-white p-2 lg:p-3 rounded-lg shadow-md"
                            >
                                <div class="flex items-center justify-center gap-1 lg:gap-1.5 mb-1 lg:mb-1.5">
                                    <Clock class="w-2.5 h-2.5 lg:w-3 lg:h-3 animate-pulse" />
                                    <span class="text-[9px] lg:text-[10px] font-bold uppercase tracking-wide"
                                        >¡Oferta por tiempo limitado!</span
                                    >
                                </div>
                                <div class="flex items-center justify-center gap-1.5 lg:gap-2">
                                    <div class="text-center">
                                        <div
                                            class="text-lg lg:text-xl font-black bg-white/20 rounded px-1.5 lg:px-2 py-0.5 lg:py-1 min-w-[35px] lg:min-w-[40px]"
                                        >
                                            {{ String(timeLeft.hours).padStart(2, '0') }}
                                        </div>
                                        <div class="text-[7px] lg:text-[8px] mt-0.5 font-semibold uppercase tracking-wider opacity-90">
                                            HORAS
                                        </div>
                                    </div>
                                    <div class="text-base lg:text-lg font-black">:</div>
                                    <div class="text-center">
                                        <div
                                            class="text-lg lg:text-xl font-black bg-white/20 rounded px-1.5 lg:px-2 py-0.5 lg:py-1 min-w-[35px] lg:min-w-[40px]"
                                        >
                                            {{
                                                String(timeLeft.minutes).padStart(
                                                    2,
                                                    '0',
                                                )
                                            }}
                                        </div>
                                        <div class="text-[7px] lg:text-[8px] mt-0.5 font-semibold uppercase tracking-wider opacity-90">
                                            MIN
                                        </div>
                                    </div>
                                    <div class="text-base lg:text-lg font-black">:</div>
                                    <div class="text-center">
                                        <div
                                            class="text-lg lg:text-xl font-black bg-white/20 rounded px-1.5 lg:px-2 py-0.5 lg:py-1 min-w-[35px] lg:min-w-[40px]"
                                        >
                                            {{
                                                String(timeLeft.seconds).padStart(
                                                    2,
                                                    '0',
                                                )
                                            }}
                                        </div>
                                        <div class="text-[7px] lg:text-[8px] mt-0.5 font-semibold uppercase tracking-wider opacity-90">
                                            SEG
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha: Promesa, Precio y CTA -->
                        <div class="space-y-3 lg:space-y-6">
                            <!-- Promesa Principal -->
                            <div
                                class="bg-gradient-to-br from-emerald-600 to-green-700 text-white p-4 lg:p-6 rounded-xl lg:rounded-2xl shadow-lg border border-emerald-500/20"
                            >
                                <div class="flex items-start gap-2 lg:gap-4">
                                    <div
                                        class="w-10 h-10 lg:w-12 lg:h-12 bg-white/15 rounded-lg lg:rounded-xl flex items-center justify-center flex-shrink-0 backdrop-blur-sm"
                                    >
                                        <BadgeCheck class="w-6 h-6 lg:w-7 lg:h-7" />
                                    </div>
                                    <div>
                                        <h2
                                            class="text-lg lg:text-2xl font-bold mb-1 lg:mb-2 leading-tight"
                                        >
                                            Reduce tu estrés, ansiedad e insomnio
                                        </h2>
                                        <p class="text-base lg:text-lg font-semibold text-white/95">
                                            en solo
                            <span
                                                class="text-2xl lg:text-3xl font-black text-yellow-300"
                                            >
                                                30 DÍAS
                                            </span>
                                        </p>
                                        <p class="text-sm lg:text-base mt-1 lg:mt-2 text-white/80">
                                            Con el suplemento #1 en salud natural
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Precio -->
                            <div
                                class="bg-white border border-gray-200 p-4 lg:p-6 rounded-xl lg:rounded-2xl shadow-md"
                            >
                                <div class="space-y-2 lg:space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs lg:text-sm text-gray-500"
                                            >Precio Normal:</span
                            >
                                <span
                                            class="text-base lg:text-xl text-gray-400 line-through font-semibold"
                                            >$459.800</span
                                        >
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm lg:text-base font-bold text-gray-700"
                                            >Precio Oferta:</span
                                >
                                    <span
                                            class="text-2xl lg:text-3xl text-emerald-600 font-black"
                                            >$436.800</span
                                        >
                                    </div>
                                    <div
                                        class="flex items-center justify-center gap-2 bg-orange-50 rounded-lg lg:rounded-xl py-2 lg:py-3 px-3 lg:px-4 border border-orange-200"
                                    >
                                        <span class="text-sm lg:text-base font-bold text-orange-700"
                                            >¡Ahorras 33% = $23.000!</span
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Principal -->
                            <button
                                class="group w-full py-4 lg:py-5 px-4 lg:px-6 rounded-xl lg:rounded-2xl bg-gradient-to-r from-emerald-600 to-green-700 text-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]"
                            >
                                <div class="flex items-center justify-center gap-2 lg:gap-3">
                                    <Package class="w-6 h-6 lg:w-7 lg:h-7" />
                                    <div class="text-center">
                                        <div class="text-lg lg:text-xl font-black">
                                            COMPRAR AHORA
                                        </div>
                                        <div class="text-xs lg:text-sm font-semibold opacity-90">
                                            Y paga al recibir
                                        </div>
                                    </div>
                                    <ArrowRight
                                        class="w-5 h-5 lg:w-6 lg:h-6 group-hover:translate-x-2 transition-transform"
                                    />
                                </div>
                            </button>

                            <!-- Trust Badges -->
                            <div class="grid grid-cols-2 gap-2 lg:gap-3">
                                <div
                                    class="flex items-center gap-1.5 lg:gap-2 px-2 lg:px-3 py-2 lg:py-2.5 bg-gray-50 rounded-lg border border-gray-200"
                                >
                                    <Truck class="w-4 h-4 lg:w-5 lg:h-5 text-emerald-600 flex-shrink-0" />
                                    <span class="text-xs lg:text-sm font-semibold text-gray-700"
                                        >Envío GRATIS</span
                                    >
                                </div>
                                <div
                                    class="flex items-center gap-1.5 lg:gap-2 px-2 lg:px-3 py-2 lg:py-2.5 bg-gray-50 rounded-lg border border-gray-200"
                                >
                                    <Shield class="w-4 h-4 lg:w-5 lg:h-5 text-emerald-600 flex-shrink-0" />
                                    <span class="text-xs lg:text-sm font-semibold text-gray-700"
                                        >Pago Seguro</span
                                    >
                                </div>
                                <div
                                    class="flex items-center gap-1.5 lg:gap-2 px-2 lg:px-3 py-2 lg:py-2.5 bg-gray-50 rounded-lg border border-gray-200"
                                >
                                    <ThumbsUp class="w-4 h-4 lg:w-5 lg:h-5 text-emerald-600 flex-shrink-0" />
                                    <span class="text-xs lg:text-sm font-semibold text-gray-700"
                                        >100% Garantizado</span
                                    >
                                </div>
                                <div
                                    class="flex items-center gap-1.5 lg:gap-2 px-2 lg:px-3 py-2 lg:py-2.5 bg-gray-50 rounded-lg border border-gray-200"
                                >
                                    <BadgeCheck class="w-4 h-4 lg:w-5 lg:h-5 text-emerald-600 flex-shrink-0" />
                                    <span class="text-xs lg:text-sm font-semibold text-gray-700"
                                        >Calidad Premium</span
                                    >
                                </div>
                            </div>

                            <!-- Logos de Seguridad -->
                            <div class="flex items-center justify-center gap-4 lg:gap-6 pt-1 lg:pt-2">
                                <img
                                    src="/ImagesHome/securitylogo/Security_1.png"
                                    alt="Seguridad Verificada"
                                    class="h-12 lg:h-16 w-auto object-contain hover:scale-110 transition-transform duration-300"
                                />
                                <img
                                    src="/ImagesHome/securitylogo/Securit_2.png"
                                    alt="Pago Protegido"
                                    class="h-12 lg:h-16 w-auto object-contain hover:scale-110 transition-transform duration-300"
                                />
                                <img
                                    src="/ImagesHome/securitylogo/Security_3.png"
                                    alt="Certificado de Calidad"
                                    class="h-12 lg:h-16 w-auto object-contain hover:scale-110 transition-transform duration-300"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Beneficios Clave -->
        <section class="py-10 lg:py-24 bg-white">
            <div class="container mx-auto px-3 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <h2
                        class="text-2xl lg:text-5xl font-black text-center text-gray-900 mb-8 lg:mb-16"
                    >
                        Respaldado por
                            <span
                            class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent"
                        >
                            Nanotecnología Avanzada
                        </span>
                    </h2>

                    <div class="grid md:grid-cols-3 gap-4 lg:gap-8">
                        <div
                            v-for="(benefit, index) in benefits"
                            :key="index"
                            class="group relative bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl lg:rounded-3xl p-4 lg:p-8 border-2 border-green-100 hover:border-green-300 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2"
                        >
                            <!-- Móvil: Icono + Título en horizontal -->
                            <div class="flex lg:flex-col items-start lg:items-stretch gap-3 lg:gap-0">
                                <div
                                    class="w-12 h-12 lg:w-16 lg:h-16 rounded-xl lg:rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center flex-shrink-0 lg:mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg"
                                >
                                    <component
                                        :is="benefit.icon"
                                        class="w-6 h-6 lg:w-8 lg:h-8 text-white"
                                        :stroke-width="2.5"
                                    />
                                </div>
                                <h3 class="text-base lg:text-2xl font-black text-gray-900 lg:mb-3 flex-1 lg:flex-none">
                                    {{ benefit.title }}
                                </h3>
                            </div>
                            <p class="text-gray-600 text-sm lg:text-lg leading-relaxed mt-2 lg:mt-0">
                                {{ benefit.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Paquetes de Precios -->
        <section
            class="py-16 lg:py-24 bg-gradient-to-br from-gray-50 via-white to-green-50"
        >
            <div class="container mx-auto px-4 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <!-- Header -->
                    <div class="text-center mb-16 space-y-4">
                        <div
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 border-2 border-red-300"
                        >
                            <Sparkles class="w-4 h-4 text-red-600" />
                            <span class="text-sm font-bold text-red-700">
                                OFERTA ESPECIAL DE LANZAMIENTO
                                </span>
                        </div>
                        <h2
                            class="text-3xl lg:text-5xl font-black text-gray-900"
                        >
                            Elige tu
                                    <span
                                class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent"
                            >
                                Paquete Ideal
                            </span>
                        </h2>
                        <p class="text-xl text-gray-600">
                            Llévalo ahora con envío GRATIS a toda Colombia
                        </p>
                    </div>

                    <!-- Pricing Cards -->
                    <div class="grid md:grid-cols-3 gap-8 mb-12">
                        <div
                            v-for="(pkg, index) in pricePackages"
                            :key="index"
                            :class="[
                                'relative bg-white rounded-3xl p-8 border-4 transition-all duration-300 hover:scale-105',
                                pkg.popular
                                    ? 'border-green-500 shadow-2xl scale-105 lg:scale-110'
                                    : 'border-gray-200 shadow-lg hover:shadow-2xl',
                            ]"
                        >
                            <!-- Popular Badge -->
                            <div
                                v-if="pkg.popular"
                                class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-2 rounded-full text-sm font-black shadow-lg"
                            >
                                ⭐ MÁS POPULAR
                            </div>

                            <!-- Discount Badge -->
                            <div
                                v-if="pkg.discount"
                                class="absolute -top-3 -right-3 bg-gradient-to-br from-red-500 to-orange-500 text-white w-20 h-20 rounded-full flex items-center justify-center shadow-xl transform rotate-12"
                            >
                                <div class="text-center">
                                    <div class="text-xs font-bold leading-tight">
                                        {{ pkg.discount }}
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="text-center space-y-6">
                                <div>
                                    <div class="text-6xl font-black text-gray-900 mb-2">
                                        {{ pkg.units }}
                                    </div>
                                    <div class="text-xl font-bold text-gray-600">
                                        {{
                                            pkg.units === 1
                                                ? 'Unidad'
                                                : 'Unidades'
                                        }}
                                    </div>
                                </div>

                                <!-- Price -->
                                <div>
                                    <div
                                        v-if="pkg.savings > 0"
                                        class="text-lg text-gray-400 line-through"
                                    >
                                        {{ formatPrice(pkg.originalPrice) }}
                                    </div>
                                    <div
                                        class="text-4xl font-black text-green-600"
                                    >
                                        {{ formatPrice(pkg.finalPrice) }}
                                    </div>
                                    <div
                                        v-if="pkg.savings > 0"
                                        class="text-sm font-bold text-red-600 mt-2"
                                    >
                                        ¡Ahorras {{ formatPrice(pkg.savings) }}!
                                    </div>
                                </div>

                                <!-- CTA Button -->
                                <button
                                    :class="[
                                        'w-full py-3 lg:py-4 px-4 lg:px-6 rounded-xl lg:rounded-2xl font-black text-base lg:text-lg transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-xl',
                                        pkg.popular
                                            ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white'
                                            : 'bg-gray-900 text-white hover:bg-gray-800',
                                    ]"
                                >
                                    COMPRAR AHORA
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Global -->
                    <div class="text-center px-4 lg:px-0">
                        <button
                            class="group inline-flex flex-wrap items-center justify-center gap-2 lg:gap-3 px-6 lg:px-12 py-4 lg:py-6 rounded-xl lg:rounded-2xl bg-gradient-to-r from-green-500 to-emerald-600 text-white text-base lg:text-2xl font-black shadow-2xl hover:shadow-3xl transition-all duration-300 hover:scale-105 animate-pulse-slow w-full sm:w-auto"
                        >
                            <Package class="w-6 h-6 lg:w-8 lg:h-8 flex-shrink-0" />
                            <span class="text-center">COMPRAR Y PAGA AL RECIBIR</span>
                            <ArrowRight
                                class="w-5 h-5 lg:w-7 lg:h-7 group-hover:translate-x-2 transition-transform flex-shrink-0"
                            />
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vitaminas y Beneficios -->
        <section class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-4 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <h2
                        class="text-3xl lg:text-5xl font-black text-center text-gray-900 mb-4"
                    >
                        Vitaminas y
                        <span
                            class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent"
                        >
                            sus Beneficios
                            </span>
                    </h2>
                    <p class="text-xl text-center text-gray-600 mb-16">
                        Todo lo que tu cuerpo necesita en una sola fórmula
                    </p>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div
                            v-for="(vitamin, index) in vitamins"
                            :key="index"
                            class="flex items-start gap-4 p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-100 hover:border-green-300 hover:shadow-lg transition-all duration-300"
                        >
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center flex-shrink-0"
                            >
                                <Check class="w-6 h-6 text-white" :stroke-width="3" />
                </div>
                            <div>
                                <h3 class="text-lg font-black text-gray-900 mb-1">
                                    {{ vitamin.name }}
                                </h3>
                                <p class="text-gray-600">{{ vitamin.benefit }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Galería de Producto -->
        <section
            class="py-16 lg:py-24 bg-gradient-to-br from-green-50 to-emerald-50"
        >
            <div class="container mx-auto px-4 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <h2
                        class="text-3xl lg:text-5xl font-black text-center text-gray-900 mb-16"
                    >
                        Conoce
                        <span
                            class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent"
                        >
                            Fuente Life
                        </span>
                    </h2>

                    <div class="grid md:grid-cols-3 gap-8 mb-12">
                        <div
                            v-for="(image, index) in [
                                '694e48dc-8a6a-4a09-8882-c6b3eef56c4a.jpg',
                                '8211a5ef-2b9a-4472-88fe-9a19fc5a4073.jpg',
                                '6b5ba6d2-7386-4b41-af53-391bf030dec4.jpg',
                            ]"
                            :key="index"
                            class="group relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2"
                        >
                            <div
                                class="aspect-square overflow-hidden bg-gradient-to-br from-green-100 to-emerald-100"
                            >
                                <img
                                    :src="`/ImagesHome/${image}`"
                                    alt="Fuente Life"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div class="text-center px-4 lg:px-0">
                        <button
                            class="group inline-flex flex-wrap items-center justify-center gap-2 lg:gap-3 px-6 lg:px-12 py-4 lg:py-6 rounded-xl lg:rounded-2xl bg-gradient-to-r from-green-500 to-emerald-600 text-white text-base lg:text-2xl font-black shadow-2xl hover:shadow-3xl transition-all duration-300 hover:scale-105 w-full sm:w-auto"
                        >
                            <Package class="w-6 h-6 lg:w-8 lg:h-8 flex-shrink-0" />
                            <span class="text-center">COMPRAR AHORA</span>
                            <ArrowRight
                                class="w-5 h-5 lg:w-7 lg:h-7 group-hover:translate-x-2 transition-transform flex-shrink-0"
                            />
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonios Slider -->
        <section class="py-10 lg:py-24 bg-white">
            <div class="container mx-auto px-3 lg:px-8">
                <div class="max-w-7xl mx-auto">
                    <h2
                        class="text-2xl lg:text-5xl font-black text-center text-gray-900 mb-2 lg:mb-4"
                    >
                        Lo que dicen
                        <span
                            class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent"
                        >
                            nuestros clientes
                        </span>
                    </h2>
                    <p class="text-base lg:text-xl text-center text-gray-600 mb-8 lg:mb-16">
                        Miles de personas ya transformaron su vida con Fuente Life
                    </p>

                    <!-- Slider Container -->
                    <div class="relative px-8 lg:px-16">
                        <!-- Slider Wrapper -->
                        <div
                            class="overflow-hidden"
                            @mouseenter="stopAutoplay"
                            @mouseleave="startAutoplay"
                        >
                            <div
                                class="flex transition-transform duration-500 ease-out"
                                :style="{
                                    transform: `translateX(-${currentSlide * 100}%)`,
                                }"
                            >
                                <!-- Slides -->
                                <div
                                    v-for="(slide, slideIndex) in totalSlides"
                                    :key="slideIndex"
                                    class="w-full flex-shrink-0"
                                >
                                    <!-- Mobile: Show only 1 item -->
                                    <div class="md:hidden px-2">
                                        <div
                                            v-if="testimonials[slideIndex]"
                                            class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-4 border-2 border-gray-100 hover:border-green-200 hover:shadow-xl transition-all duration-300"
                                        >
                                            <!-- Rating -->
                                            <div class="flex items-center gap-1 mb-3">
                                                <Star
                                                    v-for="i in testimonials[slideIndex].rating"
                                                    :key="i"
                                                    class="w-4 h-4 text-yellow-400 fill-yellow-400"
                                                />
                                            </div>

                                            <!-- Comment -->
                                            <p
                                                class="text-gray-700 text-sm leading-relaxed mb-4 italic"
                                            >
                                                "{{ testimonials[slideIndex].comment }}"
                                            </p>

                                            <!-- Author -->
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex-shrink-0"
                                                ></div>
                                                <div>
                                                    <div
                                                        class="font-bold text-gray-900 text-sm"
                                                    >
                                                        {{ testimonials[slideIndex].name }}
                                                    </div>
                                                    <div
                                                        class="text-xs text-gray-500"
                                                    >
                                                        {{ testimonials[slideIndex].location }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Desktop: Show 2 items per slide -->
                                    <div class="hidden md:grid md:grid-cols-2 gap-6 lg:gap-8 px-2">
                                        <div
                                            v-for="itemIndex in 2"
                                            :key="itemIndex"
                                            class="bg-gradient-to-br from-gray-50 to-white rounded-3xl p-6 lg:p-8 border-2 border-gray-100 hover:border-green-200 hover:shadow-xl transition-all duration-300"
                                        >
                                            <template
                                                v-if="testimonials[slideIndex * 2 + (itemIndex - 1)]"
                                            >
                                                <!-- Rating -->
                                                <div class="flex items-center gap-1 mb-3 lg:mb-4">
                                                    <Star
                                                        v-for="i in testimonials[slideIndex * 2 + (itemIndex - 1)].rating"
                                                        :key="i"
                                                        class="w-4 h-4 lg:w-5 lg:h-5 text-yellow-400 fill-yellow-400"
                                                    />
                                                </div>

                                                <!-- Comment -->
                                                <p
                                                    class="text-gray-700 text-base lg:text-lg leading-relaxed mb-4 lg:mb-6 italic"
                                                >
                                                    "{{ testimonials[slideIndex * 2 + (itemIndex - 1)].comment }}"
                                                </p>

                                                <!-- Author -->
                                                <div class="flex items-center gap-2 lg:gap-3">
                                                    <div
                                                        class="w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex-shrink-0"
                                                    ></div>
                                                    <div>
                                                        <div
                                                            class="font-bold text-gray-900 text-sm lg:text-base"
                                                        >
                                                            {{ testimonials[slideIndex * 2 + (itemIndex - 1)].name }}
                                                        </div>
                                                        <div
                                                            class="text-xs lg:text-sm text-gray-500"
                                                        >
                                                            {{ testimonials[slideIndex * 2 + (itemIndex - 1)].location }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons - Fuera del slider -->
                        <button
                            @click="prevSlide"
                            class="absolute left-0 top-1/2 -translate-y-1/2 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white shadow-lg hover:shadow-xl flex items-center justify-center text-gray-700 hover:text-green-600 transition-all duration-300 hover:scale-110 border-2 border-gray-100 hover:border-green-200 z-10"
                            aria-label="Anterior testimonio"
                        >
                            <ChevronLeft class="w-5 h-5 lg:w-6 lg:h-6" />
                        </button>
                        <button
                            @click="nextSlide"
                            class="absolute right-0 top-1/2 -translate-y-1/2 w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-white shadow-lg hover:shadow-xl flex items-center justify-center text-gray-700 hover:text-green-600 transition-all duration-300 hover:scale-110 border-2 border-gray-100 hover:border-green-200 z-10"
                            aria-label="Siguiente testimonio"
                        >
                            <ChevronRight class="w-5 h-5 lg:w-6 lg:h-6" />
                        </button>
                    </div>

                    <!-- Dots Indicators -->
                    <div class="flex items-center justify-center gap-2 mt-6 lg:mt-8">
                        <!-- Mobile: Show dots for each testimonial (3 dots) -->
                        <button
                            v-for="(slide, index) in testimonials.length"
                            :key="`mobile-${index}`"
                            @click="goToSlide(index)"
                            :class="[
                                'h-2 rounded-full transition-all duration-300 md:hidden',
                                currentSlide === index
                                    ? 'w-8 bg-gradient-to-r from-green-500 to-emerald-600'
                                    : 'w-2 bg-gray-300 hover:bg-gray-400',
                            ]"
                            :aria-label="`Ir a testimonio ${index + 1}`"
                        />
                        
                        <!-- Desktop: Show dots for each pair (2 dots for 2 slides) -->
                        <button
                            v-for="(slide, index) in Math.ceil(testimonials.length / 2)"
                            :key="`desktop-${index}`"
                            @click="goToSlide(index)"
                            :class="[
                                'hidden md:block h-3 rounded-full transition-all duration-300',
                                currentSlide === index
                                    ? 'w-12 bg-gradient-to-r from-green-500 to-emerald-600'
                                    : 'w-3 bg-gray-300 hover:bg-gray-400',
                            ]"
                            :aria-label="`Ir a slide ${index + 1}`"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Dosificación -->
        <section
            class="py-16 lg:py-24 bg-gradient-to-br from-green-50 to-emerald-50"
        >
            <div class="container mx-auto px-4 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <h2
                        class="text-3xl lg:text-5xl font-black text-center text-gray-900 mb-16"
                    >
                        ¿Cuál es la
                        <span
                            class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent"
                        >
                            dosis
                        </span>
                        correcta?
                    </h2>

                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Niños -->
                        <div
                            class="bg-white rounded-3xl p-8 shadow-xl border-4 border-blue-200"
                        >
                            <div
                                class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mb-6 mx-auto"
                            >
                                <Heart class="w-8 h-8 text-white" />
                            </div>
                            <h3
                                class="text-2xl font-black text-center text-gray-900 mb-4"
                            >
                                Para Niños
                            </h3>
                            <p class="text-center text-gray-600 mb-4">
                                A partir de 5 años
                            </p>
                            <div
                                class="text-5xl font-black text-center text-blue-600 mb-4"
                            >
                                2.5 ML
                            </div>
                            <p class="text-center text-gray-700 leading-relaxed">
                                Ideal para tomar directamente del frasco o mezclado
                                en la bebida de su preferencia
                            </p>
                        </div>

                        <!-- Adultos -->
                        <div
                            class="bg-white rounded-3xl p-8 shadow-xl border-4 border-green-200"
                        >
                            <div
                                class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center mb-6 mx-auto"
                            >
                                <Zap class="w-8 h-8 text-white" />
                            </div>
                            <h3
                                class="text-2xl font-black text-center text-gray-900 mb-4"
                            >
                                Para Adultos
                            </h3>
                            <p class="text-center text-gray-600 mb-4">&nbsp;</p>
                            <div
                                class="text-5xl font-black text-center text-green-600 mb-4"
                            >
                                5 ML
                            </div>
                            <p class="text-center text-gray-700 leading-relaxed">
                                Ideal para tomar directamente del frasco o mezclado
                                en la bebida de su preferencia
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA con Ubicación -->
        <section class="py-10 lg:py-24 bg-white">
            <div class="container mx-auto px-3 lg:px-8">
                <div
                    class="max-w-5xl mx-auto bg-gradient-to-br from-green-500 via-emerald-600 to-green-700 rounded-3xl lg:rounded-[3rem] p-6 lg:p-16 text-center text-white relative overflow-hidden shadow-2xl"
                >
                    <!-- Background Pattern -->
                    <div
                        class="absolute inset-0 opacity-10"
                        style="
                            background-image: radial-gradient(
                                circle at 25px 25px,
                                white 2%,
                                transparent 0%
                            ),
                            radial-gradient(
                                circle at 75px 75px,
                                white 2%,
                                transparent 0%
                            );
                            background-size: 100px 100px;
                        "
                    ></div>

                    <div class="relative z-10 space-y-5 lg:space-y-8">
                        <h2 class="text-2xl lg:text-5xl font-black leading-tight">
                            ¡Ordena ya con envío GRATIS!
                        </h2>
                        <p class="text-lg lg:text-2xl font-bold">Paga contra entrega</p>

                        <!-- Trust Badges Grandes -->
                        <div
                            class="flex flex-col sm:flex-row flex-wrap gap-3 lg:gap-6 justify-center items-stretch sm:items-center py-4 lg:py-6"
                        >
                            <div
                                class="flex items-center gap-2 lg:gap-3 px-4 lg:px-6 py-3 lg:py-4 bg-white/20 backdrop-blur rounded-xl lg:rounded-2xl"
                            >
                                <Truck class="w-6 h-6 lg:w-8 lg:h-8 flex-shrink-0" />
                                <div class="text-left">
                                    <div class="font-black text-sm lg:text-lg">Envío GRATIS</div>
                                    <div class="text-xs lg:text-sm opacity-90">
                                        A toda Colombia
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex items-center gap-2 lg:gap-3 px-4 lg:px-6 py-3 lg:py-4 bg-white/20 backdrop-blur rounded-xl lg:rounded-2xl"
                            >
                                <Shield class="w-6 h-6 lg:w-8 lg:h-8 flex-shrink-0" />
                                <div class="text-left">
                                    <div class="font-black text-sm lg:text-lg">
                                        Envíos Seguros
                                    </div>
                                    <div class="text-xs lg:text-sm opacity-90">100% Protegido</div>
                                </div>
                            </div>
                            <div
                                class="flex items-center gap-2 lg:gap-3 px-4 lg:px-6 py-3 lg:py-4 bg-white/20 backdrop-blur rounded-xl lg:rounded-2xl"
                            >
                                <ThumbsUp class="w-6 h-6 lg:w-8 lg:h-8 flex-shrink-0" />
                                <div class="text-left">
                                    <div class="font-black text-sm lg:text-lg">
                                        Satisfacción 100%
                                    </div>
                                    <div class="text-xs lg:text-sm opacity-90">Garantizada</div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <button
                            class="group inline-flex flex-wrap items-center justify-center gap-2 lg:gap-3 px-6 lg:px-12 py-4 lg:py-6 rounded-xl lg:rounded-2xl bg-white text-green-600 text-base lg:text-2xl font-black shadow-2xl hover:shadow-3xl transition-all duration-300 hover:scale-105 w-full sm:w-auto"
                        >
                            <Package class="w-6 h-6 lg:w-8 lg:h-8 flex-shrink-0" />
                            <span class="text-center">COMPRAR Y PAGAR AL RECIBIR</span>
                            <ArrowRight
                                class="w-5 h-5 lg:w-7 lg:h-7 group-hover:translate-x-2 transition-transform flex-shrink-0"
                            />
                        </button>

                        <!-- Ubicación -->
                        <div class="pt-5 lg:pt-8 border-t-2 border-white/20 space-y-3 lg:space-y-4">
                            <p class="text-base lg:text-xl font-bold">Pídelo ahora con envío GRATIS</p>
                            <div class="flex flex-col md:flex-row gap-3 lg:gap-6 justify-center">
                                <div
                                    class="flex items-center gap-2 lg:gap-3 px-4 lg:px-6 py-2.5 lg:py-3 bg-white/10 rounded-lg lg:rounded-xl"
                                >
                                    <div
                                        class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"
                                    >
                                        <Package class="w-4 h-4 lg:w-5 lg:h-5" />
                </div>
                                    <div class="text-left">
                                        <div class="font-black text-sm lg:text-base">Bodega en Bucaramanga</div>
                                        <div class="text-xs lg:text-sm opacity-90">(Entrega en 1 día)</div>
        </div>
                                </div>
                                <div
                                    class="flex items-center gap-2 lg:gap-3 px-4 lg:px-6 py-2.5 lg:py-3 bg-white/10 rounded-lg lg:rounded-xl"
                                >
                                    <div
                                        class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"
                                    >
                                        <Truck class="w-4 h-4 lg:w-5 lg:h-5" />
                                    </div>
                                    <div class="text-left">
                                        <div class="font-black text-sm lg:text-base">Envíos Nacionales</div>
                                        <div class="text-xs lg:text-sm opacity-90">2 a 3 días</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="container mx-auto px-4 lg:px-8">
                <div class="max-w-7xl mx-auto text-center">
                    <div class="flex items-center justify-center gap-2 mb-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center"
                        >
                            <Heart class="w-6 h-6 text-white" :stroke-width="2.5" />
                        </div>
                        <span class="text-2xl font-black">FUENTE LIFE</span>
                    </div>
                    <p class="text-gray-400 mb-6">
                        El suplemento #1 en salud natural
                    </p>
                    <div class="text-sm text-gray-500">
                        © 2024 Fuente Life. Todos los derechos reservados.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce-slow {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

@keyframes pulse-slow {
    0%,
    100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
}

.animate-bounce-slow {
    animation: bounce-slow 3s ease-in-out infinite;
}

.animate-pulse-slow {
    animation: pulse-slow 2s ease-in-out infinite;
}

.animation-delay-200 {
    animation-delay: 200ms;
}

.animation-delay-300 {
    animation-delay: 300ms;
}
</style>