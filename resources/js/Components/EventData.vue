<script setup lang="ts">

import { Metric } from "@/types";

const props = defineProps<{
    image_logo_softweek: string
    metrics: Metric;
}>();
</script>

<template>
    <article class="mt-16 md:mt-10 flex flex-col md:flex-row items-center justify-center text-center md:text-left">
        <img :src="image_logo_softweek" alt="Imagem do evento" class="mb-8 md:mb-0 md:mr-10">
        <div>
            <div class="flex flex-col md:flex-row md:space-x-20 mb-10">
                <div class="mb-10 md:mb-0">
                    <h1 class="text-white font-semibold text-2xl md:text-4xl">+{{ metrics['total_subscriptions']}}</h1>
                    <p class="text-white font-semibold text-2xl md:text-4xl">INSCRITOS</p>
                </div>
                <div>
                    <h1 class="text-white font-semibold text-2xl md:text-4xl">+{{ metrics['companies']}}</h1>
                    <p class="text-white font-semibold text-2xl md:text-4xl">EMPRESAS</p>
                </div>
            </div>
            <div class="flex flex-col md:flex-row md:space-x-20">
                <div class="mb-10 md:mb-0">
                    <h1 class="text-white font-semibold text-2xl md:text-4xl">+{{ metrics['hours_total']}}h</h1>
                    <p class="text-white font-semibold text-2xl md:text-4xl">IMERSÃO</p>
                </div>
                <div>
                    <h1 class="text-white font-semibold text-2xl md:text-4xl">+{{ metrics['speakers']}}</h1>
                    <p class="text-white font-semibold text-2xl md:text-4xl">PALESTRANTES</p>
                </div>
            </div>
        </div>
    </article>
</template>

<style scoped>
article {
  align-content: center;
}
</style>
