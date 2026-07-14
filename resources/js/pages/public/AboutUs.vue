<script setup lang="ts">
import { onMounted } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { iconMap } from '@/lib/iconMap';

interface TeamItem {
    id: number;
    name: string;
    role: string;
    department: string;
    initials: string;
    image_path: string;
}

interface ObjectiveItem {
    id: number;
    title: string;
    description: string;
    icon_name: string;
    color_class: string;
}

interface ValueItem {
    id: number;
    title: string;
    description: string;
    icon_name: string;
    glow_bg_class: string;
    icon_container_class: string;
    accent_line_class: string;
}

interface SectionItem {
    eyebrow?: string;
    title?: string;
    description?: string;
    background_image?: string;
    extra_data?: any;
}

defineProps<{
    team: TeamItem[];
    objectives: ObjectiveItem[];
    values: ValueItem[];
    sections: Record<string, SectionItem>;
}>();

// Styling config constants for Team members (Verde medio degradado)
const glowProps = {
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
};

const getObjectiveStyle = (index: number) => {
    const positions = [
        { top: '6%', left: '50%' },
        { top: '35%', left: '83%' },
        { top: '82%', left: '72%' },
        { top: '82%', left: '28%' },
        { top: '35%', left: '17%' }
    ];

    return {
        top: positions[index] ? positions[index].top : '0%',
        left: positions[index] ? positions[index].left : '0%',
        transform: 'translate(-50%, -50%)'
    };
};

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
            :style="sections.hero?.background_image ? { backgroundImage: `url(${sections.hero.background_image})` } : {}"
        >
            <!-- Gradient Overlay for readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/90 via-neutral-950/70 to-transparent z-10"></div>
            
            <div class="max-w-7xl mx-auto w-full px-6 lg:px-8 text-left relative z-20 space-y-3">
                <span class="text-xs font-bold uppercase tracking-widest text-blue-400">{{ sections.hero?.eyebrow ?? '¿Quiénes Somos?' }}</span>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">{{ sections.hero?.title ?? 'Nosotros' }}</h1>
                <p class="text-xs md:text-sm text-white/80 max-w-3xl leading-relaxed">
                    {{ sections.hero?.description ?? 'Conoce la misión, los valores y el equipo de profesionales que lidera la Dirección de Proyección Social y Extensión Cultural en su compromiso de vincular a la Universidad Nacional del Altiplano con el desarrollo de la región.' }}
                </p>
            </div>
        </section>

        <!-- 2. MISSION SECTION -->
        <section class="reveal-section py-20 lg:py-28 max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Details -->
                <div class="lg:col-span-5 space-y-6 text-left">
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">{{ sections.mission?.eyebrow ?? 'Propósito Institucional' }}</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">{{ sections.mission?.title ?? 'Nuestra Misión' }}</h2>
                    <div class="w-12 h-1.5 bg-indigo-600 dark:bg-indigo-400 rounded-full"></div>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm md:text-base leading-relaxed">
                        {{ sections.mission?.description ?? 'Definimos el norte de nuestro trabajo en base a la responsabilidad social universitaria, promoviendo el desarrollo de capacidades humanas en estrecha relación con las comunidades locales y la herencia cultural altiplánica.' }}
                    </p>
                </div>

                <!-- Right Quote Box -->
                <div class="lg:col-span-7">
                    <div class="relative p-8 md:p-12 rounded-3xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200/60 dark:border-neutral-800 text-left overflow-hidden shadow-xs">
                        <div class="absolute -top-10 -left-6 text-neutral-200/40 dark:text-neutral-800/30 text-[180px] font-serif leading-none select-none">“</div>
                        
                        <blockquote class="relative z-10">
                            <p class="text-lg md:text-xl font-medium text-neutral-800 dark:text-neutral-100 leading-relaxed italic">
                                {{ sections.mission?.extra_data?.blockquote ?? 'Formar profesionales y posgraduados competitivos, con capacidad de investigación, emprendimiento, la responsabilidad social e identidad cultural para contribuir al desarrollo humano y desarrollo sostenible de la región y del país.' }}
                            </p>
                        </blockquote>
                        
                        <div class="mt-6 flex items-center gap-3">
                            <div class="h-px w-8 bg-neutral-300 dark:bg-neutral-700"></div>
                            <span class="text-xs font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500">
                                {{ sections.mission?.extra_data?.attribution ?? 'Estatuto UNA Puno' }}
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
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">{{ sections.team_intro?.eyebrow ?? 'Liderazgo y Gestión' }}</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">{{ sections.team_intro?.title ?? 'Nuestro Equipo' }}</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">
                        {{ sections.team_intro?.description ?? 'Contamos con un equipo multidisciplinario de profesionales apasionados por el cambio social, comprometidos con nuestros valores y enfocados en lograr resultados transformadores.' }}
                    </p>
                </div>

                <!-- Team Layout (Director at top, others below) -->
                <div class="space-y-12 flex flex-col items-center">
                    
                    <!-- Director Card (Top Row, Centered and Prominent) -->
                    <div v-if="team.length > 0" class="flex justify-center w-full">
                        <div 
                            class="team-card"
                            :style="{
                                '--glow-start': glowProps.glowStart,
                                '--glow-end': glowProps.glowEnd,
                                '--glow-hover-start': glowProps.glowHoverStart,
                                '--glow-hover-end': glowProps.glowHoverEnd,
                                '--glow-shadow': glowProps.glowShadow,
                                '--glow-shadow-hover': glowProps.glowShadowHover,
                                '--glow-border-hover': glowProps.glowBorderHover,
                                '--glow-ring': glowProps.glowRing,
                                '--glow-ring-pulse': glowProps.glowRingPulse,
                                '--bottom-bg-light': glowProps.bottomBgLight,
                                '--bottom-bg-dark': glowProps.bottomBgDark
                            }"
                        >
                            <div class="card-top">
                                <div class="avatar">
                                    <img 
                                        :src="team[0].image_path" 
                                        :alt="team[0].name" 
                                        class="avatar-image" 
                                    />
                                </div>
                            </div>
                            <div class="card-bottom">
                                <h3 class="name">{{ team[0].name }}</h3>
                                <div class="inline-flex px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold mt-0.5 mb-1.5 text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/20">
                                    {{ team[0].role }}
                                </div>
                                <div class="w-[85%] border-t border-neutral-200/50 dark:border-neutral-800 my-1"></div>
                                <p class="subunit">{{ team[0].department }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Organigrama Connectors (Visible only on md screens and up) -->
                    <div class="hidden md:flex flex-col items-center w-full max-w-5xl relative h-16 z-0 opacity-40 hover:opacity-70 transition-opacity duration-500 animate-[pulse_8s_cubic-bezier(0.4,0,0.6,1)_infinite]">
                        <!-- Line going down from Director's Card -->
                        <div class="w-[2px] h-8 bg-gradient-to-b from-indigo-500 to-indigo-500/40 dark:from-indigo-400 dark:to-indigo-400/40"></div>
                        <!-- Horizontal connection bar stretching from left card center to right card center -->
                        <div class="absolute top-8 left-[16.67%] right-[16.67%] h-[2px] bg-gradient-to-r from-transparent via-indigo-500 to-transparent dark:via-indigo-400"></div>
                        
                        <!-- Connecting lines going down to each Subunit -->
                        <div class="absolute top-8 left-[16.67%] w-[2px] h-8 bg-gradient-to-b from-indigo-500 to-transparent dark:from-indigo-400"></div>
                        <div class="absolute top-8 left-1/2 -translate-x-1/2 w-[2px] h-8 bg-gradient-to-b from-indigo-500 to-transparent dark:from-indigo-400"></div>
                        <div class="absolute top-8 right-[16.67%] w-[2px] h-8 bg-gradient-to-b from-indigo-500 to-transparent dark:from-indigo-400"></div>
                    </div>

                    <!-- Subunits Grid (3 Columns) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-12 justify-items-center w-full max-w-5xl">
                        <div 
                            v-for="member in team.slice(1)" 
                            :key="member.name" 
                            class="team-card"
                            :style="{
                                '--glow-start': glowProps.glowStart,
                                '--glow-end': glowProps.glowEnd,
                                '--glow-hover-start': glowProps.glowHoverStart,
                                '--glow-hover-end': glowProps.glowHoverEnd,
                                '--glow-shadow': glowProps.glowShadow,
                                '--glow-shadow-hover': glowProps.glowShadowHover,
                                '--glow-border-hover': glowProps.glowBorderHover,
                                '--glow-ring': glowProps.glowRing,
                                '--glow-ring-pulse': glowProps.glowRingPulse,
                                '--bottom-bg-light': glowProps.bottomBgLight,
                                '--bottom-bg-dark': glowProps.bottomBgDark
                            }"
                        >
                            <div class="card-top">
                                <div class="avatar">
                                    <img 
                                        :src="member.image_path" 
                                        :alt="member.name" 
                                        class="avatar-image" 
                                    />
                                </div>
                            </div>
                            <div class="card-bottom">
                                <h3 class="name">{{ member.name }}</h3>
                                <div class="inline-flex px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold mt-0.5 mb-1.5 text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/20">
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
        <section class="reveal-section py-20 lg:py-28 max-w-7xl mx-auto px-6 lg:px-8 border-t border-neutral-200/50 dark:border-neutral-800/30">
            <div class="space-y-16">
                
                <!-- Centered Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">{{ sections.objectives_intro?.eyebrow ?? 'Plan de Desarrollo' }}</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">{{ sections.objectives_intro?.title ?? 'Objetivos Estratégicos' }}</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">
                        {{ sections.objectives_intro?.description ?? 'Trazamos metas específicas a corto y mediano plazo para garantizar que nuestra labor tenga un impacto medible, estructurado y sostenible en la sociedad puneña.' }}
                    </p>
                </div>

                <!-- Mobile / Tablet layout (Grid) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 md:hidden">
                    <div 
                        v-for="(obj, index) in objectives" 
                        :key="obj.title" 
                        class="group relative flex items-start gap-4 p-6 rounded-2xl border border-neutral-200/80 dark:border-neutral-800/80 bg-white/95 dark:bg-neutral-900/60 shadow-sm hover:shadow-md transition-all duration-300 text-left"
                    >
                        <span class="absolute top-4 right-6 text-[10px] font-black text-neutral-300 dark:text-neutral-700 select-none">
                            0{{ index + 1 }}
                        </span>
                        <div class="p-3 rounded-xl shrink-0" :class="obj.color_class">
                            <component :is="iconMap[obj.icon_name]" class="size-5" />
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-sm font-extrabold text-neutral-900 dark:text-white leading-tight">
                                {{ obj.title }}
                            </h3>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-normal font-normal">
                                {{ obj.description }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Desktop Circular Layout -->
                <div class="relative w-full max-w-4xl mx-auto h-[620px] hidden md:block select-none overflow-visible py-10">
                    <!-- Concentric background rotating ring 1 (Dashed) -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[430px] h-[430px] rounded-full border-2 border-dashed border-indigo-500/20 dark:border-indigo-400/25 animate-[spin_60s_linear_infinite] z-0"></div>
                    <!-- Concentric background rotating ring 2 (Dashed, opposite) -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[460px] h-[460px] rounded-full border-2 border-dashed border-emerald-500/10 dark:border-emerald-400/15 animate-[spin_90s_linear_infinite_reverse] z-0"></div>

                    <!-- Center Badge Circle -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 flex flex-col items-center justify-center text-center size-36 rounded-full bg-gradient-to-tr from-indigo-600 via-indigo-700 to-emerald-600 dark:from-indigo-950 dark:via-indigo-900 dark:to-emerald-950 text-white shadow-2xl border-4 border-white dark:border-neutral-900 transition-transform duration-500 hover:scale-105 group">
                        <div class="absolute inset-0 rounded-full bg-indigo-500/20 blur-xl group-hover:blur-2xl transition-all duration-300"></div>
                        <span class="relative z-10 text-[9px] font-extrabold uppercase tracking-widest text-indigo-200 dark:text-indigo-300">DPESEC</span>
                        <h3 class="relative z-10 text-sm font-black uppercase mt-1 leading-tight tracking-wider">Objetivos<br/>Clave</h3>
                        <div class="relative z-10 size-1.5 rounded-full bg-emerald-400 mt-2 animate-ping"></div>
                    </div>

                    <!-- Dynamic Objective Cards around Center -->
                    <div 
                        v-for="(obj, index) in objectives" 
                        :key="obj.title + '-circular'" 
                        class="absolute z-10 w-[220px] flex flex-col p-5 bg-white/95 dark:bg-neutral-900/90 border border-neutral-200/80 dark:border-neutral-800/80 rounded-2xl shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl hover:border-indigo-500/50 dark:hover:border-indigo-400/50 hover:z-30 text-left"
                        :style="getObjectiveStyle(index)"
                    >
                        <div class="flex items-center gap-2.5">
                            <div class="p-2.5 rounded-lg text-indigo-600 dark:text-indigo-400 bg-indigo-500/10 shrink-0">
                                <component :is="iconMap[obj.icon_name]" class="size-4.5" />
                            </div>
                            <span class="text-[9px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">Objetivo 0{{ index + 1 }}</span>
                        </div>
                        <h4 class="text-xs font-black text-neutral-900 dark:text-white mt-3 leading-snug">{{ obj.title }}</h4>
                        <p class="text-[11px] text-neutral-500 dark:text-neutral-400 mt-1 leading-normal font-normal line-clamp-3">{{ obj.description }}</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- 5. VALUES SECTION -->
        <section class="reveal-section py-20 bg-neutral-50/50 dark:bg-neutral-900/10 border-t border-neutral-200/55 dark:border-neutral-800/40">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-16">
                
                <!-- Section Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">{{ sections.values_intro?.eyebrow ?? 'Filosofía de Trabajo' }}</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">{{ sections.values_intro?.title ?? 'Valores Institucionales' }}</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">
                        {{ sections.values_intro?.description ?? 'Nuestra cultura organizacional se cimenta sobre principios éticos que guían cada proyecto, voluntariado y expresión cultural.' }}
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
                        <div class="absolute -right-16 -top-16 size-36 rounded-full blur-3xl opacity-20 group-hover:opacity-45 transition-opacity duration-500" :class="val.glow_bg_class"></div>
                        
                        <!-- Large Transparent Background Number -->
                        <div class="absolute right-6 bottom-4 text-7xl font-black text-neutral-100 dark:text-neutral-800/10 select-none group-hover:scale-110 group-hover:text-neutral-200/30 dark:group-hover:text-neutral-800/25 transition-all duration-500">
                            0{{ index + 1 }}
                        </div>

                        <div class="relative z-10 space-y-6">
                            <!-- Icon with colorful bubble background -->
                            <div class="inline-flex size-14 rounded-2xl items-center justify-center shadow-md transition-transform duration-500 group-hover:rotate-12" :class="val.icon_container_class">
                                <component :is="iconMap[val.icon_name]" class="size-7" />
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
                        <div class="absolute bottom-0 left-0 h-1.5 w-0 group-hover:w-full transition-all duration-500" :class="val.accent_line_class"></div>
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
</style>
