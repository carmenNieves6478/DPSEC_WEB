<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { 
    Calendar, 
    FileText, 
    Plus, 
    Search, 
    Trash2, 
    ExternalLink, 
    Sparkles, 
    TrendingUp, 
    Heart,
    Eye,
    PlusCircle,
    X,
    FolderUp
} from '@lucide/vue';
import { ref, computed } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { eventsList  } from '@/lib/eventsData';
import type {EventItem} from '@/lib/eventsData';
import { dashboard } from '@/routes';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Panel Administrativo',
                href: dashboard(),
            },
        ],
    },
});

// Active Dashboard Tab
const activeTab = ref<'overview' | 'events' | 'docs'>('overview');

// Search filters
const eventQuery = ref('');
const docQuery = ref('');

// Reactive mock lists (initially populated from eventsList)
const events = ref<EventItem[]>([...eventsList]);
const documents = ref([
    { id: 1, title: 'Directiva N° 004-2026-DPESEC: Normas para Proyectos de Proyección Social', code: 'DIR-004-2026', date: '15 de Enero', type: 'Directiva', link: '#' },
    { id: 2, title: 'Resolución Rectoral N° 1024-2026-R-UNAP: Aprobación del Calendario de Actividades Culturales', code: 'RR-1024-2026', date: '04 de Marzo', type: 'Resolución', link: '#' },
    { id: 3, title: 'Guía Metodológica para la Formulación de Informes de Extensión Universitaria', code: 'GUIA-01-2026', date: '10 de Mayo', type: 'Guía', link: '#' }
]);

// Computed counts
const totalEvents = computed(() => events.value.length);
const totalDocs = computed(() => documents.value.length);
const totalProyeccionSocial = computed(() => events.value.filter(e => e.isProyeccionSocial).length);
const totalExtensionCultural = computed(() => events.value.filter(e => e.category === 'Extensión Cultural' || e.type === 'Cultural').length);

// Modal toggle states
const isAddEventOpen = ref(false);
const isAddDocOpen = ref(false);

// Reactive Form Models
const eventForm = ref({
    title: '',
    type: 'Cultural',
    category: 'Proyección Social',
    status: 'Proximos' as 'Proximos' | 'EnCurso' | 'Pasados',
    date: '',
    time: '',
    location: '',
    organizer: 'Dirección de Proyección Social y Extensión Cultural',
    description: '',
    image: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800',
    fbLink: 'https://www.facebook.com/ProyeccionSocialUNAPuno',
    isProyeccionSocial: true
});

const docForm = ref({
    title: '',
    code: '',
    date: '',
    type: 'Directiva',
    link: '#'
});

// Computed filtered lists for rendering
const filteredEvents = computed(() => {
    return events.value.filter(e => 
        e.title.toLowerCase().includes(eventQuery.value.toLowerCase()) ||
        e.category.toLowerCase().includes(eventQuery.value.toLowerCase()) ||
        e.location.toLowerCase().includes(eventQuery.value.toLowerCase())
    );
});

const filteredDocs = computed(() => {
    return documents.value.filter(d => 
        d.title.toLowerCase().includes(docQuery.value.toLowerCase()) ||
        d.code.toLowerCase().includes(docQuery.value.toLowerCase()) ||
        d.type.toLowerCase().includes(docQuery.value.toLowerCase())
    );
});

// Actions Handlers
const handleAddEventSubmit = () => {
    /* 
       BACKEND DEVELOPER NOTE:
       Hook Inertia useForm() here to send data to Laravel Controller.
       Example:
       import { useForm } from '@inertiajs/vue3';
       const form = useForm({ ... });
       form.post('/admin/eventos', { onSuccess: () => { ... } });
    */
    events.value.unshift({
        id: Date.now(),
        statusLabel: eventForm.value.status === 'Proximos' ? 'Próximo' : eventForm.value.status === 'EnCurso' ? 'En Curso' : 'Pasado',
        statusColor: eventForm.value.status === 'Proximos' ? 'bg-indigo-600' : eventForm.value.status === 'EnCurso' ? 'bg-emerald-600' : 'bg-neutral-500',
        ...eventForm.value
    });

    alert('¡Evento registrado con éxito (Simulación)!');
    isAddEventOpen.value = false;

    // Reset Form
    eventForm.value = {
        title: '',
        type: 'Cultural',
        category: 'Proyección Social',
        status: 'Proximos',
        date: '',
        time: '',
        location: '',
        organizer: 'Dirección de Proyección Social y Extensión Cultural',
        description: '',
        image: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800',
        fbLink: 'https://www.facebook.com/ProyeccionSocialUNAPuno',
        isProyeccionSocial: true
    };
};

const handleAddDocSubmit = () => {
    /* 
       BACKEND DEVELOPER NOTE:
       Hook Inertia file upload post here to save Document record.
       Example:
       form.post('/admin/documentos');
    */
    documents.value.unshift({
        id: Date.now(),
        ...docForm.value
    });

    alert('¡Documento subido y registrado con éxito (Simulación)!');
    isAddDocOpen.value = false;

    // Reset Form
    docForm.value = {
        title: '',
        code: '',
        date: '',
        type: 'Directiva',
        link: '#'
    };
};

const deleteEvent = (id: number) => {
    /* 
       BACKEND DEVELOPER NOTE:
       Hook Inertia delete route call here:
       router.delete(`/admin/eventos/${id}`);
    */
    if (confirm('¿Está seguro de que desea eliminar este evento?')) {
        events.value = events.value.filter(e => e.id !== id);
    }
};

const deleteDoc = (id: number) => {
    /* 
       BACKEND DEVELOPER NOTE:
       Hook Inertia delete route call here:
       router.delete(`/admin/documentos/${id}`);
    */
    if (confirm('¿Está seguro de que desea eliminar este documento?')) {
        documents.value = documents.value.filter(d => d.id !== id);
    }
};
</script>

<template>
    <Head title="Panel de Administración" />

    <div class="flex h-full flex-1 flex-col gap-6 p-6 max-w-7xl mx-auto w-full text-left">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-neutral-200 dark:border-neutral-800 pb-5">
            <div>
                <h1 class="text-2xl font-black text-neutral-900 dark:text-white flex items-center gap-2">
                    <Sparkles class="size-6 text-indigo-600 dark:text-indigo-400" />
                    Intranet de Gestión DPESEC
                </h1>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                    Administra los eventos, proyección social y documentos oficiales de la Dirección.
                </p>
            </div>

            <!-- Tab Buttons -->
            <div class="inline-flex p-1 bg-neutral-100 dark:bg-neutral-900 rounded-xl">
                <button 
                    @click="activeTab = 'overview'"
                    class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer"
                    :class="activeTab === 'overview' ? 'bg-white dark:bg-neutral-800 shadow-xs text-indigo-600 dark:text-indigo-400' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900'"
                >
                    Resumen
                </button>
                <button 
                    @click="activeTab = 'events'"
                    class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer"
                    :class="activeTab === 'events' ? 'bg-white dark:bg-neutral-800 shadow-xs text-indigo-600 dark:text-indigo-400' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900'"
                >
                    Eventos
                </button>
                <button 
                    @click="activeTab = 'docs'"
                    class="px-4 py-2 rounded-lg text-xs font-bold transition-all cursor-pointer"
                    :class="activeTab === 'docs' ? 'bg-white dark:bg-neutral-800 shadow-xs text-indigo-600 dark:text-indigo-400' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900'"
                >
                    Documentos
                </button>
            </div>
        </div>

        <!-- 1. OVERVIEW TAB PANEL -->
        <div v-if="activeTab === 'overview'" class="space-y-6 animate-in fade-in duration-300">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat 1 -->
                <div class="p-6 rounded-2xl border border-neutral-200/80 dark:border-neutral-800/80 bg-white dark:bg-neutral-900/60 shadow-xs flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-xs text-neutral-500 dark:text-neutral-400 font-bold uppercase tracking-wider">Total Eventos</span>
                        <h3 class="text-3xl font-black text-neutral-900 dark:text-white">{{ totalEvents }}</h3>
                        <p class="text-[10px] text-neutral-400">Publicados en el feed</p>
                    </div>
                    <div class="size-12 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                        <Calendar class="size-6" />
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="p-6 rounded-2xl border border-neutral-200/80 dark:border-neutral-800/80 bg-white dark:bg-neutral-900/60 shadow-xs flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-xs text-neutral-500 dark:text-neutral-400 font-bold uppercase tracking-wider">Proyección Social</span>
                        <h3 class="text-3xl font-black text-neutral-900 dark:text-white">{{ totalProyeccionSocial }}</h3>
                        <p class="text-[10px] text-neutral-400">Filtrados en social</p>
                    </div>
                    <div class="size-12 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                        <Heart class="size-6" />
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="p-6 rounded-2xl border border-neutral-200/80 dark:border-neutral-800/80 bg-white dark:bg-neutral-900/60 shadow-xs flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-xs text-neutral-500 dark:text-neutral-400 font-bold uppercase tracking-wider">Extensión Cultural</span>
                        <h3 class="text-3xl font-black text-neutral-900 dark:text-white">{{ totalExtensionCultural }}</h3>
                        <p class="text-[10px] text-neutral-400">Festivales y ciclos</p>
                    </div>
                    <div class="size-12 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                        <Sparkles class="size-6" />
                    </div>
                </div>

                <!-- Stat 4 -->
                <div class="p-6 rounded-2xl border border-neutral-200/80 dark:border-neutral-800/80 bg-white dark:bg-neutral-900/60 shadow-xs flex items-center justify-between">
                    <div class="space-y-1">
                        <span class="text-xs text-neutral-500 dark:text-neutral-400 font-bold uppercase tracking-wider">Documentos Subidos</span>
                        <h3 class="text-3xl font-black text-neutral-900 dark:text-white">{{ totalDocs }}</h3>
                        <p class="text-[10px] text-neutral-400">Directivas y guías</p>
                    </div>
                    <div class="size-12 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                        <FileText class="size-6" />
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Guidelines -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Action Cards -->
                <div class="lg:col-span-2 p-8 rounded-2xl border border-neutral-200/80 dark:border-neutral-800/80 bg-white dark:bg-neutral-900/60 space-y-6">
                    <h3 class="text-lg font-black text-neutral-900 dark:text-white">Acciones de Administración Rápida</h3>
                    <p class="text-xs text-neutral-500 leading-relaxed font-normal">
                        Utiliza estos atajos para insertar información en las secciones públicas de la web. Recuerda que todos los cambios se reflejan de inmediato.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button 
                            @click="activeTab = 'events'; isAddEventOpen = true"
                            class="p-4 rounded-xl border border-dashed border-indigo-200 dark:border-indigo-800 hover:border-indigo-500 bg-indigo-50/20 dark:bg-indigo-950/10 flex items-center gap-4 transition-all text-left group cursor-pointer"
                        >
                            <div class="size-10 rounded-lg bg-indigo-600/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-105 transition-all">
                                <PlusCircle class="size-5" />
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-neutral-900 dark:text-white">Crear Nuevo Evento</h4>
                                <p class="text-[10px] text-neutral-400">Para inicio y eventos</p>
                            </div>
                        </button>

                        <button 
                            @click="activeTab = 'docs'; isAddDocOpen = true"
                            class="p-4 rounded-xl border border-dashed border-purple-200 dark:border-purple-800 hover:border-purple-500 bg-purple-50/20 dark:bg-purple-950/10 flex items-center gap-4 transition-all text-left group cursor-pointer"
                        >
                            <div class="size-10 rounded-lg bg-purple-600/10 text-purple-600 dark:text-purple-400 flex items-center justify-center group-hover:scale-105 transition-all">
                                <FolderUp class="size-5" />
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-neutral-900 dark:text-white">Subir Documento</h4>
                                <p class="text-[10px] text-neutral-400">Directivas y resoluciones</p>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Info Help Panel -->
                <div class="p-8 rounded-2xl border border-neutral-200/80 dark:border-neutral-800/80 bg-white dark:bg-neutral-900/60 space-y-4">
                    <h3 class="text-sm font-bold text-neutral-900 dark:text-white flex items-center gap-1.5">
                        <TrendingUp class="size-4 text-emerald-600 dark:text-emerald-400" />
                        Notas de Desarrollo Backend
                    </h3>
                    <p class="text-[11px] text-neutral-500 leading-relaxed font-normal">
                        Este frontend está preparado con objetos reactivos locales estructurados bajo las interfaces exactas que los controladores de Laravel necesitan.
                    </p>
                    <div class="bg-neutral-50 dark:bg-neutral-950 p-4 rounded-xl space-y-2 border border-neutral-200/20">
                        <div class="flex items-center gap-2 text-[10px] font-mono text-indigo-600 dark:text-indigo-400">
                            <span class="size-1.5 rounded-full bg-indigo-500"></span>
                            Inertia route: /admin/eventos
                        </div>
                        <div class="flex items-center gap-2 text-[10px] font-mono text-emerald-600 dark:text-emerald-400">
                            <span class="size-1.5 rounded-full bg-emerald-500"></span>
                            Inertia route: /admin/documentos
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. EVENTS TAB PANEL -->
        <div v-if="activeTab === 'events'" class="space-y-6 animate-in fade-in duration-300">
            <!-- Table Header Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="relative w-full sm:w-80">
                    <Search class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-neutral-400" />
                    <Input 
                        v-model="eventQuery" 
                        placeholder="Buscar evento por título, área..."
                        class="pl-9 rounded-xl border-neutral-300 dark:border-neutral-700 text-xs h-10 w-full"
                    />
                </div>
                <Button 
                    @click="isAddEventOpen = true"
                    class="rounded-xl h-10 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold flex items-center gap-1.5 text-xs w-full sm:w-auto cursor-pointer"
                >
                    <Plus class="size-4" />
                    Agregar Nuevo Evento
                </Button>
            </div>

            <!-- Events Table -->
            <div class="border border-neutral-200/80 dark:border-neutral-800/80 rounded-2xl overflow-hidden bg-white dark:bg-neutral-900/60 shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-neutral-50 dark:bg-neutral-950/40 text-neutral-500 dark:text-neutral-400 uppercase tracking-wider font-bold border-b border-neutral-200 dark:border-neutral-800">
                                <th class="p-4 text-left font-bold w-12">ID</th>
                                <th class="p-4 text-left font-bold">Título / Nombre</th>
                                <th class="p-4 text-left font-bold">Categoría</th>
                                <th class="p-4 text-left font-bold">Fecha / Hora</th>
                                <th class="p-4 text-left font-bold">Proyección Social</th>
                                <th class="p-4 class-right text-right font-bold w-24">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                            <tr 
                                v-for="item in filteredEvents" 
                                :key="item.id"
                                class="hover:bg-neutral-50/50 dark:hover:bg-neutral-950/20 transition-colors"
                            >
                                <td class="p-4 text-neutral-500 font-mono">{{ item.id }}</td>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img :src="item.image" class="size-10 rounded-lg object-cover bg-neutral-100 shrink-0 border border-neutral-200/20" />
                                        <div>
                                            <span class="font-extrabold text-neutral-900 dark:text-white line-clamp-1 max-w-[280px]">{{ item.title }}</span>
                                            <span class="text-[10px] text-neutral-400 block">{{ item.location }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                                        {{ item.category }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="text-neutral-700 dark:text-neutral-300 font-bold">{{ item.date }}</div>
                                    <div class="text-[10px] text-neutral-400">{{ item.time }}</div>
                                </td>
                                <td class="p-4">
                                    <span 
                                        class="px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase"
                                        :class="item.isProyeccionSocial ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-neutral-100 text-neutral-500 dark:bg-neutral-800 dark:text-neutral-400'"
                                    >
                                        {{ item.isProyeccionSocial ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a :href="item.fbLink" target="_blank" class="p-2 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-500 dark:text-neutral-400">
                                            <ExternalLink class="size-4" />
                                        </a>
                                        <button 
                                            @click="deleteEvent(item.id)" 
                                            class="p-2 rounded-lg hover:bg-red-500/10 text-red-500 cursor-pointer"
                                        >
                                            <Trash2 class="size-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="filteredEvents.length === 0">
                                <td colspan="6" class="p-8 text-center text-neutral-400">No se encontraron eventos registrados.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 3. DOCUMENTS TAB PANEL -->
        <div v-if="activeTab === 'docs'" class="space-y-6 animate-in fade-in duration-300">
            <!-- Table Header Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="relative w-full sm:w-80">
                    <Search class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-neutral-400" />
                    <Input 
                        v-model="docQuery" 
                        placeholder="Buscar documento por título, código..."
                        class="pl-9 rounded-xl border-neutral-300 dark:border-neutral-700 text-xs h-10 w-full"
                    />
                </div>
                <Button 
                    @click="isAddDocOpen = true"
                    class="rounded-xl h-10 px-4 bg-purple-600 hover:bg-purple-700 text-white font-bold flex items-center gap-1.5 text-xs w-full sm:w-auto cursor-pointer"
                >
                    <Plus class="size-4" />
                    Subir Nuevo Documento
                </Button>
            </div>

            <!-- Documents Table -->
            <div class="border border-neutral-200/80 dark:border-neutral-800/80 rounded-2xl overflow-hidden bg-white dark:bg-neutral-900/60 shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-neutral-50 dark:bg-neutral-950/40 text-neutral-500 dark:text-neutral-400 uppercase tracking-wider font-bold border-b border-neutral-200 dark:border-neutral-800">
                                <th class="p-4 text-left font-bold">Código</th>
                                <th class="p-4 text-left font-bold">Título / Resolución</th>
                                <th class="p-4 text-left font-bold">Tipo</th>
                                <th class="p-4 text-left font-bold">Fecha de Aprobación</th>
                                <th class="p-4 text-right font-bold w-24">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                            <tr 
                                v-for="doc in filteredDocs" 
                                :key="doc.id"
                                class="hover:bg-neutral-50/50 dark:hover:bg-neutral-950/20 transition-colors"
                            >
                                <td class="p-4 font-mono font-bold text-neutral-900 dark:text-white">{{ doc.code }}</td>
                                <td class="p-4">
                                    <div class="font-extrabold text-neutral-900 dark:text-white line-clamp-1 max-w-[400px]">{{ doc.title }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold uppercase bg-purple-500/10 text-purple-600 dark:text-purple-400">
                                        {{ doc.type }}
                                    </span>
                                </td>
                                <td class="p-4 text-neutral-600 dark:text-neutral-300 font-bold">{{ doc.date }}</td>
                                <td class="p-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="#" class="p-2 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-500 dark:text-neutral-400">
                                            <Eye class="size-4" />
                                        </a>
                                        <button 
                                            @click="deleteDoc(doc.id)" 
                                            class="p-2 rounded-lg hover:bg-red-500/10 text-red-500 cursor-pointer"
                                        >
                                            <Trash2 class="size-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="filteredDocs.length === 0">
                                <td colspan="5" class="p-8 text-center text-neutral-400">No se encontraron documentos registrados.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 4. MODAL: AGREGAR EVENTO -->
        <div v-if="isAddEventOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 animate-in fade-in duration-200">
            <div class="w-full max-w-lg bg-white dark:bg-neutral-900 rounded-[24px] border border-neutral-200 dark:border-neutral-800 shadow-2xl p-6 relative flex flex-col max-h-[90vh] overflow-y-auto">
                <button @click="isAddEventOpen = false" class="absolute top-4 right-4 p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg text-neutral-500 cursor-pointer">
                    <X class="size-5" />
                </button>
                
                <h3 class="text-lg font-black text-neutral-900 dark:text-white mb-1 flex items-center gap-1.5">
                    <Calendar class="size-5 text-indigo-600 dark:text-indigo-400" />
                    Registrar Nuevo Evento
                </h3>
                <p class="text-xs text-neutral-500 mb-6 font-normal">Completa los campos para publicar la noticia o actividad en el sitio web.</p>
                
                <form @submit.prevent="handleAddEventSubmit" class="space-y-4 text-left">
                    <div class="space-y-1">
                        <Label for="title" class="text-xs">Título de la Actividad / Noticia</Label>
                        <Input v-model="eventForm.title" id="title" required placeholder="Ej. Concurso de Sikuris, Jornada de Reforestación..." class="rounded-xl text-xs h-10 border-neutral-300 dark:border-neutral-700" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <Label for="category" class="text-xs">Categoría</Label>
                            <select v-model="eventForm.category" id="category" class="w-full h-10 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 px-3 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                <option value="Proyección Social">Proyección Social</option>
                                <option value="Extensión Cultural">Extensión Cultural</option>
                                <option value="Voluntariado Universitario">Voluntariado Universitario</option>
                                <option value="Gestión Ambiental">Gestión Ambiental</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <Label for="status" class="text-xs">Estado</Label>
                            <select v-model="eventForm.status" id="status" class="w-full h-10 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 px-3 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                <option value="Proximos">Próximo</option>
                                <option value="EnCurso">En Curso</option>
                                <option value="Pasados">Pasado</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <Label for="date" class="text-xs">Fecha</Label>
                            <Input v-model="eventForm.date" id="date" required placeholder="Ej. 20 de Junio" class="rounded-xl text-xs h-10 border-neutral-300 dark:border-neutral-700" />
                        </div>
                        <div class="space-y-1">
                            <Label for="time" class="text-xs">Hora</Label>
                            <Input v-model="eventForm.time" id="time" required placeholder="Ej. 09:00 AM o Flexible" class="rounded-xl text-xs h-10 border-neutral-300 dark:border-neutral-700" />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <Label for="location" class="text-xs">Ubicación / Lugar</Label>
                        <Input v-model="eventForm.location" id="location" required placeholder="Ej. Estadio Monumental, Campus Universitario..." class="rounded-xl text-xs h-10 border-neutral-300 dark:border-neutral-700" />
                    </div>

                    <div class="space-y-1">
                        <Label for="description" class="text-xs">Descripción Breve</Label>
                        <textarea v-model="eventForm.description" id="description" required rows="3" placeholder="Resumen del evento o publicación..." class="w-full p-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="space-y-1">
                        <Label for="image" class="text-xs">URL de la Imagen (Facebook o Unsplash)</Label>
                        <Input v-model="eventForm.image" id="image" required placeholder="https://..." class="rounded-xl text-xs h-10 border-neutral-300 dark:border-neutral-700" />
                    </div>

                    <div class="space-y-1">
                        <Label for="fbLink" class="text-xs">Enlace a Publicación de Facebook</Label>
                        <Input v-model="eventForm.fbLink" id="fbLink" placeholder="https://facebook.com/..." class="rounded-xl text-xs h-10 border-neutral-300 dark:border-neutral-700" />
                    </div>

                    <div class="flex items-center space-x-3 py-2">
                        <input type="checkbox" v-model="eventForm.isProyeccionSocial" id="isProyeccionSocial" class="size-4 rounded border-neutral-300 dark:border-neutral-700 text-indigo-600 focus:ring-indigo-500 cursor-pointer" />
                        <Label for="isProyeccionSocial" class="text-xs font-bold text-neutral-800 dark:text-neutral-300 cursor-pointer select-none">¿Pertenece al área de Proyección Social?</Label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-neutral-100 dark:border-neutral-800">
                        <Button type="button" @click="isAddEventOpen = false" variant="outline" class="rounded-xl text-xs h-10 cursor-pointer">Cancelar</Button>
                        <Button type="submit" class="rounded-xl text-xs h-10 bg-indigo-600 hover:bg-indigo-700 text-white font-bold cursor-pointer">Registrar Evento</Button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 5. MODAL: AGREGAR DOCUMENTO -->
        <div v-if="isAddDocOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 animate-in fade-in duration-200">
            <div class="w-full max-w-md bg-white dark:bg-neutral-900 rounded-[24px] border border-neutral-200 dark:border-neutral-800 shadow-2xl p-6 relative flex flex-col">
                <button @click="isAddDocOpen = false" class="absolute top-4 right-4 p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg text-neutral-500 cursor-pointer">
                    <X class="size-5" />
                </button>
                
                <h3 class="text-lg font-black text-neutral-900 dark:text-white mb-1 flex items-center gap-1.5">
                    <FileText class="size-5 text-purple-600 dark:text-purple-400" />
                    Registrar Nuevo Documento
                </h3>
                <p class="text-xs text-neutral-500 mb-6 font-normal">Registra la directiva o resolución aprobada en la oficina.</p>
                
                <form @submit.prevent="handleAddDocSubmit" class="space-y-4 text-left">
                    <div class="space-y-1">
                        <Label for="docTitle" class="text-xs">Título del Documento / Directiva</Label>
                        <Input v-model="docForm.title" id="docTitle" required placeholder="Ej. Normas para Proyectos de Proyección Social..." class="rounded-xl text-xs h-10 border-neutral-300 dark:border-neutral-700" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <Label for="docCode" class="text-xs">Código / Identificador</Label>
                            <Input v-model="docForm.code" id="docCode" required placeholder="Ej. DIR-004-2026" class="rounded-xl text-xs h-10 border-neutral-300 dark:border-neutral-700" />
                        </div>
                        <div class="space-y-1">
                            <Label for="docType" class="text-xs">Tipo de Documento</Label>
                            <select v-model="docForm.type" id="docType" class="w-full h-10 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 px-3 text-xs focus:outline-none focus:ring-1 focus:ring-purple-500">
                                <option value="Directiva">Directiva</option>
                                <option value="Resolución">Resolución</option>
                                <option value="Guía">Guía</option>
                                <option value="Convenio">Convenio</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <Label for="docDate" class="text-xs">Fecha de Aprobación</Label>
                        <Input v-model="docForm.date" id="docDate" required placeholder="Ej. 15 de Enero" class="rounded-xl text-xs h-10 border-neutral-300 dark:border-neutral-700" />
                    </div>

                    <div class="space-y-1">
                        <Label for="docLink" class="text-xs">Enlace del PDF (Drive o Servidor)</Label>
                        <Input v-model="docForm.link" id="docLink" placeholder="Ej. https://drive.google.com/..." class="rounded-xl text-xs h-10 border-neutral-300 dark:border-neutral-700" />
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-neutral-100 dark:border-neutral-800">
                        <Button type="button" @click="isAddDocOpen = false" variant="outline" class="rounded-xl text-xs h-10 cursor-pointer">Cancelar</Button>
                        <Button type="submit" class="rounded-xl text-xs h-10 bg-purple-600 hover:bg-purple-700 text-white font-bold cursor-pointer">Guardar Documento</Button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>
