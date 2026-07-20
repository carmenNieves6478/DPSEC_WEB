<script setup lang="ts">
import { 
    Search, 
    Download, 
    ExternalLink, 
    Calendar, 
    Tag, 
    HelpCircle,
    Info
} from '@lucide/vue';
import { ref, computed } from 'vue';
import { Button } from '@/components/ui/button';
import PublicLayout from '@/layouts/PublicLayout.vue';

interface DocumentItem {
    id: number;
    title: string;
    code: string;
    category: string;
    published_date: string;
    description: string;
    file_path?: string;
}

interface SectionItem {
    eyebrow?: string;
    title?: string;
    description?: string;
    background_image?: string;
}

const props = defineProps<{
    documents: DocumentItem[];
    sections: Record<string, SectionItem>;
}>();

const search = ref('');
const activeCategory = ref('Todos');

const categories = ['Todos', 'Resoluciones', 'Directivas', 'Reglamentos', 'Guías y Formatos'];

const filteredDocuments = computed(() => {
    return props.documents.filter(doc => {
        const matchesSearch = doc.title.toLowerCase().includes(search.value.toLowerCase()) || 
                              doc.code.toLowerCase().includes(search.value.toLowerCase()) || 
                              doc.description.toLowerCase().includes(search.value.toLowerCase());
        const matchesCategory = activeCategory.value === 'Todos' || doc.category === activeCategory.value;
        return matchesSearch && matchesCategory;
    });
});

const formatDate = (dateStr: string) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
};
</script>

<template>
    <PublicLayout title="Documentos Oficiales">
        <!-- Hero Header -->
        <section 
            class="relative h-[45vh] min-h-[260px] flex items-center overflow-hidden bg-cover bg-center text-white"
            :style="sections.hero?.background_image ? { backgroundImage: `url(${sections.hero.background_image})` } : {}"
        >
            <!-- Gradient Overlay for readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/90 via-neutral-950/70 to-transparent z-10"></div>
            
            <div class="max-w-7xl mx-auto w-full px-6 lg:px-8 text-left relative z-20 space-y-3">
                <span class="text-xs font-bold uppercase tracking-widest text-blue-400">{{ sections.hero?.eyebrow ?? 'Normativa y Transparencia' }}</span>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">{{ sections.hero?.title ?? 'Centro de Documentos' }}</h1>
                <p class="text-xs md:text-sm text-white/80 max-w-3xl leading-relaxed">
                    {{ sections.hero?.description ?? 'Consulta y descarga reglamentos, resoluciones, directivas vigentes y los formatos oficiales requeridos para las actividades de proyección social de la UNA Puno.' }}
                </p>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-16 max-w-7xl mx-auto px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Filters Sidebar -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Search bar -->
                <div class="p-6 rounded-2xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-4 text-left">
                    <h3 class="font-bold text-sm uppercase tracking-wider text-neutral-800 dark:text-neutral-200 flex items-center gap-1.5">
                        <Search class="size-4 text-indigo-500" />
                        Buscar Documento
                    </h3>
                    <div class="relative">
                        <input 
                            v-model="search" 
                            type="text" 
                            placeholder="Ej. DIR-004..." 
                            class="w-full text-sm pl-9 pr-4 py-2 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-950 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <Search class="absolute left-3 top-3 size-4 text-neutral-400" />
                    </div>
                </div>

                <!-- Categories -->
                <div class="p-6 rounded-2xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 shadow-xs space-y-4 text-left">
                    <h3 class="font-bold text-sm uppercase tracking-wider text-neutral-800 dark:text-neutral-200 flex items-center gap-1.5">
                        <Tag class="size-4 text-indigo-500" />
                        Tipo de Documento
                    </h3>
                    <div class="flex flex-col gap-2">
                        <button 
                            v-for="cat in categories" 
                            :key="cat" 
                            @click="activeCategory = cat"
                            class="text-xs text-left px-3 py-2 rounded-lg transition-colors cursor-pointer"
                            :class="activeCategory === cat ? 'bg-indigo-600 text-white font-bold' : 'hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-600 dark:text-neutral-400'"
                        >
                            {{ cat }}
                        </button>
                    </div>
                </div>

                <!-- Info Help Card -->
                <div class="p-6 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-left space-y-4">
                    <h4 class="font-bold text-sm text-neutral-950 dark:text-white flex items-center gap-1.5">
                        <HelpCircle class="size-4.5 text-indigo-500" />
                        ¿Cómo enviar?
                    </h4>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed">
                        Los informes firmados y planes de trabajo deben ser subidos digitalmente por el docente coordinador a la Intranet, o presentados físicamente en Mesa de Partes en horario de oficina.
                    </p>
                    <a href="https://www.unap.edu.pe" target="_blank" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-bold flex items-center gap-1">
                        Mesa de Partes Virtual
                        <ExternalLink class="size-3" />
                    </a>
                </div>
            </div>

            <!-- Documents Table/List -->
            <div class="lg:col-span-9 space-y-6 text-left">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-extrabold text-neutral-950 dark:text-white">
                        Documentos Registrados
                        <span class="text-xs px-2 py-0.5 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-500 font-mono ml-2">{{ filteredDocuments.length }}</span>
                    </h2>
                </div>

                <div v-if="filteredDocuments.length === 0" class="p-12 text-center border border-dashed border-neutral-300 dark:border-neutral-800 rounded-2xl text-neutral-500 bg-white dark:bg-neutral-900/40">
                    <Info class="size-12 mx-auto mb-4 text-neutral-300" />
                    <p class="font-semibold">No se encontraron documentos con esos criterios</p>
                    <p class="text-xs mt-1">Intenta cambiar el término de búsqueda o la categoría seleccionada.</p>
                </div>

                <div v-else class="space-y-4">
                    <div 
                        v-for="doc in filteredDocuments" 
                        :key="doc.id" 
                        class="p-6 rounded-2xl bg-white dark:bg-neutral-900 border border-neutral-200/80 dark:border-neutral-800 shadow-xs hover:shadow-md transition-shadow flex flex-col md:flex-row md:items-center justify-between gap-6"
                    >
                        <div class="space-y-2 max-w-2xl">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                                    {{ doc.category }}
                                </span>
                                <span class="text-[10px] text-neutral-400 font-mono font-medium">{{ doc.code }}</span>
                            </div>
                            
                            <h3 class="font-bold text-base text-neutral-950 dark:text-white leading-snug">
                                {{ doc.title }}
                            </h3>
                            
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 leading-relaxed">
                                {{ doc.description }}
                            </p>

                            <div class="flex items-center gap-3 text-xs text-neutral-400 pt-1">
                                <span class="flex items-center gap-1">
                                    <Calendar class="size-3.5" />
                                    {{ formatDate(doc.published_date) }}
                                </span>
                            </div>
                        </div>

                        <!-- Download button -->
                        <div class="shrink-0 flex items-center">
                            <a 
                                v-if="doc.file_path"
                                :href="doc.file_path" 
                                target="_blank"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-neutral-950 hover:bg-neutral-900 dark:bg-white dark:text-neutral-950 dark:hover:bg-neutral-100 px-5 py-2.5 text-xs font-bold text-white transition-colors cursor-pointer"
                            >
                                <Download class="size-4" />
                                Descargar PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </PublicLayout>
</template>
