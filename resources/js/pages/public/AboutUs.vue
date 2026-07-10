<script setup lang="ts">
import { 
    Users, 
    Heart, 
    Lightbulb, 
    ShieldCheck, 
    Flame, 
    Building2, 
    TrendingUp, 
    Scale, 
    UsersRound,
    Leaf
} from '@lucide/vue';
import { onMounted } from 'vue';
import { Card, CardTitle } from '@/components/ui/card';
import PublicLayout from '@/layouts/PublicLayout.vue';

// Team members list
const team = [
    {
        name: 'Dra. Milder Zanabria Ortega',
        role: 'Directora',
        department: 'Dirección de Proyección Social y Extensión Cultural',
        initials: 'MZ',
        image: 'https://cdn.phototourl.com/free/2026-07-08-0148c525-1fa2-46ce-8343-d43e2fd7c5ca.png',
        textColor: 'text-indigo-600 dark:text-indigo-400',
        bgLight: 'bg-indigo-50 dark:bg-indigo-950/20',
        // Hover custom variables: Verde medio degradado
        glowStart: 'rgba(68, 165, 76, 0.3)',
        glowEnd: 'rgba(152, 209, 43, 0.1)',
        glowHoverStart: 'rgba(68, 165, 76, 0.6)',
        glowHoverEnd: 'rgba(152, 209, 43, 0.3)',
        glowShadow: 'rgba(68, 165, 76, 0.05)',
        glowShadowHover: 'rgba(68, 165, 76, 0.15)',
        glowBorderHover: 'rgba(181, 228, 86, 0.5)',
        glowRing: 'rgba(68, 165, 76, 0.4)',
        glowRingPulse: 'rgba(68, 165, 76, 0.35)',
        bottomBgLight: 'rgba(244, 249, 244, 0.88)',
        bottomBgDark: 'rgba(8, 22, 10, 0.90)'
    },
    {
        name: 'M.Sc. Wilkerson Palza Meza',
        role: 'Jefe de Sub Unidad',
        department: 'Sub Unidad de Proyección Social y Extensión Universitaria',
        initials: 'WP',
        image: 'https://cdn.phototourl.com/free/2026-07-09-8662ddab-51eb-4547-91ce-de75938f1053.png',
        textColor: 'text-indigo-600 dark:text-indigo-400',
        bgLight: 'bg-indigo-50 dark:bg-indigo-950/20',
        // Hover custom variables: Verde medio degradado
        glowStart: 'rgba(68, 165, 76, 0.3)',
        glowEnd: 'rgba(152, 209, 43, 0.1)',
        glowHoverStart: 'rgba(68, 165, 76, 0.6)',
        glowHoverEnd: 'rgba(152, 209, 43, 0.3)',
        glowShadow: 'rgba(68, 165, 76, 0.05)',
        glowShadowHover: 'rgba(68, 165, 76, 0.15)',
        glowBorderHover: 'rgba(181, 228, 86, 0.5)',
        glowRing: 'rgba(68, 165, 76, 0.4)',
        glowRingPulse: 'rgba(68, 165, 76, 0.35)',
        bottomBgLight: 'rgba(244, 249, 244, 0.88)',
        bottomBgDark: 'rgba(8, 22, 10, 0.90)'
    },
    {
        name: 'Ing. Yumy Romero Talavera',
        role: 'Jefa de Sub Unidad',
        department: 'Sub Unidad de Seguimiento y Desarrollo del Graduado',
        initials: 'YR',
        image: 'https://cdn.phototourl.com/free/2026-07-09-a6257f35-bbb0-483f-909e-18f184a22061.png',
        textColor: 'text-indigo-600 dark:text-indigo-400',
        bgLight: 'bg-indigo-50 dark:bg-indigo-950/20',
        // Hover custom variables: Verde medio degradado
        glowStart: 'rgba(68, 165, 76, 0.3)',
        glowEnd: 'rgba(152, 209, 43, 0.1)',
        glowHoverStart: 'rgba(68, 165, 76, 0.6)',
        glowHoverEnd: 'rgba(152, 209, 43, 0.3)',
        glowShadow: 'rgba(68, 165, 76, 0.05)',
        glowShadowHover: 'rgba(68, 165, 76, 0.15)',
        glowBorderHover: 'rgba(181, 228, 86, 0.5)',
        glowRing: 'rgba(68, 165, 76, 0.4)',
        glowRingPulse: 'rgba(68, 165, 76, 0.35)',
        bottomBgLight: 'rgba(244, 249, 244, 0.88)',
        bottomBgDark: 'rgba(8, 22, 10, 0.90)'
    },
    {
        name: 'M.Sc. Marco Vera Zuñiga',
        role: 'Jefe de Sub Unidad',
        department: 'Sub Unidad de Gestión Ambiental',
        initials: 'MV',
        image: 'https://cdn.phototourl.com/free/2026-07-08-5a3b67b1-4af0-4dcb-9f3f-b6b2d73858dc.png',
        textColor: 'text-indigo-600 dark:text-indigo-400',
        bgLight: 'bg-indigo-50 dark:bg-indigo-950/20',
        // Hover custom variables: Verde medio degradado
        glowStart: 'rgba(68, 165, 76, 0.3)',
        glowEnd: 'rgba(152, 209, 43, 0.1)',
        glowHoverStart: 'rgba(68, 165, 76, 0.6)',
        glowHoverEnd: 'rgba(152, 209, 43, 0.3)',
        glowShadow: 'rgba(68, 165, 76, 0.05)',
        glowShadowHover: 'rgba(68, 165, 76, 0.15)',
        glowBorderHover: 'rgba(181, 228, 86, 0.5)',
        glowRing: 'rgba(68, 165, 76, 0.4)',
        glowRingPulse: 'rgba(68, 165, 76, 0.35)',
        bottomBgLight: 'rgba(244, 249, 244, 0.88)',
        bottomBgDark: 'rgba(8, 22, 10, 0.90)'
    }
];

// Strategic Objectives list
const objectives = [
    {
        title: 'Fortalecimiento Institucional',
        description: 'Consolidar nuestra organización como referente en el sector, con procesos eficientes y un equipo altamente capacitado.',
        icon: Building2,
        color: 'text-indigo-600 dark:text-indigo-400 bg-indigo-500/10'
    },
    {
        title: 'Impacto Social Ampliado',
        description: 'Incrementar nuestro alcance beneficiando a un 30% más de personas en los próximos 5 años.',
        icon: TrendingUp,
        color: 'text-blue-600 dark:text-blue-400 bg-blue-500/10'
    },
    {
        title: 'Innovación Continua',
        description: 'Desarrollar al menos 3 nuevos programas innovadores anuales que respondan a necesidades emergentes.',
        icon: Lightbulb,
        color: 'text-amber-500 dark:text-amber-400 bg-amber-500/10'
    },
    {
        title: 'Sostenibilidad Financiera',
        description: 'Diversificar nuestras fuentes de financiamiento para garantizar la continuidad de nuestros proyectos.',
        icon: Scale,
        color: 'text-emerald-600 dark:text-emerald-400 bg-emerald-500/10'
    },
    {
        title: 'Alianzas Estratégicas',
        description: 'Establecer colaboraciones con al menos 10 nuevas organizaciones afines en los próximos 3 años.',
        icon: UsersRound,
        color: 'text-purple-600 dark:text-purple-400 bg-purple-500/10'
    }
];

// Values list
const values = [
    {
        title: 'Compromiso',
        description: 'Nos dedicamos plenamente a nuestra misión y a las comunidades que servimos.',
        icon: Heart,
        glowBg: 'bg-rose-500',
        iconContainerClass: 'bg-rose-500/10 text-rose-600 dark:text-rose-400 dark:bg-rose-500/20',
        accentLine: 'bg-rose-500'
    },
    {
        title: 'Innovación',
        description: 'Buscamos constantemente nuevas soluciones a los desafíos sociales.',
        icon: Lightbulb,
        glowBg: 'bg-amber-500',
        iconContainerClass: 'bg-amber-500/10 text-amber-600 dark:text-amber-400 dark:bg-amber-500/20',
        accentLine: 'bg-amber-500'
    },
    {
        title: 'Trabajo en Equipo',
        description: 'Creemos en el poder de la colaboración y el esfuerzo colectivo.',
        icon: Users,
        glowBg: 'bg-blue-500',
        iconContainerClass: 'bg-blue-500/10 text-blue-600 dark:text-blue-400 dark:bg-blue-500/20',
        accentLine: 'bg-blue-500'
    },
    {
        title: 'Integridad',
        description: 'Actuamos con transparencia y ética en todas nuestras acciones.',
        icon: ShieldCheck,
        glowBg: 'bg-emerald-500',
        iconContainerClass: 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 dark:bg-emerald-500/20',
        accentLine: 'bg-emerald-500'
    },
    {
        title: 'Pasión',
        description: 'Nos apasiona nuestro trabajo y el impacto que generamos.',
        icon: Flame,
        glowBg: 'bg-orange-500',
        iconContainerClass: 'bg-orange-500/10 text-orange-600 dark:text-orange-400 dark:bg-orange-500/20',
        accentLine: 'bg-orange-500'
    },
    {
        title: 'Sostenibilidad',
        description: 'Trabajamos por soluciones que perduren en el tiempo.',
        icon: Leaf,
        glowBg: 'bg-teal-500',
        iconContainerClass: 'bg-teal-500/10 text-teal-600 dark:text-teal-400 dark:bg-teal-500/20',
        accentLine: 'bg-teal-500'
    }
];

// Scroll Reveal Intersection Observer
onMounted(() => {
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
</script>

<template>
    <PublicLayout title="Nosotros">
        <!-- 1. HERO SECTION -->
        <section 
            class="relative h-[45vh] min-h-[260px] flex items-center overflow-hidden bg-cover bg-center text-white"
            style="background-image: url('https://scontent.fjul1-1.fna.fbcdn.net/v/t39.30808-6/536276174_796288509419050_1500971593146748128_n.jpg?stp=dst-jpg_tt6&cstp=mx2048x1365&ctp=s2048x1365&_nc_cat=106&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeEZ0QOsNIB00jHh4bUAb0thSrljtwlEgXZKuWO3CUSBds7SYH_gDYG_0R2VfGo0vFaQf8RVyKkB9FtnY9Rq_1wD&_nc_ohc=ousF8M3j-KEQ7kNvwEDqhrC&_nc_oc=AdrHhbppRZWmAUI6au-ONJdpC2udbx2Axnhkbn2bDEK_YdRSf-zfh_iZf5VtXp4shA0&_nc_zt=23&_nc_ht=scontent.fjul1-1.fna&_nc_gid=sPmAI6QRXx3MzuPa6kS7Uw&_nc_ss=7b2a8&oh=00_AQDNODsPpOywvQ6UFtqDPnT4bEqSxVMpLRtrX-Dgrwj87A&oe=6A548E80');"
        >
            <!-- Gradient Overlay for readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/90 via-neutral-950/70 to-transparent z-10"></div>
            
            <div class="max-w-7xl mx-auto w-full px-6 lg:px-8 text-left relative z-20 space-y-3">
                <span class="text-xs font-bold uppercase tracking-widest text-blue-400">¿Quiénes Somos?</span>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Nosotros</h1>
                <p class="text-xs md:text-sm text-white/80 max-w-3xl leading-relaxed">
                    Conoce la misión, los valores y el equipo de profesionales que lidera la Dirección de Proyección Social y Extensión Cultural en su compromiso de vincular a la Universidad Nacional del Altiplano con el desarrollo de la región.
                </p>
            </div>
        </section>

        <!-- 2. MISSION SECTION -->
        <section class="reveal-section py-20 lg:py-28 max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Details -->
                <div class="lg:col-span-5 space-y-6 text-left">
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Propósito Institucional</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Nuestra Misión</h2>
                    <div class="w-12 h-1.5 bg-indigo-600 dark:bg-indigo-400 rounded-full"></div>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm md:text-base leading-relaxed">
                        Definimos el norte de nuestro trabajo en base a la responsabilidad social universitaria, promoviendo el desarrollo de capacidades humanas en estrecha relación con las comunidades locales y la herencia cultural altiplánica.
                    </p>
                </div>

                <!-- Right Quote Box -->
                <div class="lg:col-span-7">
                    <div class="relative p-8 md:p-12 rounded-3xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200/60 dark:border-neutral-800 text-left overflow-hidden shadow-xs">
                        <div class="absolute -top-10 -left-6 text-neutral-200/40 dark:text-neutral-800/30 text-[180px] font-serif leading-none select-none">“</div>
                        
                        <blockquote class="relative z-10">
                            <p class="text-lg md:text-xl font-medium text-neutral-800 dark:text-neutral-100 leading-relaxed italic">
                                Formar profesionales y posgraduados competitivos, con capacidad de investigación, emprendimiento, la responsabilidad social e identidad cultural para contribuir al desarrollo humano y desarrollo sostenible de la región y del país.
                            </p>
                        </blockquote>
                        
                        <div class="mt-6 flex items-center gap-3">
                            <div class="h-px w-8 bg-neutral-300 dark:bg-neutral-700"></div>
                            <span class="text-xs font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500">
                                Estatuto UNA Puno
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 3. TEAM SECTION -->
        <section class="reveal-section py-20 bg-neutral-50/50 dark:bg-neutral-900/10 border-y border-neutral-200/55 dark:border-neutral-800/40">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-16">
                
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Liderazgo y Gestión</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Nuestro Equipo</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">
                        Contamos con un equipo multidisciplinario de profesionales apasionados por el cambio social, comprometidos con nuestros valores y enfocados en lograr resultados transformadores.
                    </p>
                </div>

                <!-- Team Layout (Director at top, others below) -->
                <div class="space-y-12 flex flex-col items-center">
                    
                    <!-- Director Card (Top Row, Centered and Prominent) -->
                    <div class="flex justify-center w-full">
                        <div 
                            class="team-card"
                            :style="{
                                '--glow-start': team[0].glowStart,
                                '--glow-end': team[0].glowEnd,
                                '--glow-hover-start': team[0].glowHoverStart,
                                '--glow-hover-end': team[0].glowHoverEnd,
                                '--glow-shadow': team[0].glowShadow,
                                '--glow-shadow-hover': team[0].glowShadowHover,
                                '--glow-border-hover': team[0].glowBorderHover,
                                '--glow-ring': team[0].glowRing,
                                '--glow-ring-pulse': team[0].glowRingPulse,
                                '--bottom-bg-light': team[0].bottomBgLight,
                                '--bottom-bg-dark': team[0].bottomBgDark
                            }"
                        >
                            <div class="card-top">
                                <div class="avatar">
                                    <span class="avatar-ring"></span>
                                    <img 
                                        :src="team[0].image" 
                                        :alt="team[0].name" 
                                        class="avatar-image" 
                                    />
                                </div>
                            </div>
                            <div class="card-bottom">
                                <h3 class="name">{{ team[0].name }}</h3>
                                <div class="inline-flex px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold mt-0.5 mb-1.5" :class="[team[0].textColor, team[0].bgLight]">
                                    {{ team[0].role }}
                                </div>
                                <div class="w-[85%] border-t border-neutral-200/50 dark:border-neutral-800 my-1"></div>
                                <p class="subunit">{{ team[0].department }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Subunits Grid (3 Columns) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-12 justify-items-center w-full max-w-5xl">
                        <div 
                            v-for="member in team.slice(1)" 
                            :key="member.name" 
                            class="team-card"
                            :style="{
                                '--glow-start': member.glowStart,
                                '--glow-end': member.glowEnd,
                                '--glow-hover-start': member.glowHoverStart,
                                '--glow-hover-end': member.glowHoverEnd,
                                '--glow-shadow': member.glowShadow,
                                '--glow-shadow-hover': member.glowShadowHover,
                                '--glow-border-hover': member.glowBorderHover,
                                '--glow-ring': member.glowRing,
                                '--glow-ring-pulse': member.glowRingPulse,
                                '--bottom-bg-light': member.bottomBgLight,
                                '--bottom-bg-dark': member.bottomBgDark
                            }"
                        >
                            <div class="card-top">
                                <div class="avatar">
                                    <span class="avatar-ring"></span>
                                    <img 
                                        :src="member.image" 
                                        :alt="member.name" 
                                        class="avatar-image" 
                                    />
                                </div>
                            </div>
                            <div class="card-bottom">
                                <h3 class="name">{{ member.name }}</h3>
                                <div class="inline-flex px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold mt-0.5 mb-1.5" :class="[member.textColor, member.bgLight]">
                                    {{ member.role }}
                                </div>
                                <div class="w-[85%] border-t border-neutral-200/50 dark:border-neutral-800 my-1"></div>
                                <p class="subunit">{{ member.department }}</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 4. STRATEGIC OBJECTIVES SECTION -->
        <section class="reveal-section py-20 lg:py-28 max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Left Sticky Header -->
                <div class="lg:col-span-4 lg:sticky lg:top-28 text-left space-y-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Plan de Desarrollo</span>
                    <h2 class="text-3xl font-extrabold tracking-tight">Objetivos Estratégicos</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">
                        Trazamos metas específicas a corto y mediano plazo para garantizar que nuestra labor tenga un impacto medible, estructurado y sostenible en la sociedad puneña.
                    </p>
                </div>

                <!-- Right Objectives List -->
                <div class="lg:col-span-8 space-y-6">
                    <Card v-for="(obj, index) in objectives" :key="obj.title" class="overflow-hidden border border-neutral-200/80 dark:border-neutral-800/80 bg-white dark:bg-neutral-900/60 rounded-2xl flex items-start gap-5 p-6 text-left shadow-xs hover:border-neutral-300 dark:hover:border-neutral-700 transition-colors">
                        <div class="p-3.5 rounded-xl shrink-0" :class="obj.color">
                            <component :is="obj.icon" class="size-6" />
                        </div>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">Objetivo 0{{ index + 1 }}</span>
                            </div>
                            <CardTitle class="text-base font-extrabold text-neutral-900 dark:text-white">{{ obj.title }}</CardTitle>
                            <p class="text-xs md:text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">{{ obj.description }}</p>
                        </div>
                    </Card>
                </div>

            </div>
        </section>

        <!-- 5. VALUES SECTION -->
        <section class="reveal-section py-20 bg-neutral-50/50 dark:bg-neutral-900/10 border-t border-neutral-200/55 dark:border-neutral-800/40">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-16">
                
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Filosofía de Trabajo</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Valores Institucionales</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">
                        Nuestra cultura organizacional se cimenta sobre principios éticos que guían cada proyecto, voluntariado y expresión cultural.
                    </p>
                </div>

                <!-- Values Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div 
                        v-for="(val, index) in values" 
                        :key="val.title" 
                        class="group relative overflow-hidden p-8 rounded-3xl border border-neutral-200/60 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-2 flex flex-col justify-between text-left h-[260px]"
                    >
                        <!-- Background Light Glow (Hover effect) -->
                        <div class="absolute -right-16 -top-16 size-36 rounded-full blur-3xl opacity-20 group-hover:opacity-45 transition-opacity duration-500" :class="val.glowBg"></div>
                        
                        <!-- Large Transparent Background Number -->
                        <div class="absolute right-6 bottom-4 text-7xl font-black text-neutral-100 dark:text-neutral-800/10 select-none group-hover:scale-110 group-hover:text-neutral-200/30 dark:group-hover:text-neutral-800/25 transition-all duration-500">
                            0{{ index + 1 }}
                        </div>

                        <div class="relative z-10 space-y-6">
                            <!-- Icon with colorful bubble background -->
                            <div class="inline-flex size-14 rounded-2xl items-center justify-center shadow-md transition-transform duration-500 group-hover:rotate-12" :class="val.iconContainerClass">
                                <component :is="val.icon" class="size-7" />
                            </div>

                            <!-- Content -->
                            <div class="space-y-3">
                                <h3 class="font-extrabold text-xl text-neutral-900 dark:text-white leading-tight">
                                    {{ val.title }}
                                </h3>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed max-w-[85%]">
                                    {{ val.description }}
                                </p>
                            </div>
                        </div>

                        <!-- Decorative Bottom Color Accent Line -->
                        <div class="absolute bottom-0 left-0 h-1.5 w-0 group-hover:w-full transition-all duration-500" :class="val.accentLine"></div>
                    </div>
                </div>

            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
/* Scroll Reveal animation for about sections */
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

/* ===== CARDS DE EQUIPO PREMIUM (ESTILO DE SANDBOX - PURPLE EDITION) ===== */
.team-card {
  position: relative;
  width: 270px;
  height: 380px;
  border-radius: 28px;
  background: rgba(255, 255, 255, 0.45);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.7);
  box-shadow: 0 15px 35px var(--glow-shadow, rgba(99, 102, 241, 0.05));
  overflow: hidden;
  transform-style: preserve-3d;
  perspective: 800px;
  transition: transform 0.45s cubic-bezier(0.175, 0.885, 0.32, 1.275),
              box-shadow 0.45s ease,
              border-color 0.45s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  z-index: 10;
}

.dark .team-card {
  background: rgba(24, 24, 27, 0.45);
  border: 1px solid rgba(255, 255, 255, 0.08);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}

.team-card:hover {
  transform: translateY(-14px) scale(1.02) rotateX(2deg);
  box-shadow: 0 30px 50px var(--glow-shadow-hover, rgba(99, 102, 241, 0.15)), 0 0 30px var(--glow-shadow, rgba(99, 102, 241, 0.08));
}

.card-top {
  display: flex;
  justify-content: center;
  padding-top: 25px;
  width: 100%;
  flex-shrink: 0;
  z-index: 1;
}

.avatar {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-end;
  height: 220px;
  width: 100%;
  animation: floatIdle 4.5s ease-in-out infinite;
}

.avatar-image {
  position: relative;
  height: 100%;
  width: auto;
  max-width: 260px;
  object-fit: contain;
  object-position: bottom;
  z-index: 2;
  transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  filter: drop-shadow(0 15px 20px var(--glow-shadow, rgba(99, 102, 241, 0.12)));
}

.team-card:hover .avatar-image {
  transform: scale(1.08) translateY(-5px);
}

.avatar-ring {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  border: 2px solid var(--glow-ring, rgba(99, 102, 241, 0.4));
  opacity: 0;
  transform: translate(-50%, -50%) scale(0.8);
  transition: opacity 0.35s ease, transform 0.35s ease;
  z-index: 1;
}

.team-card:hover .avatar-ring {
  opacity: 1;
  transform: translate(-50%, -50%) scale(1);
  animation: pulseRing 1.8s ease-out infinite;
}

/* Barra Inferior */
.card-bottom {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 150px; 
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), var(--bottom-bg-light, rgba(238, 242, 255, 0.88)));
  backdrop-filter: blur(30px);
  -webkit-backdrop-filter: blur(30px);
  border-top: 1.5px solid rgba(255, 255, 255, 1);
  border-radius: 0px 0px 28px 28px;
  box-shadow: 0 -10px 30px var(--glow-shadow, rgba(99, 102, 241, 0.04));
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 0 20px; 
  padding-bottom: 10px; 
  box-sizing: border-box;
  transition: background 0.3s ease;
  z-index: 3;
}

.dark .card-bottom {
  background: linear-gradient(135deg, rgba(24, 24, 27, 0.95), var(--bottom-bg-dark, rgba(15, 23, 42, 0.90)));
  border-top: 1.5px solid rgba(255, 255, 255, 0.08);
}

.name {
  margin: 0 0 6px 0;
  font-size: 1.15rem; 
  font-weight: 700;
  color: #0f172a;
  letter-spacing: -0.3px;
  line-height: 1.2;
  transition: transform 0.3s ease;
}

.dark .name {
  color: #f1f5f9;
}

.team-card:hover .name {
  transform: translateY(-2px);
}

.role {
  margin: 0;
  font-size: 0.72rem;
  font-weight: 850;
  text-transform: uppercase;
  letter-spacing: 0.4px;
  box-sizing: border-box;
}

.subunit {
  margin: 0;
  font-size: 0.72rem;
  font-weight: 500;
  color: #71717a; 
  line-height: 1.3;
  max-width: 90%; 
}

.dark .subunit {
  color: #a1a1aa;
}

@keyframes floatIdle {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}

@keyframes pulseRing {
  0% { box-shadow: 0 0 0 0 var(--glow-ring-pulse, rgba(99, 102, 241, 0.35)); }
  100% { box-shadow: 0 0 0 16px rgba(99, 102, 241, 0); }
}
</style>
