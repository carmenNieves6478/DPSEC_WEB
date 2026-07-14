<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    Calendar,
    ArrowRight,
    FileText,
    MapPin,
    ChevronRight,
    ExternalLink,
    X,
    UserCheck,
    Award,
    Leaf,
    Users
} from '@lucide/vue';
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { Button } from '@/components/ui/button';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { iconMap } from '@/lib/iconMap';

interface EventItem {
    id: number;
    title: string;
    type: string;
    category: string;
    status: 'Proximos' | 'EnCurso' | 'Pasados';
    status_label: string;
    status_color: string;
    event_date: string;
    time: string;
    location: string;
    organizer: string;
    description: string;
    image_path: string;
    fb_link: string;
    is_proyeccion_social: boolean;
}

interface DocumentItem {
    id: number;
    title: string;
    code: string;
    category: string;
    published_date: string;
    file_size: string;
    description: string;
}

interface StatItem {
    label: string;
    value: string;
    description: string;
    icon_name: string;
    color_class: string;
}

interface VideoItem {
    id: number;
    title: string;
    description: string;
    youtube_url: string;
    embed_url: string;
}

interface SubUnitItem {
    name: string;
    description: string;
    href: string;
    is_external: boolean;
    logo_path: string;
    fb_url: string;
}

interface SectionItem {
    eyebrow?: string;
    title?: string;
    description?: string;
    background_image?: string;
}

const props = defineProps<{
    events: EventItem[];
    documents: DocumentItem[];
    stats: StatItem[];
    videos: VideoItem[];
    subUnits: SubUnitItem[];
    sections: Record<string, SectionItem>;
}>();

// Modal states
const selectedActivity = ref<any>(null);
const isModalOpen = ref(false);

const openActivityModal = (activity: any) => {
    selectedActivity.value = activity;
    isModalOpen.value = true;
};

const closeActivityModal = () => {
    isModalOpen.value = false;
};

const latestActivities = computed(() => props.events.slice(0, 3));
const slides = computed(() => props.events.slice(0, 3).map(e => e.image_path));

const currentSlide = ref(0);
let timer: ReturnType<typeof setInterval> | null = null;

const showFloatingBar = ref(false);

const heroTitleHtml = computed(() => {
    const title = props.sections.hero?.title ?? 'Conectando la Universidad con nuestra Sociedad';
    return title.replace('Universidad', '<span class="bg-gradient-to-r from-indigo-400 via-blue-400 to-indigo-300 bg-clip-text text-transparent">Universidad</span>');
});

const formatDate = (dateStr: string) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    return `${date.getDate()} de ${months[date.getMonth()]}`;
};

const getUnitIcon = (name: string) => {
    if (name.toLowerCase().includes('ambiental')) return Leaf;
    if (name.toLowerCase().includes('graduado')) return Users;
    return Award;
};

const handleScroll = () => {
    const scrollY = window.scrollY;
    const isPastHero = scrollY > 400;
    const footer = document.querySelector('footer');
    let collidesWithFooter = false;

    if (footer) {
        const footerTop = footer.getBoundingClientRect().top + window.scrollY;
        const windowHeight = window.innerHeight;
        const barBottomEdge = scrollY + (windowHeight / 2) + 140;

        if (barBottomEdge >= footerTop) {
            collidesWithFooter = true;
        }
    }

    showFloatingBar.value = isPastHero && !collidesWithFooter;
};

onMounted(() => {
    timer = setInterval(() => {
        if (slides.value.length > 0) {
            currentSlide.value = (currentSlide.value + 1) % slides.value.length;
        }
    }, 6000);

    window.addEventListener('scroll', handleScroll);

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            } else {
                entry.target.classList.remove('is-visible');
            }
        });
    }, {
        threshold: 0.08,
        rootMargin: '0px 0px -40px 0px'
    });

    const sections = document.querySelectorAll('.reveal-section');
    sections.forEach((section) => revealObserver.observe(section));
});

onUnmounted(() => {
    if (timer) {
        clearInterval(timer);
    }
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <PublicLayout title="Inicio">
        <section
            class="relative h-[calc(100vh-96px)] min-h-[500px] flex items-center overflow-hidden bg-neutral-950 text-white">
            <!-- Background Images Carousel -->
            <div class="absolute inset-0 z-0">
                <transition-group name="fade">
                    <div v-for="(slide, index) in slides" v-show="currentSlide === index" :key="slide"
                        class="absolute inset-0 bg-cover bg-center transition-all duration-1000 ease-in-out transform scale-105"
                        :style="{ backgroundImage: `url(${slide})` }"></div>
                </transition-group>
                <!-- Dark Overlay to ensure high contrast/readability -->
                <div
                    class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-transparent dark:from-black/95 dark:via-black/80 dark:to-transparent z-10">
                </div>
            </div>

            <!-- Content Area -->
            <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full relative z-20">
                <div class="max-w-3xl space-y-6 text-left">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-semibold uppercase tracking-wider border border-indigo-500/30">
                        <TrendingUp class="size-3.5" />
                        <span>{{ sections.hero?.eyebrow ?? 'Compromiso Social y Cultural' }}</span>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1] text-white" v-html="heroTitleHtml">
                    </h1>

                    <p class="text-lg text-neutral-300 leading-relaxed max-w-2xl">
                        {{ sections.hero?.description ?? 'La Dirección de Proyección Social y Extensión Cultural de la UNA Puno lidera programas integradores, voluntariados, preservación del patrimonio cultural altiplánico y proyectos sostenibles para el desarrollo regional.' }}
                    </p>

                    <div class="flex flex-wrap gap-4 pt-2">
                        <Link href="/proyeccion-social">
                            <Button
                                class="rounded-xl h-12 px-6 bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-600/25 transition-all font-semibold flex items-center gap-2 cursor-pointer border-0">
                                Ver Actividades
                                <ArrowRight class="size-4" />
                            </Button>
                        </Link>
                        <Link href="/documentos">
                            <Button variant="outline"
                                class="rounded-xl h-12 px-6 border-white/20 bg-white/5 text-white hover:bg-white/10 font-semibold flex items-center gap-2 cursor-pointer">
                                <FileText class="size-4 text-indigo-300" />
                                Normativas y Guías
                            </Button>
                        </Link>
                    </div>
                </div>
            </div>
        </section>



        <!-- 2. FEATURED LATEST ACTIVITIES (Inspriado de Facebook) -->
        <section class="reveal-section py-20 lg:py-28">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-12">

                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div class="space-y-3 text-left">
                        <span
                            class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Noticias
                            y Publicaciones</span>
                        <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Actividades Recientes</h2>
                        <p class="text-neutral-500 dark:text-neutral-400 max-w-xl text-sm md:text-base">
                            Mantente al día con los últimos eventos, campañas de voluntariado y proyectos de proyección
                            social publicados en nuestros canales oficiales.
                        </p>
                    </div>
                    <Link href="/eventos">
                        <Button variant="ghost"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold group flex items-center gap-1 cursor-pointer">
                            Ver Cronograma Completo
                            <ChevronRight class="size-4 group-hover:translate-x-1 transition-transform" />
                        </Button>
                    </Link>
                </div>

                <!-- Activities Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="activity in latestActivities" :key="activity.id"
                        class="group relative flex flex-col bg-white dark:bg-neutral-900 border border-neutral-200/80 dark:border-neutral-800/80 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer"
                        @click="openActivityModal(activity)">
                        <!-- Image Section -->
                        <div class="h-52 relative overflow-hidden bg-neutral-150 dark:bg-neutral-950 shrink-0">
                            <img :src="activity.image_path" :alt="activity.title"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4 z-20">
                                <span
                                    class="text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-1.5 rounded-lg bg-white/95 dark:bg-neutral-950/95 text-indigo-600 dark:text-indigo-400 shadow-xs border border-neutral-200/30 dark:border-neutral-800/30">
                                    {{ activity.category }}
                                </span>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="flex-grow p-6 flex flex-col justify-between text-left">
                            <div class="space-y-2">
                                <!-- Date & Location -->
                                <div
                                    class="flex items-center gap-2.5 text-[11px] text-neutral-500 dark:text-neutral-400 font-semibold">
                                    <span class="flex items-center gap-1">
                                        <Calendar class="size-3.5 text-indigo-600/70 dark:text-indigo-400/70" />
                                        {{ formatDate(activity.event_date) }}
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-neutral-300 dark:bg-neutral-700"></span>
                                    <span class="flex items-center gap-1">
                                        <MapPin class="size-3.5 text-indigo-600/70 dark:text-indigo-400/70" />
                                        {{ activity.location }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3
                                    class="text-base font-extrabold text-neutral-900 dark:text-white leading-snug line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ activity.title }}
                                </h3>

                                <!-- Description -->
                                <p
                                    class="text-xs text-neutral-500 dark:text-neutral-400 line-clamp-2 leading-relaxed font-normal">
                                    {{ activity.description }}
                                </p>
                            </div>

                            <!-- Divider and Read More -->
                            <div
                                class="border-t border-neutral-100 dark:border-neutral-800/60 w-full pt-4 mt-5 flex items-center justify-between">
                                <span
                                    class="text-xs font-bold text-indigo-600 dark:text-indigo-400 group-hover:text-indigo-700 dark:group-hover:text-indigo-300 flex items-center gap-1 transition-colors">
                                    Leer más detalles
                                    <ChevronRight class="size-3.5" />
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- VIDEOS SECTOR (YOUTUBE EMBEDS) -->
        <section class="reveal-section py-20 border-t border-neutral-200/50 dark:border-neutral-800/30">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-12">
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <span
                        class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Multimedia
                        y Registro Audiovisual</span>
                    <h2 class="text-3xl font-extrabold tracking-tight">Videos Recientes</h2>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">
                        Revive los mejores momentos de nuestras campañas, inauguraciones y actividades de proyección
                        social en video.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="video in videos" :key="video.id"
                        class="group relative flex flex-col bg-white dark:bg-neutral-900 border border-neutral-200/80 dark:border-neutral-800/80 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                        <div class="relative aspect-video overflow-hidden bg-neutral-950">
                            <iframe class="w-full h-full border-0" :src="video.embed_url"
                                :title="video.title"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>
                        <div class="p-5 text-left flex-grow flex flex-col justify-between">
                            <div>
                                <h3
                                    class="text-sm font-extrabold text-neutral-900 dark:text-white leading-snug line-clamp-1">
                                    {{ video.title }}
                                </h3>
                                <p
                                    class="text-xs text-neutral-500 dark:text-neutral-400 mt-1.5 leading-relaxed line-clamp-2">
                                    {{ video.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- See More Redirection Button -->
                <div class="pt-4 text-center">
                    <a href="https://www.youtube.com/@direccionderesponsabilidad3871" target="_blank"
                        rel="noopener noreferrer">
                        <Button
                            class="rounded-xl h-12 px-6 bg-red-600 hover:bg-red-700 text-white shadow-lg shadow-red-600/25 transition-all font-bold inline-flex items-center gap-2 cursor-pointer border-0">
                            <svg class="size-4 fill-current shrink-0" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M23.498 6.163a3.003 3.003 0 0 0-2.11-2.11C19.517 3.545 12 3.545 12 3.545s-7.517 0-9.388.508a3.003 3.003 0 0 0-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 0 0 2.11 2.11c1.871.508 9.388.508 9.388.508s7.517 0 9.388-.508a3.003 3.003 0 0 0 2.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                            Ver más videos
                        </Button>
                    </a>
                </div>
            </div>
        </section>

        <!-- 3. QUICK OFFICE ACCESS DIRECTORY -->
        <section
            class="reveal-section py-20 bg-neutral-50/50 dark:bg-neutral-900/10 border-t border-neutral-200/50 dark:border-neutral-800/30">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-12">
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <span
                        class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Directorio
                        de SubUnidades</span>
                    <h2 class="text-3xl font-extrabold tracking-tight">Accede a Nuestras Áreas</h2>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">
                        Conoce las dependencias que forman parte de la Dirección de Proyección Social y Extensión
                        Cultural.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div v-for="sub in subUnits" :key="sub.name"
                        class="p-8 rounded-2xl border border-neutral-200/80 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 shadow-xs space-y-5 text-left flex flex-col h-full justify-between"
                        :class="sub.name.toLowerCase().includes('graduado') ? 'opacity-85 hover:opacity-100 transition-opacity' : ''">
                        <div class="space-y-4">
                            <div
                                class="size-12 rounded-xl flex items-center justify-center"
                                :class="sub.name.toLowerCase().includes('ambiental') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : (sub.name.toLowerCase().includes('graduado') ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400')">
                                <component :is="getUnitIcon(sub.name)" class="size-6" />
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="text-xl font-bold text-neutral-950 dark:text-white">{{ sub.name }}</h3>
                                <span v-if="sub.name.toLowerCase().includes('graduado')"
                                    class="text-[9px] bg-amber-500/10 text-amber-600 dark:text-amber-400 px-2 py-0.5 rounded font-bold uppercase tracking-wider shrink-0">Próximamente</span>
                            </div>
                            <p class="text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed">
                                {{ sub.description }}
                            </p>
                        </div>
                        
                        <div class="pt-4">
                            <a v-if="sub.is_external" :href="sub.href" target="_blank" rel="noopener noreferrer" class="block">
                                <Button variant="outline"
                                    class="w-full rounded-xl flex items-center justify-center gap-2 border-neutral-300 dark:border-neutral-700 cursor-pointer">
                                    Visitar Sitio Web
                                    <ExternalLink class="size-4 text-neutral-500" />
                                </Button>
                            </a>
                            <Link v-else :href="sub.href" class="block">
                                <Button
                                    class="w-full rounded-xl flex items-center justify-center gap-2 cursor-pointer"
                                    :class="sub.name.toLowerCase().includes('graduado') ? 'border border-neutral-300 dark:border-neutral-700 bg-transparent text-neutral-950 dark:text-white hover:bg-neutral-50 dark:hover:bg-neutral-800/50' : 'bg-neutral-950 hover:bg-neutral-900 dark:bg-white dark:text-neutral-950 dark:hover:bg-neutral-100'">
                                    {{ sub.name.toLowerCase().includes('graduado') ? 'Conoce Más' : 'Ver Actividades' }}
                                    <ArrowRight class="size-4" />
                                </Button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. RECENT DOCUMENTS PREVIEW -->
        <section class="reveal-section py-20">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                <!-- Left Details -->
                <div class="lg:col-span-5 space-y-6 text-left">
                    <span
                        class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Transparencia
                        y Normas</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Documentación Oficial</h2>
                    <p class="text-neutral-600 dark:text-neutral-300 text-sm md:text-base leading-relaxed">
                        Descarga las resoluciones, directivas vigentes, reglamentos y guías metodológicas para registrar
                        tus proyectos de proyección social y extensión cultural adecuadamente.
                    </p>
                    <Link href="/documentos">
                        <Button
                            class="rounded-xl bg-indigo-700 hover:bg-indigo-800 text-white flex items-center gap-2 cursor-pointer">
                            Ver Todos los Documentos
                            <ArrowRight class="size-4" />
                        </Button>
                    </Link>
                </div>

                <!-- Right Documents Table / Cards -->
                <div class="lg:col-span-7 space-y-4 w-full">
                    <div v-for="doc in documents" :key="doc.id"
                        class="p-5 rounded-2xl border border-neutral-200/80 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 shadow-xs hover:border-indigo-500/50 dark:hover:border-indigo-400/50 transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-left">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-[9px] bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 px-1.5 py-0.5 rounded font-bold uppercase tracking-wider">{{
                                        doc.category }}</span>
                                <span class="text-[10px] text-neutral-400 font-mono">{{ doc.code }}</span>
                            </div>
                            <h4 class="font-bold text-sm text-neutral-900 dark:text-white line-clamp-1">{{ doc.title }}
                            </h4>
                            <p class="text-xs text-neutral-400">Publicado: {{ formatDate(doc.published_date) }}</p>
                        </div>
                        <Link href="/documentos">
                            <Button size="sm" variant="outline"
                                class="rounded-xl flex items-center gap-1.5 text-xs border-neutral-300 dark:border-neutral-700 shrink-0 self-start sm:self-auto cursor-pointer">
                                <FileText class="size-3.5 text-indigo-500" />
                                Descargar PDF
                            </Button>
                        </Link>
                    </div>
                </div>

            </div>
        </section>

        <!-- 5. STATS SECTION (GLASSMORPHIC CARDS) -->
        <section
            class="reveal-section py-12 border-y border-y-neutral-200/55 dark:border-y-neutral-800/40 bg-neutral-50/50 dark:bg-neutral-900/10">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="stat in stats" :key="stat.label"
                        class="p-6 rounded-2xl bg-white dark:bg-neutral-900/50 border border-neutral-200/60 dark:border-neutral-800/60 shadow-xs flex items-start gap-4 hover:shadow-md transition-shadow">
                        <div class="p-3 rounded-xl shrink-0" :class="stat.color_class">
                            <component :is="iconMap[stat.icon_name]" class="size-6" />
                        </div>
                        <div class="space-y-1 text-left">
                            <span class="text-3xl font-extrabold text-neutral-900 dark:text-white tracking-tight">{{
                                stat.value }}</span>
                            <h3 class="text-sm font-semibold text-neutral-800 dark:text-neutral-200">{{ stat.label }}
                            </h3>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ stat.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. FACEBOOK SOCIAL COMMUNITY BANNER -->
        <!-- <section class="reveal-section py-12 bg-gradient-to-r from-indigo-700 to-indigo-900 dark:from-indigo-950 dark:to-neutral-950 text-white">
            <div class="max-w-5xl mx-auto px-6 text-center space-y-6">
                <h3 class="text-2xl md:text-3xl font-extrabold tracking-tight">¿Quieres ver fotos y videos en tiempo real?</h3>
                <p class="text-white/80 text-sm md:text-base max-w-2xl mx-auto">
                    Nuestra comunidad más activa está en Facebook. Publicamos diariamente convocatorias de voluntariados, transmisiones en vivo de festivales y testimonios de beneficiarios.
                </p>
                <div class="pt-2">
                    <a 
                        href="https://www.facebook.com/ProyeccionSocialUNAPuno" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-indigo-950 hover:bg-neutral-100 transition-colors font-bold text-sm shadow-md"
                    >
                        <svg class="size-5 fill-current text-[#1877F2]" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1V12h3l-.5 3h-2.5v6.8c4.56-.93 8-4.96 8-9.8z"/>
                        </svg>
                        Seguir en Facebook
                        <ExternalLink class="size-4 opacity-75" />
                    </a>
                </div>
            </div>
        </section> -->

        <!-- BEAUTIFUL RESPONSIVE MODAL FOR ACTIVITY DETAILS -->
        <Transition name="modal">
            <div v-if="isModalOpen && selectedActivity"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-md p-4"
                @click.self="closeActivityModal">
                <!-- Modal Panel -->
                <div
                    class="relative w-full max-w-3xl bg-white dark:bg-neutral-900 rounded-3xl overflow-hidden shadow-2xl border border-neutral-200 dark:border-neutral-800 flex flex-col md:flex-row h-auto max-h-[90vh] md:h-[500px] text-left transform transition-all duration-300">

                    <div class="grid grid-cols-1 md:grid-cols-12 w-full h-full">
                        <!-- Left side: Image -->
                        <div
                            class="md:col-span-5 relative h-[180px] sm:h-[220px] md:h-full overflow-hidden bg-neutral-100 dark:bg-neutral-950 shrink-0">
                            <img :src="selectedActivity.image_path" :alt="selectedActivity.title"
                                class="w-full h-full object-cover" />
                            <div class="absolute top-4 left-4 flex gap-1.5 flex-wrap">
                                <span
                                    class="text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-indigo-600 text-white shadow-md">
                                    {{ selectedActivity.category }}
                                </span>
                            </div>
                        </div>

                        <!-- Right side: Details -->
                        <div
                            class="md:col-span-7 p-6 md:p-8 flex flex-col justify-between h-full overflow-y-auto max-h-[calc(90vh-180px)] sm:max-h-[calc(90vh-220px)] md:max-h-full">
                            <div class="space-y-4">
                                <!-- Header and Close button -->
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-indigo-600/10 text-indigo-600 dark:text-indigo-400">
                                        {{ selectedActivity.category }}
                                    </span>

                                    <!-- Close Button -->
                                    <button @click="closeActivityModal"
                                        class="size-8 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 flex items-center justify-center hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors cursor-pointer">
                                        <X class="size-4" />
                                    </button>
                                </div>

                                <!-- Title -->
                                <h2
                                    class="text-base sm:text-lg md:text-xl font-black text-neutral-900 dark:text-white leading-tight">
                                    {{ selectedActivity.title }}
                                </h2>

                                <!-- Divider -->
                                <div class="border-t border-neutral-100 dark:border-neutral-800"></div>

                                <!-- Meta Grid (2 cols) -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                    <div
                                        class="flex items-center gap-2 text-neutral-600 dark:text-neutral-300 sm:col-span-2">
                                        <Calendar class="size-4 text-indigo-600 dark:text-indigo-400 shrink-0" />
                                        <span class="font-semibold">{{ formatDate(selectedActivity.event_date) }}</span>
                                    </div>
                                    <div
                                        class="flex items-start gap-2 text-neutral-600 dark:text-neutral-300 sm:col-span-2">
                                        <MapPin class="size-4 text-red-500 shrink-0 mt-0.5" />
                                        <span class="leading-tight">{{ selectedActivity.location }}</span>
                                    </div>
                                </div>

                                <!-- Divider -->
                                <div class="border-t border-neutral-100 dark:border-neutral-800"></div>

                                <!-- Description -->
                                <div class="space-y-1.5">
                                    <h4 class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider">Detalles
                                    </h4>
                                    <p
                                        class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed">
                                        {{ selectedActivity.description }}
                                    </p>
                                </div>
                            </div>

                            <!-- Footer Actions -->
                            <div
                                class="border-t border-neutral-100 dark:border-neutral-800/80 pt-4 mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <a :href="selectedActivity.fb_link || 'https://www.facebook.com/ProyeccionSocialUNAPuno'" target="_blank"
                                    rel="noopener noreferrer" class="w-full sm:w-auto" @click.stop>
                                    <Button size="sm"
                                        class="w-full sm:w-auto rounded-xl bg-indigo-700 hover:bg-indigo-800 text-white text-xs font-semibold flex items-center justify-center gap-1.5 cursor-pointer">
                                        <UserCheck class="size-3.5" />
                                        Inscribirse/Participar
                                    </Button>
                                </a>

                                <a :href="selectedActivity.fb_link || 'https://www.facebook.com/ProyeccionSocialUNAPuno'" target="_blank"
                                    class="text-xs text-neutral-400 hover:text-blue-500 transition-colors flex items-center gap-1"
                                    @click.stop>
                                    <svg class="size-4 fill-current" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1V12h3l-.5 3h-2.5v6.8c4.56-.93 8-4.96 8-9.8z" />
                                    </svg>
                                    Ver en Facebook
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </Transition>

        <!-- Floating Vertical Subunits Bar (Sticky, appears after Hero on the left) -->
        <div class="fixed left-4 top-1/2 -translate-y-1/2 z-50 hidden sm:flex flex-col gap-4 transition-all duration-500 ease-in-out"
            :class="showFloatingBar ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-16 pointer-events-none'">
            <div
                class="flex flex-col items-center pb-3 bg-white/70 dark:bg-neutral-950/70 backdrop-blur-md rounded-2xl border border-neutral-200/50 dark:border-neutral-800/50 shadow-lg w-14">
                <!-- Header Facebook Indicator (Takes the top shape of the bar) -->
                <div class="w-full h-10 flex items-center justify-center bg-[#1877f2] text-white shrink-0 mb-3 rounded-t-2xl"
                    title="Páginas de Facebook Oficiales">
                    <svg class="size-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1V12h3l-.5 3h-2.5v6.8c4.56-.93 8-4.96 8-9.8z" />
                    </svg>
                </div>

                <!-- Subunits items -->
                <div class="flex flex-col gap-3 px-2">
                    <a v-for="sub in subUnits" :key="sub.name" :href="sub.fb_url" target="_blank"
                        rel="noopener noreferrer"
                        class="group relative flex items-center justify-center size-10 rounded-full border-2 border-white dark:border-neutral-800 bg-white shadow-md hover:shadow-xl hover:scale-110 transition-all duration-300 cursor-pointer">
                        <img :src="sub.logo_path" :alt="sub.name" class="w-full h-full object-cover rounded-full" />
                        <!-- Tooltip name on hover -->
                        <div
                            class="absolute left-12 top-1/2 -translate-y-1/2 px-3 py-1.5 rounded-xl bg-white/90 dark:bg-neutral-950/90 backdrop-blur-md border border-neutral-200/60 dark:border-neutral-800/60 text-indigo-600 dark:text-indigo-400 text-[10px] font-extrabold whitespace-nowrap opacity-0 -translate-x-3 pointer-events-none group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 shadow-xl z-50">
                            {{ sub.name }}
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </PublicLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 1.5s ease-in-out;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* Scroll Reveal animation for home sections */
.reveal-section {
    opacity: 0;
    transform: translateY(35px);
    transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
    will-change: transform, opacity;
}

.reveal-section.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* Modal Transition Animations */
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-active .relative,
.modal-leave-active .relative {
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
}

.modal-enter-from .relative,
.modal-leave-to .relative {
    transform: scale(0.92) translateY(20px);
    opacity: 0;
}
</style>
