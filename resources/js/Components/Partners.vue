<script setup lang="ts">

import {Swiper, SwiperSlide} from 'swiper/vue';
import 'swiper/swiper-bundle.css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

import {Navigation, Pagination, Mousewheel, Keyboard, Autoplay} from 'swiper/modules';
import {ImagePartner} from "@/types";

const props = defineProps<{
    images_partners: ImagePartner;
}>();

const modules = [Navigation, Pagination, Mousewheel, Keyboard, Autoplay];

</script>

<template>
    <div class="text-center">
        <h1 class="font-semibold text-white text-2xl mb-5 mt-10">Empresas Master:</h1>
        <swiper
            :cssMode="true"
            :navigation="false"
            :pagination="false"
            :mousewheel="true"
            :autoplay="{
                delay: 2500,
                disableOnInteraction: false,
            }"
            :keyboard="true"
            :loop="true"
            :slides-per-view="1"
            :modules="modules"
            class="mySwiper"
        >
            <swiper-slide v-for="(partner, index) in images_partners.master" :key="index">
                <img :src="partner" alt="Logo Empresa Parceira" class="w-32 h-full">
            </swiper-slide>
        </swiper>

        <h1 class="font-semibold text-white text-2xl mb-5 mt-10">Empresas Ouro:</h1>
        <swiper
            :cssMode="true"
            :navigation="false"
            :pagination="false"
            :mousewheel="true"
            :slides-per-view="2"
            :autoplay="{
                delay: 2500,
                disableOnInteraction: false,
            }"
            :keyboard="true"
            :loop="true"
            :modules="modules"
            class="mySwiper"
        >
            <swiper-slide v-for="(partner, index) in images_partners.ouro" :key="index">
                <img :src="partner" alt="Logo Empresa Parceira" class="w-32 h-full">
            </swiper-slide>
        </swiper>

        <h1 class="font-semibold text-white text-2xl mb-5 mt-10">Empresas Prata:</h1>
        <swiper
            :cssMode="true"
            :navigation="false"
            :pagination="false"
            :mousewheel="true"
            :slides-per-view="2"
            :autoplay="{
                delay: 2500,
                disableOnInteraction: false,
            }"
            :keyboard="true"
            :loop="true"
            :modules="modules"
            class="mySwiper"
        >
            <swiper-slide v-for="(partner, index) in images_partners.prata" :key="index">
                <img :src="partner" alt="Logo Empresa Parceira" class="w-32 h-full">
            </swiper-slide>
        </swiper>

        <h1 class="font-semibold text-white text-2xl mb-5 mt-10">Empresas Parceiras:</h1>
        <swiper
            :cssMode="true"
            :navigation="false"
            :pagination="false"
            :mousewheel="true"
            :slides-per-view="3"
            :autoplay="{
                delay: 2500,
                disableOnInteraction: false,
            }"
            :keyboard="true"
            :loop="true"
            :modules="modules"
            class="mySwiper"
        >
            <swiper-slide v-for="(partner, index) in images_partners.parceiros" :key="index">
                <img :src="partner" alt="Logo Empresa Parceira" class="w-32 h-full">
            </swiper-slide>
        </swiper>
    </div>
</template>

<style scoped>
.mySwiper {
    width: 40%;
    height: 200px; /* Ajuste de altura fixa ou conforme sua necessidade */
}

.swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.swiper-slide img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; /* Garante que a imagem seja ajustada sem distorção */
}

@media (max-width: 768px) {
    .mySwiper {
        width: 80%;
    }
}
</style>
