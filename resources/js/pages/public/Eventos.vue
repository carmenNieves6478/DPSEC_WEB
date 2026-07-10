<script setup lang="ts">
import { 
    Calendar, 
    MapPin, 
    Clock, 
    ChevronRight, 
    Info, 
    Sparkles, 
    Mail, 
    X, 
    UserCheck
} from '@lucide/vue';
import { ref, computed } from 'vue';
import { Button } from '@/components/ui/button';
import PublicLayout from '@/layouts/PublicLayout.vue';

const activeFilter = ref('Proximos');

// Modal states
const selectedEvent = ref<any>(null);
const isModalOpen = ref(false);

const openEventModal = (event: any) => {
    selectedEvent.value = event;
    isModalOpen.value = true;
};

const closeEventModal = () => {
    isModalOpen.value = false;
};

// Mock events based on UNA Puno FB activity calendar
const events = [
    {
        id: 1,
        title: 'Festival Interfacultades de Danzas Autóctonas UNA Puno 2026',
        type: 'Cultural',
        status: 'Proximos',
        date: '04 Nov 2026',
        time: '08:00 AM',
        location: 'Estadio Monumental UNA Puno',
        organizer: 'Dirección de Proyección Social y Extensión Cultural',
        description: 'La máxima expresión folclórica universitaria del Altiplano. Las 35 escuelas profesionales compiten presentando danzas autóctonas tradicionales, revalorando nuestra identidad cultural y rindiendo homenaje al aniversario de la ciudad de Puno.',
        image: 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3', // Festival/dance placeholder
        fbLink: 'https://www.facebook.com/ProyeccionSocialUNAPuno'
    },
    {
        id: 2,
        title: 'Campaña Odontológica Preventiva "Sonrisas Altiplánicas"',
        type: 'Campaña Social',
        status: 'Proximos',
        date: '10 Nov 2026',
        time: '09:00 AM - 02:00 PM',
        location: 'Plaza Principal de Chucuito',
        organizer: 'Facultad de Odontología y DPESEC',
        description: 'Campaña de salud gratuita dirigida a niños de 5 a 12 años. Brindaremos servicios de profilaxis, aplicación de flúor, obturaciones simples y charlas preventivas a padres de familia sobre salud bucal infantil.',
        image: 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3', // Medical placeholder
        fbLink: 'https://www.facebook.com/ProyeccionSocialUNAPuno'
    },
    {
        id: 3,
        title: 'Jornada Universitaria de Arborización y Limpieza en la Bahía de Puno',
        type: 'Ambiental',
        status: 'Proximos',
        date: '22 Nov 2026',
        time: '07:30 AM',
        location: 'Bahía Interior del Lago Titicaca',
        organizer: 'Suboficina de Gestión Ambiental y Voluntariado',
        description: 'Invitamos a toda la comunidad universitaria a sumarse a esta jornada masiva de limpieza y plantación de especies nativas en las riberas del Lago Titicaca. ¡Suma horas de proyección social y ayuda al medio ambiente!',
        image: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3', // Planting/environment placeholder
        fbLink: 'https://www.facebook.com/ProyeccionSocialUNAPuno'
    },
    {
        id: 6,
        title: 'Campaña de Recolección de Residuos Electrónicos "Eco-UNA 2026"',
        type: 'Ambiental',
        status: 'EnCurso',
        date: '05 Jul 2026 - 12 Jul 2026',
        time: '08:00 AM - 03:00 PM',
        location: 'Puntos de acopio en Ciudad Universitaria (Puerta Floral y Sesquicentenario)',
        organizer: 'Sub Unidad de Gestión Ambiental',
        description: 'Recolección y adecuada disposición final de celulares en desuso, computadoras, cargadores y baterías. Los estudiantes participantes obtendrán constancia de horas ambientales y de proyección.',
        image: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3',
        fbLink: 'https://www.facebook.com/ProyeccionSocialUNAPuno'
    },
    {
        id: 7,
        title: 'Tercer Ciclo de Cine Universitario y Debate Social',
        type: 'Cultural',
        status: 'EnCurso',
        date: '01 Jul 2026 - 15 Jul 2026',
        time: '05:00 PM',
        location: 'Auditorio de la Facultad de Ingeniería Estadística',
        organizer: 'Sub Unidad de Extensión Universitaria y Proyección Social',
        description: 'Ciclo de proyecciones semanales sobre documentales de ecología andina e historia altiplánica, seguido de mesas de debate estudiantil dirigidas por docentes de Ciencias Sociales.',
        image: 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3',
        fbLink: 'https://www.facebook.com/ProyeccionSocialUNAPuno'
    },
    {
        id: 4,
        title: 'Seminario Internacional: Retos del Desarrollo Social Altoandino',
        type: 'Académico',
        status: 'Pasados',
        date: '15 Jun 2026',
        time: '10:00 AM',
        location: 'Auditorio Magno UNA Puno',
        organizer: 'Dirección de Proyección Social y Extensión Cultural',
        description: 'Ciclo de ponencias magistrales a cargo de especialistas de Perú, Bolivia y Ecuador sobre las políticas públicas, retos agrícolas y adaptabilidad al cambio climático de las comunidades altoandinas en el siglo XXI.',
        image: 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3', // Academic conference placeholder
        fbLink: 'https://www.facebook.com/ProyeccionSocialUNAPuno'
    },
    {
        id: 5,
        title: 'Campaña Solidaria "Abrigo UNA Puno": Donación para Zonas de Heladas',
        type: 'Campaña Social',
        status: 'Pasados',
        date: '03 Jul 2026',
        time: '08:00 AM - 04:00 PM',
        location: 'Puerta Principal Ciudad Universitaria',
        organizer: 'Comisión de Voluntariado DPESEC',
        description: 'Recolección masiva de mantas, ropa de abrigo en buen estado y alimentos no perecibles para ser distribuidos en las comunidades rurales altoandinas de Puno más afectadas por el friaje de la temporada invernal.',
        image: 'https://images.unsplash.com/photo-1584263343329-8a6f31ab2881?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3', // Charity/winter clothes placeholder
        fbLink: 'https://www.facebook.com/ProyeccionSocialUNAPuno'
    }
];

const filteredEvents = computed(() => {
    if (activeFilter.value === 'Todos') {
return events;
}

    return events.filter(event => event.status === activeFilter.value);
});
</script>

<template>
    <PublicLayout title="Cronograma de Eventos">
        <!-- Hero Header -->
        <section 
            class="relative h-[45vh] min-h-[260px] flex items-center overflow-hidden bg-cover bg-center text-white"
            style="background-image: url('https://scontent.fjul1-1.fna.fbcdn.net/v/t39.30808-6/599715893_884448530603047_8830935029040207180_n.jpg?stp=dst-jpg_tt6&cstp=mx2048x1365&ctp=s2048x1365&_nc_cat=105&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeHQTG8nj3AVQPEHA1wTgQHYKeP-NFCKFbkp4_40UIoVuSWAiJSKTpXbty2XufqHJ3TjfkBChQkMKeic-hENsQFS&_nc_ohc=y0aeGiZKoI8Q7kNvwHlWwdS&_nc_oc=AdrAcbj07hIEXl4hMGQ0WxmZ3uxiOjPk3rSDXBstr9iXtNUKrJ_uMeBgXLuI-L3q0iQ&_nc_zt=23&_nc_ht=scontent.fjul1-1.fna&_nc_gid=4KCvHQKz0MhLi4lQ3kNatQ&_nc_ss=7b2a8&oh=00_AQCPYaYVBsK7Adxqddq_DlU6zk0tr2nCG3amFSJjCR6x5g&oe=6A547587');"
        >
            <!-- Gradient Overlay for readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/90 via-neutral-950/70 to-transparent z-10"></div>
            
            <div class="max-w-7xl mx-auto w-full px-6 lg:px-8 text-left relative z-20 space-y-3">
                <span class="text-xs font-bold uppercase tracking-widest text-blue-400">Agenda Institucional</span>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Eventos y Certificados</h1>
                <p class="text-xs md:text-sm text-white/80 max-w-3xl leading-relaxed">
                    Sigue nuestro cronograma de festivales culturales, campañas de salud descentralizadas, convocatorias a voluntariados ecológicos y seminarios académicos de proyección social.
                </p>
            </div>
        </section>

        <!-- Navigation Tabs & Content -->
        <section class="py-16 max-w-7xl mx-auto px-6 lg:px-8 space-y-10">
            
            <!-- Filters & Tabs -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 border-b border-neutral-200 dark:border-neutral-800 pb-4">
                
                <!-- Filter buttons -->
                <div class="inline-flex p-1 rounded-xl bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-sm">
                    <button 
                        @click="activeFilter = 'Proximos'"
                        class="px-5 py-2 rounded-lg font-bold transition-all text-xs cursor-pointer"
                        :class="activeFilter === 'Proximos' ? 'bg-indigo-600 text-white shadow-xs' : 'text-neutral-500 hover:text-neutral-800 dark:hover:text-neutral-200'"
                    >
                        Próximos
                    </button>
                    <button 
                        @click="activeFilter = 'EnCurso'"
                        class="px-5 py-2 rounded-lg font-bold transition-all text-xs cursor-pointer"
                        :class="activeFilter === 'EnCurso' ? 'bg-indigo-600 text-white shadow-xs' : 'text-neutral-500 hover:text-neutral-800 dark:hover:text-neutral-200'"
                    >
                        En Curso
                    </button>
                    <button 
                        @click="activeFilter = 'Pasados'"
                        class="px-5 py-2 rounded-lg font-bold transition-all text-xs cursor-pointer"
                        :class="activeFilter === 'Pasados' ? 'bg-indigo-600 text-white shadow-xs' : 'text-neutral-500 hover:text-neutral-800 dark:hover:text-neutral-200'"
                    >
                        Pasados
                    </button>
                    <button 
                        @click="activeFilter = 'Todos'"
                        class="px-5 py-2 rounded-lg font-bold transition-all text-xs cursor-pointer"
                        :class="activeFilter === 'Todos' ? 'bg-indigo-600 text-white shadow-xs' : 'text-neutral-500 hover:text-neutral-800 dark:hover:text-neutral-200'"
                    >
                        Todos
                    </button>
                </div>

                <!-- Info message -->
                <span class="text-xs text-neutral-400 font-medium flex items-center gap-1.5">
                    <Info class="size-3.5 text-indigo-500" />
                    Las inscripciones cierran 24 horas antes del evento.
                </span>
            </div>

            <!-- Events Grid -->
            <div v-if="filteredEvents.length === 0" class="p-16 text-center border border-dashed border-neutral-300 dark:border-neutral-800 rounded-2xl text-neutral-500">
                <Calendar class="size-12 mx-auto mb-4 text-neutral-300 animate-pulse" />
                <p class="font-semibold text-base">No hay eventos para mostrar en esta lista</p>
                <p class="text-xs mt-1">Vuelve más tarde o consulta nuestra página de Facebook para avisos rápidos.</p>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div 
                    v-for="ev in filteredEvents" 
                    :key="ev.id" 
                    class="group relative flex flex-col bg-white dark:bg-neutral-900 border border-neutral-200/80 dark:border-neutral-800/80 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer"
                    :class="{ 'opacity-80': ev.status === 'Pasados' }"
                    @click="openEventModal(ev)"
                >
                    <!-- Image Section -->
                    <div class="h-52 relative overflow-hidden bg-neutral-150 dark:bg-neutral-950 shrink-0">
                        <img 
                            :src="ev.image" 
                            :alt="ev.title" 
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                        />
                        <!-- Top Badges -->
                        <div class="absolute top-4 left-4 z-20 flex gap-2 flex-wrap">
                            <span class="text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-1.5 rounded-lg bg-white/95 dark:bg-neutral-950/95 text-indigo-600 dark:text-indigo-400 shadow-xs border border-neutral-200/30 dark:border-neutral-800/30">
                                {{ ev.type }}
                            </span>
                            <span 
                                class="text-[9px] font-extrabold uppercase tracking-wider px-2.5 py-1.5 rounded-lg text-white shadow-xs"
                                :class="{
                                    'bg-indigo-600': ev.status === 'Proximos',
                                    'bg-emerald-600': ev.status === 'EnCurso',
                                    'bg-neutral-500': ev.status === 'Pasados'
                                }"
                            >
                                {{ ev.status === 'Proximos' ? 'Próximo' : ev.status === 'EnCurso' ? 'En Curso' : 'Finalizado' }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="flex-grow p-6 flex flex-col justify-between text-left">
                        <div class="space-y-2">
                            <!-- Date & Time & Location -->
                            <div class="flex flex-wrap items-center gap-2.5 text-[11px] text-neutral-500 dark:text-neutral-400 font-semibold">
                                <span class="flex items-center gap-1">
                                    <Calendar class="size-3.5 text-indigo-600/70 dark:text-indigo-400/70" />
                                    {{ ev.date }}
                                </span>
                                <span class="w-1 h-1 rounded-full bg-neutral-300 dark:bg-neutral-700"></span>
                                <span class="flex items-center gap-1">
                                    <Clock class="size-3.5 text-indigo-600/70 dark:text-indigo-400/70" />
                                    {{ ev.time }}
                                </span>
                                <span class="w-1 h-1 rounded-full bg-neutral-300 dark:bg-neutral-700"></span>
                                <span class="flex items-center gap-1 max-w-[120px] truncate">
                                    <MapPin class="size-3.5 text-indigo-600/70 dark:text-indigo-400/70 shrink-0" />
                                    {{ ev.location }}
                                </span>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-base font-extrabold text-neutral-900 dark:text-white leading-snug line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ ev.title }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 line-clamp-2 leading-relaxed font-normal">
                                {{ ev.description }}
                            </p>
                        </div>
                        
                        <!-- Divider and Read More -->
                        <div class="border-t border-neutral-100 dark:border-neutral-800/60 w-full pt-4 mt-5 flex items-center justify-between">
                            <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 group-hover:text-indigo-700 dark:group-hover:text-indigo-300 flex items-center gap-1 transition-colors">
                                Leer más detalles
                                <ChevronRight class="size-3.5" />
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity proposal banner -->
            <div class="mt-20 p-8 rounded-3xl bg-gradient-to-br from-[#00004d] to-indigo-950 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6 text-left">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(99,102,241,0.15),transparent_40%)]"></div>
                <div class="space-y-2 relative z-10 max-w-2xl">
                    <div class="inline-flex items-center gap-1.5 text-xs text-amber-300 font-bold uppercase tracking-wider">
                        <Sparkles class="size-4" />
                        Propuestas Culturales y Sociales
                    </div>
                    <h3 class="text-xl md:text-2xl font-extrabold tracking-tight">¿Deseas proponer una campaña o ciclo cultural?</h3>
                    <p class="text-xs md:text-sm text-white/80 leading-relaxed">
                        Coordinamos con las 35 escuelas profesionales y grupos estudiantiles organizados de la UNA Puno. Envíanos tu plan o idea de proyección social para incluirlo en nuestra agenda oficial.
                    </p>
                </div>
                <div class="relative z-10 shrink-0">
                    <a href="mailto:proyeccionsocial@unap.edu.pe">
                        <Button class="rounded-xl bg-white hover:bg-neutral-100 text-indigo-950 font-bold text-xs flex items-center gap-1.5 px-6 py-5 cursor-pointer">
                            <Mail class="size-4" />
                            Enviar Propuesta
                        </Button>
                    </a>
                </div>
            </div>

        </section>

        <!-- BEAUTIFUL RESPONSIVE MODAL FOR EVENT DETAILS -->
        <Transition name="modal">
            <div 
                v-if="isModalOpen && selectedEvent" 
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-md p-4"
                @click.self="closeEventModal"
            >
                <!-- Modal Panel -->
                <div class="relative w-full max-w-3xl bg-white dark:bg-neutral-900 rounded-3xl overflow-hidden shadow-2xl border border-neutral-200 dark:border-neutral-800 flex flex-col md:flex-row h-auto max-h-[90vh] md:h-[500px] text-left transform transition-all duration-300">
                    
                    <div class="grid grid-cols-1 md:grid-cols-12 w-full h-full">
                        <!-- Left side: Image -->
                        <div class="md:col-span-5 relative h-[180px] sm:h-[220px] md:h-full overflow-hidden bg-neutral-100 dark:bg-neutral-950 shrink-0">
                            <img :src="selectedEvent.image" :alt="selectedEvent.title" class="w-full h-full object-cover" />
                            <div class="absolute top-4 left-4">
                                <span class="text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-indigo-600 text-white shadow-md">
                                    {{ selectedEvent.type }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Right side: Details -->
                        <div class="md:col-span-7 p-6 md:p-8 flex flex-col justify-between h-full overflow-y-auto max-h-[calc(90vh-180px)] sm:max-h-[calc(90vh-220px)] md:max-h-full">
                            <div class="space-y-4">
                                <!-- Header with status and Close button -->
                                <div class="flex items-center justify-between">
                                    <span 
                                        class="text-[10px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded-md"
                                        :class="{
                                            'bg-indigo-50 text-indigo-600 dark:bg-indigo-950/40 dark:text-indigo-400': selectedEvent.status === 'Proximos',
                                            'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400': selectedEvent.status === 'EnCurso',
                                            'bg-neutral-100 text-neutral-500 dark:bg-neutral-800 dark:text-neutral-400': selectedEvent.status === 'Pasados'
                                        }"
                                    >
                                        {{ selectedEvent.status === 'Proximos' ? 'Próximo' : selectedEvent.status === 'EnCurso' ? 'En Curso' : 'Finalizado' }}
                                    </span>
                                    
                                    <!-- Close Button -->
                                    <button 
                                        @click="closeEventModal" 
                                        class="size-8 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 flex items-center justify-center hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors cursor-pointer"
                                    >
                                        <X class="size-4" />
                                    </button>
                                </div>

                                <!-- Title -->
                                <h2 class="text-base sm:text-lg md:text-xl font-black text-neutral-900 dark:text-white leading-tight">
                                    {{ selectedEvent.title }}
                                </h2>

                                <!-- Organizer -->
                                <div class="flex flex-wrap items-center gap-1 text-[11px] sm:text-xs text-neutral-400">
                                    <span class="font-bold text-neutral-600 dark:text-neutral-300">Organiza:</span>
                                    <span>{{ selectedEvent.organizer }}</span>
                                </div>

                                <!-- Divider -->
                                <div class="border-t border-neutral-100 dark:border-neutral-800"></div>

                                <!-- Meta Grid (2 cols) -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                    <div class="flex items-center gap-2 text-neutral-600 dark:text-neutral-300">
                                        <Calendar class="size-4 text-indigo-600 dark:text-indigo-400 shrink-0" />
                                        <span class="font-semibold">{{ selectedEvent.date }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-neutral-600 dark:text-neutral-300">
                                        <Clock class="size-4 text-indigo-600 dark:text-indigo-400 shrink-0" />
                                        <span>{{ selectedEvent.time }}</span>
                                    </div>
                                    <div class="flex items-start gap-2 text-neutral-600 dark:text-neutral-300 sm:col-span-2">
                                        <MapPin class="size-4 text-red-500 shrink-0 mt-0.5" />
                                        <span class="leading-tight">{{ selectedEvent.location }}</span>
                                    </div>
                                </div>

                                <!-- Divider -->
                                <div class="border-t border-neutral-100 dark:border-neutral-800"></div>

                                <!-- Description -->
                                <div class="space-y-1.5">
                                    <h4 class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider">Detalles del Evento</h4>
                                    <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed">
                                        {{ selectedEvent.description }}
                                    </p>
                                </div>
                            </div>

                            <!-- Footer Actions -->
                            <div class="border-t border-neutral-100 dark:border-neutral-800/80 pt-4 mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <a 
                                    v-if="selectedEvent.status !== 'Pasados'"
                                    :href="selectedEvent.fbLink"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-full sm:w-auto"
                                    @click.stop
                                >
                                    <Button size="sm" class="w-full sm:w-auto rounded-xl bg-indigo-700 hover:bg-indigo-800 text-white text-xs font-semibold flex items-center justify-center gap-1.5 cursor-pointer">
                                        <UserCheck class="size-3.5" />
                                        Inscribirse/Participar
                                    </Button>
                                </a>
                                <span v-else class="text-xs bg-neutral-100 dark:bg-neutral-800 text-neutral-500 px-4 py-1.5 rounded-lg font-semibold uppercase tracking-wider w-full sm:w-auto text-center">
                                    Finalizado
                                </span>

                                <a 
                                    :href="selectedEvent.fbLink" 
                                    target="_blank" 
                                    class="text-xs text-neutral-400 hover:text-blue-500 transition-colors flex items-center gap-1"
                                    @click.stop
                                >
                                    <svg class="size-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1V12h3l-.5 3h-2.5v6.8c4.56-.93 8-4.96 8-9.8z"/>
                                    </svg>
                                    Ver en Facebook
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </Transition>

    </PublicLayout>
</template>

<style scoped>
/* Modal Transition Animations */
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.3s ease;
}
.modal-enter-from, .modal-leave-to {
  opacity: 0;
}
.modal-enter-active .relative, .modal-leave-active .relative {
  transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
}
.modal-enter-from .relative, .modal-leave-to .relative {
  transform: scale(0.92) translateY(20px);
  opacity: 0;
}
</style>
